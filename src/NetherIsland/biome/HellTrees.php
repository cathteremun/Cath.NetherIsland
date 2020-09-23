<?php

declare(strict_types=1);

namespace NetherIsland\biome;

use NetherIsland\populator\HellTree;
use pocketmine\level\biome\Biome;
use NetherIsland\Main;

class HellTrees extends Biome{
    public function __construct(){
        /*$pt = new HellFire(); //Todo
        $pt->setBaseAmount(0);
        $pt->setRandomAmount(6);
        $this->addPopulator($pt);*/

        $this->temperature = 4;
        $this->rainfall = 0;
    }

    public function getName() : string {
        return "Hell Trees";
    }

    public function getId(): int {
        return Main::HELLTREES;
    }
}