<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMatchTeamTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'matchTeamID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint' => '255',
                'null' => false,
            ],
            'eventTeamID' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'matchID' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'endOfPlaying' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'overtime1' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'overtime2' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'afterPenalityThrow' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'teamTimeout1' => [
                'type'       => 'TIME',
                'null' => true,
            ],
            'teamTimeout2' => [
                'type'       => 'TIME',
                'null' => true,
            ],
            'teamTimeout3' => [
                'type'       => 'TIME',
                'null' => true,
            ],
            'pointInMatch' => [
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
        $this->forge->addKey('matchTeamID', true);
        $this->forge->addForeignKey('matchID','matches','matchID','CASCADE');
        $this->forge->createTable('matchTeams');
    }

    public function down()
    {
        $this->forge->dropTable('matchTeams');
    }
}
