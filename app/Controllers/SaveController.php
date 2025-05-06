<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SaveModel;
use App\Models\MatchPlayerModel;

class SaveController extends BaseController
{
    public function index($matchPlayerID)
    {
        $saveModel = new SaveModel();
        $matchPlayerModel = new MatchPlayerModel();

        $player = $matchPlayerModel
            ->select('matchPlayers.*, players.name, players.image')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchPlayerID', $matchPlayerID)
            ->first();

        $saves = $saveModel->where('matchPlayerID', $matchPlayerID)->findAll();

        $data = [
            'pageTitle' => 'Player Saves',
            'player' => $player,
            'saves' => $saves
        ];

        return view('pages/save/save', $data);
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
            'pageTitle' => 'Add Save',
            'player' => $player
        ];

        return view('pages/save/saveCreate', $data);
    }

    public function createHandler($matchPlayerID)
    {
        $saveModel = new SaveModel();
        $data = [
            'isSaved' => $this->request->getPost('isSaved'),
            'saveType' => $this->request->getPost('saveType'),
            'defenseType' => $this->request->getPost('defenseType'),
            'tacticType' => $this->request->getPost('tacticType'),
            'time' => $this->request->getPost('time'),
            'period' => $this->request->getPost('period'),
            'matchPlayerID' => $matchPlayerID,
        ];

        try {
            $saveModel->insert($data);
            return redirect()->route('event.match.team.player.save', [$matchPlayerID])
                ->with('success', 'Save added successfully');
        } catch (\Exception $e) {
            return redirect()->route('event.match.team.player.save.create', [$matchPlayerID])
                ->with('error', 'Failed to add save: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($saveID)
    {
        $saveModel = new SaveModel();
        $matchPlayerModel = new MatchPlayerModel();

        $save = $saveModel->find($saveID);
        $player = $matchPlayerModel
            ->select('matchPlayers.*, players.name')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchPlayerID', $save['matchPlayerID'])
            ->first();

        $data = [
            'pageTitle' => 'Edit Save',
            'save' => $save,
            'player' => $player
        ];

        return view('pages/save/saveEdit', $data);
    }

    public function editHandler($saveID)
    {
        $saveModel = new SaveModel();
        $save = $saveModel->find($saveID);

        $data = [
            'isSaved' => $this->request->getPost('isSaved'),
            'saveType' => $this->request->getPost('saveType'),
            'defenseType' => $this->request->getPost('defenseType'),
            'tacticType' => $this->request->getPost('tacticType'),
            'time' => $this->request->getPost('time'),
            'period' => $this->request->getPost('period')
        ];

        try {
            $saveModel->update($saveID, $data);
            return redirect()->route('event.match.team.save', [$save['matchPlayerID']])
                ->with('success', 'Save updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update save: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function view($saveID)
    {
        $saveModel = new SaveModel();
        $matchPlayerModel = new MatchPlayerModel();

        $save = $saveModel->find($saveID);
        $player = $matchPlayerModel
            ->select('matchPlayers.*, players.name, players.image')
            ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchPlayers.eventPlayerID')
            ->join('players', 'players.playerID = eventPlayers.playerID')
            ->where('matchPlayers.matchPlayerID', $save['matchPlayerID'])
            ->first();

        $data = [
            'pageTitle' => 'View Save',
            'save' => $save,
            'player' => $player
        ];

        return view('pages/save/saveView', $data);
    }

    public function delete($saveID)
    {
        $saveModel = new SaveModel();
        try {
            $saveModel->delete($saveID);
            return redirect()->back()->with('success', 'Save deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete save: ' . $e->getMessage());
        }
    }

    public function restore($saveID)
    {
        $saveModel = new SaveModel();
        try {
            $saveModel->update($saveID, ['isDeleted' => null]);
            return redirect()->back()->with('success', 'Save restored successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to restore save: ' . $e->getMessage());
        }
    }
}
