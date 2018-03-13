<?php
namespace Modules\Map\Models;
use  Modules\Base\Model as BaseModel;
use  Modules\Map\Models\Location ;
use Illuminate\Database\Eloquent\Collection as Collection;
#use Libs\Eloquent\Extentions\HasCompositePrimaryKey; 
#


class MapCollection extends Collection {
    public function toResponse() {
        $result = [];
        foreach($this->items as $key => $item) {
            $result[] = $item->toResponse();
        }
        return $result;
    }
}


class Map extends BaseModel {
    public $timestamps = false;


    /*

	"DataSpec": {
		"WorldBounds": {
			"x": -2.525,
			"y": 1.30226386,
			"width": 171.7,
			"height": 199.246368
		},
		"TerritoriesType": "StaggeredIsoMap",
		"WorldTileSize": {gg
			"x": 3.57088923,
			"y": 3.57088923
		},
		"TileHorizontalPixels": 508,
		"TileVerticalPixels": 262,
		"PixelsInUnit": 100
    */

    
    public function toResponse() {
        #return MapCollection
    
            $result = ["DataSpec"=>
                [
                    'WorldBounds'=>[
                        'x'=> $this->x_bound,
                        'y'=> $this->y_bound,
                        'width'=> $this->width,
                        'height'=> $this->height,
                    ],
                    "TerritoriesType"=>$this->type,
                    "WorldTileSize"=>[
                        "x"=>$this->x_tile_size,
                        "y"=>$this->y_tile_size,
                    ],
                    "TileVerticalPixels"=>$this->tile_vertical_px,
                    "TileHorizontalPixels"=>$this->tile_horisontal_px,
                    "PixelsInUnit"=>$this->unit_px,
                    "TerritoriesSpec"=>$this->TerritoriesSpec->toResponse()
                ]
            ];
            return $result;
    }
    public function TerritoriesSpec() {
        return $this->hasMany('\\'.Location::class,'map_id');
    
    }

    public function newCollection(array $models =[]) {
        return new MapCollection($models);
    }
}

