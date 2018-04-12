<?php
class Database
{
	// The database connection
	protected static $connection;
	private $host = HOST;
	private $user = USER;
	private $pass = PASSWORD;
	private $dbName = DATABASE;
	
	private $stmt;
	private $dbh;
	private $error;
	
	function __construct()
	{
		// Set DSN
		$dsn = "mysql:host=" . $this -> host . ";dbname=" . $this -> dbName;
		
		// Set Options
		$options = array(
			PDO::ATTR_PERSISTENT	=> true,
			PDO::ATTR_ERRMODE		=> PDO::ERRMODE_EXCEPTION
		);
		
		try{
			$this -> dbh = new PDO( $dsn, $this -> user, $this -> pass, $options );
		}
		catch(PDOException $e ){
			$this -> error = $e ->getMessage();
		}
	}
	
	public function query( $query )
	{
		$this -> stmt = $this -> dbh -> prepare( $query );
	}
	
	public function bind($param, $value, $type = null)
	{
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
	
	public function execute()
	{
		$this -> stmt -> execute();
	}
	
	// Multiple rows returned.
	public function resultSet()
	{
		$this -> execute();
		return $this -> stmt -> fetchAll( PDO::FETCH_ASSOC );
	}
	
	// Fetch the first row of the returned result set.
	public function single()
	{
		$this -> execute();
		return $this -> stmt -> fetch( PDO::FETCH_ASSOC );
	}
	
	// Count number of returned rows.
	public function rowCount()
	{
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
	public function beginTransaction()
	{
		$this -> dbh -> beginTransaction();
	}
	
	public function endTransaction()
	{
		$this -> dbh -> commit();
	}
	
	public function cancelTransaction()
	{
		$this -> dbh -> rollbBack();
	}
	
	public function debugDumpParameters()
	{
		return $this -> dbh -> debugDumpParameters();
	}
}
?>