<?php

declare(strict_types=1);

namespace NetherIsland\biome;

use NetherIsland\populator\SharpRock;
use pocketmine\level\biome\Biome;
use NetherIsland\Main;

class SharpRocks extends Biome{
    public function __construct(){
        /*$pt = new SharpRock(); //Todo
        $pt->setBaseAmount(0);
        $pt->setRandomAmount(6);
        $this->addPopulator($pt);*/

        $this->temperature = 5;
        $this->rainfall = 0;
    }

    public function getName() : string {
        return "Sharp Rocks";
    }

    public function getId(): int {
        return Main::SHARPROCKS;
    }
}