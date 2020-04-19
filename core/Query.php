<?php
namespace core;
use PDO;

class Query
{
	private $_db;

	private $_columns = '*';
	private $_table = '';
	private $_innerJoin = [];
	private $_leftJoin = [];
	private $_rightJoin = [];
	private $_where = [];
	private $_andWhere = [];
	private $_orWhere = [];
	private $_group = [];
	private $_order = [];
	private $_offset = 0;
	private $_limit = 0;

	public function __construct($db = null)
	{
		if ($db !== null) {
			$this->_db = $ddb;
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
		$this->_innerJoin[$table] = $onCondition;
		return $this;
	}

	public function leftJoin(string $table, string $onCondition)
	{
		$this->_leftJoin[$table] = $onCondition;
		return $this;
	}

	public function rightJoin(string $table, string $onCondition)
	{
		$this->_rightJoin[$table] = $onCondition;
		return $this;
	}

	public function where($where)
	{
		$this->_where = $where;
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
					$arr[] = $value . ' AS ' . $key;
				}
			}
			if ($arr) {
				$str = implode(', ', $arr);
			}
		}
		return $base . $str;
	}
}