<?php

declare(strict_types=1);

namespace NetherIsland;

use NetherIsland\Generator\NetherIsland;
use pocketmine\level\generator\GeneratorManager;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    private static $instance;

    public function onLoad() {
        GeneratorManager::addGenerator(NetherIsland::class, "netherisland");
        self::$instance = $this;
    }

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    public static function getInstance(): Main {
        return self::$instance;
    }
}
