<?php

class Customer extends DB {
  public function __construct() {
    parent::__construct();
  }
  
  public function get_customer( $id ) {
    $sql = sprintf( "SELECT * FROM `customers` WHERE `id` = %d", (int)$id );
    $row = $this->get_row( $sql );
    return $row;
  }
  
  public function get_customers() {
    $sql = sprintf( "SELECT * FROM `customers`" );
    $rows = $this->get_results( $sql );
    return $rows;
  }
  
  // public function get_category_name( $id ) {
    // return $this->get_category( $id )['category_name'];
  // }
  
}