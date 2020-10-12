<?php

declare(strict_types=1);

namespace NetherIsland;

use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\network\mcpe\protocol\ChangeDimensionPacket;
use pocketmine\Player;

class EventListener implements Listener {

    public $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onLevelChange(EntityLevelChangeEvent $event) {
        $entity = $event->getEntity();
        if($entity instanceof Player) {
            $originGenerator = $event->getOrigin()->getProvider()->getGenerator();
            $targetGenerator = $event->getTarget()->getProvider()->getGenerator();

            $getDimension = function ($generator): int {
                switch ($generator) {
                    case "sb-nether":
                    case "nether":
                        return 1;
                    case "ender":
                        return 2;
                    default:
                        return 0;
                }
            };

            if($getDimension($originGenerator) == $getDimension($targetGenerator)) return;

            $pk = new ChangeDimensionPacket();
            $pk->dimension = $getDimension($targetGenerator);
            $pk->position = $event->getTarget()->getSpawnLocation();

            $entity->dataPacket($pk);
        }
    }

    public function onPlayerDeath(PlayerDeathEvent $event) {
        $player = $event->getPlayer();

        $getDimension = function ($generator): int {
            switch ($generator) {
                case "sb-nether":
                case "nether":
                    return 1;
                case "ender":
                    return 2;
                default:
                    return 0;
            }
        };

        if($getDimension($player->getLevel()->getProvider()->getGenerator()) !== 0) {
            $player->teleport($this->plugin->getServer()->getDefaultLevel()->getSafeSpawn());
            return;
        }
    }
}