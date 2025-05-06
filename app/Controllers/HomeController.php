<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UpdateMatch;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\EventModel;
use App\Models\EventOfficialModel;
use App\Models\EventPlayerModel;
use App\Models\EventTeamModel;
use App\Models\MatchModel;
use App\Models\MatchOfficialModel;
use App\Models\MatchPlayerModel;
use App\Models\MatchTeamModel;
use App\Models\OfficialModel;
use App\Models\PartnerModel;
use App\Models\PenaltyModel;
use App\Models\PlayerModel;
use App\Models\ShotModel;
use App\Models\SaveModel;
use App\Models\TeamModel;
class HomeController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle' => 'dashboard',
        ];

        $eventModel = new EventModel();
        $events = $eventModel->findAll();

        $teamModel = new TeamModel();
        $teams = $teamModel->findAll();

        $matchModel = new MatchModel();
        $matches = $matchModel->findAll();

        $data['events'] = $events;
        $data['teams'] = $teams;
        $data['matches'] = $matches;
        return view('pages/home', $data);
    }

    public function uploadTeamFileHandler()
    {
        $file = $this->request->getFile('teamUpload');
        $selection = $this->request->getPost('fileSelection');

        if ($file->isValid() && !$file->hasMoved()) {
            // Define the upload path
            $uploadPath = WRITEPATH . 'uploads/team/';

            // Generate unique filename
            $newFileName = $file->getRandomName();

            // Move the file to the upload directory
            if (!$file->move($uploadPath, $newFileName)) {
                session()->setFlashdata('error', 'Failed to move uploaded file.');
                return redirect()->route('home');
            }

            // Process the CSV file
            $filePath = $uploadPath . $newFileName;
            $csvData = array_map('str_getcsv', file($filePath));

            // Process different file types based on selection
            switch ($selection) {
                case 'team':
                    // Process team CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);
                    $teamModel = new TeamModel();
                    foreach ($csvData as $row) {
                        $teamData = [
                            'teamID' => $row[0],
                            'name' => $row[1],
                            'teamInfo' => $row[2],
                            'dateFounded' => date('Y-m-d', strtotime($row[3])),
                            'country' => $row[4],
                            'state' => ($row[4] === 'Malaysia') ? $row[5] : "",
                            'gender' => $row[6]
                        ];
                        $teamModel->save($teamData);
                    }
                    break;

                case 'official':
                    // Process team CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);
                    $officialModel = new OfficialModel();
                    foreach ($csvData as $row) {
                        $teamData = [
                            'officialID' => $row[0],
                            'name' => $row[1],
                            'dateOfBirth' => date('Y-m-d', strtotime($row[2])),
                            'teamID' => empty($row[3]) ? (session()->setFlashdata('error', 'Team ID cannot be empty.') && redirect()->route('home')) : $row[3],
                            'function' => $row[4]
                        ];
                        $officialModel->save($teamData);
                    }
                    break;

                case 'player':
                    // Process player CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);
                    $playerModel = new PlayerModel();
                    foreach ($csvData as $row) {
                        $playerData = [
                            'playerID' => $row[0],
                            'name' => $row[1],
                            'dateOfBirth' => date('Y-m-d', strtotime($row[2])),
                            'height' => $row[3],
                            'weight' => $row[4],
                            'gender' => $row[5],
                            'country' => $row[6],
                            'teamID' => empty($row[7]) ? (session()->setFlashdata('error', 'Team ID cannot be empty.') && redirect()->route('home')) : $row[7],
                        ];
                        $playerModel->save($playerData);
                    }
                    break;

                default:
                    // Handle unknown selection type
                    session()->setFlashdata('error', 'Invalid file type selection.');
                    return redirect()->route('home');
            }
            // Set success message
            session()->setFlashdata('success', 'csv file uploaded successfully.');
        } else {
            // Set error message
            session()->setFlashdata('error', 'Failed to upload file.');
        }
        return redirect()->route('home');
    }

    public function downloadTeamFileHandler()
    {
        $fileSelection = $this->request->getPost('fileSelection');
        $teamID = $this->request->getPost('teamID');

        // Create CSV headers based on selection
        switch ($fileSelection) {
            case 'team':
                $teamModel = new TeamModel();
                $data = $teamModel->select('teamID, name, teamInfo, dateFounded, country, state, gender')->findAll();
                $headers = ['TeamID', 'Name', 'Team Info', 'Date Founded', 'Country', 'State', 'Gender'];
                break;

            case 'official':
                $officialModel = new OfficialModel();
                $data = $officialModel
                    ->select('teamofficials.officialID, teamofficials.name, teamofficials.dateOfBirth, teamofficials.function, teams.teamID, teams.name as teamName')
                    ->join('teams', 'teams.teamID = teamofficials.teamID')
                    ->where('teamofficials.teamID', $teamID)
                    ->findAll();
                $headers = ['Official ID', 'Name', 'Date of Birth', 'Function', 'Team ID', 'Team Name'];
                break;

            case 'player':
                $playerModel = new PlayerModel();
                $data = $playerModel
                    ->select('players.playerID, players.name, players.dateOfBirth, players.height, players.weight, players.gender, players.country, teams.teamID, teams.name as teamName')
                    ->join('teams', 'teams.teamID = players.teamID')
                    ->where('players.teamID', $teamID)
                    ->findAll();
                $headers = ['Player ID', 'Name', 'Date of Birth', 'Height', 'Weight', 'Gender', 'Country', 'Team ID', 'Team Name'];
                break;

            default:
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid file type selection']);
        }

        // Create temporary file
        $temp = fopen('php://temp', 'w+');

        // Write headers
        fputcsv($temp, $headers);

        // Write data rows
        foreach ($data as $row) {
            if ($fileSelection === 'team') {
                fputcsv($temp, [
                    $row['teamID'],
                    $row['name'],
                    $row['teamInfo'],
                    $row['dateFounded'],
                    $row['country'],
                    $row['state'],
                    $row['gender']
                ]);
            } elseif ($fileSelection === 'official') {
                fputcsv($temp, [
                    $row['officialID'],
                    $row['name'],
                    $row['dateOfBirth'],
                    $row['function'],
                    $row['teamID'],
                    $row['teamName']
                ]);
            } else { // player
                fputcsv($temp, [
                    $row['playerID'],
                    $row['name'],
                    $row['dateOfBirth'],
                    $row['height'],
                    $row['weight'],
                    $row['gender'],
                    $row['country'],
                    $row['teamID'],
                    $row['teamName']
                ]);
            }
        }

        // Reset file pointer
        rewind($temp);

        // Read file contents
        $output = stream_get_contents($temp);

        // Close file
        fclose($temp);

        // Set headers for download
        $filename = $fileSelection . '_data_' . date('Y-m-d') . '.csv';
        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($output);
    }





    public function uploadEventFileHandler()
    {
        $file = $this->request->getFile('eventUpload');
        $selection = $this->request->getPost('fileSelection');
        $eventID = $this->request->getPost('eventID');

        if ($file->isValid() && !$file->hasMoved()) {
            // Define the upload path
            $uploadPath = WRITEPATH . 'uploads/event/';

            // Generate unique filename
            $newFileName = $file->getRandomName();

            // Move the file to the upload directory
            if (!$file->move($uploadPath, $newFileName)) {
                session()->setFlashdata('error', 'Failed to move uploaded file.');
                return redirect()->route('home');
            }

            // Process the CSV file
            $filePath = $uploadPath . $newFileName;
            $csvData = array_map('str_getcsv', file($filePath));

            // Process different file types based on selection
            switch ($selection) {
                case 'event':
                    // Process team CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);
                    $eventModel = new EventModel();
                    foreach ($csvData as $row) {
                        $eventData = [
                            'eventID' => $row[0],
                            'name' => $row[1],
                            'startDate' => date('Y-m-d', strtotime($row[2])),
                            'endDate' => date('Y-m-d', strtotime($row[3])),
                            'series' => $row[4],
                            'rules' => $row[5],
                            'candidateNum' => $row[6],
                            'address' => $row[7],
                            'hall' => $row[8],
                            'gender' => $row[9],
                            'age' => $row[10]
                        ];
                        $eventModel->save($eventData);
                    }
                    break;

                case 'team':
                    // Process team CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);
                    $eventTeamModel = new EventTeamModel();
                    foreach ($csvData as $row) {
                        $teamData = [
                            'eventTeamID' => $row[0],
                            'teamID' => empty($row[1]) ? (session()->setFlashdata('error', 'Team ID cannot be empty.') && redirect()->route('home')) : $row[1],
                            'group' => $row[2],
                            'eventID' => empty($eventID) ? (session()->setFlashdata('error', 'Event ID cannot be empty.') && redirect()->route('home')) : $eventID,
                        ];
                        $eventTeamModel->save($teamData);
                    }
                    break;

                case 'player':
                    // Process player CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);

                    $eventPlayerModel = new EventPlayerModel();
                    $eventTeamModel = new EventTeamModel();
                    $playerModel = new PlayerModel();
                    $teamModel = new TeamModel();

                    foreach ($csvData as $row) {
                        // Get eventTeamID by joining tables and matching conditions
                        $eventTeam = $eventTeamModel
                            ->select('eventteams.eventTeamID')
                            ->join('teams', 'teams.teamID = eventteams.teamID')
                            ->join('players', 'players.teamID = teams.teamID')
                            ->where('players.playerID', $row[1])
                            ->where('eventteams.eventID', $eventID)
                            ->first();

                        if (!$eventTeam) {
                            session()->setFlashdata('error', 'Event Team not found for Player ID: ' . $row[1]);
                            return redirect()->route('home');
                        }

                        $playerData = [
                            'eventPlayerID' => $row[0],
                            'eventTeamID' => $eventTeam['eventTeamID'],
                            'playerID' => $row[1],
                            'jerseyCode' => $row[2],
                            'position' => $row[3],
                        ];
                        $eventPlayerModel->save($playerData);
                    }
                    break;
                case 'official':
                    // Process player CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);
                    $eventOfficialModel = new EventOfficialModel();
                    foreach ($csvData as $row) {
                        $officialData = [
                            'eventOfficialID' => $row[0],
                            'eventID' => empty($eventID) ? (session()->setFlashdata('error', 'Event ID cannot be empty.') && redirect()->route('home')) : $eventID,
                            'name' => $row[1],
                            'function' => $row[2],
                            'dateOfBirth' => date('Y-m-d', strtotime($row[3])),
                        ];
                        $eventOfficialModel->save($officialData);
                    }
                    break;
                case 'partner':
                    // Process player CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);
                    $partnerModel = new PartnerModel();
                    foreach ($csvData as $row) {
                        $partnerData = [
                            'eventOfficialID' => $row[0],
                            'eventID' => empty($eventID) ? (session()->setFlashdata('error', 'Event ID cannot be empty.') && redirect()->route('home')) : $eventID,
                            'name' => $row[1],
                            'function' => $row[2],
                            'dateOfBirth' => date('Y-m-d', strtotime($row[3])),
                        ];
                        $partnerModel->save($partnerData);
                    }
                    break;
                default:
                    // Handle unknown selection type
                    session()->setFlashdata('error', 'Invalid file type selection.');
                    return redirect()->route('home');
            }
            // Set success message
            session()->setFlashdata('success', 'csv file uploaded successfully.');
        } else {
            // Set error message
            session()->setFlashdata('error', 'Failed to upload file.');
        }
        return redirect()->route('home');
    }
    public function downloadEventFileHandler()
    {
        $eventID = $this->request->getPost('eventID');
        $fileSelections = $this->request->getPost('fileSelection');
        if (empty($eventID) || empty($fileSelections)) {
            session()->setFlashdata('error', 'Event ID and file type selection are required');
            return redirect()->route('home');
        }

        $eventModel = new EventModel();
        $eventTeamModel = new EventTeamModel();
        $eventPlayerModel = new EventPlayerModel();
        $partnerModel = new PartnerModel();
        $teamModel = new TeamModel();
        $playerModel = new PlayerModel();

        // Create temporary file
        $temp = fopen('php://temp', 'w+');

        // Process each selected file type
        foreach ($fileSelections as $selection) {
            switch ($selection) {
                case 'event':
                    $data = $eventModel->select('eventID, name, startDate, endDate, series, rules, candidateNum, address, hall, gender, age')
                        ->where('eventID', $eventID)
                        ->findAll();
                    $headers = ['Event ID', 'Name', 'Start Date', 'End Date', 'Series', 'Rules', 'Candidate Number', 'Address', 'Hall', 'Gender', 'Age'];
                    fputcsv($temp, $headers);
                    foreach ($data as $row) {
                        fputcsv($temp, $row);
                    }
                    fputcsv($temp, []); // Empty line between sections
                    break;

                case 'team':
                    $data = $eventTeamModel
                        ->select('eventTeams.eventTeamID, eventTeams.teamID, teams.name as teamName, eventTeams.group, eventTeams.eventID')
                        ->join('teams', 'teams.teamID = eventTeams.teamID')
                        ->where('eventTeams.eventID', $eventID)
                        ->findAll();
                    $headers = ['Event Team ID', 'Team ID', 'Team Name', 'Group', 'Event ID'];
                    fputcsv($temp, $headers);
                    foreach ($data as $row) {
                        fputcsv($temp, $row);
                    }
                    fputcsv($temp, []); // Empty line between sections
                    break;

                case 'player':
                    $data = $eventPlayerModel
                        ->select('eventPlayers.eventPlayerID, eventPlayers.eventTeamID, players.name as playerName, eventPlayers.jerseyCode, eventPlayers.position')
                        ->join('players', 'players.playerID = eventPlayers.playerID')
                        ->join('eventTeams', 'eventTeams.eventTeamID = eventPlayers.eventTeamID')
                        ->where('eventTeams.eventID', $eventID)
                        ->findAll();
                    $headers = ['Event Player ID', 'Event Team ID', 'Player Name', 'Jersey Code', 'Position'];
                    fputcsv($temp, $headers);
                    foreach ($data as $row) {
                        fputcsv($temp, $row);
                    }
                    fputcsv($temp, []); // Empty line between sections
                    break;

                case 'partner':
                    $data = $partnerModel
                        ->select('eventPartners.eventPartnerID, eventPartners.eventID, eventPartners.name, eventPartners.type, eventPartners.hyperlink')
                        ->where('eventID', $eventID)
                        ->findAll();
                    $headers = ['Event Partner ID', 'Event ID', 'Name', 'Type', 'Description'];
                    fputcsv($temp, $headers);
                    foreach ($data as $row) {
                        fputcsv($temp, $row);
                    }
                    fputcsv($temp, []); // Empty line between sections
                    break;
            }
        }

        // Reset file pointer
        rewind($temp);

        // Read file contents
        $output = stream_get_contents($temp);

        // Close file
        fclose($temp);

        // Set headers for download
        $filename = 'event_data_' . $eventID . '_' . date('Y-m-d') . '.csv';
        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($output);
    }



    public function uploadMatchFileHandler()
    {
        $file = $this->request->getFile('matchUpload');
        $selection = $this->request->getPost('fileSelection');
        $eventID = $this->request->getPost('eventID');

        if ($file->isValid() && !$file->hasMoved()) {
            // Define the upload path
            $uploadPath = WRITEPATH . 'uploads/match/';

            // Generate unique filename
            $newFileName = $file->getRandomName();

            // Move the file to the upload directory
            if (!$file->move($uploadPath, $newFileName)) {
                session()->setFlashdata('error', 'Failed to move uploaded file.');
                return redirect()->route('home');
            }

            // Process the CSV file
            $filePath = $uploadPath . $newFileName;
            $csvData = array_map('str_getcsv', file($filePath));
            // Process different file types based on selection
            switch ($selection) {
                case 'match':
                    // Process team CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);
                    $matchModel = new MatchModel();
                    $matchTeamModel = new matchTeamModel();
                    foreach ($csvData as $row) {
                        $matchData = [
                            'matchID' => $row[0],
                            'eventID' => $eventID,
                            'hall' => $row[1],
                            'dateTime' => date('Y-m-d H:i:s', strtotime($row[2])),
                            'spectator' => $row[3],
                            'matchNo' => $row[4],
                            'remark' => $row[5],
                            'status' => $row[6],
                            'winner' => $row[7],
                            'round' => $row[8],
                        ];
                        if (empty($row[0])) {
                            $matchID = $matchModel->save($matchData);
                            $teamData1 = [
                                'matchID' => $matchID,
                                'eventTeamID' => $row[9],
                            ];
                            $matchTeamModel->save($teamData1);
                            $teamData2 = [
                                'matchID' => $matchID,
                                'eventTeamID' => $row[10],
                            ];
                            $matchTeamModel->save($teamData2);
                        }
                    }
                    break;

                case 'team':
                    // Process team CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);
                    $matchTeamModel = new MatchTeamModel();
                    foreach ($csvData as $row) {
                        $teamData = [
                            'matchTeamID' => $row[0],
                            'eventTeamID' => empty($row[1]) ? (session()->setFlashdata('error', 'Team ID cannot be empty.') && redirect()->route('home')) : $row[1],
                            'matchID' => empty($row[2]) ? (session()->setFlashdata('error', 'Match ID cannot be empty.') && redirect()->route('home')) : $row[2],
                        ];
                        $matchTeamModel->save($teamData);
                    }
                    break;

                case 'player':
                    // Process player CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);

                    $eventPlayerModel = new EventPlayerModel();
                    $matchTeamModel = new MatchTeamModel();
                    $matchPlayerModel = new MatchPlayerModel();

                    foreach ($csvData as $row) {
                        // Get eventTeamID by joining tables and matching conditions
                        $matchTeam = $matchTeamModel
                            ->select('matchteams.matchTeamID')
                            ->join('eventteams', 'eventteams.eventTeamID = matchteams.eventTeamID')
                            ->join('eventplayers', 'eventplayers.eventTeamID = eventteams.eventTeamID')
                            ->where('eventplayers.eventPlayerID', $row[1])
                            ->where('matchteams.matchID', $row[2])
                            ->first();

                        if (!$matchTeam) {
                            session()->setFlashdata('error', 'Match Team not found for Player ID: ' . $row[1]);
                            return redirect()->route('home');
                        }

                        $playerData = [
                            'matchPlayerID' => $row[0],
                            'eventPlayerID' => $row[1],
                            'isStartingLineUp' => $row[3],
                            'matchTeamID' => $matchTeam['matchTeamID']
                        ];
                        $matchPlayerModel->save($playerData);
                    }
                    break;
                case 'official':
                    // Process player CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);
                    $matchOfficialModel = new MatchOfficialModel();
                    foreach ($csvData as $row) {
                        $officialData = [
                            'matchOfficialID' => $row[0],
                            'matchID' => empty($row[1]) ? (session()->setFlashdata('error', 'Match ID cannot be empty.') && redirect()->route('home')) : $row[1],
                            'eventOfficialID' => $row[2],
                            'remark' => $row[3]
                        ];
                        $matchOfficialModel->save($officialData);
                    }
                    break;

                case 'timeline':
                    $shotModel = new ShotModel();
                    $penaltyModel = new PenaltyModel();
                    $matchModel = new MatchModel();
                    $saveModel = new SaveModel();
                    $matchPlayerModel = new MatchPlayerModel();
                    $eventPlayerModel = new EventPlayerModel();
                    $matchTeamModel = new MatchTeamModel();
                    // Process player CSV format
                    array_shift($csvData); // Remove header row
                    // Remove rows containing * character
                    $csvData = array_filter($csvData, function ($row) {
                        return !str_contains(implode('', $row), '*');
                    });
                    // Re-index array after filtering
                    $csvData = array_values($csvData);

                    foreach ($csvData as $row) {
                        $timelineData = [
                            'matchID' => $row[1],
                            'period' => $row[2],
                            'time' => $row[2],
                            'teamID' => $row[4],
                            'jerseyCode' => $row[5],
                            'action' => $row[6],
                            'throwPosition' => $row[7],
                            'result' => $row[8],
                            'goalkeeperJerseyCode' => $row[9],
                            'destType' => $row[10],
                            'defenseNum' => $row[11],
                            'attackNum' => $row[12],
                            'isGoalKeeperOut' => $row[13],
                            'speed' => $row[14],
                            'substitudeJerseyCode' => $row[15],
                        ];
                        $matchTeam = $matchTeamModel->find($timelineData['teamID'])->first();
                        if (!empty($timelineData['jerseyCode'])) {
                            $matchPlayer = $matchPlayerModel
                                ->select('matchplayers.matchPlayerID')
                                ->join('matchteams', 'matchteams.matchTeamID = matchplayers.matchTeamID')
                                ->join('eventplayers', 'eventplayers.eventPlayerID = matchplayers.eventPlayerID')
                                ->where('matchteams.matchID', $timelineData['matchID'])
                                ->where('matchteams.matchTeamID', $timelineData['teamID'])
                                ->where('eventplayers.jerseyCode', $timelineData['jerseyCode'])
                                ->first();
                        }
                        if (!empty($timelineData['goalkeeperJerseyCode'])) {
                            $goalKeeper = $matchPlayerModel
                                ->select('matchplayers.matchPlayerID')
                                ->join('matchteams', 'matchteams.matchTeamID = matchplayers.matchTeamID')
                                ->join('eventplayers', 'eventplayers.eventPlayerID = matchplayers.eventPlayerID')
                                ->where('matchteams.matchID', $timelineData['matchID'])
                                ->where('matchteams.matchTeamID !=', $timelineData['teamID'])
                                ->where('eventplayers.jerseyCode', $timelineData['goalkeeperJerseyCode'])
                                ->first();
                        }
                        if (!empty($timelineData['substitudeJerseyCode'])) {
                            $substitution = $matchPlayerModel
                                ->select('matchplayers.matchPlayerID')
                                ->join('matchteams', 'matchteams.matchTeamID = matchplayers.matchTeamID')
                                ->join('eventplayers', 'eventplayers.eventPlayerID = matchplayers.eventPlayerID')
                                ->where('matchteams.matchID', $timelineData['matchID'])
                                ->where('matchteams.matchTeamID', $timelineData['teamID'])
                                ->where('eventplayers.jerseyCode', $timelineData['substitudeJerseyCode'])
                                ->first();
                        }

                        switch ($timelineData['action']) {
                            case 'shot':
                                $shotData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'shotType' => 'unknown',
                                    'goalType' => $timelineData['result'],
                                    'destType' => $timelineData['destType'],
                                    'throwPosition' => $timelineData['throwPosition'],
                                    'period' => $timelineData['period'],
                                    'time' => $timelineData['time'],
                                    'defenseNum' => $timelineData['defenseNum'],
                                    'attackNum' => $timelineData['attackNum'],
                                    'goalkeeperID' => $goalKeeper['matchPlayerID'],
                                    'isGoalKeeperOut' => $timelineData['isGoalKeeperOut'],
                                    'speed' => $timelineData['speed']
                                ];
                                $shotModel->save($shotData);

                                $matchGoal = $timelineData['result'] === 'goal' ?
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first();
                                $matchShot = $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchShot')->first() + 1;
                                $matchSave = $timelineData['result'] === 'save' ?
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first();

                                $matchPlayerData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'matchGoal' => $matchGoal,
                                    'matchShot' => $matchShot,
                                ];
                                $matchPlayerModel->save($matchPlayerData);
                                $goalkeeperData = [
                                    'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                    'matchSave' => $matchSave,
                                ];
                                $matchPlayerModel->save($goalkeeperData);
                                if ($timelineData['result'] !== 'miss') {
                                    $saveData = [
                                        'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                        'isSaved' => $timelineData['result'] === 'save' ? true : false,
                                        'period' => $timelineData['period'],
                                        'time' => $timelineData['time'],
                                        'saveType' => 'unknown',
                                    ];
                                    $saveModel->save($saveData);
                                }
                                break;
                            case 'distance ball shot':
                                $shotData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'shotType' => 'long distance',
                                    'goalType' => $timelineData['result'],
                                    'destType' => $timelineData['destType'],
                                    'throwPosition' => $timelineData['throwPosition'],
                                    'period' => $timelineData['period'],
                                    'time' => $timelineData['time'],
                                    'defenseNum' => $timelineData['defenseNum'],
                                    'attackNum' => $timelineData['attackNum'],
                                    'goalkeeperID' => $goalKeeper['matchPlayerID'],
                                    'isGoalKeeperOut' => $timelineData['isGoalKeeperOut'],
                                    'speed' => $timelineData['speed']
                                ];
                                $shotModel->save($shotData);

                                $matchGoal = $timelineData['result'] === 'goal' ?
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first();
                                $matchShot = $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchShot')->first() + 1;
                                $matchSave = $timelineData['result'] === 'save' ?
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first();

                                $matchPlayerData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'matchGoal' => $matchGoal,
                                    'matchShot' => $matchShot,
                                ];
                                $matchPlayerModel->save($matchPlayerData);
                                $goalkeeperData = [
                                    'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                    'matchSave' => $matchSave,
                                ];
                                $matchPlayerModel->save($goalkeeperData);
                                if ($timelineData['result'] !== 'miss') {
                                    $saveData = [
                                        'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                        'isSaved' => $timelineData['result'] === 'save' ? true : false,
                                        'saveType' => 'long distance',
                                        'period' => $timelineData['period'],
                                        'time' => $timelineData['time']
                                    ];
                                    $saveModel->save($saveData);
                                }
                                break;
                            case 'breakthrough shot':
                                $shotData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'shotType' => 'breakthrough',
                                    'goalType' => $timelineData['result'],
                                    'destType' => $timelineData['destType'],
                                    'throwPosition' => $timelineData['throwPosition'],
                                    'period' => $timelineData['period'],
                                    'time' => $timelineData['time'],
                                    'defenseNum' => $timelineData['defenseNum'],
                                    'attackNum' => $timelineData['attackNum'],
                                    'goalkeeperID' => $goalKeeper['matchPlayerID'],
                                    'isGoalKeeperOut' => $timelineData['isGoalKeeperOut'],
                                    'speed' => $timelineData['speed']
                                ];
                                $shotModel->save($shotData);

                                $matchGoal = $timelineData['result'] === 'goal' ?
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first();
                                $matchShot = $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchShot')->first() + 1;
                                $matchSave = $timelineData['result'] === 'save' ?
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first();
                                $matchPlayerData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'matchGoal' => $matchGoal,
                                    'matchShot' => $matchShot,
                                ];
                                $matchPlayerModel->save($matchPlayerData);
                                $goalkeeperData = [
                                    'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                    'matchSave' => $matchSave,
                                ];
                                $matchPlayerModel->save($goalkeeperData);

                                if ($timelineData['result'] !== 'miss') {
                                    $saveData = [
                                        'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                        'isSaved' => $timelineData['result'] === 'save' ? true : false,
                                        'period' => $timelineData['period'],
                                        'time' => $timelineData['time'],
                                        'saveType' => 'breakthrough',
                                    ];
                                    $saveModel->save($saveData);
                                }
                                break;
                            case 'fastbreak shot':
                                $shotData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'shotType' => 'fastbreak',
                                    'goalType' => $timelineData['result'],
                                    'destType' => $timelineData['destType'],
                                    'throwPosition' => $timelineData['throwPosition'],
                                    'period' => $timelineData['period'],
                                    'time' => $timelineData['time'],
                                    'defenseNum' => $timelineData['defenseNum'],
                                    'attackNum' => $timelineData['attackNum'],
                                    'goalkeeperID' => $goalKeeper['matchPlayerID'],
                                    'isGoalKeeperOut' => $timelineData['isGoalKeeperOut'],
                                    'speed' => $timelineData['speed']
                                ];
                                $shotModel->save($shotData);

                                $matchGoal = $timelineData['result'] === 'goal' ?
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first();
                                $matchShot = $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchShot')->first() + 1;
                                $matchSave = $timelineData['result'] === 'save' ?
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first();

                                $matchPlayerData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'matchGoal' => $matchGoal,
                                    'matchShot' => $matchShot,
                                ];
                                $matchPlayerModel->save($matchPlayerData);
                                $goalkeeperData = [
                                    'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                    'matchSave' => $matchSave,
                                ];
                                $matchPlayerModel->save($goalkeeperData);
                                if ($timelineData['result'] !== 'miss') {
                                    $saveData = [
                                        'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                        'isSaved' => $timelineData['result'] === 'save' ? true : false,
                                        'period' => $timelineData['period'],
                                        'time' => $timelineData['time'],
                                        'saveType' => 'fastbreak',
                                    ];
                                    $saveModel->save($saveData);
                                }
                                break;
                            case '7m shot':
                                $shotData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'shotType' => '7 meter',
                                    'goalType' => $timelineData['result'],
                                    'destType' => $timelineData['destType'],
                                    'throwPosition' => $timelineData['throwPosition'],
                                    'period' => $timelineData['period'],
                                    'time' => $timelineData['time'],
                                    'defenseNum' => $timelineData['defenseNum'],
                                    'attackNum' => $timelineData['attackNum'],
                                    'goalkeeperID' => $goalKeeper['matchPlayerID'],
                                    'isGoalKeeperOut' => $timelineData['isGoalKeeperOut'],
                                    'speed' => $timelineData['speed']
                                ];
                                $shotModel->save($shotData);

                                $matchGoal = $timelineData['result'] === 'goal' ?
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first();
                                $matchShot = $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchShot')->first() + 1;
                                $matchSave = $timelineData['result'] === 'save' ?
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first();

                                $matchPlayerData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'matchGoal' => $matchGoal,
                                    'matchShot' => $matchShot,
                                ];
                                $matchPlayerModel->save($matchPlayerData);
                                $goalkeeperData = [
                                    'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                    'matchSave' => $matchSave,
                                ];
                                $matchPlayerModel->save($goalkeeperData);
                                if ($timelineData['result'] !== 'miss') {
                                    $saveData = [
                                        'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                        'isSaved' => $timelineData['result'] === 'save' ? true : false,
                                        'period' => $timelineData['period'],
                                        'time' => $timelineData['time'],
                                        'saveType' => '7 meter',
                                    ];
                                    $saveModel->save($saveData);
                                }
                                break;
                            case '9m shot':
                                $shotData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'shotType' => '9 meter',
                                    'goalType' => $timelineData['result'],
                                    'destType' => $timelineData['destType'],
                                    'throwPosition' => $timelineData['throwPosition'],
                                    'period' => $timelineData['period'],
                                    'time' => $timelineData['time'],
                                    'defenseNum' => $timelineData['defenseNum'],
                                    'attackNum' => $timelineData['attackNum'],
                                    'goalkeeperID' => $goalKeeper['matchPlayerID'],
                                    'isGoalKeeperOut' => $timelineData['isGoalKeeperOut'],
                                    'speed' => $timelineData['speed']
                                ];
                                $shotModel->save($shotData);

                                $matchGoal = $timelineData['result'] === 'goal' ?
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first();
                                $matchShot = $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchShot')->first() + 1;
                                $matchSave = $timelineData['result'] === 'save' ?
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first();

                                $matchPlayerData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'matchGoal' => $matchGoal,
                                    'matchShot' => $matchShot,
                                ];
                                $matchPlayerModel->save($matchPlayerData);
                                $goalkeeperData = [
                                    'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                    'matchSave' => $matchSave,
                                ];
                                $matchPlayerModel->save($goalkeeperData);
                                if ($timelineData['result'] !== 'miss') {
                                    $saveData = [
                                        'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                        'isSaved' => $timelineData['result'] === 'save' ? true : false,
                                        'period' => $timelineData['period'],
                                        'time' => $timelineData['time'],
                                        'saveType' => '9 meter',
                                    ];
                                    $saveModel->save($saveData);
                                }
                                break;
                            case '6m shot':
                                $shotData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'shotType' => '6 meter',
                                    'goalType' => $timelineData['result'],
                                    'destType' => $timelineData['destType'],
                                    'throwPosition' => $timelineData['throwPosition'],
                                    'period' => $timelineData['period'],
                                    'time' => $timelineData['time'],
                                    'defenseNum' => $timelineData['defenseNum'],
                                    'attackNum' => $timelineData['attackNum'],
                                    'goalkeeperID' => $goalKeeper['matchPlayerID'],
                                    'isGoalKeeperOut' => $timelineData['isGoalKeeperOut'],
                                    'speed' => $timelineData['speed']
                                ];
                                $shotModel->save($shotData);

                                $matchGoal = $timelineData['result'] === 'goal' ?
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first();
                                $matchShot = $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchShot')->first() + 1;
                                $matchSave = $timelineData['result'] === 'save' ?
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first();

                                $matchPlayerData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'matchGoal' => $matchGoal,
                                    'matchShot' => $matchShot,
                                ];
                                $matchPlayerModel->save($matchPlayerData);
                                $goalkeeperData = [
                                    'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                    'matchSave' => $matchSave,
                                ];
                                $matchPlayerModel->save($goalkeeperData);
                                if ($timelineData['result'] !== 'miss') {
                                    $saveData = [
                                        'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                        'isSaved' => $timelineData['result'] === 'save' ? true : false,
                                        'period' => $timelineData['period'],
                                        'time' => $timelineData['time'],
                                        'saveType' => '6 meter',
                                    ];
                                    $saveModel->save($saveData);
                                }
                                break;
                            case 'wing shot':
                                $shotData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'shotType' => 'wing',
                                    'goalType' => $timelineData['result'],
                                    'destType' => $timelineData['destType'],
                                    'throwPosition' => $timelineData['throwPosition'],
                                    'period' => $timelineData['period'],
                                    'time' => $timelineData['time'],
                                    'defenseNum' => $timelineData['defenseNum'],
                                    'attackNum' => $timelineData['attackNum'],
                                    'goalkeeperID' => $goalKeeper['matchPlayerID'],
                                    'isGoalKeeperOut' => $timelineData['isGoalKeeperOut'],
                                    'speed' => $timelineData['speed']
                                ];
                                $shotModel->save($shotData);

                                $matchGoal = $timelineData['result'] === 'goal' ?
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchGoal')->first();
                                $matchShot = $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.matchShot')->first() + 1;
                                $matchSave = $timelineData['result'] === 'save' ?
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first() + 1 :
                                    $matchPlayerModel->where('matchPlayerID', $goalKeeper['matchPlayerID'])->select('matchplayers.matchGoal')->first();

                                $matchPlayerData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'matchGoal' => $matchGoal,
                                    'matchShot' => $matchShot,
                                ];
                                $matchPlayerModel->save($matchPlayerData);
                                $goalkeeperData = [
                                    'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                    'matchSave' => $matchSave,
                                ];
                                $matchPlayerModel->save($goalkeeperData);
                                if ($timelineData['result'] !== 'miss') {
                                    $saveData = [
                                        'matchPlayerID' => $goalKeeper['matchPlayerID'],
                                        'isSaved' => $timelineData['result'] === 'save' ? true : false,
                                        'period' => $timelineData['period'],
                                        'time' => $timelineData['time'],
                                        'saveType' => 'wing',
                                    ];
                                    $saveModel->save($saveData);
                                }
                                break;
                            case 'res sub':
                                // If substituting player is already playing, calculate their play time and update
                                if (isset($substitutionPlayerData[$substitution['matchPlayerID']])) {
                                    $playTime = $timelineData['time'] - $substitutionPlayerData[$substitution['matchPlayerID']]['timeStart'];
                                    $substitutionPlayerData[$substitution['matchPlayerID']]['totalPlayTime'] += $playTime;
                                    $substitutionPlayerData[$substitution['matchPlayerID']]['play'] = false;
                                    $substitutionPlayerData[$substitution['matchPlayerID']]['timeStart'] = null;
                                } else {
                                    // Initialize data for new substituting player
                                    $substitutionPlayerData[$substitution['matchPlayerID']] = [
                                        'matchPlayerID' => $substitution['matchPlayerID'],
                                        'play' => true,
                                        'timeStart' => $timelineData['time'],
                                        'totalPlayTime' => 0
                                    ];
                                }

                                // If replaced player is currently playing, calculate their play time and update
                                if (isset($substitutionPlayerData[$matchPlayer['matchPlayerID']])) {
                                    $playTime = $timelineData['time'] - $substitutionPlayerData[$matchPlayer['matchPlayerID']]['timeStart'];
                                    $substitutionPlayerData[$matchPlayer['matchPlayerID']]['totalPlayTime'] += $playTime;
                                    $substitutionPlayerData[$matchPlayer['matchPlayerID']]['play'] = false;
                                    $substitutionPlayerData[$matchPlayer['matchPlayerID']]['timeStart'] = null;
                                } else {
                                    // Initialize data for replaced player
                                    $substitutionPlayerData[$matchPlayer['matchPlayerID']] = [
                                        'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                        'play' => false,
                                        'timeStart' => null,
                                        'totalPlayTime' => $timelineData['time'] // Assuming they started from beginning
                                    ];
                                }
                                break;
                            case 'halftime start':
                                $matchData = [
                                    'matchID' => $timelineData['matchID'],
                                    'HalfTimeStart' => $timelineData['time'],
                                ];
                                $matchModel->save($matchData);
                            case 'halftime end':
                                $matchData = [
                                    'matchID' => $timelineData['matchID'],
                                    'HalfTimeEnd' => $timelineData['time'],
                                ];
                                $matchModel->save($matchData);
                                break;
                            case 'steal':
                                $matchSteal = $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.steal')->first() + 1;
                                $matchPlayerData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'steal' => $matchSteal
                                ];
                                $matchPlayerModel->save($matchPlayerData);
                            case 'assist':
                                $matchAssist = $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.assist')->first() + 1;
                                $matchPlayerData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'assist' => $matchAssist
                                ];
                                $matchPlayerModel->save($matchPlayerData);
                            case 'timeout':
                                if (!$matchTeam) {
                                    session()->setFlashdata('error', 'Match Team not found.');
                                    return redirect()->route('home');
                                }

                                // Check which timeout slot is available and update
                                if (empty($matchTeam['teamTimeout1'])) {
                                    $matchTeamModel->update($matchTeam['matchTeamID'], ['teamTimeout1' => $timelineData['time']]);
                                } elseif (empty($matchTeam['teamTimeout2'])) {
                                    $matchTeamModel->update($matchTeam['matchTeamID'], ['teamTimeout2' => $timelineData['time']]);
                                } elseif (empty($matchTeam['teamTimeout3'])) {
                                    $matchTeamModel->update($matchTeam['matchTeamID'], ['teamTimeout3' => $timelineData['time']]);
                                } else {
                                    session()->setFlashdata('error', 'Maximum number of timeouts reached.');
                                    return redirect()->route('home');
                                }
                                break;
                            case '7m receive':
                                $match7mReceive = $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.recieve7m')->first() + 1;
                                $matchPlayerData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'recieve7m' => $match7mReceive
                                ];
                                $matchPlayerModel->save($matchPlayerData);
                                break;

                            case '7m commit':
                                $match7m = $matchPlayerModel->where('matchPlayerID', $matchPlayer['matchPlayerID'])->select('matchplayers.commit7m')->first() + 1;
                                $matchPlayerData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'commit7m' => $match7m,
                                ];
                                $matchPlayerModel->save($matchPlayerData);

                                $panaltyData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'penaltyType' => '7m commit',
                                    'time' => $timelineData['time'],
                                    'period' => $timelineData['period']
                                ];
                                $penaltyModel->save($panaltyData);
                            case 'free throw':
                                $panaltyData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'penaltyType' => 'free throw recieved',
                                    'time' => $timelineData['time'],
                                    'period' => $timelineData['period']
                                ];
                                $penaltyModel->save($panaltyData);
                                break;
                            case 'technical fault':
                                $panaltyData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'penaltyType' => 'technical fault recieved',
                                    'time' => $timelineData['time'],
                                    'period' => $timelineData['period']
                                ];
                                $penaltyModel->save($panaltyData);
                                break;
                            case 'yellow card':
                                $panaltyData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'penaltyType' => 'yellow card recieved',
                                    'time' => $timelineData['time'],
                                    'period' => $timelineData['period']
                                ];
                                $penaltyModel->save($panaltyData);
                                break;
                            case 'red card':
                                $panaltyData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'penaltyType' => 'red card recieved',
                                    'time' => $timelineData['time'],
                                    'period' => $timelineData['period']
                                ];
                                $penaltyModel->save($panaltyData);
                                break;
                            case 'blue card':
                                $panaltyData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'penaltyType' => 'blue card recieved recieved',
                                    'time' => $timelineData['time'],
                                    'period' => $timelineData['period']
                                ];
                                $penaltyModel->save($panaltyData);
                                break;
                            case '2 min suspension':
                                $panaltyData = [
                                    'matchPlayerID' => $matchPlayer['matchPlayerID'],
                                    'penaltyType' => '2 min suspension recieved',
                                    'time' => $timelineData['time'],
                                    'period' => $timelineData['period']
                                ];
                                $penaltyModel->save($panaltyData);
                                break;
                        }
                        $endTime = $timelineData['time'];
                    }
                    //total performance time
                    foreach ($substitutionPlayerData as $playerData) {
                        if ($playerData['play']===true) {
                            $playerData['totalPlayTime'] = $playerData['totalPlayTime'] + ($endTime-$playerData['startTime']);
                        }
                        if ($playerData['totalPlayTime']!==0) {
                            $playTimeData = [
                                'matchPlayerID' => $playerData['matchPlayerID'],
                                'totalPerformanceTime' => $playerData['totalPlayTime'],
                            ];
                            $matchPlayerModel->save($playTimeData);
                            $eventPlayerID = $matchPlayerModel->find($playerData['matchPlayerID'])->select('eventPlayerID')->first();
                            $PlayerGameData = [
                               'eventPlayerID' => $eventPlayerID,
                                'game' => $eventPlayerModel->find($eventPlayerID)->select('game')->first() + 1,
                                'play' => $eventPlayerModel->find( $eventPlayerID)->select('play')->first() + 1,
                            ];
                            $eventPlayerModel->save($PlayerGameData);
                        }else{
                            $eventPlayerID = $matchPlayerModel->find($playerData['matchPlayerID'])->select('eventPlayerID')->first();
                            $PlayerGameData = [
                                'eventPlayerID' => $eventPlayerID,
                                'game' => $eventPlayerModel->find($eventPlayerID)->select('game')->first() + 1,
                             ];
                             $eventPlayerModel->save($PlayerGameData);
                        }
                    }
                    $updateMatch = new UpdateMatch();
                    $updateMatch->UpdateMatchStatus($timelineData('matchID'));
                    break;
                default:
                    // Handle unknown selection type
                    session()->setFlashdata('error', 'Invalid file type selection.');
                    return redirect()->route('home');
            }
            // Set success message
            session()->setFlashdata('success', 'csv file uploaded successfully.');
        } else {
            // Set error message
            session()->setFlashdata('error', 'Failed to upload file.');
        }
        return redirect()->route('home');
    }
    public function downloadMatchFileHandler()
    {
        $eventID = $this->request->getPost('eventID');
        $fileSelections = $this->request->getPost('fileSelection');
        if (empty($eventID) || empty($fileSelections)) {
            session()->setFlashdata('error', 'Event ID and file type selection are required');
            return redirect()->route('home');
        }

        $eventModel = new EventModel();
        $eventTeamModel = new EventTeamModel();
        $eventPlayerModel = new EventPlayerModel();
        $partnerModel = new PartnerModel();
        $teamModel = new TeamModel();
        $playerModel = new PlayerModel();

        // Create temporary file
        $temp = fopen('php://temp', 'w+');

        // Process each selected file type
        foreach ($fileSelections as $selection) {
            switch ($selection) {
                case 'match':
                    $matchModel = new MatchModel();
                    $data = $matchModel
                        ->select('matches.*, events.name as eventName, events.eventID')
                        ->join('events', 'events.eventID = matches.eventID')
                        ->where('matches.eventID', $eventID)
                        ->findAll();
                    $headers = ['Match ID', 'Event ID', 'Hall', 'Date Time', 'Spectator', 'Match No', 'Remark', 'Status', 'Winner', 'Round', 'Event Name'];
                    fputcsv($temp, $headers);
                    foreach ($data as $row) {
                        fputcsv($temp, $row);
                    }
                    fputcsv($temp, []); // Empty line between sections
                    break;

                case 'team':
                    $matchTeamModel = new MatchTeamModel();
                    $data = $matchTeamModel
                        ->select('matchteams.*, teams.teamID, teams.name as teamName, teams.country, teams.state, eventTeams.eventTeamID, eventTeams.group')
                        ->join('teams', 'teams.teamID = eventTeams.teamID')
                        ->join('matchteams', 'matchTeams.eventTeamID = eventTeams.eventTeamID')
                        ->where('eventTeams.eventID', $eventID)
                        ->findAll();
                    $headers = ['Match Team ID', 'Team ID', 'Team Name', 'Country', 'State', 'Event Team ID', 'Group'];
                    fputcsv($temp, $headers);
                    foreach ($data as $row) {
                        fputcsv($temp, $row);
                    }
                    fputcsv($temp, []); // Empty line between sections
                    break;

                case 'player':
                    $matchPlayerModel = new MatchPlayerModel();
                    $data = $matchPlayerModel
                        ->select('matchplayers.*, eventPlayers.position, eventPlayers.jerseyCode, players.playerID, players.teamID, players.name as playerName, teams.teamID, teams.name as teamName')
                        ->join('eventPlayers', 'eventPlayers.eventPlayerID = matchplayers.eventPlayerID')
                        ->join('players', 'players.playerID = eventPlayers.playerID')
                        ->join('teams', 'teams.teamID = players.teamID')
                        ->join('eventTeams', 'eventTeams.teamID = teams.teamID')
                        ->where('eventTeams.eventID', $eventID)
                        ->findAll();
                    $headers = [
                        'Match Player ID',
                        'Match Team ID',
                        'Event Player ID',
                        'Event Player ID',
                        'Match Goal',
                        'Match Shot',
                        'Match Save',
                        'Is Starting LineUp',
                        'Total Performance Time',
                        'Assist',
                        'Pass Clear Chance',
                        'Earned 7m Pen',
                        'Earned 2m Pun',
                        'Technical Fault',
                        'Steal',
                        'Commit 7m',
                        'Block',
                        'Position',
                        'Jersey Code',
                        'Player ID',
                        'Player Name',
                        'Team ID',
                        'Team Name'
                    ];
                    fputcsv($temp, $headers);
                    foreach ($data as $row) {
                        fputcsv($temp, $row);
                    }
                    fputcsv($temp, []); // Empty line between sections
                    break;

                case 'official':
                    $matchOfficialModel = new MatchOfficialModel();
                    $data = $matchOfficialModel
                        ->select('matchOfficials.matchOfficialID, matchOfficials.matchID, matchOfficials.eventOfficialID, matchOfficials.remark,
                                 eventOfficials.eventID, eventOfficials.name, eventOfficials.function, eventOfficials.dateOfBirth,
                                 events.name as eventName, matches.remark as matchRemark')
                        ->join('eventOfficials', 'eventOfficials.eventOfficialID = matchOfficials.eventOfficialID')
                        ->join('events', 'events.eventID = eventOfficials.eventID')
                        ->join('matches', 'matches.matchID = matchOfficials.matchID')
                        ->where('eventOfficials.eventID', $eventID)
                        ->findAll();
                    $headers = ['Match Official ID', 'Match ID', 'Event Official ID', 'Remark', 'Event ID', 'Name', 'Function', 'Date of Birth', 'Event Name', 'Match Remark'];
                    fputcsv($temp, $headers);
                    foreach ($data as $row) {
                        fputcsv($temp, $row);
                    }
                    fputcsv($temp, []); // Empty line between sections
                    break;
            }
        }

        // Reset file pointer
        rewind($temp);

        // Read file contents
        $output = stream_get_contents($temp);

        // Close file
        fclose($temp);

        // Set headers for download
        $filename = 'event_data_' . $eventID . '_' . date('Y-m-d') . '.csv';
        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($output);
    }
}
