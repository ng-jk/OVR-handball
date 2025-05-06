<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeamOfficialTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'officialID' => [
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
            'function' => [
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
        $this->forge->addKey('officialID', true);
        $this->forge->addForeignKey('teamID','teams','teamID','CASCADE');
        $this->forge->createTable('teamOfficials');
    }

    public function down()
    {
        $this->forge->dropTable('teamOfficials');
    }
}
