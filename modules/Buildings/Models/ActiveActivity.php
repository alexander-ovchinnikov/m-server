<?php
namespace Modules\Buildings\Models;
use  Modules\Base\Model as BaseModel;
#use Libs\Eloquent\Extentions\HasCompositePrimaryKey; 
class ActiveActivity  extends BaseModel {
    protected $fillable = ['activity_id','game_object_id','ts_end'];

    public $primaryKey = 'id';
    public $timestamps = false;
    protected $appends = ['progress'];
    protected $hidden = ['ts_end','activity_id'];

    public function getProgressAttribute() {
        try {
            $activity = Activity::where(['id'=>$this->activity_id])->firstOrFail();
            $progress = round(1-($this->ts_end-time())/$activity->time,2);
            return $progress>$activity->max_stack ? $activity->max_stack : $progress;
        } catch (Exception $e) {
            return null;
        }
    }

}

