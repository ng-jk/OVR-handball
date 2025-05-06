<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePlayerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'playerID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint' => '255',
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                "null" => true,
            ],
            'dateOfBirth' => [
                'type'       => 'DATE',
                "null" => true,
            ],
            'height' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                "null" => true,
            ],
            'weight' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                "null" => true,
            ],
            'gender' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                "null" => true,
            ],
            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                "null" => true,
            ],
            'teamID' => [
                'type'       => 'INT',
                'constraint' => '255',
                "null" => true,
            ],
            'image' => [
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
        $this->forge->addKey('playerID', true);
        $this->forge->addForeignKey('teamID','teams','teamID','CASCADE');
        $this->forge->createTable('players');
    }

    public function down()
    {
        $this->forge->dropTable('players');
    }
}
