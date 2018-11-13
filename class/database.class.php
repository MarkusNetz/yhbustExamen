<?php
class Database
{
	// The database connection
	protected static $connection;
	private $dbType = "mysql";
	private $dbHost = DB_HOST;
	private $dbUser = DB_USER;
	private $dbPass = DB_PASSWORD;
	private $dbChar = DB_CHARSET;
	private $dbPort = DB_PORT;
	private $dbName = DB_DATABASE;
	
	private $stmt;
	private $dbh;
	private $error;
	
	function __construct(){
		// Set DSN
		$dsn = $this -> dbType . ":host=" . $this -> dbHost . ";port=" . $this -> dbPort . ";dbname=" . $this -> dbName . ";charset=" . $this -> dbChar;
		
		// Set Options
		$options = array(
			PDO::ATTR_PERSISTENT	=> true,
			PDO::ATTR_ERRMODE		=> PDO::ERRMODE_EXCEPTION
		);
		
		try{
			$this -> dbh = new PDO( $dsn, $this -> dbUser, $this -> dbPass, $options );
		}
		catch(PDOException $e ){
			die($this -> error = $e ->getMessage());
		}
	}
	
	public function query( $query ){
		$this -> stmt = $this -> dbh -> prepare( $query );
	}
	
	public function bind($param, $value, $type = null){
		if( is_null( $type ) ){
			switch ( true ){
				case ( is_int( $value ) ):
					$type = PDO::PARAM_INT;
					break;
				case ( is_bool( $value ) ):
					$type = PDO::PARAM_BOOL;
					break;
				case ( is_null( $value ) ):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		$this -> stmt -> bindValue( $param, $value, $type );
	}
	
	public function execute(){
		return $this -> stmt -> execute();
	}
	
	// Multiple rows returned.
	public function resultSet(){
		$this -> execute();
		return $this -> stmt -> fetchAll( PDO::FETCH_ASSOC );
	}
	
	// Fetch the first row of the returned result set.
	public function single(){
		$this -> execute();
		return $this -> stmt -> fetch( PDO::FETCH_ASSOC );
	}
	
	// Count number of returned rows.
	public function rowCount(){
		return $this -> stmt -> rowCount();
	}
	
	// Fetch the id of last inserted row.
	public function lastInsertId(){
		return $this-> dbh ->lastInsertId();
	}
	
	/**
	* Transaction handling
	*
	*/
	public function beginTransaction(){
		return $this -> dbh -> beginTransaction();
	}
	
	public function endTransaction(){
		return $this -> dbh -> commit();
	}
	
	public function cancelTransaction(){
		return $this -> dbh -> rollbBack();
	}
	
	public function debugDumpParameters(){
		return $this -> dbh -> debugDumpParameters();
	}
}