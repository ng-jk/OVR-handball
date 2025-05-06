<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventPartnerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'eventPartnerID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'constraint' => '255',
            ],
            'eventID' => [
                'type'       => 'INT',
                'constraint' => '255',
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'hyperlink' => [
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
        $this->forge->addKey('eventPartnerID', true);
        $this->forge->addForeignKey('eventID','events','eventID','CASCADE');
        $this->forge->createTable('eventPartners');
    }

    public function down()
    {
        $this->forge->dropTable('eventPartners');
    }
}
