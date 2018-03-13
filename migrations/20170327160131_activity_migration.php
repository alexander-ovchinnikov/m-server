<?php

use Phinx\Migration\AbstractMigration;

class ActivityMigration extends AbstractMigration
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
        $this->table('levels')
            ->create();
        $this->table('levels')->insert(['id'=>'1'])->saveData();

        $this->table('buildings')
            ->addForeignKey('level', 'levels', 'id')
            ->save();

        $this->table('resource_types')
            ->addColumn('name','string')
            ->create();

        $this->table('activity_types')
            ->addColumn('name','string')
            ->create();

        $this->table('activities') 
            ->addColumn('max_stack','integer',['default'=>1])
            ->addColumn('name','string')
            ->addColumn('time','integer')
            ->addColumn('type_id','integer')
            ->addForeignKey('type_id',  'activity_types', 'id')
            ->create();


        $this->table('active_activities')
            ->addColumn('game_object_id','integer')
            ->addColumn('activity_id','integer')
            ->addColumn('ts_end','integer')
            ->addForeignKey('activity_id',  'activities')
            ->addForeignKey('game_object_id',  'game_objects')
            ->addIndex(['game_object_id'],['unique'=>true])
            ->create();


        $this->table('activity_requirements')
            ->addColumn('activity_id','integer')
            ->addColumn('resource_type_id','integer')
            ->addColumn('resource_count','integer')
            ->addForeignKey('activity_id', 'activities', 'id')
            ->addForeignKey('resource_type_id', 'resource_types', 'id')
            ->create();

        $this->table('activity_rewards')
            ->addColumn('activity_id','integer')
            ->addColumn('resource_type_id','integer')
            ->addColumn('resource_count','integer')
            ->addForeignKey('activity_id', 'activities', 'id')
            ->addForeignKey('resource_type_id', 'resource_types', 'id')
            ->create();

        $this->table('building_levels',['id'=>false,'primary_key'=>['level_id','type_id']])
            ->addColumn('level_id','integer')
            ->addColumn('type_id','integer')
            ->addColumn('build_activity_id','integer') //requirement
            ->addForeignKey('level_id', 'levels', 'id')
            ->addForeignKey('type_id', 'building_types', 'type_id')
            ->addForeignKey('build_activity_id', 'activities', 'id')
            ->create();

        /* witch activities can building at that level had */
        $this->table('building_activities',['id'=>false,'primary_key'=>['level_id','type_id','activity_id']])
            ->addColumn('level_id','integer')
            ->addColumn('type_id','integer')//building type id
            ->addColumn('activity_id','integer')
            ->addForeignKey('activity_id', 'activities', 'id')
            ->addForeignKey('level_id', 'levels', 'id')
            ->addForeignKey('type_id',  'building_types', 'type_id')
            ///->addColumn('requirement_activity_id','integer')
            ->create();


    }
}
