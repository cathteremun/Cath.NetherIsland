<?php

declare(strict_types=1);

namespace NetherIsland\biome;

use NetherIsland\populator\BoneStruct;
use pocketmine\level\biome\Biome;
use NetherIsland\Main;

class BoneFields extends Biome{

    public function __construct(){
        $pt = new BoneStruct();
        $pt->setBaseAmount(0);
        $pt->setRandomAmount(1);
        $this->addPopulator($pt);

        $this->temperature = 6;
        $this->rainfall = 0;
    }

    public function getName() : string {
        return "Bone Fields";
    }

    public function getId(): int {
        return Main::BONEFIELDS;
    }
}