<?php
namespace Modules\Auth\Models;
use  Modules\Base\Model as BaseModel;
#use Libs\Eloquent\Extentions\HasCompositePrimaryKey; 
class ResourceSet extends BaseModel {
    protected $table = 'resource_set';
    protected $fillable = [];
    public $primaryKey = 'id';
    public $timestamps = false;
}

