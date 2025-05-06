<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class EventPlayerController extends BaseController
{
    protected $eventPlayerModel;
    protected $eventModel;
    protected $playerModel;
    protected $teamModel;
    protected $eventTeamModel;

    public function __construct()
    {
        $this->eventPlayerModel = new \App\Models\EventPlayerModel();
        $this->eventModel = new \App\Models\EventModel();
        $this->playerModel = new \App\Models\PlayerModel();
        $this->teamModel = new \App\Models\TeamModel();
        $this->eventTeamModel = new \App\Models\EventTeamModel();
    }

    public function index()
    {
        $data['eventPlayers'] = $this->eventPlayerModel->getEventPlayers();
        $data['deletedEventPlayers'] = $this->eventPlayerModel->getDeletedEventPlayers();
        
        return view('pages/eventPlayer/eventPlayer', $data);
    }

    public function create()
    {
        $data['events'] = $this->eventModel->findAll();
        $data['teams'] = $this->teamModel->findAll();
        $data['players'] = $this->playerModel->findAll();
        
        return view('pages/eventPlayer/eventPlayerCreate', $data);
    }

    public function createHandler()
    {
        $rules = [
            'eventID' => 'required',
            'playerID' => 'required',
            'jerseyNo' => 'required|numeric',
            'position' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'eventID' => $this->request->getPost('eventID'),
            'playerID' => $this->request->getPost('playerID'),
            'jerseyNo' => $this->request->getPost('jerseyNo'),
            'position' => $this->request->getPost('position'),
            'status' => 'active'
        ];

        $this->eventPlayerModel->insert($data);
        return redirect()->to('eventPlayer')->with('success', 'Event Player registered successfully');
    }

    public function view($id)
    {
        $data['eventPlayer'] = $this->eventPlayerModel->getEventPlayer($id);
        
        if (empty($data['eventPlayer'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('pages/eventPlayer/eventPlayerView', $data);
    }

    public function edit($id)
    {
        $data['eventPlayer'] = $this->eventPlayerModel->find($id);
        
        if (empty($data['eventPlayer'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['events'] = $this->eventModel->findAll();
        $data['teams'] = $this->teamModel->findAll();
        $data['players'] = $this->playerModel->findAll();

        return view('pages/eventPlayer/eventPlayerEdit', $data);
    }

    public function editHandler($id)
    {
        $rules = [
            'eventID' => 'required',
            'playerID' => 'required',
            'jerseyNo' => 'required|numeric',
            'position' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'eventID' => $this->request->getPost('eventID'),
            'playerID' => $this->request->getPost('playerID'),
            'jerseyNo' => $this->request->getPost('jerseyNo'),
            'position' => $this->request->getPost('position'),
            'status' => $this->request->getPost('status')
        ];

        $this->eventPlayerModel->update($id, $data);
        return redirect()->to('eventPlayer')->with('success', 'Event Player updated successfully');
    }

    public function delete($id)
    {
        $this->eventPlayerModel->delete($id);
        return redirect()->to('eventPlayer')->with('success', 'Event Player deleted successfully');
    }

    public function restore($id)
    {
        $this->eventPlayerModel->restore($id);
        return redirect()->to('eventPlayer')->with('success', 'Event Player restored successfully');
    }

    public function getTeamPlayers()
    {
        $teamID = $this->request->getPost('teamID');
        $players = $this->playerModel->where('teamID', $teamID)->findAll();
        return $this->response->setJSON($players);
    }
}
