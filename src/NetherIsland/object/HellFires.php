<?php

declare(strict_types=1);

namespace NetherIsland\object;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

class HellFires {

    public static function placeObject(ChunkManager $level, int $x, int $y, int $z, Random $random) : void {
        $level->setBlockIdAt($x, $y, $z, Block::FIRE);
        $level->setBlockDataAt($x, $y, $z, Block::FIRE);
    }
}