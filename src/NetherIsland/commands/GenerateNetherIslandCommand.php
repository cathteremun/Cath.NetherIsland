<?php

namespace NetherIsland\commands;

use NetherIsland\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\generator\GeneratorManager;

class GenerateNetherIslandCommand extends Command {

    /*
     * TODO: Change
     */

    public function __construct() {
        parent::__construct("generateni");
        $this->setDescription("Generiert eine NetherIsland Welt");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender->hasPermission('netherisland.generate')) {
            if (count($args) < 1) {
                return false;
            }
            $world = array_shift($args);
            if (Main::getInstance()->getServer()->isLevelGenerated($world)) {
                $sender->sendMessage(Main::PREFIX . ("Diese Welt existiert bereits"));

                return true;
            }
            $seed = 0;
            Main::getInstance()->getServer()->broadcastMessage(Main::PREFIX . ("Eine Welt wird erstellt. (Lag)"));
            Main::getInstance()->getServer()->generateLevel($world, $seed, GeneratorManager::getGenerator('sb-nether'));
            Main::getInstance()->getServer()->loadLevel($world);
            return true;
        } else {
            $sender->sendMessage(Main::PREFIX . Main::NO_PERMISSIONS);
        }
    }
}