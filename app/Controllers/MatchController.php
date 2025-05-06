<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MatchModel;
use App\Models\MatchTeamModel;
use App\Models\MatchPlayerModel;
use App\Models\MatchOfficialModel;
use App\Models\EventModel;
use App\Models\EventTeamModel;
use App\Models\EventPlayerModel;
use App\Models\EventOfficialModel;
use App\Models\PlayerModel;
use App\Models\TeamModel;
use App\Libraries\Matching;

class MatchController extends BaseController
{
    protected $match;
    public function __construct()
    {
        $this->match = new Matching();
    }
    public function index()
    {
        helper('text');
        $eventModel = new EventModel();
        $data = [
            'pageTitle' => 'matches',
            'events' => $eventModel->findAll(),
        ];
        return view('pages/match/match', $data);
    }

    public function view($eventID)
    {
        helper('text');
        $matchModel = new MatchModel();
        $eventModel = new EventModel();
        $matchTeams = $matchModel->select('matches.*, matchteams.*, eventteams.*, teams.*')
            ->join('matchteams', 'matchteams.matchID = matches.matchID')
            ->join('eventteams', 'eventteams.eventTeamID = matchteams.eventTeamID')
            ->join('teams', 'teams.teamID = eventteams.teamID')
            ->where('matches.eventID', $eventID)
            ->findAll();
        $matches = $matchModel->where('eventID', $eventID)->findAll();

        // Group teams by matchID
        foreach ($matches as &$match) {
            $match['teams'] = array_values(array_filter($matchTeams, function($team) use ($match) {
                return $team['matchID'] === $match['matchID'];
            }));
        }
        $data = [
            'pageTitle' => 'match details',
            'matches' => $matches,
            'event' => $eventModel->find($eventID),
        ];
        return view('pages/match/matchView', $data);
    }

    public function viewDetail($matchID)
    {
        helper('text');
        $matchModel = new MatchModel();
        $matchTeamModel = new MatchTeamModel();
        $matchPlayerModel = new MatchPlayerModel();
        $matchOfficialModel = new MatchOfficialModel();

        $match = $matchModel->find($matchID);
        $matchTeams = $matchTeamModel
            ->select('matchteams.*, teams.*, eventteams.*')
            ->join('eventteams', 'eventteams.eventTeamID = matchteams.eventTeamID')
            ->join('teams', 'teams.teamID = eventteams.teamID')
            ->where('matchID', $matchID)
            ->findAll();

        $matchOfficials = $matchOfficialModel
            ->select('matchofficials.*, eventofficials.*')
            ->join('eventofficials', 'eventofficials.eventOfficialID = matchofficials.eventOfficialID')
            ->where('matchID', $matchID)
            ->findAll();

        $data = [
            'pageTitle' => 'match details',
            'match' => $match,
            'matchTeams' => $matchTeams,
            'matchOfficials' => $matchOfficials,
        ];

        return view('pages/match/matchDetail', $data);
    }

    public function edit($matchID)
    {
        helper('text');
        $matchModel = new MatchModel();
        $eventTeamModel = new EventTeamModel();
        $matchTeamModel = new MatchTeamModel();
        $teamModel = new TeamModel();

        $match = $matchModel->find($matchID);

        $eventTeams = $eventTeamModel
            ->select('eventteams.*, teams.*')
            ->join('teams', 'teams.teamID = eventteams.teamID')
            ->where('eventID', $match['eventID'])
            ->findAll();

        $matchTeams = $matchTeamModel
            ->select('matchteams.*, teams.*, eventteams.*')
            ->join('eventteams', 'eventteams.eventTeamID = matchteams.eventTeamID')
            ->join('teams', 'teams.teamID = eventteams.teamID')
            ->where('matchID', $matchID)
            ->findAll();

        $data = [
            'pageTitle' => 'edit match',
            'match' => $match,
            'eventTeams' => $eventTeams,
            'matchTeams' => $matchTeams,
        ];
        return view('pages/match/matchEdit', $data);
    }

    public function editHandler($matchID)
    {
        $matchModel = new MatchModel();
        $match = $matchModel->find($matchID);

        $matchData = [
            'hall' => $this->request->getPost('hall'),
            'dateTime' => date('Y-m-d H:i:s', strtotime($this->request->getPost('dateTime'))),
            'spectator' => $this->request->getPost('spectator'),
            'matchNo' => $this->request->getPost('matchNo'),
            'remark' => $this->request->getPost('remark'),
            'status' => $this->request->getPost('status'),
            'winner' => $this->request->getPost('winner')
        ];

        $matchModel->update($matchID, $matchData);
        return redirect()->route('event.match.view', [$match['eventID']])->with('success', 'Match updated successfully!');
    }

