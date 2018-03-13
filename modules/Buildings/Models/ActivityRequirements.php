<?php
namespace Modules\Buildings\Models;
use  Modules\Base\Model as BaseModel;
#use Libs\Eloquent\Extentions\HasCompositePrimaryKey; 
class ActivityRequirements extends BaseModel {
    protected $fillable = [];
    public $primaryKey = 'id';
    public $timestamps = false;
}

