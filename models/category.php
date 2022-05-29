<?php

class Category extends DB {
  public function __construct() {
    parent::__construct();
  }
  
  public function get_category( $id ) {
    $sql = sprintf( "SELECT * FROM `product_categories` WHERE `id` = %d", (int)$id );
    $row = $this->get_row( $sql );
    return $row;
  }
  
  public function get_categories() {
    $sql = sprintf( "SELECT * FROM `product_categories`" );
    $rows = $this->get_results( $sql );
    return $rows;
  }
  
  public function get_category_name( $id ) {
    return $this->get_category( $id )['category_name'];
  }
  
}