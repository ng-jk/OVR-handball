<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenalityTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'penaltyID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint' => '255',
            ],
            'matchPlayerID' => [
                'type'           => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'penaltyType' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'time' => [
                'type'       => 'TIME',
                'null' => true,
            ],
            'period' => [
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
        $this->forge->addKey('penaltyID', true);
        $this->forge->addForeignKey('matchPlayerID','matchPlayers','matchPlayerID','CASCADE');
        $this->forge->createTable('penalties');
    }

    public function down()
    {
        $this->forge->dropTable('penalties');
    }
}
