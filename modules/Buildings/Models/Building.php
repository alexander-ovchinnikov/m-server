<?php
namespace Modules\Buildings\Models;
use Illuminate\Database\Eloquent\Model as Model;
class Building extends Model {
    public function __construct() {
        throw new \Exception('Model "Building" is deprecated');
    }

    public $primaryKey = 'building_id';
    protected $fillable = ['building_id','type_id','position','flipped','level'];
    public $timestamps = false;
}
