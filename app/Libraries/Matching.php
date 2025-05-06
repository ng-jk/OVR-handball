<?php

namespace App\Libraries;

use App\Models\EventTeamModel;
use App\Models\MatchModel;
use App\Models\EventModel;
use App\Models\TeamModel;
use App\Models\MatchTeamModel;

class Matching
{
    protected $eventTeamModel;
    protected $matchModel;
    protected $eventModel;
    protected $teamModel;
    protected $matchTeamModel;
    protected $teams = [];

    public function __construct()
    {
        $this->eventTeamModel = new EventTeamModel();
        $this->matchModel = new MatchModel();
        $this->eventModel = new EventModel();
        $this->teamModel = new TeamModel();
        $this->matchTeamModel = new MatchTeamModel();
    }

    public function generateLeagueMatch($eventID)
    {
        // Get teams and sort them by seed
        $teams = $this->eventTeamModel
            ->where('eventID', $eventID)
            ->orderBy('seed', 'ASC')
            ->where('seed !=', 0)
            ->findAll();

        // Classify teams by group
        $teamsByGroup = [];
        foreach ($teams as $team) {
            $group = $team['group'];
            if (!isset($teamsByGroup[$group])) {
                $teamsByGroup[$group] = [];
            }
            $teamsByGroup[$group][] = $team;
        }

        // Generate matches for each group
        foreach ($teamsByGroup as $group => $groupTeams) {
            $teamCount = count($groupTeams);
            // Each team plays against every other team in their group
            for ($i = 0; $i < $teamCount; $i++) {
                for ($j = $i + 1; $j < $teamCount; $j++) {
                    // Create match record
                    $matchData = [
                        'eventID' => $eventID,
                        'round' => 1, // League matches are all round 1
                        'matchDate' => date('Y-m-d'),
                        'status' => 'ready',
                        'team1ID' => $groupTeams[$i]['eventTeamID'],
                        'team2ID' => $groupTeams[$j]['eventTeamID'],
                        'group' => $group
                    ];
                    $matchDataArray[$group][] = $matchData;
                }
            }
        }
        if (isset($matchDataArray)) {
            return $matchDataArray;
        }
    }

    public function generateKnockoutMatch($eventID)
    {
        // Get teams and sort them by seed
        $teams = $this->eventTeamModel
            ->where('eventID', $eventID)
            ->orderBy('rank', 'ASC')
            ->where('seed !=', 0)
            ->findAll();

        // Calculate total rounds needed
        $teamCount = count($teams);
        $totalRounds = ceil(log($teamCount, 2));

        // Generate first round matches
        $matchDataArray = [];
        for ($i = 0; $i < $teamCount; $i += 2) {
            if (isset($teams[$i + 1])) {
                $matchData = [
                    'eventID' => $eventID,
                    'round' => $totalRounds,
                    'matchDate' => date('Y-m-d'),
                    'status' => 'ready',
                    'team1ID' => $teams[$i]['eventTeamID'],
                    'team2ID' => $teams[$i + 1]['eventTeamID']
                ];
                $matchDataArray[] = $matchData;
            }
        }
        dd($matchDataArray);

        // Generate pending matches for subsequent rounds
        for ($round = $totalRounds - 1; $round >= 1; $round--) {
            $numMatches = pow(2, $round - 1);
            for ($i = 0; $i < $numMatches; $i++) {
                $matchData = [
                    'eventID' => $eventID,
                    'round' => $round,
                    'matchDate' => date('Y-m-d'),
                    'status' => 'pending',
                    'team1ID' => null,
                    'team2ID' => null
                ];
                $matchDataArray[] = $matchData;
            }
        }
        if (isset($matchDataArray)) {
            return $matchDataArray;
        }
    }

    public function generateCombineMatch($eventID)
    {
        $event = $this->eventModel->find($eventID);
        $matchDataArray = [];

        // Generate league matches first
        $leagueMatches = $this->generateLeagueMatch($eventID);
        foreach ($leagueMatches as $group => $matches) {
            $matchDataArray['league'][$group] = $matches;
        }

        // Get event details to determine knockout participants
        $event = $this->eventModel->find($eventID);
        $numTeamsPerGroup = $event['candidateNum'];
        $totalGroups = count($matchDataArray['league']);

        // Total teams in knockout phase
        $totalParticipants = $numTeamsPerGroup * $totalGroups;

        // Calculate number of matches needed for first round
        $firstRoundMatches = ceil($totalParticipants / 2);
        $totalRounds = ceil(log($firstRoundMatches, 2)) + 1;

        // Generate knockout matches starting from first round
        $knockoutMatches = [];
        $currentRoundMatches = $firstRoundMatches;

        for ($round = $totalRounds; $round >= 1; $round--) {
            for ($i = 0; $i < $currentRoundMatches; $i++) {
                $matchData = [
                    'eventID' => $eventID,
                    'round' => $round,
                    'matchDate' => date('Y-m-d'),
                    'status' => 'pending',
                    'team1ID' => null,
                    'team2ID' => null,
                    'isKnockout' => true
                ];
                $knockoutMatches[] = $matchData;
            }
            $currentRoundMatches = ceil($currentRoundMatches / 2);
        }

        $matchDataArray['knockout'] = $knockoutMatches;
        if (isset($matchDataArray)) {
            return $matchDataArray;
        }
    }

    public function assignSeeds($eventID)
    {
        $teams = $this->eventTeamModel
            ->where('eventID', $eventID)
            ->findAll();
        shuffle($teams);
        foreach ($teams as $index => $team) {
            $this->eventTeamModel->update($team['eventTeamID'], [
                'seed' => $index + 1
            ]);
        }
        return true;
    }

    public function insertMatches($matchDataArray)
        {
            try {
                // Insert league matches
                if (isset($matchDataArray['league'])) {
                    foreach ($matchDataArray['league'] as $group => $matches) {
                        foreach ($matches as $match) {
                            $matchID = $this->matchModel->insert($match);
                            $teamData = [
                                'eventTeamID' => $match['team1ID'],
                                'matchID' => $matchID,
                            ];
                            $this->matchTeamModel->insert($teamData);
                            $teamData = [
                                'eventTeamID' => $match['team2ID'],
                                'matchID' => $matchID,
                            ];
                            $this->matchTeamModel->insert($teamData);
                        }
                    }
                }
                // Insert knockout matches
                if (isset($matchDataArray['knockout'])) {
                    foreach ($matchDataArray['knockout'] as $match) {
                        $this->matchModel->insert($match);
                        $teamData = [
                            'eventTeamID' => $match['team1ID'],
                            'matchID' => $matchID,
                        ];
                        $this->matchTeamModel->insert($teamData);
                        $teamData = [
                            'eventTeamID' => $match['team2ID'],
                            'matchID' => $matchID,
                        ];
                        $this->matchTeamModel->insert($teamData);
                    }
                }
                return true;
            } catch (\Exception $e) {
                // Log error or handle exception
                dd([$e]);
            }
        }
}
