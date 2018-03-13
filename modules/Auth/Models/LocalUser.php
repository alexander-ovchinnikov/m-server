<?php
namespace Modules\Auth\Models;
use Illuminate\Database\Eloquent\Model as Model;
class LocalUser extends Model {
    protected $fillable = ['device_id', 'code', 'token','expires'];
    public $primaryKey = 'user_id';
    public $timestamps = false;

    public static function getCode(string $device_id) : string {
        $user = LocalUser::firstOrNew(['device_id'=>$device_id]);
        do {
            $user->code = substr(md5(uniqid()), -5);
        } while (LocalUser::where(['code'=>$user->code])->first());
        $user->save();
        return $user->code;
    }
}
?>
