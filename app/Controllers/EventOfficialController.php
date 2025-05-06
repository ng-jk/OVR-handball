<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class EventOfficialController extends BaseController
{
    protected $eventOfficialModel;
    protected $officialModel;
    protected $validation;

    public function __construct()
    {
        $this->eventOfficialModel = new \App\Models\EventOfficialModel();
        $this->officialModel = new \App\Models\OfficialModel();
        $this->validation = \Config\Services::validation();
    }

    public function view($id)
    {
        $eventOfficial = $this->eventOfficialModel->find($id);
        if (!$eventOfficial) {
            return redirect()->back()->with('error', 'Official not found');
        }

        $official = $this->officialModel->find($eventOfficial['officialID']);
        return view('pages/eventOfficial/eventOfficialView', [
            'eventOfficial' => $eventOfficial,
            'official' => $official
        ]);
    }

    public function create($eventID)
    {
        return view('pages/eventOfficial/eventOfficialCreate', [
            'eventID' => $eventID,
        ]);
    }

    public function createHandler()
    {
        $rules = [
            'image' => 'is_image[image]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        // Create event official record
        $eventOfficialData = [
            'name' => $this->request->getPost('name'),
            'eventID' => $this->request->getPost('eventID'),
            'function' => $this->request->getPost('function'),
            'dateOfBirth' => date('Y-m-d', strtotime($this->request->getPost('date'))),
        ];

        // Handle image upload
        if ($image = $this->request->getFile('image')) {
            if ($image->isValid() && !$image->hasMoved()) {
                $newName = $image->getRandomName();
                $image->move(FCPATH . 'uploads/eventOfficialImage', $newName);
                $eventOfficialData['image'] = $newName;
            }
        }

        $this->eventOfficialModel->insert($eventOfficialData);

        return redirect()->to(route_to('event.view', $this->request->getPost('eventID')))
            ->with('success', 'Official added successfully');
    }

    public function edit($id)
    {
        $eventOfficial = $this->eventOfficialModel->find($id);
        if (!$eventOfficial) {
            return redirect()->back()->with('error', 'Official not found');
        }

        $official = $this->officialModel->find($eventOfficial['officialID']);
        return view('pages/eventOfficial/eventOfficialEdit', [
            'eventOfficial' => $eventOfficial,
            'official' => $official
        ]);
    }

    public function editHandler($id)
    {
        $rules = [
            'role' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $eventOfficial = $this->eventOfficialModel->find($id);
        if (!$eventOfficial) {
            return redirect()->back()->with('error', 'Official not found');
        }

        $this->eventOfficialModel->update($id, [
            'role' => $this->request->getPost('role')
        ]);

        return redirect()->to(route_to('event.view', $eventOfficial['eventID']))
            ->with('success', 'Official updated successfully');
    }

    public function delete($id)
    {
        $eventOfficial = $this->eventOfficialModel->find($id);
        if (!$eventOfficial) {
            return redirect()->back()->with('error', 'Official not found');
        }

        $this->eventOfficialModel->delete($id);
        return redirect()->back()->with('success', 'Official removed successfully');
    }

    public function restore($id)
    {
        $this->eventOfficialModel->update($id, ['deleted_at' => null]);
        return redirect()->back()->with('success', 'Official restored successfully');
    }
}

