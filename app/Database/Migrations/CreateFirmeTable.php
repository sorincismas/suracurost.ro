<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFirmeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nume_firma' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'cui' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'adresa' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'telefon' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('firme');
    }

    public function down()
    {
        $this->forge->dropTable('firme');
    }
}
