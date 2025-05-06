<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MatchModel;
use App\Models\MatchOfficialModel;
use App\Models\EventOfficialModel;
use App\Models\OfficialModel;

class MatchOfficialController extends BaseController
{
    public function index($matchID)
    {
        $matchModel = new MatchModel();
        $matchOfficialModel = new MatchOfficialModel();

        $match = $matchModel->find($matchID);
        $officials = $matchOfficialModel
            ->select('match_officials.*, officials.name, officials.image, officials.licenseNo')
            ->join('event_officials', 'event_officials.eventOfficialID = match_officials.eventOfficialID')
            ->join('officials', 'officials.officialID = event_officials.officialID')
            ->where('match_officials.matchID', $matchID)
            ->findAll();

        $data = [
            'pageTitle' => 'Match Officials',
            'match' => $match,
            'officials' => $officials
        ];

        return view('pages/match/officials', $data);
    }

    public function assign($matchID)
    {
        $matchModel = new MatchModel();
        $eventOfficialModel = new EventOfficialModel();
        
        $match = $matchModel->find($matchID);
        $availableOfficials = $eventOfficialModel
            ->select('event_officials.*, officials.name, officials.licenseNo')
            ->join('officials', 'officials.officialID = event_officials.officialID')
            ->where('event_officials.eventID', $match['eventID'])
            ->findAll();

        $data = [
            'pageTitle' => 'Assign Officials',
            'match' => $match,
            'availableOfficials' => $availableOfficials
        ];

        return view('pages/match/assignOfficials', $data);
    }

    public function assignHandler($matchID)
    {
        $matchOfficialModel = new MatchOfficialModel();
        $officials = $this->request->getPost('officials');
        $roles = $this->request->getPost('roles');

        try {
            // Remove existing officials
            $matchOfficialModel->where('matchID', $matchID)->delete();

            // Assign new officials
            foreach ($officials as $key => $eventOfficialID) {
                if (!empty($roles[$key])) {
                    $matchOfficialModel->insert([
                        'matchID' => $matchID,
                        'eventOfficialID' => $eventOfficialID,
                        'role' => $roles[$key]
                    ]);
                }
            }

            return redirect()->route('match.officials', [$matchID])
                           ->with('success', 'Officials assigned successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to assign officials: ' . $e->getMessage());
        }
    }

    public function updateRole($matchID, $eventOfficialID)
    {
        $matchOfficialModel = new MatchOfficialModel();
        $role = $this->request->getPost('role');

        try {
            $matchOfficialModel->update(
                ['matchID' => $matchID, 'eventOfficialID' => $eventOfficialID],
                ['role' => $role]
            );
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function remove($matchID, $eventOfficialID)
    {
        $matchOfficialModel = new MatchOfficialModel();

        try {
            $matchOfficialModel->where('matchID', $matchID)
                             ->where('eventOfficialID', $eventOfficialID)
                             ->delete();
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
