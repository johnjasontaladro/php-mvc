<?php

class Cart extends DB {
  
  public $cart = array();
  
  public function __construct() {
    parent::__construct();
    $this->set_cart();  
  }
  
  public function set_cart() {
    if ( session_id() == '' ) {
      session_start();
    }
    
    if ( isset( $_SESSION['cart'] ) ) {
      $this->cart = $_SESSION['cart'];
    }
  }
  
  /**
   * Adds our product to session cart
   * @access public
   * @param int $prod_id - Product ID
   * @return array $response
   */
  public function add_to_cart( $prod_id, $qty = null ) {
    require_once( ABSPATH . "models/product.php" );
    $product_obj = new Product();
    $product = $product_obj->get_product( $prod_id );
    
    $response = array(
      'error' => false,
      'msg' => ''
    );
    
    // check if product is still available, qty must be greater than zero
    if ( $product_obj->is_product_available( $prod_id ) ) {
    
      if ( !isset( $_SESSION['cart'] ) ) {
        // add our first product to cart
        $_SESSION['cart'][] = array(
          'qty' => 1,
          'prod_id' => $prod_id,
          'product_name' => $product['product_name'],
          'selling_price' => $product['selling_price']
        );
        
      } else {        
        
        // check if product is in our cart. If it is, return the array key
        $cart_key = $this->is_prod_exist( $prod_id );
        
        if ( is_numeric( $cart_key ) && $cart_key>= 0 ) {
        
          // Check if qty is passed in our post
          if ( !is_null( $qty ) ) {
            // Product qty must be
            if ( $qty > 0 && (int)$product['qty'] >= $qty ) {
              $_SESSION['cart'][$cart_key]['qty'] = $qty;
            } else {
              if ( $qty <= 0 ) {
                // var_dump("test");
                // die();
                $this->remove_from_cart( $cart_key );
                // die();
              } else {
                // error, means product is out of stock
                $response = array( 'error' => true, 'msg' => $_SESSION['cart'][$cart_key]['product_name'] . " is out of stock!") ;
              }
            }
          // Product qty must be greater than the session cart qty to continue adding it in our cart
          } else if ( (int)$product['qty'] > (int) $_SESSION['cart'][$cart_key]['qty'] ) {
              $_SESSION['cart'][$cart_key]['qty']++;
          } else {
            // error, means product is out of stock
            $response = array( 'error' => true, 'msg' => $_SESSION['cart'][$cart_key]['product_name'] . " is out of stock!") ;
          }
        } else {
          // if product not found in cart, add it on cart
          $_SESSION['cart'][ count($_SESSION['cart']) ] = array(
            'qty' => 1,
            'prod_id' => $prod_id,
            'product_name' => $product['product_name'],
            'selling_price' => $product['selling_price']
          );
        }         
        
      }
    } else {
      // error, means product is out of stock
      $response = array( 'error' => true, 'msg' => $product['product_name'] . " is out of stock!") ;
    }
    
    if ( isset( $_SESSION['cart'] ) )
      $this->cart = $_SESSION['cart'];
    
    return $response;
    
  }
  
  public function decrease_product( $prod_id ) {
    $response = array(
      'error' => false,
      'msg' => ''
    );
    
    // check if product is in our cart. If it is, return the array key
    $cart_key = $this->is_prod_exist( $prod_id );
    
    if ( is_numeric( $cart_key ) && $cart_key>= 0 ) {
      if ( $_SESSION['cart'][$cart_key]['qty'] > 1 ) {
        $_SESSION['cart'][$cart_key]['qty']--; 
      } else {
        $this->remove_from_cart( $cart_key );
      }
    } else {
      // error, means product is out of stock
      $response = array( 'error' => true, 'msg' => $_SESSION['cart'][$cart_key]['product_name'] . " is out of stock!") ;
    }
    
    $this->cart = $_SESSION['cart'];
    
    return $response;
    
  }
  
  public function remove_from_cart( $cart_key ) {
    $response = array(
      'error' => false,
      'msg' => ''
    );
    
    $cart = array();
    foreach( $this->cart as $key => $product ) {
      if ( (int)$cart_key !== (int)$key ) {
        $cart[] = $product;
      }
    }
    
    $_SESSION['cart'] = $cart;
    $this->cart = $cart;
    
    return $response;
  }
  
  public function is_prod_exist( $prod_id ) {
    $return_key = false;
    
    if ( isset( $_SESSION['cart'] ) && is_array( $_SESSION['cart'] ) ) {
      foreach( $_SESSION['cart'] as $key => $cart ) {
        if ( (int) $cart['prod_id'] === (int) $prod_id ) {
          $return_key = $key;
          break;
        }
      }
    }
    
    return $return_key;
  }
  
  public function compute_subtotal() {
    $subtotal = 0;
    
    if ( !empty( $this->cart ) ) {
      foreach( $this->cart as $cart ) {
        $prod_total = $cart['qty'] * $cart['selling_price'];
        $subtotal += $prod_total;
      }
    }
    
    return $subtotal;
  }
  
  public function compute_total() {
    $tax = 0; // currently no tax
    return $this->compute_subtotal() + $tax;
  }
  
}