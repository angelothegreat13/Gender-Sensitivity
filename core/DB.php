<?php

namespace Gender\Core;

use Gender\Classes\Supports\Config;

class DB {
	
	private static $_instance = null;
				   
	private $_pdo,
			$_query,
			$_error = false,
			$_results,
			$_count = 0,
			$_lastInsertID;

	private function __construct($dbname)
	{	
		try {
		$this -> _pdo = new \PDO('mysql:host='.Config::get('mysql/host').';dbname='.$dbname,Config::get('mysql/username'),Config::get('mysql/password'));
		} 
		catch (\PDOException $e){
			die($e -> getMessage());
		}
	}

	public static function instance($dbname)
	{	
		return self::$_instance = new DB($dbname); 		
	}

	public function query($sql,$params = array())
	{	
		$this -> _error = false; //to prevent returning an error to the previous query
		if ($this -> _query = $this -> _pdo -> prepare($sql)) 
		{
			if (count($params)) 
			{
				$x=1;
				foreach ($params as $param) 
				{
					$this -> _query -> bindValue($x,$param);
					$x++;
				}
			}

			if ($this -> _query -> execute()) 
			{
				$this -> _results = $this -> _query -> fetchAll(\PDO::FETCH_OBJ);
				$this -> _count = $this -> _query -> rowCount();
				$this -> _lastInsertID = $this -> _pdo -> lastInsertId();
			}
			else
			{
				$this -> _error = true;
			}
		}
		return $this; //return this OBJ
	}

	public function action($action,$table,$where = array())
	{	
		//check if the where array length is equal to 3
		if (count($where) === 3) 
		{
			$operators = array('=','<>','>','<','>=','<=');

			$field 	   = $where[0];
			$operator  = $where[1];
			$value     = $where[2];

			if (in_array($operator,$operators)) 
			{
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if (!$this -> query($sql,array($value))->error()) 
				{
					return $this;
				}
			}
		}
		return false;
	}

	public function get($table,$where = array())
	{
		return $this -> action("SELECT *",$table,$where);	
	}

	public function all($table, $field = null , $order = 'ASC')
	{	
		$sql = "SELECT * FROM {$table}";
		$data = $this -> query(($field == null) ? $sql .= "" : $sql.=" ORDER BY {$field} {$order}");
		
		if ($data -> count()) {
			return $data -> results();
		}

		return false;
	}

	public function delete($table,$where)
	{
		return $this -> action("DELETE",$table,$where);
	}

	public function softDelete($table,$where,$column = 'deleted')
	{
		$field 	   = $where[0];
		$operator  = $where[1];
		$value     = $where[2];
		$sql = "UPDATE {$table} SET {$column} = 1 WHERE {$field} {$operator} ?";

		if (!$this -> query($sql,[$value]) -> error()) {
			return true; 
		}
		
		return false;
	}

	public function insert($table,$fields = array())
	{
		
		$keys = array_keys($fields); 
		$values = null;
		$x = 1;

		foreach ($fields as $field) 
		{
			$values .= '?';
			if ($x < count($fields)) 
			{
				$values .= ', ';
			}
			$x++;
		}
		// ?, ?, ? = output of the values

		$sql = "INSERT INTO {$table} (`" . implode('`,`', $keys) . "`) VALUES({$values})";

		// INSERT INTO users(`username`,`password`,`salt`) = output of the sql after implode

		if (!$this -> query($sql,$fields) -> error()) 
		{
			return true; 
		}
		return false;
	}

	public function update($table,$id,$fields = array(),$fieldId)
	{
		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) //getting the column name of the table
		{
			$set .= "{$name} = ?";
			if ($x < count($fields)) 
			{
				$set .= ', ';
			}
			$x++;
		}
		// pass = ?, name = ? = output of the set

		$sql = "UPDATE {$table} SET {$set} WHERE {$fieldId} = {$id}";
		
		// UPDATE users SET pass = ?, name = ? WHERE user_id = 2 = output of the sql
		if (!$this -> query($sql,$fields) -> error()) 
		{
			return true; 
		}
		return false;
	}

	public function results() 
	{
		return $this -> _results;
	}

	public function first() 
	{
		return $this -> results()[0];
	}

	public function error() 
	{
		return $this -> _error;
	}

	public function count() 
	{
		return $this -> _count;
	}

	public function lastRow($table,$id,$columns = array())
	{	
		$columns = ($columns) ? implode(',', $columns) : '*'; 
		$lastRow = $this -> query("SELECT {$columns} FROM {$table} ORDER BY {$id} DESC LIMIT 1");
		
		if ($lastRow -> count()) {
			return $lastRow -> first();
		}
		return false;
	}

	public function select(array $columns,$table,$order = 'ASC')
	{	
		$id = $columns[0];
		$sql = "SELECT `" . implode('`,`', $columns) . "` FROM {$table} ORDER BY {$id} {$order}";
		return $this -> query($sql) -> results();
	}

	public function lastID()
	{
		return $this -> _lastInsertID;
	}

	public function __destruct()
	{
		$this -> _pdo = null;
	}

}


