<?php

declare(strict_types=1);

namespace NetherIsland\object;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

class BoneStruct{

    public static function placeObject(ChunkManager $level, int $x, int $y, int $z, Random $random) : void {
        if($random->nextRange(0,10) === 1) {
            if($random->nextRange(0,1) === 0){  //$z is constant
                $i = $z + 6;
                switch ($random->nextRange(0,3)) {
                    case 0: //Rip Complete
                        for($nz = $z; $nz < $i;) {
                            $level->setBlockIdAt($x, $y, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 1, $y, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 1, $y, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 2, $y + 1, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 2, $y + 1, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 3, $y + 2, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 3, $y + 2, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 3, $y + 3, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 3, $y + 3, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 2, $y + 4, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 2, $y + 4, $nz, Block::BONE_BLOCK);
                            $nz = $nz + 2;
                        }
                        $level->setBlockIdAt($x, $y, $z + 1, Block::BONE_BLOCK);
                        $level->setBlockIdAt($x, $y, $z + 3, Block::BONE_BLOCK);
                        break;
                    case 1: //Rip Broken
                        for($nz = $z; $nz < $i;) {
                            $level->setBlockIdAt($x, $y, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 1, $y, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 2, $y + 1, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 2, $y + 1, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 3, $y + 2, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 3, $y + 2, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 3, $y + 3, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 2, $y + 4, $nz, Block::BONE_BLOCK);
                            $nz = $nz + 2;
                        }
                        $level->setBlockIdAt($x, $y, $z + 1, Block::BONE_BLOCK);
                        $level->setBlockIdAt($x, $y, $z + 3, Block::BONE_BLOCK);
                        break;
                    case 2: //Rip Left Broken
                        for($nz = $z; $nz < $i;) {
                            $level->setBlockIdAt($x, $y, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 1, $y, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 1, $y, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 2, $y + 1, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 2, $y + 1, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 3, $y + 2, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 3, $y + 3, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 2, $y + 4, $nz, Block::BONE_BLOCK);
                            $nz = $nz + 2;
                        }
                        $level->setBlockIdAt($x, $y, $z + 1, Block::BONE_BLOCK);
                        $level->setBlockIdAt($x, $y, $z + 3, Block::BONE_BLOCK);
                        break;
                    case 3: //Rip Right Broken
                        for($nz = $z; $nz < $i;) {
                            $level->setBlockIdAt($x, $y, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 1, $y, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 1, $y, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x - 2, $y + 1, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 2, $y + 1, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 3, $y + 2, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 3, $y + 3, $nz, Block::BONE_BLOCK);
                            $level->setBlockIdAt($x + 2, $y + 4, $nz, Block::BONE_BLOCK);
                            $nz = $nz + 2;
                        }
                        $level->setBlockIdAt($x, $y, $z + 1, Block::BONE_BLOCK);
                        $level->setBlockIdAt($x, $y, $z + 3, Block::BONE_BLOCK);
                        break;
                }
            } else { //$x is constant
                $i = $x + 6;
                switch ($random->nextRange(0,3)) {
                    case 0: //Rip Complete
                        for($nx = $x; $nx < $i;) {
                            $level->setBlockIdAt($nx, $y, $z, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y, $z -1, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y, $z + 1, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 1, $z -2, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 1, $z + 2, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 2, $z - 3, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 2, $z + 3, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 3, $z - 3, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 3, $z + 3, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 4, $z - 2, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 4, $z + 2, Block::BONE_BLOCK);
                            $nx = $nx + 2;
                        }
                        $level->setBlockIdAt($x + 1, $y, $z, Block::BONE_BLOCK);
                        $level->setBlockIdAt($x + 3, $y, $z, Block::BONE_BLOCK);
                        break;
                    case 1: //Rip Broken
                        for($nx = $x; $nx < $i;) {
                            $level->setBlockIdAt($nx, $y, $z, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y, $z -1, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y, $z + 1, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 1, $z -2, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 1, $z + 2, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 2, $z + 3, Block::BONE_BLOCK);
                            $nx = $nx + 2;
                        }
                        $level->setBlockIdAt($x + 1, $y, $z, Block::BONE_BLOCK);
                        $level->setBlockIdAt($x + 3, $y, $z, Block::BONE_BLOCK);
                        break;
                    case 2: //Rip Left Broken
                        for($nx = $x; $nx < $i;) {
                            $level->setBlockIdAt($nx, $y, $z, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y, $z -1, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y, $z + 1, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 1, $z -2, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 1, $z + 2, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 2, $z - 3, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 3, $z - 3, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 4, $z - 2, Block::BONE_BLOCK);
                            $nx = $nx + 2;
                        }
                        $level->setBlockIdAt($x + 1, $y, $z, Block::BONE_BLOCK);
                        $level->setBlockIdAt($x + 3, $y, $z, Block::BONE_BLOCK);
                        break;
                    case 3: //Rip Right Broken
                        for($nx = $x; $nx < $i;) {
                            $level->setBlockIdAt($nx, $y, $z, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y, $z -1, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y, $z + 1, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 1, $z -2, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 1, $z + 2, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 2, $z + 3, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 3, $z + 3, Block::BONE_BLOCK);
                            $level->setBlockIdAt($nx, $y + 4, $z + 2, Block::BONE_BLOCK);
                            $nx = $nx + 2;
                        }
                        $level->setBlockIdAt($x + 1, $y, $z, Block::BONE_BLOCK);
                        $level->setBlockIdAt($x + 3, $y, $z, Block::BONE_BLOCK);
                        break;
                }
            }
        }
    }
}