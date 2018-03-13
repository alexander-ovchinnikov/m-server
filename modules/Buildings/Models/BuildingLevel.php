<?php
namespace Modules\Buildings\Models;
use  Modules\Base\Model as BaseModel;
use Libs\Eloquent\Extentions\HasCompositePrimaryKey; // *** THIS!!! ***
class BuildingLevel extends BaseModel {
    use HasCompositePrimaryKey; 
    protected $fillable = [];
    public $primaryKey = ['level_id','type_id'];
    public $timestamps = false;
}

