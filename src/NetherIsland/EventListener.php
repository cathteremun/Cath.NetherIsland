<?php

declare(strict_types=1);

namespace NetherIsland;

use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\ChangeDimensionPacket;
use pocketmine\player\Player;
use pocketmine\world\Explosion;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\Random;

class EventListener implements Listener {

    public $plugin;
    public $chestData;

    public function __construct(Main $plugin, array $chestData) {
        $this->plugin = $plugin;
        $this->chestData = $chestData;
    }
    //API 4.5.2 Fix
    public function onWorldChange(EntityTeleportEvent $event) {
        $entity = $event->getEntity();

        if($entity instanceof Player) {
            $originGenerator = $event->getFrom()->getWorld()->getProvider()->getWorldData()->getGenerator();
            $targetGenerator = $event->getTo()->getWorld()->getProvider()->getWorldData()->getGenerator();

            if($this->getDimensionId($originGenerator) == $this->getDimensionId($targetGenerator)) return;

            $pk = new ChangeDimensionPacket();
            $pk->dimension = $this->getDimensionId($targetGenerator);
            $pk->position = $event->getTo()->getWorld()->getSpawnLocation();

            $entity->getNetworkSession()->sendDataPacket($pk);
        }
    }

    public function getDimensionId(string $generator) : int {
        switch ($generator) {
            case "tnether":
            case "nether":
                return 1;
            case "ender":
            case "end":
                return 2;
            default:
                return 0;
        }
    }

    //Probably not working anymore
    /*
    public function onBreakNetherReactor(BlockBreakEvent $event) {
        $block = $event->getBlock();
        if($block->getId() === Block::NETHERREACTOR) {
            $event->getPlayer()->sendMessage(Main::PREFIX . "Entität Unbekannt: Du bist noch nicht §kbereit §rdieses §kGeheimnis §rzu erfahren§k!§r");
            $event->setCancelled(true);
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

    public function interactNetherReactor(PlayerInteractEvent $event) {
        $block = $event->getBlock();
        if($block->getId() == VanillaBlocks::NETHER_REACTOR_CORE()) {
            $event->getPlayer()->sendMessage("Something tells you that this will have a deeper thought");
        }
    }

    public function interactGlowing(PlayerInteractEvent $event) {
        $block = $event->getBlock();
        if($block->getId() === Block::GLOWING_OBSIDIAN) {
            $level = $event->getPlayer()->getLevel();
            $x = $block->getX();
            $y = $block->getY();
            $z = $block->getZ();

            $form = new SimpleForm(function (Player $player, $data) use ($x, $y, $z, $level) {
                if ($data === null) {
                    return;
                }
                switch ($data) {
                    case 0:
                        for($i = 0; $i < 6;) {
                            $this->EntityGift($player);
                            $i++;
                        }
                        $level->setBlockIdAt($x, $y, $z, Block::AIR);
                        break;
                    case 1:
                        break;
                }
                return;
            });
            $form->setTitle("Entität §kUnbekannt");
            $form->setContent("§kWie ich sehe erfüllst du meine Anforderungen. Nimm meinen Tribut als Dank");
            $form->addButton("Nicken");
            $form->addButton("Fliehen");
            $form->sendToPlayer($event->getPlayer());
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
    */
}