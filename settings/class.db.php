<?php

class DB {
	private $host   = DB_HOST;
	private $user   = DB_USER;
	private $pass   = DB_PASSWORD;
	private $db     = DB_NAME;
  private $conn   = null; 
  
	
	public function __construct() {
		$conn = mysqli_connect( $this->host, $this->user, $this->pass ) or die( 'Cannot connect db' . mysqli_error( $conn ) );
		mysqli_select_db( $conn, $this->db ) or die( 'Cannot connect. ' . mysqli_error( $conn ) );
    $this->conn = $conn;
	}
  
  public function mysqli_real_escape_string_callback( $raw ) {
    return mysqli_real_escape_string( $this->conn, $raw );
  }
  
  public function query( $sql ) {
    $result = mysqli_query( $this->conn, $sql );
		
		return ( mysqli_affected_rows( $this->conn ) > 0 ) ? true : false;
  }
	
	public function get_results( $sql ) {
		$data = array();
		
		$results = mysqli_query( $this->conn, $sql );
    if ( !$results ) {
      die( "Error: " . mysqli_errno( $this->conn ) . " : " . mysqli_error( $this->conn )."</br>Query: " . $sql );
    }
    while( $row = mysqli_fetch_array( $results, MYSQLI_ASSOC ) ) {
      $data[] = $row;
    }
		
    
		return ( !empty( $data ) ) ? $data : FALSE;
	}
	
	public function get_row( $sql ) {
		$data = array();
		
		$result = mysqli_query( $this->conn, $sql );
		$data = mysqli_fetch_assoc( $result );
		
		return $data;
	}
	
	public function insert( $table, $data = array() ) {
    $data = array_map( array( $this, "mysqli_real_escape_string_callback" ), $data );
    
		$fields = array_keys( $data );
		$field_value = array();
		
		foreach ( $data as $value ) {
			$field_value[] = $value;
		}
		
		$sql = "INSERT INTO $table (" . implode( ',', $fields ) . ") VALUES ('" . implode( "','", $field_value ) . "')";
		
		$result = mysqli_query( $this->conn, $sql );
		$last_id = mysqli_insert_id( $this->conn );
		
		if ( $last_id !== NULL && is_numeric( $last_id ) && $last_id > 0 )
			return $last_id;
		else
			return FALSE;
		
	}
  
  public function update( $table, $data = array(), $where = array(), $condition = "AND" ) {
    $data = array_map( array( $this, "mysqli_real_escape_string_callback" ), $data );
    $where = array_map( array( $this, "mysqli_real_escape_string_callback" ), $where );
    
    $set = array();
		foreach ( $data as $key => $value ) {
			$set[] = "`$key`=\"$value\"";
		}    
    
    $_where = array();
    foreach ( $where as $key => $value ) {
			$_where[] = "`$key`=\"$value\"";
		}
    
		$sql = "UPDATE `$table` SET " . implode( ", ", $set ) . " WHERE " . implode(" " . $condition . " ", $_where );
		
		$result = mysqli_query( $this->conn, $sql );
		
    return ( mysqli_affected_rows( $this->conn ) > 0 ) ? true : false;
		
	}
	
	public function delete( $table, $where = array() ) {
    $where = array_map( array( $this, "mysqli_real_escape_string_callback" ), $where );
    
		$wheres = array();
		foreach ( $where as $field => $value ) {
			$wheres[] = "`$field` = \"$value\"";
		}
		
		$sql = "DELETE FROM `$table` WHERE " . implode( ' AND ', $wheres );
		$result = mysqli_query( $this->conn, $sql );
		
		return ( mysqli_affected_rows( $this->conn ) > 0 ) ? true : false;
	
	}
	
	
	
}

$db = new DB();