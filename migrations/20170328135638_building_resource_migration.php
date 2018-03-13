<?php

use Phinx\Migration\AbstractMigration;

class BuildingResourceMigration extends AbstractMigration
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
        
        //$this->table('resources')
        //    ->addColumn('name','string')
        //    ->create();
        $this->table('user_resources',['id'=>false,'primary_key'=>['user_id','resource_id']])
            ->addColumn('user_id','integer')
            ->addColumn('resource_id','integer')
            ->addColumn('count','integer')
            ->addForeignKey('user_id','users','user_id')
            ->addForeignKey('resource_id','resource_types')
            ->addIndex(['resource_id','user_id'],['unique'=>true])
            ->create();

        $this->table('resource_set')
            ->addColumn('resource_id','integer')
            ->addColumn('count','integer')
            ->addForeignKey('resource_id','resources_types')
            ->create();

        $this->table('activity_requirements')
            ->addColumn('max_stack')
            ->removeColumn('resource_count')
            ->removeColumn('resource_type_id')
            ->addColumn('resource_set_id','integer')
            ->addForeignKey('resource_set_id','resource_set')
            ->save();
        $this->table('activity_rewards')
            ->removeColumn('resource_count')
            ->removeColumn('resource_type_id')
            ->addColumn('resource_set_id','integer')
            ->addForeignKey('resource_set_id','resource_set')
            ->save();


    }
}
