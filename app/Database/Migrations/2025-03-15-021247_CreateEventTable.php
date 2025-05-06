<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'eventID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint' => '255',
                'null' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'startDate' => [
                'type'       => 'DATE',
                'null' => true,
            ],
            'endDate' => [
                'type'       => 'DATE',
                'null' => true,
            ],
            'series' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'rules' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'candidateNum' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'address' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'hall' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'gender' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'age' => [
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
        $this->forge->addKey('eventID', true);
        $this->forge->createTable('events');
    }

    public function down()
    {
        $this->forge->dropTable('events');
    }
}
