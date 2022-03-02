<?php

namespace nakidori\TapID;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\console\ConsoleCommandSender;

class Main extends PluginBase implements Listener{

    const ITEM_NAME = TextFormat::YELLOW."ID checker";

    public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onInteract(PlayerInteractEvent $event){
        if ($event->getAction() == PlayerInteractEvent::LEFT_CLICK_BLOCK) {
            return;
        }
        
        $item = $event->getItem();
        if ($item->getCustomName() == self::ITEM_NAME && $item->getId() == ItemIds::CLOCK) {
            $event->getPlayer()->sendMessage(TextFormat::YELLOW."Id : ".TextFormat::WHITE.$event->getBlock()->getId());
        }
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if ($command->getName() == "tapid") {
            if (!($sender instanceof ConsoleCommandSender)) {
                $item = ItemFactory::getInstance()->get(ItemIds::CLOCK)->setCustomName(self::ITEM_NAME);
                $sender->getInventory()->addItem($item);
                $sender->sendMessage("[TapID] ID checkerを取得しました");
                return true;
            }
        }
        return false;
    }

}
