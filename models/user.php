<?php

class User extends DB {
  public function __construct() {
    parent::__construct();
  }
  
  public function is_user_exist( $user ) {
    $sql = sprintf( "SELECT * FROM `users` WHERE `username` = '%s'", $user );
    $row = $this->get_row( $sql );
    
    if ( $row )
      return $row;
    else
      return false;
  }
  
  public function login( $user, $password ) {
    $sql = sprintf( "SELECT * FROM `users` WHERE `username` = '%s' AND `password` = '%s'", $user, $password );
    $row = $this->get_row( $sql );
    
    return ( $row ) ? true : false;
  }
  
  public function user_data($id) {
    $sql = sprintf("SELECT `fname`, `lname` FROM `users` WHERE `id` = %d", (int)$id);
    $row = $this->get_row($sql);
    return $row;
  }
}