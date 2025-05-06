<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TeamModel;
use App\Models\PlayerModel;
use App\Models\OfficialModel;

class TeamController extends BaseController
{
    public function index()
    {
        helper('text');
        $teamModel = new TeamModel();
        $data = [
                'pageTitle' => 'teams',
                'teams' => $teamModel->findAll(),
                'deletedTeams'=>$teamModel->onlyDeleted()->findAll()
        ];
        return view('pages/team/team', $data);
    }

    public function view($teamID)
    {
        helper('text');
        $teamModel = new TeamModel();
        $officialModel = new officialModel();
        $playerModel = new playerModel();
        $data = [
                'pageTitle' => 'teams',
                'team' => $teamModel->find($teamID),
                'officials'=>$officialModel->where('teamID', $teamID)->findAll(),
                'deletedOfficials'=>$officialModel->onlyDeleted()->where('teamID', $teamID)->findAll(),
                'players'=>$playerModel->where('teamID', $teamID)->findAll(),
                'deletedPlayers'=>$playerModel->onlyDeleted()->where('teamID', $teamID)->findAll(),
        ];
        return view('pages/team/teamView', $data);
    }

    public function edit($teamID)
    {
        helper('text');
        $teamModel = new TeamModel();
        $data = [
                'pageTitle' => 'teams',
                'team' => $teamModel->find($teamID),
        ];
        return view('pages/team/teamEdit', $data);
    }

    public function editHandler($teamID) {
        $teamModel = new TeamModel();
        $team = $teamModel->find($teamID);
        $rules = [
            'image' => [
                'label' => 'image',
                'rules' => [
                    'is_image[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                ],
            ],
        ];
        if ($imageFile = $this->request->getFile('image')){
            if (!$this->validateData([],$rules)) {
                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
            }
        }
        if($this->request->getPost('name')) $teamData['name'] = $this->request->getPost('name');
        if($this->request->getPost('country')) $teamData['country'] = $this->request->getPost('country');
        if($this->request->getPost('state')) $teamData['state'] = $this->request->getPost('state');
        if($this->request->getPost('teamInfo')) $teamData['teamInfo'] = $this->request->getPost('teamInfo');
        if($this->request->getPost('dateFounded')) $teamData['dateFounded'] = date('Y-m-d', strtotime($this->request->getPost('dateFounded')));

        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $filePath =  '/uploads/teamLogo/' . $team['logo'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $imageFile->move( 'uploads/teamLogo',$team['logo']);
        }
        $teamModel->update($teamID,$teamData);
        return redirect()->route('team');
    }

    public function create()
    {
        $data = [
            'pageTitle' => 'create team',
        ];
        return view('/pages/team/teamCreate', $data);
    }

    public function createHandler() {
        $rules = [
            'image' => [
                'label' => 'image',
                'rules' => [
                    'is_image[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                ],
            ],
        ];

        if ($imageFile = $this->request->getFile('image')){
            if (!$this->validateData([],$rules)) {
                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
            }
        }
        //not best practice
        if($this->request->getPost('name')) $teamData['name'] = $this->request->getPost('name');
        if($this->request->getPost('country')) $teamData['country'] = $this->request->getPost('country');
        if($this->request->getPost('state')) $teamData['state'] = $this->request->getPost('state');
        if($this->request->getPost('teamInfo')) $teamData['teamInfo'] = $this->request->getPost('teamInfo');
        if($this->request->getPost('dateFounded')) $teamData['dateFounded'] = date('Y-m-d', strtotime($this->request->getPost('dateFounded')));

        // Save image details to the database
        $teamModel = new TeamModel();
        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $teamData['logo'] = $imageFile->getRandomName();
            $imageFile->move( 'uploads/teamLogo',$teamData['logo']);
        }
        $teamModel->insert($teamData);
        return redirect()->back()->with('success', 'team created successfully!');
    }

    public function delete($id)
    {
        $teamModel = new TeamModel();
        $team = $teamModel->withDeleted()->find($id);

        if (!empty($team['deleted_at'])) {
            $filePath =  '/uploads/teamLogo/' . $team['logo'];
            if (file_exists($filePath) && !empty($team['logo']) ) {
                unlink($filePath);
            }
            try{
                $teamModel->delete($id, true);
            }catch(\Exception $e){
                return redirect()->back()->with('error',['you need to delete all players and officials of this team first',$e->getMessage()]);
            }
        } else {
            $teamModel->delete($id);
            $teamModel->withDeleted()->update($id, ['ranking' => null]);
        }
        return redirect()->back()->with('success', 'delete successfully!');
    }

    public function restore($id)
    {
        $teamModel = new TeamModel();
        $teamModel->withDeleted()->update($id, ['deleted_at' => null]);
        return redirect()->back()->with('success', 'restore successfully!');
    }
}
