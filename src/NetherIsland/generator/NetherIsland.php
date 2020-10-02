<?php

declare(strict_types=1);

namespace NetherIsland\generator;

use NetherIsland\biome\{BoneFields, HellFire, HellTrees, SharpRocks};
use NetherIsland\Main;
use pocketmine\block\{Block, Glowstone, Gravel, Lava, Magma, NetherQuartzOre, SoulSand};
use NetherIsland\populator\BoneStruct;
use pocketmine\level\biome\Biome;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\Generator;
use pocketmine\level\generator\noise\Simplex;
use pocketmine\level\generator\object\OreType;
use NetherIsland\populator\Ore;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

use ReflectionMethod;
use function exp;
use function abs;

class NetherIsland extends Generator {

    protected $level;
    private $populators = [ ];
    private $generationPopulators = [];
    private $waterHeight = 5;
    private $emptyHeight = 32;
    private $emptyAmplitude = 1;
    private $density = 0.87;
    public $options;

    private $noiseBase;
    private static $GAUSSIAN_KERNEL = null;
    private static $SMOOTH_SIZE = 4;

    public function __construct(array $options = []){
        if(self::$GAUSSIAN_KERNEL === null){
            self::generateKernel();
        }

        Biome::init();

        $reflect = new ReflectionMethod(Biome::class, 'register');
        $reflect->setAccessible(true);

        $reflect->invoke(null, Main::BONEFIELDS, new BoneFields());
        $reflect->invoke(null, Main::HELLFIRE, new HellFire());
        $reflect->invoke(null, Main::SHARPROCKS, new SharpRocks());
        $reflect->invoke(null, Main::HELLTREES, new HellTrees());
        $this->options = $options;
    }

    public function init(ChunkManager $level, Random $random) : void {
        parent::init($level, $random);

        $this->random->setSeed(0);
        $this->noiseBase = new Simplex($this->random, 4, 1 / 4, 1 / 64);

        $bone = new BoneStruct();
        $bone->setRandomAmount(1);
        $bone->setBaseAmount(0);
        $this->populators[] = $bone;

        $ores = new Ore();
        $ores->setOreTypes([
            new OreType(new Glowstone(), 5, 16, 0, 128),
            new OreType(new NetherQuartzOre(), 20, 16, 0, 128),
            new OreType(new SoulSand(), 5, 64, 0, 128),
            new OreType(new Gravel(), 5, 64, 0, 128),
            new OreType(new Lava(1), 4, 16, 0, 128),
            new OreType(new Magma(),5, 42, 0, 128)
        ]);
        $this->populators[] = $ores;
    }

    private static function generateKernel(){
        self::$GAUSSIAN_KERNEL = [];

        $bellSize = 1 / self::$SMOOTH_SIZE;
        $bellHeight = 2 * self::$SMOOTH_SIZE;

        for($sx = -self::$SMOOTH_SIZE; $sx <= self::$SMOOTH_SIZE; ++$sx){
            self::$GAUSSIAN_KERNEL[$sx + self::$SMOOTH_SIZE] = [];

            for($sz = -self::$SMOOTH_SIZE; $sz <= self::$SMOOTH_SIZE; ++$sz){
                $bx = $bellSize * $sx;
                $bz = $bellSize * $sz;
                self::$GAUSSIAN_KERNEL[$sx + self::$SMOOTH_SIZE][$sz + self::$SMOOTH_SIZE] = $bellHeight * exp(-($bx * $bx + $bz * $bz) / 2);
            }
        }
    }

    public function getName() : string {
        return "sb-nether";
    }

    public function getWaterHeight() : int {
        return $this->waterHeight;
    }

    public function getSettings() : array {
        return [];
    }

    public function pickBiome() : int {
        return Biome::HELL;
    }

    public function generateChunk(int $chunkX, int $chunkZ) : void{
        $this->random->setSeed(0xa6fe78dc ^ ($chunkX << 8) ^ $chunkZ ^ $this->level->getSeed());

        $noise = $this->noiseBase->getFastNoise3D(16, 128, 16, 4, 8, 4, $chunkX * 16, 0, $chunkZ * 16);

        $chunk = $this->level->getChunk($chunkX, $chunkZ);

        for($x = 0; $x < 16; ++$x) {
            for($z = 0; $z < 16; ++$z) {

                $biome = Biome::getBiome($this->pickBiome());
                $biome->setGroundCover([
                    Block::get(Block::BEDROCK, 0)
                ]);
                $chunk->setBiomeId($x, $z, Biome::HELL);
                $color = [0, 0, 0];
                $bColor = 2;
                $color[0] += (($bColor >> 16) ** 2);
                $color[1] += ((($bColor >> 8) & 0xff) ** 2);
                $color[2] += (($bColor & 0xff) ** 2);

                for($y = 0; $y < 128; ++$y) {

                    $noiseValue = (abs($this->emptyHeight - $y) / $this->emptyHeight) * $this->emptyAmplitude - $noise[$x][$z][$y];
                    $noiseValue -= 1 - $this->density;

                    $distance = new Vector3(0, 64, 0);
                    $distance = $distance->distance(new Vector3($chunkX * 16 + $x, ($y / 1.3), $chunkZ * 16 + $z));

                    if($noiseValue < 0 && $distance < 100 or $noiseValue < -0.2 && $distance > 400){
                        $chunk->setBlock($x, $y, $z, Block::NETHERRACK, 0);
                    } elseif($y <= $this->waterHeight){
                        if($y != 1) {
                            $chunk->setBlock($x, $y, $z, Block::STILL_LAVA, 0);
                        } else {
                            $chunk->setBlock($x, $y, $z, Block::BEDROCK, 0);
                        }
                    }
                }
            }
        }

        foreach($this->generationPopulators as $populator) {
            $populator->populate($this->level, $chunkX, $chunkZ, $this->random);
        }
    }

    public function populateChunk(int $chunkX, int $chunkZ) : void {
        $this->random->setSeed(0xa6fe78dc ^ ($chunkX << 8) ^ $chunkZ ^ $this->level->getSeed());
        foreach($this->populators as $populator){
            $populator->populate($this->level, $chunkX, $chunkZ, $this->random);
        }

        $chunk = $this->level->getChunk($chunkX, $chunkZ);
        $biome = Biome::getBiome($chunk->getBiomeId(7, 7));
        $biome->populateChunk($this->level, $chunkX, $chunkZ, $this->random);
    }

    public function getSpawn() : Vector3 {
        return new Vector3(48, 128, 48);
    }

}