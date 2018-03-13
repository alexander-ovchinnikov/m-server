<?php

use Phinx\Migration\AbstractMigration;

class BuildingMigrations extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {

        $this->table('game_objects')
            ->addColumn('user_id','integer')
            ->addForeignKey('user_id', 'users', 'user_id')
            ->addIndex(['user_id','id'],['unique'=>true])
            ->create();
        $this->table('building_types',['id'=>false,'primary_key'=>'type_id'])
            ->addColumn('type_id','integer')
            ->addColumn('name','string')
            ->addColumn('width','integer')
            ->addColumn('height','integer')
            ->addColumn('levels','integer')
            ->addColumn('init_leve;','integer')
            ->addIndex(['type_id'],['unique'=>true])
            ->create();

        $this->table('buildings',['id'=>false,'primary_key'=>'building_id'])
            ->addColumn('building_id','integer')
            ->addColumn('type_id','integer')
            ->addColumn('position','string')
            ->addColumn('flipped','integer')
            ->addColumn('level','integer')
            ->addForeignKey('type_id', 'building_types', 'type_id')
            ->addForeignKey('building_id', 'game_objects', 'id')
            ->create();



    }
}
