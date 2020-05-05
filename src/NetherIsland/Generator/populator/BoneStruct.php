<?php


declare(strict_types=1);

namespace NetherIsland\Generator\populator;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

class BoneStruct extends Populator {

    private $level;

    private $randomAmount;
    private $baseAmount;

    public function __construct(int $randomAmount = 0, int $baseAmount = 0){
        $this->baseAmount = $baseAmount;
        $this->randomAmount = $randomAmount;
    }

    public function setRandomAmount($amount) {
        $this->randomAmount = $amount;
    }

    public function setBaseAmount($amount) {
        $this->baseAmount = $amount;
    }

    /**
     * @param ChunkManager $level
     * @param int $chunkX
     * @param int $chunkZ
     * @param Random $random
     * @return mixed|void
     */
    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) {
        if(mt_rand(0, 99) < 10) {
            $this->level = $level;
            $amount = $random->nextRange(0, $this->randomAmount + 1) + $this->baseAmount;
            for ($i = 0; $i < $amount; ++$i) {
                $x = $random->nextRange($chunkX * 16, $chunkX * 16 + 15);
                $z = $random->nextRange($chunkZ * 16, $chunkZ * 16 + 15);
                $y = $random->nextRange(0, 120);
                if ($this->level->getBlockIdAt($x, $y, $z) == Block::NETHERRACK) {
                    $this->spawnRibStruct($level, $x, $y, $z);
                }
            }
        }
    }

    public static function spawnBone(ChunkManager $level, $x, $y, $z) {
        // Todo if even working
    }

    public static function spawnRibStruct(ChunkManager $level, $x, $y, $z){
        for($nz = $z; $nz < $z + 6; $nz + 2) {
            $level->setBlockIdAt($x, $y, $nz, Block::BONE_BLOCK);
            $level->setBlockIdAt($x - 1, $y, $nz, Block::BONE_BLOCK);
            $level->setBlockIdAt($x + 1, $y, $nz, Block::BONE_BLOCK);
            $level->setBlockIdAt($x - 2, $y + 1, $nz, Block::BONE_BLOCK);
            $level->setBlockIdAt($x + 2, $y + 1, $nz, Block::BONE_BLOCK);
            $level->setBlockIdAt($x - 3, $y + 2, $nz, Block::BONE_BLOCK);
            $level->setBlockIdAt($x - 3, $y + 2, $nz, Block::BONE_BLOCK);
            $level->setBlockIdAt($x - 3, $y + 3, $nz, Block::BONE_BLOCK);
            $level->setBlockIdAt($x - 3, $y + 3, $nz, Block::BONE_BLOCK);
            $level->setBlockIdAt($x - 2, $y + 4, $nz, Block::BONE_BLOCK);
            $level->setBlockIdAt($x - 2, $y + 4, $nz, Block::BONE_BLOCK);
            $level->setBlockDataAt($x, $y, $nz, 0);
            $level->setBlockDataAt($x - 1, $y, $nz, 0);
            $level->setBlockDataAt($x + 1, $y, $nz, 0);
            $level->setBlockDataAt($x - 2, $y + 1, $nz, 0);
            $level->setBlockDataAt($x + 2, $y + 1, $nz, 0);
            $level->setBlockDataAt($x - 3, $y + 2, $nz, 0);
            $level->setBlockDataAt($x - 3, $y + 2, $nz, 0);
            $level->setBlockDataAt($x - 3, $y + 3, $nz, 0);
            $level->setBlockDataAt($x - 3, $y + 3, $nz, 0);
            $level->setBlockDataAt($x - 2, $y + 4, $nz, 0);
            $level->setBlockDataAt($x - 2, $y + 4, $nz, 0);
        }
    }
}