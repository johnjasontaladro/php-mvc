<?php
if ( !is_login() )
  redirect( site_url( 'login' ) );
  
require_once(ABSPATH . "models/product.php");
require_once(ABSPATH . "models/category.php");
$product = new Product();
$category = new Category();

$data['product'] = array();
$data['categories'] = $category->get_categories();

$error_msg = array();
$err_count = 0;

// get product data for edit product
if ( "edit" === $_GET['action'] ) {
    $prod_id = (int) $_GET['id'];
    $data['product'] = $product->get_product( $prod_id );
}

// Check if form is submitted
if ( $_POST && !empty( $_POST ) ) {
    
    if ( $_POST['token'] === $_SESSION['token'] ) {
      
      $post = array_map( 'trim', $_POST );
      $prod_data = array(
        'product_name' => ( $post['product_name'] == '' ) ? null : $post['product_name'],
        'qty' => ( $post['qty'] == '' ) ? null : (int) $post['qty'],
        'reorder_lvl' => ( $post['reorder_lvl'] == '' ) ? null : (int) $post['reorder_lvl'],
        'cat_id' => ( $post['cat_id'] == '' ) ? null : (int) $post['cat_id'],
        'unit_price' => ( $post['unit_price'] == '' ) ? null : floatval( $post['unit_price'] ),
        'selling_price' => ( $post['selling_price'] == '' ) ? null : floatval( $post['selling_price'] )
      );
      
      $prod_req_field_label = array( 
        'product_name' => 'Product Name',
        'qty' => 'Quantity',
        'reorder_lvl' => 'Reorder Level',
        'cat_id' => 'Category',
        'unit_price' => 'Unit Price',
        'selling_price' => 'Selling Price'
      );
      foreach( $prod_req_field_label as $key => $required_field ) {
        if ( $prod_data[$key] == '' ) {
          $error_msg[] = $required_field . " is required.<br />";
          $err_count++;
        }
      }
      
      if ( $err_count === 0 ) {
      
        // for adding new chix
        if ( "add" === $_GET['action'] ) {
            $last_id = $product->insert( 'products', $prod_data ); // mysqli inserted id
            
            /**
             * Check if id is generated (should be greater than zero), meaning our mysql insert is successful
             */
            if ( $last_id !== NULL && is_numeric($last_id) && $last_id > 0) {
                // redirect to homepage
                redirect( site_url( 'product' ) );
            } else {
                $data['form_is_error'] = TRUE;
                $data['error_msg'] = array( "Unable to insert new product" );
            }
        } 
        // for editing existing chix
        elseif ( "edit" === $_GET['action'] ) {
            
            // for saving
            if ( isset( $post['save'] ) ) {
                $is_update = $product->update( 'products', $prod_data, array( 'id' => $prod_id ) );
                if ( $is_update ) {
                    // redirect to homepage
                    redirect( site_url( 'product' ) );
                } else {
                    $data['form_is_error'] = TRUE;
                    $data['error_msg'] = array( "Unable to update product <strong>$post[product_name]</strong>" );
                }
            } 
            // for deleting
            elseif ( isset( $post['delete'] ) ) {
                $is_deleted = $product->delete( 'products', array( 'id' => $prod_id ) );
                if ( $is_deleted ) {
                     // redirect to homepage
                    redirect( site_url( 'product' ) );
                } else {
                    $data['form_is_error'] = TRUE;
                    $data['error_msg'] = array( "Unable to delete product <strong>$post[product_name]</strong>" );
                }
            }
        }
        
      } else {
        $data['form_is_error'] = TRUE;
        $data['error_msg'] = $error_msg;
      }
      
    } else {
      $data['form_is_error'] = TRUE;
      $data['error_msg'] = array( "Bad Request!" );
    }
}


$data['title'] = 'Edit Product';
$data['css'] = 'dashboard';
$data['js'] = array( 'jquery.min', 'bootstrap.min', 'jquery.number.min', 'global' );

$data['user'] = $_SESSION[ VAR_PREFIX . 'user' ];

load_view( 'includes/header_view', $data );
load_view( 'includes/header_nav_view', $data );
load_view( 'edit_product_view', $data );
load_view( 'includes/footer_view', $data );