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
                    }
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