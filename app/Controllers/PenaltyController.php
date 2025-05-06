<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\penaltyModel;
use App\Models\MatchPlayerModel;

class PenaltyController extends BaseController
{
    public function index($matchPlayerID)
    {
        $penaltyModel = new penaltyModel();
        $matchPlayerModel = new MatchPlayerModel();

        $player = $matchPlayerModel
            ->select('matchPlayers.*, players.name, players.image')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchPlayerID', $matchPlayerID)
            ->first();

        $penalties = $penaltyModel->where('matchPlayerID', $matchPlayerID)->findAll();

        $data = [
            'pageTitle' => 'Player Penalties',
            'player' => $player,
            'penalties' => $penalties
        ];

        return view('pages/penalty/penalty', $data);
    }

    public function create($matchPlayerID)
    {
        $matchPlayerModel = new MatchPlayerModel();
        $player = $matchPlayerModel
            ->select('matchPlayers.*, players.name')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchPlayerID', $matchPlayerID)
            ->first();

        $data = [
            'pageTitle' => 'Add Penalty',
            'player' => $player
        ];

        return view('pages/penalty/penaltyCreate', $data);
    }

    public function createHandler($matchPlayerID)
    {
        $penaltyModel = new penaltyModel();
        $data = [
            'matchPlayerID'=> $matchPlayerID,
            'penaltyType' => $this->request->getPost('type'),
            'time' => $this->request->getPost('time'),
            'period' => $this->request->getPost('period')
        ];

        try {
            $penaltyModel->insert($data);
            return redirect()->route('event.match.team.player.penalty', [$matchPlayerID])
                ->with('success', 'Penalty added successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to add penalty: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($penaltyID)
    {
        $penaltyModel = new penaltyModel();
        $matchPlayerModel = new MatchPlayerModel();

        $penalty = $penaltyModel->find($penaltyID);
        $player = $matchPlayerModel
            ->select('matchPlayers.*, players.name')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchPlayerID', $penalty['matchPlayerID'])
            ->first();

        $data = [
            'pageTitle' => 'Edit Penalty',
            'penalty' => $penalty,
            'player' => $player
        ];

        return view('pages/penalty/penaltyEdit', $data);
    }

    public function editHandler($penaltyID)
    {
        $penaltyModel = new penaltyModel();
        $penalty = $penaltyModel->find($penaltyID);

        $data = [
            'penaltyType' => $this->request->getPost('type'),
            'time' => $this->request->getPost('time'),
            'period' => $this->request->getPost('period')
        ];
        try {
            $penaltyModel->update($penaltyID, $data);
            return redirect()->route('event.match.team.penalty', [$penalty['matchPlayerID']])
                ->with('success', 'Penalty updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update penalty: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function view($penaltyID)
    {
        $penaltyModel = new penaltyModel();
        $matchPlayerModel = new MatchPlayerModel();

        $penalty = $penaltyModel->find($penaltyID);
        $player = $matchPlayerModel
            ->select('matchPlayers.*, players.name, players.image')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchPlayerID', $penalty['matchPlayerID'])
            ->first();

        $data = [
            'pageTitle' => 'View Penalty',
            'penalty' => $penalty,
            'player' => $player
        ];

        return view('pages/penalty/penaltyView', $data);
    }

    public function delete($penaltyID)
    {
        $penaltyModel = new penaltyModel();
        try {
            $penaltyModel->delete($penaltyID);
            return redirect()->back()->with('success', 'Penalty deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete penalty: ' . $e->getMessage());
        }
    }

    public function restore($penaltyID)
    {
        $penaltyModel = new penaltyModel();
        try {
            $penaltyModel->update($penaltyID, ['isDeleted' => null]);
            return redirect()->back()->with('success', 'Penalty restored successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to restore penalty: ' . $e->getMessage());
        }
    }
}
