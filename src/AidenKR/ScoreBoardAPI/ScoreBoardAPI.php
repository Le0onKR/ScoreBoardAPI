<?php

namespace AidenKR\ScoreBoard;

use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\player\Player;

class ScoreBoardAPI
{
    public const DISPLAY_NAME = "§l§e- §f레온판타지 §e-";

    public function addScoreBoard(Player $player): void
    {
        $player->getNetworkSession()->sendDataPacket(
            SetDisplayObjectivePacket::create(
                'sidebar',
                $player->getName(),
                self::DISPLAY_NAME,
                'dummy',
                0
            )
        );
    }

    public function deleteScoreBoard(Player $player): void
    {
        $player->getNetworkSession()->sendDataPacket(
            RemoveObjectivePacket::create($player->getName())
        );
    }

    public function setLine(Player $player, array $lines): void
    {
        foreach ($lines as $key => $score) {
            $entry = new ScorePacketEntry();
            $entry->objectiveName = $player->getName();
            $entry->type = 3;
            $entry->customName = $score;
            $entry->score = $key;
            $entry->scoreboardId = $key;

            $pk = new SetScorePacket();
            $pk->type = 0;
            $pk->entries[$key] = $entry;
            $player->getNetworkSession()->sendDataPacket($pk);
        }
    }
}
