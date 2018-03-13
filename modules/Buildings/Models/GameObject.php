<?php
namespace Modules\Buildings\Models;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Collection as Collection;
use Libs\Eloquent\Extentions\HasCompositePrimaryKey; 

class GameObjectCollection extends Collection {

    public function toResponse() {
        $items = $this->items;
        $result = [];
        foreach($items as $item) {  
        $result[] = [
            'Id'=> $item->id,
            'Type'=>$item->type->name,
            'Passability'=>$item->type->passability,
            'Data'=>[
                'm_origin'=>json_decode($item->position),
                'm_size'  =>json_decode($item->type->size),
                'm_sortPosition' => $item->sort_position,
                'm_flipped'=>$item->flipped,
                'm_sprite' =>$item->type->sprite,
                '__type'   =>$item->type->game_type
            ]
        ];
        }
        return $result;
    }

}


class GameObject extends Model {

    protected $fillable = ['user_id','position','sort_position','location_id','type_id','flipped','level'];
    public $timestamps = false;

    public function newCollection(array $models =[]) {
        return new GameObjectCollection($models);
    }

    public function toArray() {
        return parent::toArray();
    }


    public function type() {
        return $this->belongsTo('\Modules\Buildings\Models\GameObjectType','type_id');
    }

}