    public function create($eventID)
    {
        $eventModel = new EventModel();
        $eventTeamModel = new EventTeamModel();
        $eventOfficialModel = new EventOfficialModel();
        $event = $eventModel->find($eventID);
        $eventTeams = $eventTeamModel->where('eventID', $eventID)->findAll();
        $eventTeams = $eventTeamModel
            ->select('eventteams.*, teams.*')
            ->join('teams', 'teams.teamID = eventteams.teamID')
            ->where('eventteams.eventID', $eventID)
            ->findAll();
        $data = [
            'pageTitle' => 'create match',
            'event' => $event,
            'eventTeams' => $eventTeams,
            'officials' => $eventOfficialModel->where('eventID', $eventID)->findAll(),
        ];
        return view('pages/match/matchCreate', $data);
    }

    public function createHandler()
    {
        $matchModel = new MatchModel();
        $matchTeamModel = new MatchTeamModel();
        $matchOfficialModel = new MatchOfficialModel();
        $matchData = [
            'eventID' => $this->request->getPost('eventID'),
            'hall' => $this->request->getPost('hall'),
            'dateTime' => date('Y-m-d H:i:s', strtotime($this->request->getPost('dateTime'))),
            'spectator' => $this->request->getPost('spectator'),
            'matchNo' => $this->request->getPost('matchNo'),
            'remark' => $this->request->getPost('remark'),
            'status' => $this->request->getPost('status'),
        ];
        $matchID = $matchModel->insert($matchData);
        // Get team IDs from request
        $teamID1 = $this->request->getPost('teamID1');
        $teamID2 = $this->request->getPost('teamID2');

        // Check if both teams exist and are different
        if (!$teamID1 && !$teamID2) {
            return redirect()->back()->with('error', 'Both teams must be selected');
        }

        if ($teamID1 === $teamID2) {
            return redirect()->back()->with('error', 'Cannot select the same team twice');
        }

        if ($teamID1){
            $team1Data = [
                'eventTeamID' => $teamID1,
                'matchID' => $matchID,
            ];
            $matchTeamModel->insert($team1Data);
        }
        if ($teamID2) {
            $team2Data = [
                'eventTeamID' => $teamID2,
                'matchID' => $matchID,
            ];
            $matchTeamModel->insert($team2Data);
        }
        // Check if official ID exists before inserting
        if ($this->request->getPost('officialID')) {
            $officialData = [
                'eventOfficialID' => $this->request->getPost('officialID'),
                'matchID' => $matchID,
            ];
            $matchOfficialModel->insert($officialData);
        }
        return redirect()->route('event.match.view', [$this->request->getPost('eventID')])->with('success', 'Match created successfully!');
    }

    public function delete($matchID)
    {
        $matchModel = new MatchModel();
        $match = $matchModel->withDeleted()->find($matchID);

        if (!empty($match['deleted_at'])) {
            $matchModel->delete($matchID, true);
        } else {
            $matchModel->delete($matchID);
        }
        return redirect()->back()->with('success', 'Match deleted successfully!');
    }

    public function restore($matchID)
    {
        $matchModel = new MatchModel();
        $matchModel->withDeleted()->update($matchID, ['deleted_at' => null]);
        return redirect()->back()->with('success', 'Match restored successfully!');
    }

    public function generate($eventID)
    {
        $eventModel = new EventModel();
        $event = $eventModel->find($eventID);

        switch ($event['rules']) {
            case 'league':
                $this->match->assignSeeds($eventID);
                $this->match->insertMatches($this->match->generateLeagueMatch($eventID));
                return redirect()->route('event.match.view', [$eventID])->with('success', 'Match league schedule generated successfully!');

            case 'knockout':
                $this->match->assignSeeds($eventID);
                $this->match->insertMatches($this->match->generateKnockoutMatch($eventID));
                return redirect()->route('event.match.view', [$eventID])->with('success', 'Match knockout schedule generated successfully!');

            case 'combine':
                $this->match->assignSeeds($eventID);
                $this->match->insertMatches($this->match->generateCombineMatch($eventID));
                return redirect()->route('event.match.view', [$eventID])->with('success', 'Match combined schedule generated successfully!');

            default:
                return redirect()->back()->with('error', 'Invalid tournament rules selected! try create match manually');
        }
    }
}
