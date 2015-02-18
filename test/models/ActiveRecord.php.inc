<?php

abstract class ActiveRecord{

	
	static protected $s_table="";
	static protected $s_field=array();
	static protected $s_pdo=NULL;
	protected $m_field=array(); //array
	protected $m_id=-1;
	protected $m_from=array();
	protected $m_where=array();
	
	
	
	// set m_field 
	abstract protected function initField();
	
	public function __construct( $argv){
		$this->initField();
		//print_r ($argv);
		//echo '<h1> hihi</h1>';
		foreach ( $argv as $key => $value ){
			if ($key =='id'){
				$this->m_id = $value;
				continue;
			}
			
			if (array_key_exists($key, $this->m_field )){
				$this-> m_field[$key] = $value;
			}
		}
		//print_r ($this->m_field);
		
	}
	protected static function getPDO(){
		global $DB_TYPE;
		if (self::$s_pdo == NULL){
			try {
			if ($DB_TYPE == 'sqlite') {
				self::$s_pdo = new PDO(DATABASE);
			}else{
				self::$s_pdo = new PDO(DATABASE,DB_USER,DB_PWD);
			}
			}catch (PDOException $e){
				echo '<h1> PDO ERROR!!! </h1>';
				echo $e->getMessage();
				return NULL;
			}
			return self::$s_pdo;
		}
		else return self::$s_pdo;
			
	}
	
	public function save(){
		
		if ( ($pdo = self::getPDO())==NULL){
			return false;
		}
			
		
		//check if existing item
		if ($this->m_id>=0){
				$query = "UPDATE ". static::$s_table ." SET  ";
				$temp =[];
				foreach ( $this->m_field as $key =>  $value){
					$query .= "$key=? ,";
					$temp[]=$value ;
				
				}
				//update_at
				$query .= " updated_at = CURRENT_TIMESTAMP";
				
				//substr($query,0,-1); //delete trailing ','
				
				$query .= " WHERE id=$this->m_id;";
				
				if (($sth = $pdo->prepare($query))==false){

					echo '<h1> prepare fail </h1>';
					print_r($pdo->errorInfo());
					return false;
				}
				if ($sth->execute($temp)){
					echo '<p> succeed </p>';
					
					return true;
				}else {
					echo ' <p> fail </p>';
					
					return false;
				}
		}
		else {
			$key_temp = array();
			$value_temp =array();
			$template = "";
			
			foreach ( $this->m_field as $key =>  $value){
					
					$key_temp[]= $key;	
					$value_temp[]= $value;
					
					$template .=' ? ,';
					
			}
			$key_temp= join(',', $key_temp);
			$template=substr($template,0,-1);
			
			$query = "INSERT INTO ".static::$s_table." ($key_temp) VALUES ($template)";
			
			echo "$query";
			
			if (($sth = $pdo->prepare($query))==false){
					return false;
			}
			
			
			if ($sth->execute($value_temp)){
				echo '<p> succeed </p>';
				$m_id = $pdo->lastInsertId();	
				return true;
			}else {
				print_r ($sth->errorInfo());
				echo ' <h1> Fail!! </h1>';
				
				return false;
			}
		
		}
			
	}
	
	//return pdo::statement
	public static function All($object=false, $join=""){ 
			if ( ($pdo = self::getPDO())==NULL){
				return false;
			}
		
			if (empty($join)){
				$result = $pdo->query("SELECT * FROM ".static::$s_table);
			}else {
				$joinTable = $join::$s_table;
					
				
				$joinId = $joinTable."_id";
				if (!in_array($joinId, static::$s_field))
					return false;
				
				$joinField=[];
				foreach ($join::$s_field as $f){
					$joinField[]="$f as '{$joinTable}.{$f}'";
				}
				$joinField = implode(" , ", $joinField);
				$q = "SELECT ". static::$s_table.".* , {$joinField} FROM ".static::$s_table.", $joinTable WHERE ".static::$s_table.'.'.$joinId." = {$joinTable}.id";
				
				
				$result = $pdo->query($q );		
				
				
			}
			
			$result->setFetchMode(PDO::FETCH_ASSOC);
			if (!$object){
				return $result;
			}else {
				$objects=[];
				while ($row = $result->fetch()){
					$objects[]=new static($row);
				
				}
				return $objects;
			}
	}
	
	
	public static function getField(){
		return static::$s_field;
	}

	public static function find($i){
		if (!ctype_digit($i)){
			return false;
		}
		if ( ($pdo = self::getPDO())==NULL){
				return false;
		}
		$result = $pdo->query("SELECT * FROM ".static::$s_table." WHERE id = $i");
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$params = $result->fetch();
		return new static($params);
		 
		
	}
	
	//===============================================
	//delete this record!!
	public function delete(){
		if ($this->m_id <0 ) {
			echo "<p>$this->m_id</p>";
			return false;
		}
		if ( ($pdo = self::getPDO())==NULL){
				return false;
		}
		if ($pdo->exec("DELETE FROM ".static::$s_table." WHERE id = {$this->m_id}")){
			return true;
		}else {
		
			return false;
		}
		
	
	}
	public function join($table){
		$tableId =$table."_id";
		if (!in_array($table, static::$s_field))
			return false;
		$this->m_from[]=$table;
		$this->m_where[]= static::$s_table.$tableId." = {$table}.id";
		return $this;
	
	}
	public function getThis($temp='*'){
		$str = "SELECT $temp FROM ";
		$from[]=static::$s_table;
		$from = implode(",",$this->from );
		$where[]= static::$s_table.".id= $this->m_id";
		$where = implode (",",$this->where);
		$str .= $from." ".$where;
		if ( ($pdo = self::getPDO())==NULL){
				return false;
		}
		
		$result = $pdo->query($str);
		$result->setFetchMode(PDO::FETCH_ASSOC);
		return $result;
	
	}
	
	
	
	public function reset(){
		$this->from=array();
		$this->where=array();
	
	}
	
	
}


?>