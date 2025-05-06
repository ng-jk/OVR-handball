<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSaveTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'saveID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint'     => '255',
            ],
            'matchPlayerID' => [
                'type'       => 'INT',
                'constraint' => '255',
                'null' => true,
            ],
            'isSaved' => [
                'type'       => 'BOOLEAN',
                'null' => true,
            ],
            'saveType' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'period' => [
                'type'       => 'INT',
                'constraint' => '10',
                'null' => true,
            ],
            'time' => [
                'type'       => 'TIME',
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
        $this->forge->addKey('saveID', true);
        $this->forge->addForeignKey('matchPlayerID','matchPlayers','matchPlayerID','CASCADE');
        $this->forge->createTable('saves');
    }

    public function down()
    {
        $this->forge->dropTable('saves');
    }
}
