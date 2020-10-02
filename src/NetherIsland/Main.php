<?php

declare(strict_types=1);

namespace NetherIsland;

use NetherIsland\commands\GenerateNetherIslandCommand;
use NetherIsland\generator\NetherIsland;
use pocketmine\level\generator\GeneratorManager;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    const PREFIX = "§6Cat§fhesda§8 >§f ";
    const NO_PERMISSIONS = "§4Du hast nicht die benötigten Berechtigungen für diesen Befehl";

    private static $instance;

    public function onLoad() {
        GeneratorManager::addGenerator(NetherIsland::class, "sb-nether");
        self::$instance = $this;
    }

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register("generateni", new GenerateNetherIslandCommand);
    }

    public static function getInstance(): Main {
        return self::$instance;
    }
}