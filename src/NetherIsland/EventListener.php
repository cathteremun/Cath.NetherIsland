<?php

declare(strict_types=1);

namespace NetherIsland;

use NetherIsland\lib\FormAPI\SimpleForm;
use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Item;
use pocketmine\level\Explosion;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\network\mcpe\protocol\ChangeDimensionPacket;
use pocketmine\Player;
use pocketmine\utils\Random;

class EventListener implements Listener {

    public $plugin;
    public $chestData;

    public function __construct(Main $plugin, array $chestData) {
        $this->plugin = $plugin;
        $this->chestData = $chestData;
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

    public function EntityGift(Player $player) {
        $amount = (new Random(mt_rand(1,7)))->nextRange(1, 4);
        $id = (new Random(mt_rand(1,8)))->nextRange(0, count($this->chestData) - 1);
        $item = $this->chestData[$id];
        if($item === 742 or $item === 444 or $item === 25 or $item === 49) {
            $player->getInventory()->addItem(Item::get($item, 0, 1));
        } else {
            $player->getInventory()->addItem(Item::get($item, 0, $amount));
        }
    }
}