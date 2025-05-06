<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMatchOfficial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'matchOfficialID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint'     => '255',
            ],
            'matchID' => [
                'type'       => 'INT',
                'constraint' => '255',
            ],
            'eventOfficialID' => [
                'type'       => 'INT',
                'constraint' => '255',
            ],
            'remark' => [
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
        $this->forge->addKey('matchOfficialID', true);
        $this->forge->addForeignKey('matchID','matches','matchID','CASCADE');
        $this->forge->addForeignKey('eventOfficialID','eventOfficials','eventOfficialID','CASCADE');
        $this->forge->createTable('matchOfficials');
    }

    public function down()
    {
        $this->forge->dropTable('matchOfficials');
    }
}
