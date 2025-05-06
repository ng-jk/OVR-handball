<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMatchTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'matchID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint' => '255',
            ],
            'eventID' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'hall' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'dateTime' => [
                'type'       => 'DATETIME',
                'null' => true,
            ],
            'spectator' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'matchNo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'remark' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'winner' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'round' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'halftimeStart' => [
                'type'       => 'TIME',
                'null' => true,
            ],
            'halftimeEnd' => [
                'type'       => 'TIME',
                'null' => true,
            ],
            "created_at" => [
                "type" => "DATETIME",
                "null" => true,
            ],
            "updated_at" => [
                "type" => "DATETIME",
                "null" => true,
            ],
            "deleted_at" => [
                "type" => "DATETIME",
                "null" => true,
            ],
        ]);
        $this->forge->addKey('matchID', true);
        $this->forge->addForeignKey('eventID','events','eventID','CASCADE');
        $this->forge->createTable('matches');
    }

    public function down()
    {
        $this->forge->dropTable('matches');
    }
}
