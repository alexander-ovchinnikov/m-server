<?php

use Phinx\Migration\AbstractMigration;

class PremiumValute extends AbstractMigration
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

        $this->table('force_prices')
             ->addColumn('target_resource_id','integer',['null'=>true])
             ->addColumn('value','integer')
             ->addColumn('price','integer')
             ->addIndex(['value','price','target_resource_id'],['unique'=>true])
             ->create();

        $this->table('units')
            ->addColumn('name','string',['null'=>true])
            ->create();
              
        $this->table('user_units')
            ->addColumn('user_id','integer')
            ->addColumn('unit_id','integer')
            ->addColumn('activity_id', 'integer',['null'=>true])
            ->addForeignKey('user_id', 'users', 'user_id')
            ->addForeignKey('unit_id', 'units', 'id')
            ->addForeignKey('activity_id', 'active_activities', 'id')
            ->create();

        $this->table('activity')
            ->addColumn('units_required','integer',['default'=>0])
            ->save();
    }
}
