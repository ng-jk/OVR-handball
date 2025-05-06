<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PlayerModel;
use App\Models\TeamModel;

class PlayerController extends BaseController
{
    public function view($playerID)
    {
        helper('text');
        $playerModel = new playerModel();
        $data = [
                'pageTitle' => 'players',
                'player'=>$playerModel->find($playerID),

        ];
        return view('pages/player/playerView', $data);
    }

    public function edit($playerID)
    {
        helper('text');
        $playerModel = new PlayerModel();
        $teamModel = new TeamModel();
        $player = $playerModel->find($playerID);
        $data = [
                'pageTitle' => 'players',
                'team'=> $teamModel->find($player['teamID']),
                'teams'=> $teamModel->findAll(),
                'player' => $player,
        ];
        return view('pages/player/playerEdit', $data);
    }

    public function editHandler($playerID) {
        $playerModel = new PlayerModel();
        $player = $playerModel->find($playerID);
        $teamModel = new TeamModel();
        $team = $teamModel->find($player['teamID']);
        $rules = [
            'image' => [
                'label' => 'image',
                'rules' => [
                    'is_image[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                ],
            ],
            'gender' => [
                'label' => 'gender',
                'rules' => [
                    'matches[' . $team->gender . ']'
                ],
            ],
        ];
        if ($imageFile = $this->request->getFile('image')){
            if (!$this->validateData([],$rules)) {
                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
            }
        }
        if ($this->request->getPost('name')) $playerData['name'] = $this->request->getPost('name');
        if ($this->request->getPost('dateOfBirth')) $playerData['dateOfBirth'] = date('Y-m-d', strtotime($this->request->getPost('dateOfBirth')));
        if ($this->request->getPost('height')) $playerData['height'] = floatval($this->request->getPost('height'));
        if ($this->request->getPost('gender')) $playerData['gender'] = $this->request->getPost('gender');
        if ($this->request->getPost('weight')) $playerData['weight'] = floatval($this->request->getPost('weight'));
        if ($this->request->getPost('country')) $playerData['country'] = $this->request->getPost('country');
        if ($this->request->getPost('matchPlayed')) $playerData['matchPlayed'] = $this->request->getPost('matchPlayed');
        if ($this->request->getPost('goal')) $playerData['goal'] = $this->request->getPost('goal');
        if ($this->request->getPost('teamID')) $playerData['teamID'] = $this->request->getPost('teamID');
        if ($this->request->getPost('ranking')) $playerData['ranking'] = $this->request->getPost('ranking');
        if ($this->request->getPost('yellowCard')) $playerData['yellowCard'] = $this->request->getPost('yellowCard');
        if ($this->request->getPost('redCard')) $playerData['redCard'] = $this->request->getPost('redCard');
        if ($this->request->getPost('blueCard')) $playerData['blueCard'] = $this->request->getPost('blueCard');
        if ($this->request->getPost('2m1')) $playerData['2m1'] = $this->request->getPost('2m1');
        if ($this->request->getPost('2m2')) $playerData['2m2'] = $this->request->getPost('2m2');
        if ($this->request->getPost('2m3')) $playerData['2m3'] = $this->request->getPost('2m3');
        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $filePath =  '/uploads/playerImage/' . $player['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $imageFile->move( 'uploads/playerImage',$player['image']);
        }
        $playerModel->update($playerID,$playerData);
        return redirect()->route('team.view',[intval($playerData['teamID'])])->with('success', 'player edited successfully!');
    }

    public function create($id)
    {
        $teamModel = new TeamModel();
        $team = $teamModel->find($id);
        $data = [
            'pageTitle' => 'add new player',
            'teams'=> $teamModel->findAll(),
            'teamID'=> $id,
            'teamName'=> $team['name'],
        ];
        return view('/pages/player/playerCreate', $data);
    }

    public function createHandler() {
        $teamModel = new TeamModel();
        $team = $teamModel->find($this->request->getPost('teamID'));
        $rules = [
            'image' => [
                'label' => 'image',
                'rules' => [
                    'is_image[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                ],
            ],
            'gender' => [
                'label' => 'gender',
                'rules' => [
                    'matches[' . $team->gender . ']'
                ],
            ],
        ];

        if ($imageFile = $this->request->getFile('image')){
            if (!$this->validateData([],$rules)) {
                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
            }
        }
        if ($this->request->getPost('name')) $playerData['name'] = $this->request->getPost('name');
        if ($this->request->getPost('dateOfBirth')) $playerData['dateOfBirth'] = date('Y-m-d', strtotime($this->request->getPost('dateOfBirth')));
        if ($this->request->getPost('height')) $playerData['height'] = floatval($this->request->getPost('height'));
        if ($this->request->getPost('weight')) $playerData['weight'] = floatval($this->request->getPost('weight'));
        if ($this->request->getPost('country')) $playerData['country'] = $this->request->getPost('country');
        if ($this->request->getPost('teamID')) $playerData['teamID'] = $this->request->getPost('teamID');
        // Save image details to the database
        $playerModel = new PlayerModel();
        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $playerData['image'] = $imageFile->getRandomName();
            $imageFile->move( 'uploads/playerImage',$playerData['image']);
        }
        $playerModel->insert($playerData);
        return redirect()->route('team.view',[intval($playerData['teamID'])])->with('success', 'player added successfully!');
    }

    public function delete($id)
    {
        $playerModel = new PlayerModel();
        $player = $playerModel->withDeleted()->find($id);
        if (!empty($team['deleted_at'])) {
            $filePath =  '/uploads/playerImage/' . $player['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $playerModel->delete($id, true);
        } else {
            $playerModel->delete($id);
            $playerModel->withDeleted()->update($id, ['ranking' => null]);
        }
        return redirect()->back()->with('success', 'delete successfully!');
    }

    public function restore($id)
    {
        $playerModel = new playerModel();
        $playerModel->withDeleted()->update($id, ['deleted_at' => null]);
        return redirect()->back()->with('success', 'restore successfully!');
    }
}
