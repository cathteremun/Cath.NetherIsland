<?php

declare(strict_types=1);

namespace NetherIsland\populator;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use NetherIsland\object\StoneOfKnowledge as ObjectStoneOfKnowledge;
use pocketmine\utils\Random;
use pocketmine\level\generator\populator\Populator;

class StoneOfKnowledge extends Populator{

    private $level;
    private $randomAmount;
    private $baseAmount;

    public function setRandomAmount(int $amount) : void{
        $this->randomAmount = $amount;
    }
    public function setBaseAmount(int $amount) : void{
        $this->baseAmount = $amount;
    }
    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void{
        $this->level = $level;
        $amount = $random->nextRange(0, $this->randomAmount + 1) + $this->baseAmount;
        for($i = 0; $i < $amount; ++$i){
            $x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
            $z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
            $y = $this->getHighestWorkableBlock($x, $z);
            if($y === -1){
                continue;
            }
            ObjectStoneOfKnowledge::placeObject($this->level, $x, $y -1, $z, $random);
        }
    }

    private function getHighestWorkableBlock(int $x, int $z) : int{
        for($y = 127; $y > 0; --$y) {
            if ($this->level->getBlockIdAt($x, $y, $z) === Block::NETHERRACK and $this->level->getBlockIdAt($x + 1, $y, $z) === Block::NETHERRACK and $this->level->getBlockIdAt($x + 2, $y, $z) === Block::NETHERRACK) {
                if ($this->level->getBlockIdAt($x, $y, $z + 1) === Block::NETHERRACK and $this->level->getBlockIdAt($x + 1, $y, $z + 1) === Block::NETHERRACK and $this->level->getBlockIdAt($x + 2, $y, $z + 1) === Block::NETHERRACK) {
                    if ($this->level->getBlockIdAt($x, $y, $z) === Block::NETHERRACK and $this->level->getBlockIdAt($x + 1, $y, $z) === Block::NETHERRACK and $this->level->getBlockIdAt($x + 2, $y, $z) === Block::NETHERRACK) {
                        break;
                    }
                }
            } elseif ($this->level->getBlockIdAt($x, $y, $z) !== Block::AIR or $this->level->getBlockIdAt($x + 1, $y, $z) !== Block::AIR or $this->level->getBlockIdAt($x + 2, $y, $z) !== Block::AIR) {
                return -1;
            } elseif ($this->level->getBlockIdAt($x, $y, $z + 1) !== Block::AIR or $this->level->getBlockIdAt($x + 1, $y, $z + 1) !== Block::AIR or $this->level->getBlockIdAt($x + 2, $y, $z + 1) !== Block::AIR) {
                return -1;
            } elseif ($this->level->getBlockIdAt($x, $y, $z) !== Block::AIR or $this->level->getBlockIdAt($x + 1, $y, $z) !== Block::AIR or $this->level->getBlockIdAt($x + 2, $y, $z) !== Block::AIR) {
                return -1;
            }
        }
        return ++$y;
    }
}