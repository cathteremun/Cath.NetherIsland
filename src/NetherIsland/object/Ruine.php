<?php

namespace NetherIsland\object;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

class Ruine{

    public static function placeRuine(ChunkManager $level, int $x, int $y, int $z, Random $random) : void {
        if($random->nextRange(0, 7) === 1) {
            //Airspace - 5x5x5
            for($y1 = $y + 5; $y1 != $y; $y1--){ //y
                for($x1 = $x + 5; $x1 != $x; $x1--){//x
                    for($z1 = $z + 5; $z1 != $z; $z1--){//z
                        $level->setBlockIdAt($x1, $y1, $z1, Block::AIR);
                    }
                }
            }
            //Base
            for($x1 = $x + 4; $x1 != $x - 1; $x1--){//x
                for($z1 = $z + 4; $z1 != $z - 1; $z1--){//z
                    self::setRandomBlock($level, $x1, $y, $z1, $random->nextRange(0,3));
                }
            }
            //Border
            for ($nx = $x + 4; $nx > $x - 1;) {
                $level->setBlockIdAt($nx, $y, $z - 1, Block::STONE_SLAB);
                $level->setBlockIdAt($nx, $y, $z + 5, Block::STONE_SLAB);
                $level->setBlockDataAt($nx, $y, $z - 1, 7);
                $level->setBlockDataAt($nx, $y, $z + 5, 7);
                $nx--;
            }
            for ($nz = $z + 4; $nz > $z - 1;) {
                $level->setBlockIdAt($x - 1, $y, $nz, Block::STONE_SLAB);
                $level->setBlockIdAt($x + 5, $y, $nz, Block::STONE_SLAB);
                $level->setBlockDataAt($x - 1, $y, $nz, 7);
                $level->setBlockDataAt($x +  5, $y, $nz, 7);
                $nz--;
            }
            //Wall
            self::getRandomWallBlock($level, $x + 0, $y + 1, $z + 0, $random->nextRange(0, 2));
            self::getRandomWallBlock($level, $x + 0, $y + 2, $z + 0, $random->nextRange(0, 2));
            self::getRandomWallBlock($level, $x + 1, $y + 1, $z + 0, $random->nextRange(0, 2));
            self::getRandomWallBlock($level, $x + 0, $y + 1, $z + 1, $random->nextRange(0, 2));

            self::getRandomWallBlock($level, $x + 4, $y + 1, $z + 0, $random->nextRange(0, 2));
            self::getRandomWallBlock($level, $x + 4, $y + 2, $z + 0, $random->nextRange(0, 2));
            self::getRandomWallBlock($level, $x + 4, $y + 1, $z + 0, $random->nextRange(0, 2));
            self::getRandomWallBlock($level, $x + 4, $y + 1, $z + 1, $random->nextRange(0, 2));

            self::getRandomWallBlock($level, $x + 0, $y + 1, $z + 4, $random->nextRange(0, 2));
            self::getRandomWallBlock($level, $x + 0, $y + 2, $z + 4, $random->nextRange(0, 2));
            self::getRandomWallBlock($level, $x + 0, $y + 1, $z + 3, $random->nextRange(0, 2));
            self::getRandomWallBlock($level, $x + 1, $y + 1, $z + 4, $random->nextRange(0, 2));

            self::getRandomWallBlock($level, $x + 4, $y + 1, $z + 4, $random->nextRange(0, 2));
            self::getRandomWallBlock($level, $x + 4, $y + 2, $z + 4, $random->nextRange(0, 2));
            self::getRandomWallBlock($level, $x + 4, $y + 1, $z + 3, $random->nextRange(0, 2));
            self::getRandomWallBlock($level, $x + 4, $y + 1, $z + 4, $random->nextRange(0, 2));

            //Chest
            $level->setBlockIdAt($x + 2, $y + 1, $z + 2, Block::CHEST);
        }
    }

    public static function setSegments(ChunkManager $level, int $x, int $y, int $z, int $type) : void {
        switch($type) {
            case 1:
                self::placePortal();
                break;
            case 2:
                self::placePath();
                break;
            case 3:
                self::placeEndSeg(); //Name???
                break;
        }
    }

    public static function placePortal(){
        //TODO
    }

    public static function placePath(){
        //TODO
    }

    public static function placeEndSeg(){
        //TODO
    }

    public static function setRandomBlock(ChunkManager $level, int $x, int $y, int $z, int $block) {
        if($block === 0) {
            $level->setBlockIdAt($x, $y, $z, Block::NETHER_BRICK_BLOCK);
        } elseif($block === 1) {
            $level->setBlockIdAt($x, $y, $z, Block::MAGMA);
        } elseif($block === 2) {
            $level->setBlockIdAt($x, $y, $z, Block::SOUL_SAND);
        } elseif($block === 3) {
            $level->setBlockIdAt($x, $y, $z, Block::OBSIDIAN);
        }
    }

    public static function getRandomWallBlock(ChunkManager $level, int $x, int $y, int $z, int $block) {
        if($block === 0) {
            $level->setBlockIdAt($x, $y, $z, Block::NETHER_BRICK_FENCE);
        } elseif($block === 1) {
            $level->setBlockIdAt($x, $y, $z, Block::NETHER_BRICK_BLOCK);
        } elseif($block === 2) {
            $level->setBlockIdAt($x, $y, $z, Block::NETHER_BRICK_FENCE);
        }
    }
}