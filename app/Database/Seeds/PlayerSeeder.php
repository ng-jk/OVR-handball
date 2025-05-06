<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PlayerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'John Smith',
                'dateOfBirth' => date('Y-m-d', strtotime('1995-03-15')),
                'height' => 180,
                'weight' => 75,
                'country' => 'Malaysia',
                'teamID' => 1,
                'gender' => 'male'
            ],
            [
                'name' => 'Ahmad Abdullah',
                'dateOfBirth' => date('Y-m-d', strtotime('1998-06-22')),
                'height' => 175,
                'weight' => 70,
                'country' => 'Malaysia',
                'teamID' => 1,
                'gender' => 'male'
            ],
            [
                'name' => 'Muhammad Ismail',
                'dateOfBirth' => date('Y-m-d', strtotime('1997-09-10')),
                'height' => 182,
                'weight' => 78,
                'country' => 'Malaysia',
                'teamID' => 1,
                'gender' => 'male'
            ],
            [
                'name' => 'Ali Hassan',
                'dateOfBirth' => date('Y-m-d', strtotime('1996-12-05')),
                'height' => 178,
                'weight' => 72,
                'country' => 'Malaysia',
                'teamID' => 1,
                'gender' => 'male'
            ],
            [
                'name' => 'Tan Wei Ming',
                'dateOfBirth' => date('Y-m-d', strtotime('1999-02-18')),
                'height' => 176,
                'weight' => 68,
                'country' => 'Malaysia',
                'teamID' => 2,
                'gender' => 'male'
            ],
            [
                'name' => 'Kumar Raju',
                'dateOfBirth' => date('Y-m-d', strtotime('1997-07-30')),
                'height' => 183,
                'weight' => 80,
                'country' => 'Malaysia',
                'teamID' => 2,
                'gender' => 'male'
            ],
            [
                'name' => 'Lee Chong Wei',
                'dateOfBirth' => date('Y-m-d', strtotime('1998-04-25')),
                'height' => 177,
                'weight' => 71,
                'country' => 'Malaysia',
                'teamID' => 2,
                'gender' => 'male'
            ],
            [
                'name' => 'Raj Kumar',
                'dateOfBirth' => date('Y-m-d', strtotime('1996-08-12')),
                'height' => 181,
                'weight' => 76,
                'country' => 'Malaysia',
                'teamID' => 2,
                'gender' => 'male'
            ],
            [
                'name' => 'Wong Kah Wai',
                'dateOfBirth' => date('Y-m-d', strtotime('1995-11-20')),
                'height' => 179,
                'weight' => 74,
                'country' => 'Malaysia',
                'teamID' => 3,
                'gender' => 'male'
            ],
            [
                'name' => 'Azman Hashim',
                'dateOfBirth' => date('Y-m-d', strtotime('1997-01-08')),
                'height' => 184,
                'weight' => 82,
                'country' => 'Malaysia',
                'teamID' => 3,
                'gender' => 'male'
            ],
            [
                'name' => 'David Chen',
                'dateOfBirth' => date('Y-m-d', strtotime('1996-04-15')),
                'height' => 182,
                'weight' => 76,
                'country' => 'Malaysia',
                'teamID' => 3,
                'gender' => 'male'
            ],
            [
                'name' => 'Zain Ahmed',
                'dateOfBirth' => date('Y-m-d', strtotime('1997-08-22')),
                'height' => 178,
                'weight' => 72,
                'country' => 'Malaysia',
                'teamID' => 3,
                'gender' => 'male'
            ],
            [
                'name' => 'Lim Kuan Yew',
                'dateOfBirth' => date('Y-m-d', strtotime('1995-11-30')),
                'height' => 175,
                'weight' => 70,
                'country' => 'Malaysia',
                'teamID' => 4,
                'gender' => 'male'
            ],
            [
                'name' => 'Syed Omar',
                'dateOfBirth' => date('Y-m-d', strtotime('1998-02-14')),
                'height' => 180,
                'weight' => 75,
                'country' => 'Malaysia',
                'teamID' => 4,
                'gender' => 'male'
            ],
            [
                'name' => 'Ravi Shankar',
                'dateOfBirth' => date('Y-m-d', strtotime('1996-07-19')),
                'height' => 183,
                'weight' => 78,
                'country' => 'Malaysia',
                'teamID' => 4,
                'gender' => 'male'
            ],
            [
                'name' => 'Jason Wong',
                'dateOfBirth' => date('Y-m-d', strtotime('1997-12-03')),
                'height' => 177,
                'weight' => 71,
                'country' => 'Malaysia',
                'teamID' => 4,
                'gender' => 'male'
            ],
            [
                'name' => 'Kamal Ibrahim',
                'dateOfBirth' => date('Y-m-d', strtotime('1995-09-28')),
                'height' => 181,
                'weight' => 77,
                'country' => 'Malaysia',
                'teamID' => 4,
                'gender' => 'male'
            ],
            [
                'name' => 'Ng Wei Jian',
                'dateOfBirth' => date('Y-m-d', strtotime('1998-05-11')),
                'height' => 176,
                'weight' => 69,
                'country' => 'Malaysia',
                'teamID' => 5,
                'gender' => 'female'
            ],
            [
                'name' => 'Amir Hamzah',
                'dateOfBirth' => date('Y-m-d', strtotime('1996-10-07')),
                'height' => 179,
                'weight' => 74,
                'country' => 'Malaysia',
                'teamID' => 5,
                'gender' => 'female'
            ],
            [
                'name' => 'Suresh Kumar',
                'dateOfBirth' => date('Y-m-d', strtotime('1997-03-25')),
                'height' => 184,
                'weight' => 80,
                'country' => 'Malaysia',
                'teamID' => 5,
                'gender' => 'female'
            ],
            [
                'name' => 'Chong Wei Feng',
                'dateOfBirth' => date('Y-m-d', strtotime('1995-06-16')),
                'height' => 178,
                'weight' => 73,
                'country' => 'Malaysia',
                'teamID' => 5,
                'gender' => 'female'
            ]
        ];

        $this->db->table('players')->insertBatch($data);
    }
}
