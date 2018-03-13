<?php

use Phinx\Migration\AbstractMigration;

class UsersMigrations extends AbstractMigration
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
        $this->table('local_users',['id'=>'user_id','primary_key'=>'user_id'])
            ->addColumn('device_id','string')
            ->addColumn('code','string',['null'=>true])
            ->addColumn('token','string',['null'=>true])
            ->addColumn('expires','timestamp',['null'=>true])
            ->addIndex(['code'],['unique'=>true])
            ->addIndex(['user_id'],['unique'=>true])
            ->create();

        $this->table('users',['id'=>'user_id','primary_key'=>'user_id'])
            ->addColumn('token','string',['null'=>true])
            ->addColumn('expiration_ts','timestamp',['null'=>true])
            ->addColumn('name','string',['null'=>true])
            ->addColumn('coins','integer',['null'=>true])
            ->create();

        $this->table('accounts',['id'=>false,'primary_key'=>['platform_id','platform_user_id']])
            ->addColumn('user_id','integer')     # local_user_id
            ->addColumn('platform_id','integer') # platform identificator 1 for sa, 2 for fb, etc
            ->addColumn('platform_user_id','string') 
            ->addColumn('token','string')
            ->addIndex(['platform_id','platform_user_id'],['unique'=>true])
            ->addForeignKey('user_id', 'users', 'user_id')
            #->addColumn('creation_ts','timestamp',[
            #    'default'=>'CURRENT_TIMESTAMP'
            #])
            ->create();

        $this->table('locations',['id'=>'location_id','primary_key'=>'location_id'])
            ->addColumn('name','string')
            ->addColumn('description','string')
            ->addIndex(['name'],['unique'=>true])
            ->create();

        $this->table('user_locations',['id'=>false,'primary_key'=>['user_id','location_id']])
            ->addColumn('user_id','integer')
            ->addColumn('location_id','integer')
            ->addForeignKey('user_id', 'users', 'user_id')
            ->addForeignKey('location_id', 'locations', 'location_id')
            ->create();
    }
}
