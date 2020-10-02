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

    public const BONEFIELDS = 101;
    public const HELLFIRE = 102;
    public const SHARPROCKS = 103;
    public const HELLTREES = 104;

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