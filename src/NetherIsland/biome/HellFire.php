<?php

declare(strict_types=1);

namespace NetherIsland\biome;

use NetherIsland\Generator\populator\HellFires;
use pocketmine\level\biome\Biome;
use NetherIsland\Main;

class HellFire extends Biome{

    public function __construct(){
        $pt = new HellFires();
        $pt->setBaseAmount(0);
        $pt->setRandomAmount(4);
        $this->addPopulator($pt);

        $this->temperature = 12;
        $this->rainfall = 0;
    }

    public function getName() : string {
        return "Hell Fires";
    }

    public function getId(): int {
        return Main::HELLFIRE;
    }
}