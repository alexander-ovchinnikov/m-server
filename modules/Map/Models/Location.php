<?php
namespace Modules\Map\Models;
use  Modules\Base\Model as BaseModel;
use  Modules\Buildings\Models\GameObject;

class Location extends BaseModel {
    public $timestamps = false;
    public function toResponse() {
            $result = [
                'Id'    => $this->location_id,
                "MapSize"=> [
                    "x"=>$this->x_size,
                    "y"=>$this->x_size,
                ],
                "Name"=>$this->name,
                "Position"=>[
                    "x"=>$this->x_position,
                    "y"=>$this->y_position,
                    "z"=>$this->z_position
                ],
                "Bounds"=>[
                    "x"=>$this->x_bound,
                    "y"=>$this->y_bound,
                    "z"=>$this->z_bound,
                    "width"=>$this->width,
                    "height"=>$this->height
                ],
                "Layers"=>[
                    [
                        "Type"  =>"OBJECTS",
                        "SortingLayer"=>"Environment",
                        "Objects"=>$this->objects->toResponse()
                    ]
                ]
            ];
            return $result;
    }


    public function objects()  {
        return $this->hasMany(GameObject::class,'location_id','location_id');
    }
}
