<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Team1',
                'teamInfo' => 'Team One Football Club',
                'dateFounded' => date('Y-m-d', strtotime('1996-10-07')),
                'country' => 'Malaysia',
                'state' => 'Selangor',
                'gender' => 'male'
            ],
            [
                'name' => 'Team2',
                'teamInfo' => 'Team Two Football Club',
                'dateFounded' => date('Y-m-d', strtotime('1996-10-07')),
                'country' => 'Malaysia',
                'state' => 'Johor',
                'gender' => 'male'
            ],
            [
                'name' => 'Team3',
                'teamInfo' => 'Team Three Football Club',
                'dateFounded' => date('Y-m-d', strtotime('1998-03-15')),
                'country' => 'Malaysia',
                'state' => 'Penang',
                'gender' => 'male'
            ],
            [
                'name' => 'Team4',
                'teamInfo' => 'Team Four Football Club',
                'dateFounded' => date('Y-m-d', strtotime('1997-08-22')),
                'country' => 'Malaysia',
                'state' => 'Sabah',
                'gender' => 'male'
            ],
            [
                'name' => 'Team5',
                'teamInfo' => 'Team Five Football Club',
                'dateFounded' => date('Y-m-d', strtotime('1999-05-30')),
                'country' => 'Malaysia',
                'state' => 'Sarawak',
                'gender' => 'male'
            ],
            [
                'name' => 'Team6',
                'teamInfo' => 'Team Six Football Club',
                'dateFounded' => date('Y-m-d', strtotime('2000-02-14')),
                'country' => 'Malaysia',
                'state' => 'Kedah',
                'gender' => 'male'
            ],
            [
                'name' => 'Team7',
                'teamInfo' => 'Team Seven Football Club',
                'dateFounded' => date('Y-m-d', strtotime('2000-07-19')),
                'country' => 'Malaysia',
                'state' => 'Perak',
                'gender' => 'male'
            ],
            [
                'name' => 'Team8',
                'teamInfo' => 'Team Eight Football Club',
                'dateFounded' => date('Y-m-d', strtotime('2001-04-25')),
                'country' => 'Malaysia',
                'state' => 'Melaka',
                'gender' => 'male'
            ],
            [
                'name' => 'Team9',
                'teamInfo' => 'Team Nine Football Club',
                'dateFounded' => date('Y-m-d', strtotime('2001-09-30')),
                'country' => 'Malaysia',
                'state' => 'Pahang',
                'gender' => 'male'
            ],
            [
                'name' => 'Team10',
                'teamInfo' => 'Team Ten Football Club',
                'dateFounded' => date('Y-m-d', strtotime('2002-01-08')),
                'country' => 'Malaysia',
                'state' => 'Terengganu',
                'gender' => 'male'
            ]
        ];

        $this->db->table('teams')->insertBatch($data);
    }
}
