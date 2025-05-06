<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventTeamTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'eventTeamID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint' => '255',
            ],
            'teamID' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            'eventID' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            'group' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                "null" => true,
            ],
            'seed' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            'rank' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            'win' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            'tied' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            'lost' => [
                'type'       => 'INT',
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
        $this->forge->addKey('eventTeamID', true);
        $this->forge->addForeignKey('eventID','events','eventID','CASCADE');
        $this->forge->addForeignKey('teamID','teams','teamID','CASCADE');
        $this->forge->createTable('eventTeams');
    }

    public function down()
    {
        $this->forge->dropTable('eventTeams');
    }
}
