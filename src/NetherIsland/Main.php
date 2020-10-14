<?php
declare(strict_types=1);

namespace NetherIsland;

use NetherIsland\commands\GenerateNetherIslandCommand;
use NetherIsland\generator\NetherIsland;
use pocketmine\level\generator\GeneratorManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase {

    const PREFIX = "§6Cat§fhesda§8 >§f ";
    const NO_PERMISSIONS = "§4Du hast nicht die benötigten Berechtigungen für diesen Befehl";

    private static $instance;

    public function onLoad() {
        GeneratorManager::addGenerator(NetherIsland::class, "sb-nether");
        self::$instance = $this;

        $this->saveResource("loot.yml");
    }

    public function onEnable() {
        $chestData = (new Config($this->getDataFolder() . "loot.yml", Config::YAML))->get("chest");
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this, $chestData), $this);
        $this->getServer()->getCommandMap()->register("generateni", new GenerateNetherIslandCommand);
    }

    public static function getInstance() {
        return self::$instance;
    }
}