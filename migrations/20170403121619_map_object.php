<?php

use Phinx\Migration\AbstractMigration;

class MapObject extends AbstractMigration
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
        $this->table('maps')
            ->addColumn('version','float',['null'=>true])
            ->addColumn('x_bound','float',['default'=>0])
            ->addColumn('y_bound','float',['default'=>0])
            ->addColumn('width','float',['default'=>0])
            ->addColumn('height','float',['default'=>0])
            ->addColumn('type','string')
            ->addColumn('x_tile_size','float',['default'=>0])
            ->addColumn('y_tile_size','float',['default'=>0])
            ->addColumn('tile_horisontal_px','integer',['default'=>0])
            ->addColumn('tile_vertical_px','integer',['default'=>0])
            ->addColumn('unit_px','integer',['default'=>0])
            ->create();
        $this->table('maps')->insert(['type'=>'MAP_TYPE'])->saveData();

        $this->table('locations')
            ->addColumn('x_size','float',['default'=>0])
            ->addColumn('y_size','float',['default'=>0])
            ->addColumn('x_position','float',['default'=>0])
            ->addColumn('y_position','float',['default'=>0])
            ->addColumn('z_position','float',['default'=>0])
            ->addColumn('x_bound','float',['default'=>0])
            ->addColumn('y_bound','float',['default'=>0])
            ->addColumn('z_bound','float',['default'=>0])
            ->addColumn('width','float',['default'=>0])
            ->addColumn('height','float',['default'=>0])
            ->addColumn('map_id','integer',['default'=>1])
            //->addForeignKey('map_id','maps')
            ->save();

        $this->table('properties')
            ->addColumn('name','string');

        $this->table('object_properties')
            ->addColumn('property_id','integer')
            ->addColumn('game_object_id','integer')
            ->addColumn('value','string')
            ->create();

        $this->table('game_object_types')
            ->addColumn('name','string',['null'=>true])
            ->addColumn('category','string',['null'=>true])      //environment etc
            ->addColumn('game_type','string',['null'=>true]) //__iso_object_spec 
            ->addColumn('passability','integer',['default'=>1])
            ->addColumn('size','string',['default'=>'{x:0,y:0,z:0}'])
            ->addColumn('sprite','integer',['null'=>true])
            ->addColumn('update_activity','integer')
            ->addColumn('update_result',  'integer')
            ->create();
        $this->table('game_object_types')->insert(['name'=>'initial type','category'=>'INITIAL'])->saveData();

        $this->table('game_objects') 
            ->addColumn('type_id','integer',['default'=>1]) // game object types id
            ->addColumn('position','string',['default'=>'{x:0,y:0,z:0}']) // x, y, z
            ->addColumn('sort_position','string',['default'=>1])
            ->addColumn('flipped','integer',['default'=>0])
            ->save();

    }
}
