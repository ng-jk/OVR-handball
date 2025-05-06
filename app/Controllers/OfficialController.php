<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\OfficialModel;
use App\Models\TeamModel;

class OfficialController extends BaseController
{
    public function view($officialID)
    {
        helper('text');
        $officialModel = new officialModel();
        $data = [
                'pageTitle' => 'officials',
                'official'=>$officialModel->find($officialID),
        ];
        return view('pages/official/officialView', $data);
    }

    public function edit($officialID)
    {
        helper('text');
        $officialModel = new OfficialModel();
        $teamModel = new TeamModel();
        $official = $officialModel->find($officialID);
        $data = [
                'pageTitle' => 'officials',
                'team'=> $teamModel->find($official['teamID']),
                'teams'=> $teamModel->findAll(),
                'official' => $official,
        ];
        return view('pages/official/officialEdit', $data);
    }

    public function editHandler($officialID) {
        $officialModel = new OfficialModel();
        $official = $officialModel->find($officialID);
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
        if ($this->request->getPost('name')) $officialData['name'] = $this->request->getPost('name');
        if ($this->request->getPost('dateOfBirth')) $officialData['dateOfBirth'] = date('Y-m-d', strtotime($this->request->getPost('dateOfBirth')));
        if ($this->request->getPost('teamID')) $officialData['teamID'] = $this->request->getPost('teamID');
        if ($this->request->getPost('function')) $officialData['function'] = $this->request->getPost('function');
        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $filePath =  '/uploads/officialImage/' . $official['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $imageFile->move( 'uploads/officialImage',$official['image']);
        }
        $officialModel->update($officialID,$officialData);
        return redirect()->route('team.view',[intval($officialData['teamID'])])->with('success', 'official edited successfully!');
    }

    public function create($id)
    {
        $teamModel = new TeamModel();
        $data = [
            'pageTitle' => 'add new official',
            'teams'=> $teamModel->findAll(),
            'teamID'=>$id,
        ];
        return view('/pages/official/officialCreate', $data);
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
        if ($this->request->getPost('name')) $officialData['name'] = $this->request->getPost('name');
        if ($this->request->getPost('dateOfBirth')) $officialData['dateOfBirth'] = date('Y-m-d', strtotime($this->request->getPost('dateOfBirth')));
        if ($this->request->getPost('teamID')) $officialData['teamID'] = $this->request->getPost('teamID');
        if ($this->request->getPost('function')) $officialData['function'] = $this->request->getPost('function');
        // Save image details to the database
        $officialModel = new OfficialModel();
        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $officialData['image'] = $imageFile->getRandomName();
            $imageFile->move( 'uploads/officialImage',$officialData['image']);
        }
        $officialModel->insert($officialData);
        return redirect()->route('team.view',[intval($officialData['teamID'])])->with('success', 'official added successfully!');
    }

    public function delete($id)
    {
        $officialModel = new OfficialModel();
        $official = $officialModel->withDeleted()->find($id);
        if (!empty($team['deleted_at'])) {
            $filePath =  '/uploads/officialImage/' . $official['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $officialModel->delete($id, true);
        } else {
            $officialModel->delete($id);
        }
        return redirect()->back()->with('success', 'delete successfully!');
    }

    public function restore($id)
    {
        $officialModel = new OfficialModel();
        $officialModel->withDeleted()->update($id, ['deleted_at' => null]);
        return redirect()->back()->with('success', 'restore successfully!');
    }
}
