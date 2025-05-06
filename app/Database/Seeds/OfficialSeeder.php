<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OfficialSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'eventID' => 1,
                'name' => 'Official1',
                'function' => 'Event Coordinator',
                'dateOfBirth' => date('Y-m-d', strtotime('1990-05-15'))
            ],
            [
                'eventID' => 1,
                'name' => 'Official2',
                'function' => 'Event Manager',
                'dateOfBirth' => date('Y-m-d', strtotime('1990-05-15'))
            ],
            [
                'eventID' => 1,
                'name' => 'Official3',
                'function' => 'Technical Support',
                'dateOfBirth' => date('Y-m-d', strtotime('1990-05-15'))
            ],
            [
                'eventID' => 1,
                'name' => 'Official4',
                'function' => 'Event Assistant',
                'dateOfBirth' => date('Y-m-d', strtotime('1990-05-15'))
            ]
        ];

        $this->db->table('eventOfficials')->insertBatch($data);
    }
}
