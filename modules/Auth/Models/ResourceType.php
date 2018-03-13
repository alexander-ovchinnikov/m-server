<?php
namespace Modules\Auth\Models;
use  Modules\Base\Model as BaseModel;
#use Libs\Eloquent\Extentions\HasCompositePrimaryKey; 
class ResourceType extends BaseModel {
    protected $fillable = [];
    public $primaryKey = 'id';
    public $timestamps = false;
}

