<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventOfficialModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\EventModel;
use App\Models\PartnerModel;
use App\Models\TeamModel;
use App\Models\EventTeamModel;


class EventController extends BaseController
{
    public function index()
    {
        helper('text');
        $eventModel = new EventModel();
        $data = [
                'pageTitle' => 'events',
                'events' => $eventModel->findAll(),
                'deletedEvents'=>$eventModel->onlyDeleted()->findAll()
        ];
        return view('pages/event/event', $data);
    }
    public function view($id)
    {
        helper('text');
        $eventModel = new EventModel();
        $eventOfficialModel = new EventOfficialModel();
        $partnerModel = new PartnerModel();
        $teamModel = new TeamModel();
        $eventTeamModel = new EventTeamModel();
        $data = [
            'pageTitle' => 'events',
            'event' => $eventModel->find($id),
            'partners' => $partnerModel->where('eventID', $id)->findAll(),
            'officials' => $eventOfficialModel->where('eventID', $id)->findAll(),
            'teams' => !empty($eventTeamModel->where('eventID', $id)->findAll()) 
            ? $teamModel->whereIn('teamID', array_column($eventTeamModel->where('eventID', $id)->findAll(), 'teamID'))->findAll() 
            : [],
        ];
        return view('pages/event/eventView', $data);
    }

    public function edit($id)
    {
        helper('text');
        $eventModel = new EventModel();
        $event = $eventModel->find($id);
        $data = [
                'pageTitle' => 'edit events',
                'event'=>$event,
        ];
        return view('pages/event/eventEdit', $data);
    }

    public function editHandler($id) {
        $eventModel = new EventModel();
        $event = $eventModel->find($id);
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
        if ($this->request->getPost('name')) $eventData['name'] = $this->request->getPost('name');
        if ($this->request->getPost('startDate')) $eventData['startDate'] = date('Y-m-d', strtotime($this->request->getPost('startDate')));
        if ($this->request->getPost('endDate')) $eventData['endDate'] = date('Y-m-d', strtotime($this->request->getPost('endDate')));
        if ($this->request->getPost('series')) $eventData['series'] = $this->request->getPost('series');
        if ($this->request->getPost('rules')) $eventData['rules'] = $this->request->getPost('rules');
        if ($this->request->getPost('candidateNum')) $eventData['candidateNum'] = $this->request->getPost('candidateNum');
        if ($this->request->getPost('address')) $eventData['address'] = $this->request->getPost('address');
        if ($this->request->getPost('hall')) $eventData['hall'] = $this->request->getPost('hall');
        if ($this->request->getPost('age')) $eventData['age'] = $this->request->getPost('age');
        if ($this->request->getPost('gender')) $eventData['gender'] = $this->request->getPost('gender');
        if ($imageFile = $this->request->getFile('image')){
            if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                $filePath =  '/uploads/eventLogo/' . $event['logo'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $imageFile->move('uploads/eventLogo', $event['logo']);
            }
        }
        $eventModel->update($id,$eventData);
        return redirect()->route('event.view',[intval($id)])->with('success', 'event edited successfully!');
    }

    public function create()
    {
        $data = [
            'pageTitle' => 'add new event',
        ];
        return view('/pages/event/eventCreate', $data);
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
        if ($this->request->getPost('name')) $eventData['name'] = $this->request->getPost('name');
        if ($this->request->getPost('startDate')) $eventData['startDate'] = date('Y-m-d', strtotime($this->request->getPost('startDate')));
        if ($this->request->getPost('endDate')) $eventData['endDate'] = date('Y-m-d', strtotime($this->request->getPost('endDate')));
        if ($this->request->getPost('series')) $eventData['series'] = $this->request->getPost('series');
        if ($this->request->getPost('rules')) $eventData['rules'] = $this->request->getPost('rules');
        if ($this->request->getPost('candidateNum')) $eventData['candidateNum'] = $this->request->getPost('candidateNum');
        if ($this->request->getPost('address')) $eventData['address'] = $this->request->getPost('address');
        if ($this->request->getPost('hall')) $eventData['hall'] = $this->request->getPost('hall');
        if ($this->request->getPost('age')) $eventData['age'] = $this->request->getPost('age');
        if ($this->request->getPost('gender')) $eventData['gender'] = $this->request->getPost('gender');
        $eventModel = new EventModel();
        if ($imageFile = $this->request->getFile('image')) {
            if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                $eventData['logo'] = $imageFile->getRandomName();
                $imageFile->move('uploads/eventLogo', $eventData['logo']);
            }
        }
        $eventModel->insert($eventData);

        return redirect()->route('event')->with('success', 'event create successfully!');
    }

    public function delete($id)
    {
        $eventModel = new EventModel();
        $event = $eventModel->withDeleted()->find($id);
        if (!empty($team['deleted_at'])) {
            $filePath =  '/uploads/eventLogo/' . $event['logo'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $eventModel->delete($id, true);
        } else {
            $eventModel->delete($id);
        }
        return redirect()->back()->with('success', 'delete successfully!');
    }

    public function restore($id)
    {
        $eventModel = new EventModel();
        $eventModel->withDeleted()->update($id, ['deleted_at' => null]);
        return redirect()->back()->with('success', 'restore successfully!');
    }
}
