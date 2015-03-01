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
	abstract protected function initField($argv);
	
	public function __construct( $argv){
		$this->m_field=array_combine(static::$s_field, array_fill(0, count(static::$s_field), ''));
		$this->initField($argv);
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
		global $DEBUG;	
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
				if (!empty($value)){	
					$key_temp[]= $key;	
					$value_temp[]= $value;
					
					$template .=' ? ,';
				}	
			}
			$key_temp= join(',', $key_temp);
			$template=substr($template,0,-1);
			
			$query = "INSERT INTO ".static::$s_table." ($key_temp) VALUES ($template)";
			
			echo "$query";
			
			if (($sth = $pdo->prepare($query))==false){
				if($DEBUG)
					print_r ($sth->errorInfo());
				return false;
			}
			
			
			if ($sth->execute($value_temp)){
				echo '<p> succeed </p>';
				$m_id = $pdo->lastInsertId();	
				return true;
			}else {
				if ($DEBUG)
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
				//join the table
				$joinTable = $join::$s_table;
					
				
			
				$joinId = $joinTable."_id";
				// check join_table exists
				if (!in_array($joinId, static::$s_field))
					return false;
				
				$joinField=[];
				//rename the fields
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
	//expect field to be assoc array
	//return object
	public static function findBy($field=[],$isArray=false){
		if (count($field)==0) {
			//print_r ($field);	
			return null;
		}
		if ( ($pdo = self::getPDO())==null){
			echo 'pdo suck';
				return false;
		}
		$where =[];
		$values =[];
		foreach ($field as $key => $value){
			if (in_array($key, static::$s_field)){
				$where []= "$key = ?";
				$values []= "$value";
			}
		}
		$where_str= implode(',',$where);
		$query = "SELECT * FROM ".static::$s_table.' WHERE '.$where_str;
		//print_r($query);
		$tmp = $pdo -> prepare($query);
		if ($tmp == false){
			if ($DEBUG)
				print_r($tmp->errorInfo());
			//exit(1);	
		}
		//print_r($values);		
		$re= $tmp ->execute($values);
		if ($re == false){
			echo 'false';
		}	

		$tmp->setFetchMode(PDO::FETCH_ASSOC);
	
		$params = $tmp->fetch();
		if ($params == false){
			return null;
		}
		//print_r ($params);
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
	// parameter: Class
	public function join($table){
		global $DEBUG;
		$this->reset();
		$table_name = $table::$s_table;
		$tableId =$table_name."_id";
		if (!in_array($tableId, static::$s_field)){
			if ($DEBUG){
				echo '<h1> join null table</h1>';
			}
			return false;
		}
		$this->m_from[]=$table;
		$this->m_where[]= static::$s_table.'.'.$tableId." = {$table::$s_table}.id";
		return $this;
	
	}
	public function getData($temp=[], $joinfield=[]){
		global $DEBUG;
		if (count($temp) ==0) {
			$fields	= array( static::$s_table.'.* ');
		}else{
			$fields =[];
			foreach ($temp as $f){
				if (in_array($f, static::$s_field)){
					$fields []= static::$s_table.".$f ";	
				}

			}	
			if (empty($field)){

				$fields = [static::$s_table.'.* '];
			}
		}
		//from: store class Name
		foreach ($this->m_from as  $f	){
			$joinField = $f::$s_field;
			//renaming
			foreach($joinField as $jf){
				$fields[] = $f::$s_table.'.'.$jf." as '{$f::$s_table}.{$jf}'";  
			}
			$from_query[]=$f::$s_table;
		}
		$fields_str = implode(',',$fields);

		//this table + join table
		
		$from_query[]=static::$s_table;
		$from_str = implode(",",$from_query );
		//=======================
		//where caluse
		$this->m_where[]= static::$s_table.".id= $this->m_id";
		$where_query = implode (' AND ',$this->m_where);

		//query
		$query = 'SELECT '.$fields_str.' FROM  '.$from_str.' WHERE  '.$where_query;
		if ( ($pdo = self::getPDO())==NULL){
				return false;
		}
		
		$result = $pdo->query($query);
		if (!$result){
		if ($DEBUG){
			print_r($query);
			print_r($pdo->errorInfo());
		}
		}
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$this->reset();
		return $result;
	
	}
	
	public function getObjectData($field){
		if ($field=='id')
			return $this->m_id;
		if (in_array($field,static::$s_field)){
				return $this->m_field[$field]; 
		}

	}	
	public function setObjectData($field,$value){
		if (in_array($field, static::$s_field)){
			$this->m_field[$field] = $value;
		}

	}	
	public function reset(){
		$this->m_from=array();
		$this->m_where=array();
	
	}
	public function __toString(){
		print_r($this->m_field);
	}	
	
}


?>
