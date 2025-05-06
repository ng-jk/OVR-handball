<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MatchModel;
use App\Models\MatchPlayerModel;
use App\Models\EventPlayerModel;
use App\Models\PlayerModel;
use App\Models\TeamModel;

class MatchPlayerController extends BaseController
{
    public function index($matchTeamID)
    {
        $matchPlayerModel = new MatchPlayerModel();

        $players = $matchPlayerModel
            ->select('matchPlayers.*, eventPlayers.*, players.*')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchTeamID', $matchTeamID)
            ->findAll();

        $data = [
            'pageTitle' => 'All Players in Match',
            'players' => $players,
            'matchTeamID' => $matchTeamID,
        ];

        return view('pages/matchPlayer/matchPlayer', $data);
    }
    public function view($matchPlayerID)
    {
        $matchPlayerModel = new MatchPlayerModel();
        $player = $matchPlayerModel
            ->select('matchPlayers.*, eventPlayers.*, players.*')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchPlayerID', $matchPlayerID)
            ->first();

        $data = [
            'pageTitle' => 'Player In Match Details',
            'matchPlayerID' => $matchPlayerID,
            'player' => $player
        ];

        return view('pages/matchPlayer/matchPlayerView', $data);
    }

    public function create($matchTeamID)
    {
        $eventPlayerModel = new EventPlayerModel();
        $matchModel = new MatchModel();
        $match = $matchModel
            ->select('eventTeams.eventTeamID')
            ->join('matchTeams', 'matchTeams.matchID = matches.matchID')
            ->join('eventTeams', 'eventTeams.eventTeamID = matchTeams.eventTeamID')
            ->where('matchTeams.matchTeamID', $matchTeamID)
            ->first();

        $eventTeamID = $match['eventTeamID'];

        // Now get players using the event team ID
        $players = $eventPlayerModel
            ->select('eventplayers.*, players.*')
            ->join('players', 'players.playerID = eventplayers.playerID')
            ->where('eventplayers.eventTeamID', $eventTeamID)
            ->findAll();
        $data = [
            'pageTitle' => 'Add Player to Match',
            'players' => $players,
            'matchTeamID' => $matchTeamID,
        ];

        return view('pages/matchPlayer/matchPlayerCreate', $data);
    }

    public function createHandler()
    {
        // Validate if required data exists
        if (!($matchTeamID = $this->request->getPost('matchTeamID')) || !($players = $this->request->getPost('playerIDs'))) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Required data is missing');
        }

        $matchPlayerModel = new MatchPlayerModel();

        $data = [];
        foreach ($players as $player) {

            $data[] = [
                'matchTeamID' => $matchTeamID,
                'eventPlayerID' => $player,
            ];
        }

        try {
            // Check if data array is not empty
            if (empty($data)) {
                throw new \Exception('No valid player data to insert');
            }

            $matchPlayerModel->insertBatch($data);
            return redirect()
                ->route('event.match.team.player', [$matchTeamID])
                ->with('success', 'Players added to match successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to add players to match: ' . $e->getMessage());
        }
    }

    public function edit($matchPlayerID)
    {
        $matchPlayerModel = new MatchPlayerModel();
        $player = $matchPlayerModel
            ->select('matchPlayers.*, eventPlayers.*, players.*')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchPlayerID', $matchPlayerID)
            ->first();

        $data = [
            'pageTitle' => 'Edit Player Match Details',
            'player' => $player
        ];

        return view('pages/matchPlayer/matchPlayerEdit', $data);
    }

    public function editHandler($matchPlayerID)
    {
        $matchPlayerModel = new MatchPlayerModel();

        $data = [
            'position' => $this->request->getPost('position') ?? '',
            'matchGoal' => $this->request->getPost('matchGoal') ?? 0,
            'matchShot' => $this->request->getPost('matchShot') ?? 0,
            'matchSave' => $this->request->getPost('matchSave') ?? 0,
            'isStartingLineUp' => $this->request->getPost('isStartingLineUp') ?? 0,
            'totalPerformanceTime' => $this->request->getPost('totalPerformanceTime') ?? 0,
            'assist' => $this->request->getPost('assist') ?? 0,
            'passClearChance' => $this->request->getPost('passClearChance') ?? 0,
            'earned7mPen' => $this->request->getPost('earned7mPen') ?? 0,
            'earned2mPun' => $this->request->getPost('earned2mPun') ?? 0,
            'technicalFault' => $this->request->getPost('technicalFault') ?? 0,
            'steal' => $this->request->getPost('steal') ?? 0,
            'commit7m' => $this->request->getPost('commit7m') ?? 0,
            'block' => $this->request->getPost('block') ?? 0,
        ];

        try {
            $matchPlayerModel->update($matchPlayerID, $data);
            return redirect()
                ->route('event.match.team.player', $data['matchTeamID'])
                ->with('success', 'Player match details updated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update player match details: ' . $e->getMessage());
        }
    }

    public function delete($matchPlayerID)
    {
        $matchPlayerModel = new MatchPlayerModel();

        try {
            $matchPlayerModel->delete($matchPlayerID);
            return redirect()
                ->back()
                ->with('success', 'Player deleted successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete player: ' . $e->getMessage());
        }
    }

    public function restore($matchPlayerID)
    {
        $matchPlayerModel = new MatchPlayerModel();

        try {
            $matchPlayerModel->update($matchPlayerID, ['isDeleted' => 0]);
            return redirect()
                ->back()
                ->with('success', 'Player restored successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to restore player: ' . $e->getMessage());
        }
    }
}
