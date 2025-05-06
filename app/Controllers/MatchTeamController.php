<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MatchModel;
use App\Models\MatchTeamModel;
use App\Models\EventTeamModel;
use App\Models\TeamModel;

class MatchTeamController extends BaseController
{
    public function view($matchTeamID)
    {
        $matchTeamModel = new MatchTeamModel();

        $team = $matchTeamModel
            ->select('matchTeams.*, eventTeams.*, teams.*')
            ->join('eventTeams', 'eventTeams.eventTeamID = matchTeams.eventTeamID')
            ->join('teams', 'teams.teamID = eventTeams.teamID')
            ->where('matchTeams.matchTeamID', $matchTeamID)
            ->first();
        $data = [
            'pageTitle' => 'Team Match Details',
            'team' => $team
        ];
        return view('pages/matchTeam/matchTeamView', $data);
    }

    public function edit($matchTeamID)
    {
        $matchModel = new MatchModel();
        $matchTeamModel = new MatchTeamModel();
        $matchTeam = $matchTeamModel->find($matchTeamID);

        $match = $matchModel->find($matchTeam['matchID']);
        $team = $matchTeamModel
            ->select('matchTeams.*, eventTeams.*, teams.*')
            ->join('eventTeams', 'eventTeams.eventTeamID = matchTeams.eventTeamID')
            ->join('teams', 'teams.teamID = eventTeams.teamID')
            ->where('matchTeams.matchTeamID', $matchTeamID)
            ->first();

        $data = [
            'pageTitle' => 'Edit Team Match Details',
            'match' => $match,
            'team' => $team
        ];

        return view('pages/matchTeam/matchTeamEdit', $data);
    }

    public function editHandler($matchTeamID)
    {
        $matchTeamModel = new MatchTeamModel();
        $matchTeam = $matchTeamModel->find($matchTeamID);
        $data = [
            'halftime' => $this->request->getPost('halftime'),
            'endOfPlaying' => $this->request->getPost('endOfPlaying'),
            'overtime1' => $this->request->getPost('overtime1'),
            'overtime2' => $this->request->getPost('overtime2'),
            'afterPenalityThrow' => $this->request->getPost('afterPenalityThrow'),
            '7mShot' => $this->request->getPost('7mShot'),
            '7mGoal' => $this->request->getPost('7mGoal'),
            'teamTimeout1' => $this->request->getPost('teamTimeout1'),
            'teamTimeout2' => $this->request->getPost('teamTimeout2'),
            'teamTimeout3' => $this->request->getPost('teamTimeout3'),
            'pointInMatch' => $this->request->getPost('pointInMatch'),
        ];
        try {
            $matchTeamModel->update($matchTeamID, $data);
            return redirect()->back()->with('success', 'Team match details updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update team match details: ' . $e->getMessage());
        }
    }

    public function delete($matchID, $teamID)
    {
        $matchTeamModel = new MatchTeamModel();

        try {
            $matchTeamModel->where('matchID', $matchID)
                ->where('eventTeamID', $teamID)
                ->update(null, ['isDeleted' => 1]);

            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function restore($matchID, $teamID)
    {
        $matchTeamModel = new MatchTeamModel();

        try {
            $matchTeamModel->where('matchID', $matchID)
                ->where('eventTeamID', $teamID)
                ->update(null, ['isDeleted' => 0]);

            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
