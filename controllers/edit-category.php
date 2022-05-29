<?php
if ( !is_login() )
  redirect( site_url( 'login' ) );
  
require_once(ABSPATH . "models/category.php");
$category = new Category();
$data['category_name'] = '';
    
// get category data for edit category
if ( "edit" === $_GET['action'] ) {
    $cat_id = (int) $_GET['id'];
    $cat = $category->get_category( $cat_id );
    $data['category_name'] = ( $cat && $cat['category_name'] ) ? $cat['category_name'] : "";
}

// Check if form is submitted
if ( $_POST ) {

  if ( $_POST['token'] === $_SESSION['token'] ) {
    
      // sanitize data
      $post = array_map( 'trim', $_POST );
      
      // for adding new chix
      if ( "add" === $_GET['action'] ) {
          $last_id = $category->insert( 'product_categories', array( 'category_name' => $post['name'] ) ); // mysqli inserted id
          
          /**
           * Check if id is generated (should be greater than zero), meaning our mysql insert is successful
           */
          if ( $last_id !== NULL && is_numeric($last_id) && $last_id > 0) {
              // redirect to homepage
              redirect( site_url( 'category' ) );
          } else {
              $data['form_is_error'] = TRUE;
              $data['error_msg'] = array( "Unable to insert new category" );
          }
      } 
      // for editing existing chix
      elseif ( "edit" === $_GET['action'] ) {
          
          // for saving
          if ( isset( $post['save'] ) ) {
              $is_update = $category->update( 'product_categories', array( 'category_name' => $post['name'] ), array( 'id' => $cat_id ) );
              if ( $is_update ) {
                  // redirect to homepage
                  redirect( site_url( 'category' ) );
              } else {
                  $data['form_is_error'] = TRUE;
                  $data['error_msg'] = array( "Unable to update category <strong>$post[name]</strong>" );
              }
          } 
          // for deleting
          elseif ( isset( $post['delete'] ) ) {
              $is_deleted = $category->delete( 'product_categories', array( 'id' => $cat_id ) );
              if ( $is_deleted ) {
                   // redirect to homepage
                  redirect( site_url( 'category' ) );
              } else {
                  $data['form_is_error'] = TRUE;
                  $data['error_msg'] = array( "Unable to delete category <strong>$post[name]</strong>" );
              }
          }
      }
      
  } else {
    $data['form_is_error'] = TRUE;
    $data['error_msg'] = array( "Bad Request!" );
  }
}


$data['title'] = 'Edit Category';
$data['css'] = 'dashboard';
$data['js'] = array( 'jquery.min', 'bootstrap.min' );

$data['user'] = $_SESSION[ VAR_PREFIX . 'user' ];

load_view( 'includes/header_view', $data );
load_view( 'includes/header_nav_view', $data );
load_view( 'edit_category_view', $data );
load_view( 'includes/footer_view', $data );