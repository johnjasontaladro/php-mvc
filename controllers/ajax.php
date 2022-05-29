<?php

if ( @$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) {
  //Request identified as ajax request

  if ( @isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] == site_url() ) {
   //HTTP_REFERER verification
    if ( $_POST['token'] == $_SESSION['token'] ) {
      //do your ajax task
      //don't forget to use sql injection prevention here.
      if ( function_exists( $_POST['action'] ) ) {
        $func = $_POST['action'];
        $func();
      } else {
        ajax_not_found();
      }
      
    } else {
      var_dump("failed 1");
    }
    
  } else {
    var_dump("failed 2");
  }
  
} else {
  redirect( site_url() );
}


/***********************************************************************
 *                                              CART FUNCTIONS - START
 ***********************************************************************/
 
/**
 * Add product to cart
 * @param none
 * @return none
 */
function add_to_cart() {
  require_once( ABSPATH . "models/cart.php" );
  
  $cart = new Cart();
  
  $prod_id = (int)$_POST['product_id'];
  
  if ( isset( $_POST['qty'] ) ) {
    $response = $cart->add_to_cart( $prod_id, (int) $_POST['qty'] );
  } else {
    $response = $cart->add_to_cart( $prod_id );
  }
  
  if ( !$response['error'] ) {
    $response['cart'] = $cart->cart;
  }
  
  echo json_encode( $response );
  die();
  
}

function decrease_product() {
  require_once( ABSPATH . "models/cart.php" );
  
  $cart = new Cart();
  
  $prod_id = (int)$_POST['product_id'];

  $response = $cart->decrease_product( $prod_id );
  
  if ( !$response['error'] ) {
    $response['cart'] = $cart->cart;
  }
  
  echo json_encode( $response );
  die();
}

/**
 * Remove product to cart
 * @param int $cart_key
 * @return none
 */
function remove_from_cart() {
  require_once( ABSPATH . "models/cart.php" );
  
  $cart = new Cart();
  
  $cart_key = (int)$_POST['cart_key'];

  $response = $cart->remove_from_cart( $cart_key );
  
  if ( !$response['error'] ) {
    $response['cart'] = $cart->cart;
  }
  
  echo json_encode( $response );
  die();
}

/**
 * Save Transaction
 */
function save_transaction() {
  require_once( ABSPATH . "models/order.php" );
  
  $post = array_map( "trim", $_POST);
  $order = new Order();
  $response = $order->save_transaction( $post );
  
  echo json_encode( $response );
  die();
  
}

/**
 * Clear cart
 */
function cancel_sale() {
  unset( $_SESSION['cart'] );
}

/***********************************************************************
 *                                              CART FUNCTIONS - END
 ***********************************************************************/
 
/***********************************************************************
 *                                              TEMPLATE FUNCTIONS - START
 ***********************************************************************/
 
/**
 * Dropdown product values
 */
function html_product_dropdown() {
  require_once(ABSPATH . "models/category.php");
  require_once(ABSPATH . "functions/helpers.php");
  $category = new Category();

  $data['all_cat'] = $category->get_categories();
  load_view( 'templates/product_dropdown', $data );
}
 
/***********************************************************************
 *                                              TEMPLATE FUNCTIONS - END
 ***********************************************************************/

/**
 * This is for unfound functions
 */
function ajax_not_found() {

}