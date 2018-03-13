<?php
namespace Modules\Auth\Models;
use Illuminate\Database\Eloquent\Model as Model;
use Libs\Eloquent\Extentions\HasCompositePrimaryKey; // *** THIS!!! ***
class Account extends Model {
    use HasCompositePrimaryKey; // *** THIS!!! ***
    protected $fillable = ['user_id', 'platform_id', 'platform_user_id','creation_ts'];
    public $primaryKey = ['platform_user_id','platform_id'];
    public $timestamps = false;

}
?>
