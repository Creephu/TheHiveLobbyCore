<?php

namespace DrelezTM\TheHiveLobbyCore;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as C;
use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;

class Main extends PluginBase implements Listener {
    
    public function onEnable(){
        $this->getServer()->getLogger()->info("§f[§aEnabled§f] TheHiveLobbyCore");
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function onLoad(){
        $this->getServer()->getLogger()->info("§f[§eLoading§f] TheHiveLobbyCore");
    }

    public function onDisable(){
        $this->getServer()->getLogger()->info("§f[§cDisable§f] TheHiveLobbyCore");
    }

    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $player->getInventory()->clearAll();
        $item1 = Item::get(345, 0, 1);
        $item2 = Item::get(450, 0, 1);
        $item3 = Item::get(421, 0, 1);
        $item4 = Item::get(403, 0, 1);
        $item1->setCustomName($this->cfg->get("item1-name"));
        $item2->setCustomName($this->cfg->get("item2-name"));
        $item3->setCustomName($this->cfg->get("item3-name"));
        $item4->setCustomName($this->cfg->get("item4-name"));
        $player->getInventory()->setItem(0, $item1);
        $player->getInventory()->setItem(6, $item2);
        $player->getInventory()->setItem(7, $item3);
        $player->getInventory()->setItem(8, $item4);
    }

    public function onClick(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $itn = $player->getInventory()->getItemInHand()->getCustomName();
        if($itn == $this->cfg->get("item1-name")){
            $this->getServer()->getCommandMap()->dispatch($player, $this->cfg->get("item1-cmd"));
        }
        if($itn == $this->cfg->get("item2-name")){
            $this->getServer()->getCommandMap()->dispatch($player, $this->cfg->get("item2-cmd"));
        }
        if($itn == $this->cfg->get("item3-name")){
            $this->getServer()->getCommandMap()->dispatch($player, $this->cfg->get("item3-cmd"));
        }
        if($itn == $this->cfg->get("item4-name")){
            $this->getServer()->getCommandMap()->dispatch($player, $this->cfg->get("item4-cmd"));
        }
    }

    public function onInventory(InventoryTransactionEvent $event){
        $event->setCancelled(true);
    }
}
