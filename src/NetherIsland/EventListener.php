<?php

declare(strict_types=1);

namespace NetherIsland;

use NetherIsland\lib\FormAPI\SimpleForm;
use NetherIsland\utils\Ruine;
use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\entity\object\ItemEntity;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Item;
use pocketmine\level\Explosion;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\level\Level;
use pocketmine\level\sound\DoorCrashSound;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\level\sound\LaunchSound;
use pocketmine\math\Vector3;
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

    public function onBreakGlowing(BlockBreakEvent $event) {
        $block = $event->getBlock();
        if($block->getId() === Block::GLOWING_OBSIDIAN) {
            $event->getPlayer()->kill();
            $event->setCancelled(true);
            $exp = new Explosion($event->getBlock()->asPosition(), 6, $this);
            $exp->explodeA();
            $exp->explodeB();
        }
    }

    public function interactGlowing(PlayerInteractEvent $event) {
        $block = $event->getBlock();
        if($block->getId() === Block::GLOWING_OBSIDIAN) {
            $level = $event->getPlayer()->getLevel();
            $x = $block->getX();
            $y = $block->getY();
            $z = $block->getZ();
            $chestData = $this->chestData;

            $form = new SimpleForm(function (Player $player, $data) use ($x, $y, $z, $chestData, $level) {
                if ($data === null) {
                    return;
                }
                switch ($data) {
                    case 0:
                        for($i = 5; $i > 1; --$i) {
                            $item = $chestData[(new Random())->nextRange(0, count($chestData ) - 1)];
                            if($item === 742 or $item === 444 or $item === 25 or $item === 49) {
                                $player->getInventory()->addItem(Item::get($item, 0, 1));
                            } else {
                                $player->getInventory()->addItem(Item::get($item, 0, (new Random())->nextRange(1, 4)));
                            }
                        }
                        $level->setBlockIdAt($x, $y, $z, Block::AIR);
                        break;
                    case 1:
                        break;
                }
                return;
            });
            $form->setTitle("Entität Unbekannt");
            $form->setContent("w bmhrsüe e Is ufeüo li,uiresil it.e vmct uihhact ninb, rer  ser kbTrdre  d nweindgd");
            $form->addButton("Nicken");
            $form->addButton("Fliehen");
            $form->sendToPlayer($event->getPlayer());
        }
    }
}