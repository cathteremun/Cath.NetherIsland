<?php

declare(strict_types=1);

namespace NetherIsland\Generator\populator;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

class LavaFall extends Populator {

    private $level;

    private $randomAmount;
    private $baseAmount;

    public function setRandomAmount($amount) {
        $this->randomAmount = $amount;
    }

    public function setBaseAmount($amount) {
        $this->baseAmount = $amount;
    }

    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) {
        if (mt_rand(0, 100) < 10) {
            $this->level = $level;
            $amount = $random->nextRange(0, $this->randomAmount + 1) + $this->baseAmount;
            for ($i = 0; $i < $amount; ++$i) {
                $x = $random->nextRange($chunkX * 16, $chunkX * 16 + 15);
                $z = $random->nextRange($chunkZ * 16, $chunkZ * 16 + 15);
                $y = $this->getHighestWorkableBlock($x, $z);
                if ($this->level->getBlockIdAt($x, $y, $z) == Block::NETHERRACK) {
                    $level->setBlockIdAt($x, $y, $z, Block::FLOWING_LAVA);
                }
            }
        }
    }

    /**
     * @param $x
     * @param $z
     * @return int
     */
    private function getHighestWorkableBlock($x, $z) {
        for ($y = 127; $y >= 0; --$y) {
            $b = $this->level->getBlockIdAt($x, $y, $z);
            if ($b == Block::NETHERRACK) {
                break;
            }
        }
        return $y === 0 ? -1 : $y;
    }
}