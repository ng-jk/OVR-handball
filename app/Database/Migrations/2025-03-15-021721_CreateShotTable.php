<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShotTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'shotID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint'     => '255',
            ],
            'matchPlayerID' => [
                'type'       => 'INT',
                'constraint' => '10',
                'null' => true,
            ],
            'shotType' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'goalType' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'destType' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'throwPosition' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'period' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'time' => [
                'type'       => 'TIME',
                'null' => true,
            ],
            'defenseNum' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'attackNum' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'goalkeeperID' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'isGoalKeeperOut' => [
                'type'       => 'BOOLEAN',
            ],
            'speed' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
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
        $this->forge->addKey('shotID', true);
        $this->forge->addForeignKey('matchPlayerID','matchPlayers','matchPlayerID','CASCADE');
        $this->forge->createTable('shots');
    }

    public function down()
    {
        $this->forge->dropTable('shots');
    }
}
