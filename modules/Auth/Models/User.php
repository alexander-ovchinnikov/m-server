<?php
namespace Modules\Auth\Models;
use Modules\Base\Model as BaseModel;
use Modules\Auth\Models\UserResources as UserResources;
use Modules\Auth\Models\ResourceType as ResourceType;
use  Modules\Buildings\Models\Building;
use  Modules\Buildings\Models\GameObject;

class User extends BaseModel {
    
    protected $fillable = ['creation_ts','token','name','coins'];
    public $primaryKey = 'user_id';
    public $timestamps = false;


    public function toArray() {
        $result = parent::toArray();
        $result['buildings'] = $this->buildings->toResponse();
        //$result['buildings'] = $this->buildings();
        return $result;
    }

    public static function boot() {
            parent::boot();
            self::created(function($model) {
                foreach(ResourceType::get()->toArray() as $key => $value) {
                    UserResources::create([
                        'resource_id'=>$value->id,
                        'user_id'    =>$model->user_id,
                        'count'      =>0
                    ]);
                }
            });
    }


    public function buildings() {
        #Modules\Buildings\Models\Building    Modules\Buildings\Models\UserBuilding
        #Building::class,
        $result = $this->hasMany(GameObject::class,'user_id'); 
        return $result;
        //$result = $this->hasManyThrough(
        //            Building::class,
        //            GameObject::class,
        //            'user_id',
        //            'building_id',
        //            'user_id',
        //            'id'
        //        );
        return $result;
}
}
