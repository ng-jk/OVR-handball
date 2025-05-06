<?php

namespace App\Libraries;

use App\Models\EventPlayerModel;
use App\Models\ShotModel;

class UpdateMatch
{
    public function UpdateMatchStatus($matchID)
    {
        $shotModel = new ShotModel();
        $eventPlayerModel = new EventPlayerModel();

        $goalStats = $shotModel
            ->select('eventplayers.eventPlayerID, matchteams.eventTeamID, COUNT(*) as goalCount')
            ->join('matchplayers', 'matchplayers.matchPlayerID = shots.matchPlayerID')
            ->join('eventplayers', 'eventplayers.eventPlayerID = matchplayers.eventPlayerID')
            ->join('matchteams', 'matchteams.matchTeamID = matchplayers.matchTeamID')
            ->where('matchteams.matchID', $matchID)
            ->where('shots.goalType', 'goal')
            ->groupBy('eventplayers.eventPlayerID')
            ->findAll();

        // Update event player stats
        foreach ($goalStats as $stat) {
            $eventPlayerModel->set('goal', 'goal + ' . $stat['goalCount'], false)
                ->where('eventPlayerID', $stat['eventPlayerID'])
                ->update();
        }
    }
}