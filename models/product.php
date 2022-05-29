<?php

class Product extends DB {
  public function __construct() {
    parent::__construct();
  }
  
  public function get_product( $id ) {
    $sql = sprintf( "SELECT * FROM `products` WHERE `id` = %d", (int)$id );
    $row = $this->get_row( $sql );
    return $row;
  }
  
  public function get_products() {
    $sql = sprintf( "SELECT * FROM `products`" );
    $rows = $this->get_results( $sql );
    return $rows;
  }
  
  public function get_products_by_cat( $cat_id, $status = 'available' ) {
    if ( 'all' == $status )
      $sql = sprintf( "SELECT * FROM `products` WHERE `cat_id` = %d ORDER BY `product_name`", (int) $cat_id );
    else
      $sql = sprintf( "SELECT * FROM `products` WHERE `cat_id` = %d AND `qty` > 0 ORDER BY `product_name`", (int) $cat_id );
      
    $rows = $this->get_results( $sql );
    return $rows;
  }
  
  public function is_product_available( $id ) {
    $product = $this->get_product( $id );
    return ( $product['qty'] > 0 ) ? TRUE : FALSE;
  }
  
  public function update_product_qty( $id, $qty, $action ) {
    if ( 'increase' == $action ) {
      $sql = sprintf( "UPDATE `products` SET `qty` = `qty` + %d WHERE `id` = %d", (int) $qty, (int) $id );
    } else if ( 'decrease'  == $action ) {
      $sql = sprintf( "UPDATE `products` SET `qty` = `qty` - %d WHERE `id` = %d", (int) $qty, (int) $id );
    }
    
    return $this->query( $sql );
  }
  
}