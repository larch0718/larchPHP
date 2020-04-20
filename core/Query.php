<?php
namespace core;
use PDO;

class Query
{
    use core\UtilsTrait;
    
	private $_db;

	private $_columns = '*';
	private $_table = '';
	private $_join = [];
	private $_condtion = [];
	private $_group = [];
	private $_order = [];
	private $_offset = 0;
	private $_limit = 0;
	
	const ENUM_CONDITION_WHERE = 1;//where
	const ENUM_CONDITION_AND = 2;//andWhere
	const ENUM_CONDITON_OR = 3;//orWhere

	public function __construct($db = null)
	{
		if ($db !== null) {
			$this->_db = $db;
		}
	}

	public function setDd(PDO $db)
	{
		$this->_db = $db;
		return $this;
	}

	public function select(array $select = [])
	{
		if (!!$select) {
			$this->_columns = $select;
		}
		return $this;
	}

	public function from(string $table)
	{
		if (!!$table) {
			$this->_table = $table;
		}
		return $this;
	}

	public function innerJoin(string $table, string $onCondition)
	{
		$this->_join[] = "INNER JOIN $table ON $onCondition";
		return $this;
	}

	public function leftJoin(string $table, string $onCondition)
	{
	    $this->_join[] = "LEFT JOIN $table ON $onCondition";
		return $this;
	}

	public function rightJoin(string $table, string $onCondition)
	{
	    $this->_join[] = "RIGHT JOIN $table ON $onCondition";
		return $this;
	}

	public function where($where)
	{
	    $this->_condtion[] = is_array($where) ? self::conditionToString($where) : $where;
		return $this;
	}

	public function andWhere($andWhere)
	{
		$this->_andWhere[] = $andWhere;
		return $this;
	}

	public function orWhere($orWhere)
	{
		$this->orWhere[] = $orWhere;
		return $this;
	}

	public function groupBy($group)
	{
		$this->_group = $group;
		return $this;
	}

	public function orderBy($order)
	{
		$this->_order = $order;
		return $this;
	}

	public function offset(int $offset)
	{
		$this->_offset = $offset;
		return $this;
	}

	public function limit(int $limit)
	{
		$this->_limit = $limit;
		return $this;
	}

	public function all()
	{

	}

	public function one()
	{}

	private function createSql() : string
	{
		$sql = '';
		try {
			if ($this->_columns) {

			}

		} catch (\Exception $e) {
			die($e->getMessage);
		}
	}

	private static function handleSelect($select) : string
	{
		$base = 'SELECT ';
		if (is_string($select)) {
			return $base . $select;
		}
		$str = '*';
		if (is_array($select)) {
			$arr = [];
			foreach ($select as $key => $value) {
				if (is_string($key)) {
					$arr[] = '`' . $value . '` AS `' . $key . '`';
				}
			}
			if ($arr) {
				$str = implode(', ', $arr);
			}
		}
		return $base . $str;
	}
	
	private static function handleFrom(string $tableName, string $alias = '') : string
	{
	    return '`' . $tableName . '`' . ($alias !== '' ? ' AS `' . $alias . '`': '');
	}
	
	private static function handleJoin(array $joinArr) : string
	{
	    $returnStr = '';
	    foreach ($joinArr as $item) {
	        $returnStr .= self::$joinMap[$item['type']] . $item['table'] . ' ON ' . $item['condition'];
	    }
	    return  $returnStr;
	}
	
	private static function handleConditon() : string
	{}
	
	private static function conditionToString(array $condition) : string
	{
	    $returnStr = '';
	    if (is_array($condition)) {
	        $joiner = ['AND', 'OR', 'LIKE', 'BETWEEN', '>', '>=', '<', '<='];
	        $first = '';
	        $temp = [];
	        if (isset($condition[0]) && in_array($condition[0], $joiner)) {
	            $first = array_shift($condition);
	        }
	        foreach ($condition as $key => $value) {
	            if (self::isEmpty($value)) {
	                continue;
	            }
	            if (is_int($key) && is_array($value)) {
	                $temp[] = self::conditionToString($value);
	            } else if (is_int($key) && is_string($value)) {
	                $temp[] = $value;
	            }else if (is_string($key) && is_array($value)) {
	                $temp[] = '`' . $key . '` IN (' . implode(',', $value) . ')';
	            } else {
	                $temp[] = '`' . $key . '` = ';
	            }
	        }
	    }
	}
	
	
}