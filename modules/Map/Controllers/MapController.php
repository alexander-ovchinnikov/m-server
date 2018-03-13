<?php
namespace Modules\Map\Controllers;
use Modules\Map\Models\Map;
use Modules\Buildings\Models\GameObject;
use Modules\Buildings\Models\GameObjectType;
use Modules\Buildings\Models\MapObject;
use Illuminate\Database\Capsule\Manager as Capsule;



class MapController {

    public function Upload() {
        //ModelMap
        
    }


    public static function Proto($user_id) {
            return      Map::with('TerritoriesSpec')
            ->get()->toResponse();

            //return      GameObject::with('type')
            //->where(['user_id'=>$user_id])->get()->toResponse();
    }

    public function Download() {


    }

}

?>
