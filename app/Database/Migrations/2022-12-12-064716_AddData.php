<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddData extends Migration
{
    protected $DBGroup = 'default';

    public function up()
    {
       $this->forge->addField([
        'id' => [
            'type' => 'CHAR',
            'constraint' => 14,
            'unique' => true,
            'null' => false
        ],
        'date' => [
            'type' => 'CHAR',
            'constraint' => 10,
            'null' => false
        ],
        'time' => [
            'type' => 'CHAR',
            'constraint' => 8,
            'null' => false
        ],
        'vehicle' => [
            'type' => 'VARCHAR',
            'constraint' => 20,
            'null' => false
        ],
        'total_weight' => [
            'type' => 'DECIMAL',
            'constraint' => '10,2',
            'null' => false
        ],
        'tare_weight' => [
            'type' => 'DECIMAL',
            'constraint' => '10,2',
            'null' => false
        ],
        'mineral_weight' => [
            'type' => 'DECIMAL',
            'constraint' => '10,2',
            'null' => false
        ]
    ]);

    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('Rom');
    }

    public function down()
    {
        $this->forge->dropTable('rom');
    }
}
