<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\EventTeamModel;
use App\Models\TeamModel;
use App\Models\EventModel;
use App\Models\PlayerModel;
use App\Models\EventPlayerModel;
use App\Models\MatchPlayerModel;


class EventTeamController extends BaseController
{
    protected $eventTeamModel;
    protected $teamModel;
    protected $eventModel;
    protected $playerModel;
    protected $eventPlayerModel;

    protected $matchPlayerModel;

    public function __construct()
    {
        $this->eventTeamModel = new EventTeamModel();
        $this->teamModel = new TeamModel();
        $this->eventModel = new EventModel();
        $this->playerModel = new PlayerModel();
        $this->eventPlayerModel = new EventPlayerModel();
        $this->matchPlayerModel = new MatchPlayerModel();
    }

    public function view($eventTeamID)
    {
        $eventTeam = $this->eventTeamModel
            ->select('eventTeams.*, teams.*')
            ->join('teams', 'teams.teamID = eventTeams.teamID')
            ->find($eventTeamID);
        if (!$eventTeam) {
            return redirect()->back()->with('error', 'Event Team not found');
        }

        $event = $this->eventModel->find($eventTeam['eventID']);
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found');
        }

        // Get all event players for this event team
        $eventPlayers = $this->eventPlayerModel->where('eventTeamID', $eventTeamID)->findAll();

        $data = [
            'pageTitle' => 'View Event Team',
            'event' => $event,
            'eventTeam' => $eventTeam,
            'eventPlayers' => $eventPlayers
        ];

        return view('pages/eventTeam/eventTeamView', $data);
    }

    public function create($eventID)
    {
        $data = [
            'pageTitle' => 'Add Team to Event',
            'eventID' => $eventID,
            'availableTeams' => $this->teamModel->findAll()
        ];

        return view('pages/eventTeam/eventTeamCreate', $data);
    }

    public function createHandler()
    {
        $rules = [
            'teamIDs' => 'required',
            'teamIDs.*' => 'required|numeric|greater_than[0]',
            'eventID' => 'required|numeric|greater_than[0]',
            'group' => 'permit_empty|string|max_length[50]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $teamIDs = $this->request->getPost('teamIDs');
        $eventID = $this->request->getPost('eventID');
        $group = $this->request->getPost('group');

        $successCount = 0;
        $failCount = 0;

        foreach ($teamIDs as $teamID) {
            $data = [
                'teamID' => $teamID,
                'eventID' => $eventID,
                'group' => $group,
            ];

            if ($eventTeamID = $this->eventTeamModel->insert($data)) {
                $successCount++;
            } else {
                $failCount++;
            }

            // Get all players from the team and add them to the event
            $players = $this->playerModel->where('teamID', $teamID)->findAll();
            foreach ($players as $player) {
                $eventPlayerData = [
                    'eventTeamID' => $eventTeamID,
                    'playerID' => $player['playerID']
                ];
                $this->eventPlayerModel->insert($eventPlayerData);
            }
        }

        if ($successCount > 0) {
            $message = $successCount . ' team(s) added successfully';
            if ($failCount > 0) {
                $message .= ', ' . $failCount . ' failed';
            }
            return redirect()->to('OVR/handball/event/view/' . $eventID)->with('success', $message);
        }

        return redirect()->back()->withInput()->with('error', 'Failed to add teams');
    }

    public function edit($id)
    {
        $eventTeam = $this->eventTeamModel->find($id);
        if (!$eventTeam) {
            return redirect()->back()->with('error', 'Team not found');
        }

        $data = [
            'pageTitle' => 'Edit Event Team',
            'eventTeam' => $eventTeam,
            'team' => $this->teamModel->find($eventTeam['teamID'])
        ];

        return view('pages/eventTeam/eventTeamEdit', $data);
    }

    public function editHandler($id)
    {
        $rules = [
            'group' => 'permit_empty|string',
            'seedNumber' => 'permit_empty|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'group' => $this->request->getPost('group'),
            'rank' => $this->request->getPost('rank'),
            'win' => $this->request->getPost('win'),
            'tied' => $this->request->getPost('tied'),
            'lost' => $this->request->getPost('lost'),
        ];

        if ($this->eventTeamModel->update($id, $data)) {
            $eventTeam = $this->eventTeamModel->find($id);
            return redirect()->to('OVR/handball/event/view/' . $eventTeam['eventID'])->with('success', 'Team updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update team');
    }

    public function delete($id)
    {
        $eventTeam = $this->eventTeamModel->find($id);
        if (!$eventTeam) {
            return redirect()->back()->with('error', 'Team not found');
        }

        if ($this->eventTeamModel->delete($id)) {
            return redirect()->to('OVR/handball/event/view/' . $eventTeam['eventID'])->with('success', 'Team removed successfully');
        }

        return redirect()->back()->with('error', 'Failed to remove team');
    }

    public function restore($id)
    {
        $eventTeam = $this->eventTeamModel->withDeleted()->find($id);
        if (!$eventTeam) {
            return redirect()->back()->with('error', 'Team not found');
        }

        if ($this->eventTeamModel->restore($id)) {
            return redirect()->to('event/view/' . $eventTeam['eventID'])->with('success', 'Team restored successfully');
        }

        return redirect()->back()->with('error', 'Failed to restore team');
    }
}
