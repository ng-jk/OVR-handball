<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeamTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'teamID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint' => '255',
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                "null" => true,
            ],
            'teamInfo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                "null" => true,
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                "null" => true,
            ],
            'dateFounded' => [
                'type'       => 'DATE',
                "null" => true,
            ],
            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                "null" => true,
            ],
            'state' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                "null" => true,
            ],
            'gender' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                "null" => true,
            ],
            "created_at" => [
                "type" => "DATETIME",
                "null" => true,
                "default" => null,
            ],
            "updated_at" => [
                "type" => "DATETIME",
                "null" => true,
                "default" => null,
            ],
            "deleted_at" => [
                "type" => "DATETIME",
                "null" => true,
                "default" => null,
            ],
        ]);
        $this->forge->addKey('teamID', true);
        $this->forge->createTable('teams');
    }

    public function down()
    {
        $this->forge->dropTable('teams');
    }
}
