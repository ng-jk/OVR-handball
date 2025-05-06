<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ShotModel;
use App\Models\MatchPlayerModel;

class ShotController extends BaseController
{
    public function index($matchPlayerID)
    {
        $shotModel = new ShotModel();
        $matchPlayerModel = new MatchPlayerModel();

        $player = $matchPlayerModel
            ->select('matchPlayers.*, players.name, players.image')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchPlayerID', $matchPlayerID)
            ->first();

        $shots = $shotModel->where('matchPlayerID', $matchPlayerID)->findAll();

        $data = [
            'pageTitle' => 'Player Shots',
            'player' => $player,
            'shots' => $shots
        ];

        return view('pages/shot/shot', $data);
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
            'pageTitle' => 'Add Shot',
            'player' => $player
        ];

        return view('pages/shot/shotCreate', $data);
    }

    public function createHandler($matchPlayerID)
    {
        $shotModel = new ShotModel();
        $data = [
            'shotType' => $this->request->getPost('shotType'),
            'goalType' => $this->request->getPost('goalType'),
            'destType' => $this->request->getPost('destType'),
            'period' => $this->request->getPost('period'),
            'time' => $this->request->getPost('time'),
            'defenseType' => $this->request->getPost('defenseType'),
            'tacticType' => $this->request->getPost('tacticType'),
            'speed' => $this->request->getPost('speed'),
            'matchPlayerID' => $matchPlayerID,
        ];

        try {
            $shotModel->insert($data);
            return redirect()->route('event.match.team.player.shot', [$matchPlayerID])
                ->with('success', 'Shot added successfully');
        } catch (\Exception $e) {
            return redirect()->route('event.match.team.player.shot', [$matchPlayerID])
                ->with('error', 'Failed to add shot: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($shotID)
    {
        $shotModel = new ShotModel();
        $matchPlayerModel = new MatchPlayerModel();

        $shot = $shotModel->find($shotID);
        $player = $matchPlayerModel
            ->select('matchPlayers.*, players.name')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchPlayerID', $shot['matchPlayerID'])
            ->first();

        $data = [
            'pageTitle' => 'Edit Shot',
            'shot' => $shot,
            'player' => $player
        ];

        return view('pages/shot/shotEdit', $data);
    }

    public function editHandler($shotID)
    {
        $shotModel = new ShotModel();
        $shot = $shotModel->find($shotID);

        $data = [
            'shotType' => $this->request->getPost('shotType'),
            'goalType' => $this->request->getPost('goalType'),
            'destType' => $this->request->getPost('destType'),
            'period' => $this->request->getPost('period'),
            'time' => $this->request->getPost('time'),
            'defenseType' => $this->request->getPost('defenseType'),
            'tacticType' => $this->request->getPost('tacticType'),
            'goalKeeperID' => $this->request->getPost('goalKeeperID'),
            'speed' => $this->request->getPost('speed')
        ];

        try {
            $shotModel->update($shotID, $data);
            return redirect()->route('event.match.team.shot', [$shot['matchPlayerID']])
                ->with('success', 'Shot updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update shot: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function view($shotID)
    {
        $shotModel = new ShotModel();
        $matchPlayerModel = new MatchPlayerModel();

        $shot = $shotModel->find($shotID);
        $player = $matchPlayerModel
            ->select('matchPlayers.*, players.name, players.image')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchPlayerID', $shot['matchPlayerID'])
            ->first();

        $data = [
            'pageTitle' => 'View Shot',
            'shot' => $shot,
            'player' => $player
        ];

        return view('pages/shot/shotView', $data);
    }

    public function delete($shotID)
    {
        $shotModel = new ShotModel();
        try {
            $shotModel->delete($shotID);
            return redirect()->back()->with('success', 'Shot deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete shot: ' . $e->getMessage());
        }
    }

    public function restore($shotID)
    {
        $shotModel = new ShotModel();
        try {
            $shotModel->update($shotID, ['isDeleted' => null]);
            return redirect()->back()->with('success', 'Shot restored successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to restore shot: ' . $e->getMessage());
        }
    }
}
