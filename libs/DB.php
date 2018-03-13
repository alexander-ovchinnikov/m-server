<?php 
namespace DB;
class DB
{
    protected $link = null;
    public static function init(string $connection_string)
    {
            self::$link  = pg_connect($connection_string);
            if (!self::$link) {
                throw \Exception();
            }
    }

    public function getDB() {
        if (!self::$link) {
            throw \Exception();
        }
        return self::$link;

    }
}




class CommonPostgresModel {
    private $pks;
    private $_query_string;

    public static function getPks() : array {
        return $this->pks;
    }

    public static function get($values) {
        if (!@count(self::getPks())) {
            throw Exception('Could not get by pk, when pk is not defined');
        }
        return self::select()->where(
                !is_array($values) ? array_fill_keys($this->pks,$condition) : $values
        );
    }

    public function limit($offest = 0, $limit =0) {
        $this->_query_string.=" limit {$offest}, {$limit}";
        return $this;
    }

    public function fetch($resource) : array {
        return pg_fetch_all($resource);
    }

    #public static function prepareValues($values) : self { 
    #}

    public function where(array $params) : self {
        $counter = count($this->_query_params);
        $this->_query_params+= $params;
        foreach($params as $key=>$value) {
            $counter++;
            $this->_query_string+=' and ' . $key . '= $'.$counter;
        }
        return $this;
    }


    public static function select(array $input_fields = null) : string {
        if ($input_fields != null) {
            $fields = explode(',',$input_fields);   
        } else {
            $fields = '*';
        }
        return new self('select '.$fields.' from '.self::$db_name.' where true');
    }

    public static function insert(array $values) : string {
        $params = [];
        for($i = 1; $i<=count($values); $i++) $params[]='$'.$i; 
        return new self('insert into '.self::$db_name.' ( ' . array_keys($values) . ' )  values ('.implode(',',$params).')
            where true',array_values($values)
        );

    }

    public function execute() {
        return $this->fetch(
            pg_query_params($this->_query_string,$this->_query_params)
        );
    }

    public function __invoke() {
        return $this->execute();
    
    }

    #post::select->where($params) 
    public function update($values) {
        $counter = 0;
        $this->_query_params+= $params;
        $params = [];
        foreach($params as $key=>$value) {
            $counter++;
            $params[]= $key . '= $'.$counter;
        }
        return new self('update '.self::$db_name.' set '.implode(',',$params).'
            where true',array_values($values)
        );
        
    }

    public function __construct(string $initial_query_string,array $query_params) {
        $this->$_query_string = $initial_query_string;
        $this->$_query_params = $query_params;
    }
}

?>

