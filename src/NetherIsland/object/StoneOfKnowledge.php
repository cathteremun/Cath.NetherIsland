<?php

namespace NetherIsland\object;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

class StoneOfKnowledge {

    public static function placeObject(ChunkManager $level, int $x, int $y, int $z, Random $random) : void {
        if($random->nextRange(0,5) === 1) {
            for ($nx = $x + 2; $nx > $x - 1; $nx--) {
                for ($nz = $z + 2; $nx > $z - 1; $nz--) {
                    $level->setBlockIdAt($nx, $y, $nz, 122);
                }
            }
            for ($nx = $x + 2; $nx > $x - 1;) {
                $level->setBlockIdAt($nx, $y, $z - 1, Block::STONE_SLAB);
                $level->setBlockIdAt($nx, $y, $z + 3, Block::STONE_SLAB);
                $level->setBlockDataAt($nx, $y, $z - 1, 7);
                $level->setBlockDataAt($nx, $y, $z +3, 7);
                $nx--;
            }
            for ($nz = $z + 2; $nz > $z - 1;) {
                $level->setBlockIdAt($x - 1, $y, $nz, Block::STONE_SLAB);
                $level->setBlockIdAt($x + 3, $y, $nz, Block::STONE_SLAB);
                $level->setBlockDataAt($x - 1, $y, $nz, 7);
                $level->setBlockDataAt($x + 3, $y, $nz, 7);
                $nz--;
            }
            //Pillar
            $level->setBlockIdAt($x + 1, $y + 1, $z + 1, Block::QUARTZ_BLOCK);
            $level->setBlockDataAt($x + 1, $y + 1, $z + 1, 2);
            $level->setBlockIdAt($x + 1, $y + 2, $z + 1, Block::NETHERREACTOR);
            //Fences
            $level->setBlockIdAt($x, $y + 1, $z, Block::NETHER_BRICK_FENCE);
            $level->setBlockIdAt($x + 2, $y + 1, $z, Block::NETHER_BRICK_FENCE);
            $level->setBlockIdAt($x, $y + 1, $z + 2, Block::NETHER_BRICK_FENCE);
            $level->setBlockIdAt($x +2 , $y + 1, $z + 2, Block::NETHER_BRICK_FENCE);
        }
    }

    public static function getRandomBlock(int $type) : int {
        if($type === 1) {
            return Block::NETHER_BRICK_BLOCK;
        } else {
            return Block::RED_NETHER_BRICK;
        }
    }

    public static function getRandomSlab(int $type) : int {
        if($type === 1) {
            return Block::DOUBLE_STONE_SLAB;
        } else {
            return Block::STONE_SLAB2;
        }
    }
}