<?php
namespace Modules\Base;

use Modules\Base\Collection as BaseCollection;
use Illuminate\Database\Eloquent\Model as EModel;
class Model extends EModel {
    public function toResponse() {
        return $this->toArray();
    }

    public function newCollection(array $models =[]) {
        return new BaseCollection($models);
    }

    public function hasManyThrough($related, $through, $firstKey = null, $secondKey = null, $thirdKey = null, $forthKey=null)
    {
        $through = new $through;

        $firstKey = $firstKey ?: $this->getForeignKey();
        $secondKey = $secondKey ?: $through->getForeignKey();

        return new HasManyThrough(
            (new $related)->newQuery()
            , $this, $through, $firstKey, $secondKey,$thirdKey, $forthKey);
    }
}
