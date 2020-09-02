<?php

declare(strict_types=1);

namespace NetherIsland\object;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

class BoneStruct{

    public static function placeObject(ChunkManager $level, int $x, int $y, int $z, Random $random) : void {

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