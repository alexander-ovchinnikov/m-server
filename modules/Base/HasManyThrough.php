<?php
namespace Modules\Base;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough as EHasManyThrough;

class HasManyThrough extends EHasManyThrough{

    protected $thirdkey;
    protected $forthKey;

    public function __construct(EBuilder $query, $farParent, $parent, $firstKey, $secondKey, $thirdKey, $forthKey = null)
    {
        $this->firstKey = $firstKey;
        $this->secondKey = $secondKey;
        $this->thirdkey = $thirdKey;
        $this->forthKey = $forthKey;
        $this->farParent = $farParent;

        parent::__construct($query, $farParent, $parent, $firstKey, $secondKey,$thirdKey);
    }

    public function addConstraints() {

        $this->performJoin();
        if (@$localValue) {
            $localValue = $this->farParent[$this->localKey];
            $this->performJoin();
        } else {
            $qualifiedFirstKeyName = $this->getQualifiedFirstKeyName();
            $key = explode('.',$qualifiedFirstKeyName)[1];
            $localValue = $this->farParent[$key];
        }

        if (static::$constraints) {
            $this->query->where($this->getQualifiedFirstKeyName(), '=', $localValue);
        }
    }

    protected function performJoin(EBuilder $query = null)
    {

        $query = $query ?: $this->query;
        $foreignKey = $this->related->getTable().'.'.$this->secondKey;
        if($this->thirdkey == null)
            $query->join($this->parent->getTable(), $this->getQualifiedParentKeyName(), '=', $foreignKey);
        elseif ($this->forthKey == null ){
            $join = $this->parent->getTable().".".$this->secondKey;
            $query->join($this->parent->getTable(),$join, '=', $foreignKey);
        } else {
            $join = $this->parent->getTable().".".$this->forthKey;
            $query->join($this->parent->getTable(),$join, '=', $foreignKey);
        }

        //if ($this->parentSoftDeletes())
        //{
        //    $query->whereNull($this->parent->getQualifiedDeletedAtColumn());
        //}
    }
}
?>
