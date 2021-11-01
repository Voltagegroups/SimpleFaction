<?php

/***
 *       _____ _                 _      ______         _   _
 *      / ____(_)               | |    |  ____|       | | (_)
 *     | (___  _ _ __ ___  _ __ | | ___| |__ __ _  ___| |_ _  ___  _ __
 *      \___ \| | '_ ` _ \| '_ \| |/ _ \  __/ _` |/ __| __| |/ _ \| '_ \
 *      ____) | | | | | | | |_) | |  __/ | | (_| | (__| |_| | (_) | | | |
 *     |_____/|_|_| |_| |_| .__/|_|\___|_|  \__,_|\___|\__|_|\___/|_| |_|
 *                        | |
 *                        |_|
 */

namespace Ayzrix\SimpleFaction\Events\Listener;

use Ayzrix\SimpleFaction\API\FactionsAPI;
use Ayzrix\SimpleFaction\Utils\Utils;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\level\format\Chunk;

class BlockListener implements Listener {

    public function BlockBreak(BlockBreakEvent $event): void{
        $player = $event->getPlayer();
        if (in_array($player->getLevel()->getFolderName(), Utils::getIntoConfig("faction_worlds"))) {
            $chunk = $player->getLevel()->getChunkAtPosition($event->getBlock());
            if ($chunk instanceof Chunk) {
                $chunkX = $chunk->getX();
                $chunkZ = $chunk->getZ();
                if (FactionsAPI::isInClaim($player->getLevel(), $chunkX, $chunkZ)) {
                    if (FactionsAPI::isInFaction($player->getName())) {
                        $claimer = FactionsAPI::getFactionClaim($player->getLevel(), $chunkX, $chunkZ);
                        $faction = FactionsAPI::getFaction($player->getName());
                        if ($faction !== $claimer) $event->setCancelled(true);
                    } else $event->setCancelled(true);
                }
            }
        }
    }

    public function BlockPlace(BlockPlaceEvent $event): void {
        $player = $event->getPlayer();
        if (in_array($player->getLevel()->getFolderName(), Utils::getIntoConfig("faction_worlds"))) {
            $chunk = $player->getLevel()->getChunkAtPosition($event->getBlock());
            if ($chunk instanceof Chunk) {
                $chunkX = $chunk->getX();
                $chunkZ = $chunk->getZ();
                if (FactionsAPI::isInClaim($player->getLevel(), $chunkX, $chunkZ)) {
                    if (FactionsAPI::isInFaction($player->getName())) {
                        $claimer = FactionsAPI::getFactionClaim($player->getLevel(), $chunkX, $chunkZ);
                        $faction = FactionsAPI::getFaction($player->getName());
                        if ($faction !== $claimer) $event->setCancelled(true);
                    } else $event->setCancelled(true);
                }
            }
        }
    }
}