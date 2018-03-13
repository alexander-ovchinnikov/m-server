<?php
namespace Modules\Base;

use Illuminate\Database\Eloquent\Collection as ECollection;


class Collection extends ECollection {
    public function toResponse() {
        $result = [];
        foreach($this->items as $key => $item) {
            $result[] = $item->toResponse();
        }
        return $result;
    }
}
