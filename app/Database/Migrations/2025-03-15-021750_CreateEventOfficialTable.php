<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventOfficialTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'eventOfficialID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint'     => '255',
            ],
            'eventID' => [
                'type'       => 'INT',
                'constraint' => '255',
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'function' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'dateOfBirth' => [
                'type'       => 'DATE',
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
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
        $this->forge->addKey('eventOfficialID', true);
        $this->forge->addForeignKey('eventID','events','eventID','CASCADE');
        $this->forge->createTable('eventOfficials');
    }

    public function down()
    {
        $this->forge->dropTable('eventOfficials');
    }
}
