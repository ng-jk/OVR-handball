<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use \App\Models\EventTeamModel;
use \App\Models\EventModel;

class EventTeamSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'teamID' => 1,
                'eventID' => 1,
                'group' => 'A'
            ],
            [
                'teamID' => 2,
                'eventID' => 1,
                'group' => 'A'
            ],
            [
                'teamID' => 3,
                'eventID' => 1,
                'group' => 'A'
            ],
            [
                'teamID' => 4,
                'eventID' => 1,
                'group' => 'A'
            ],
            [
                'teamID' => 5,
                'eventID' => 1,
                'group' => 'A'
            ],
            [
                'teamID' => 6,
                'eventID' => 1,
                'group' => 'B'
            ],
            [
                'teamID' => 7,
                'eventID' => 1,
                'group' => 'B'
            ],
            [
                'teamID' => 8,
                'eventID' => 1,
                'group' => 'B'
            ],
            [
                'teamID' => 9,
                'eventID' => 1,
                'group' => 'B'
            ],
            [
                'teamID' => 10,
                'eventID' => 1,
                'group' => 'B'
            ]
        ];

        $eventData = [
            'name' => 'test1'
        ];

        $eventModel = new EventModel();
        $eventModel->save($eventData);
        $eventTeamModel = new EventTeamModel();
        $eventTeamModel->insertBatch($data);
    }
}
