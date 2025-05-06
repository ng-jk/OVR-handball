<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventPlayer extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'eventPlayerID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint' => '255',
                'null' => true,
            ],
            'eventTeamID' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'playerID' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'jerseyCode' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'position' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'rank' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'goal' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'goalSaved' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'yellowCard' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            'redCard' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            'blueCard' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            '2m1' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            '2m2' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            '2m3' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            'game' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'play' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
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
        $this->forge->addKey('eventPlayerID', true);
        $this->forge->addForeignKey('eventTeamID','eventTeams','eventTeamID','CASCADE');
        $this->forge->addForeignKey('playerID','players','playerID','CASCADE');
        $this->forge->createTable('eventPlayers');
    }

    public function down()
    {
        $this->forge->dropTable('eventPlayers');
    }
}
