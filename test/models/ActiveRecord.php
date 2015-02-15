<?php
$dbInformation='mysql:dbname=test;host=localhost';
$dbUser='root';
$dbPwd='12345';
abstract class ActiveRecord{

	protected $m_id=-1;
	static protected $m_table="";
	protected $m_field=array(); //array
	
	static protected $s_pdo=NULL;
	// set m_field m_table
	abstract protected function set();
	
	public function __construct( $argv){
		$this->set();
		//print_r ($argv);
		//echo '<h1> hihi</h1>';
		foreach ( $argv as $key => $value ){
			
			if (array_key_exists($key, $this->m_field )){
				$this-> m_field[$key] = $value;
			}
		}
		//print_r ($this->m_field);
		
	}
	protected static function getPDO(){
		if (self::$s_pdo == NULL){
			try {
			self::$s_pdo = new PDO('mysql:dbname=test;host=localhost','root','12345');
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
				$query = "UPDATE ". static::$m_field ." SET  ";
				$temp = array();
				foreach ( $this->m_field as $key =>  $value){
					$query += "$key=? ,";
					$temp[]=$value ;
				
				}
				substr($query,0,-1); //delete trailing ','
				
				$query += "WHERE id=$this->m_id;";
				if (($sth = $pdo->prepare($query))==false){
					return false;
				}
				if ($sth->execute($query)){
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
			
			$query = "INSERT INTO ".static::$m_table." ($key_temp) VALUES ($template)";
			
			echo "$query";
			
			if (($sth = $pdo->prepare($query))==false){
					return false;
			}
			
			
			if ($sth->execute($value_temp)){
				echo '<p> succeed </p>';
					
				return true;
			}else {
				print_r ($sth->errorInfo());
				echo ' <h1> Fail!! </h1>';
				
				return false;
			}
		
		}
			
	}
	
	public static function All(){
			if ( ($pdo = self::getPDO())==NULL){
				return false;
			}
		
			
			$result = $pdo->query("SELECT * FROM ".static::$m_table);
			
			return $result;
	}
	
	
	
}


?>