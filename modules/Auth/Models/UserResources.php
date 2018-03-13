<?php
namespace Modules\Auth\Models;
use Modules\Base\Model as BaseModel;
use  Modules\Buildings\Models\Building;
use  Modules\Buildings\Models\GameObject;

class UserResources extends BaseModel {
    
    protected $fillable = ['user_id','resource_id','count'];
    public $primaryKey = 'user_id';
    public $timestamps = false;

    public static function prepareRewards($activity_id) { 
            return self::join('resource_set','user_resources.resource_id','resource_set.resource_id')
            ->join('activity_rewards','resource_set_id','resource_set.id')
            ->where(
                ['activity_id' =>$activity_id ]
            );
    }
}
