<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMatchPlayerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'matchPlayerID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint' => '255',
                'null' => true,
            ],
            'matchTeamID' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'eventPlayerID' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'matchGoal' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'matchShot' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'matchSave' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'isStartingLineUp' => [
                'type'       => 'BOOLEAN',
                'null' => true,
            ],
            'totalPerformanceTime' => [
                'type'       => 'TIME',
                'null' => true,
            ],
            'assist' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'passClearChance' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'recieve7m' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'recieve2min' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'commit7m' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'commit2min' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'technicalFault' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'steal' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'block' => [
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
        $this->forge->addKey('matchPlayerID', true);
        $this->forge->addForeignKey('matchTeamID','matchTeams','matchTeamID','CASCADE');
        $this->forge->addForeignKey('eventPlayerID','eventPlayers','eventPlayerID','CASCADE');
        $this->forge->createTable('matchPlayers');
    }

    public function down()
    {
        $this->forge->dropTable('matchPlayers');
    }
}
