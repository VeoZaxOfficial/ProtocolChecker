<?php

declare(strict_types=1);

namespace ProtocolChecker;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;

class Main extends PluginBase implements Listener{

    public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onLogin(PlayerLoginEvent $event) : void{
        $player = $event->getPlayer();
        $protocol = $player->getProtocol();

        $this->getLogger()->info("Incoming Login Protocol: " . $protocol);

        if(!$this->isAllowed($protocol)){
            $event->setKickMessage("§cThis Server Only Supports 0.15.x and 1.1.5 Versions.");
            $event->setCancelled(true);
        }
    }

    public function onJoin(PlayerJoinEvent $event) : void{
        $player = $event->getPlayer();
        $protocol = $player->getProtocol();

        $this->getLogger()->info("Incoming Protocol: " . $protocol);

        if(!$this->isAllowed($protocol)){
            $player->kick("§cThis Server Only Supports 0.15.x and 1.1.5 Versions.", false);
        }
    }

    private function isAllowed(int $protocol) : bool{
        return ($protocol >= 81 && $protocol <= 84) || $protocol === 113;
    }
}