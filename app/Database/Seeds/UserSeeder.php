<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = array(
            "username"=> "tester",
            "password"=> password_hash("1928374655", PASSWORD_BCRYPT),
        );

        $this->db->table('users')->insert($data);
    }
}
