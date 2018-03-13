<?php
namespace Modules\Buildings\Models;
use  Modules\Base\Model as BaseModel;
#use Libs\Eloquent\Extentions\HasCompositePrimaryKey; 
class ActivityType  extends BaseModel {
    public const REPEATABLE = 'REPEATABLE';
    public $timestamps = false;
}
