<?php
if ( !is_login() )
  redirect( site_url( 'login' ) );
  
require_once(ABSPATH . "models/customer.php");
$customer = new Customer();

$data['customer'] = array();

$error_msg = array();
$err_count = 0;
    
// get customer data for edit customer
if ( "edit" === $_GET['action'] ) {
    $cust_id = (int) $_GET['id'];
    $data['customer'] = $customer->get_customer( $cust_id );
}

// Check if form is submitted
if ( $_POST && !empty( $_POST ) ) {
    
    if ( $_POST['token'] === $_SESSION['token'] ) {
      
      $post = array_map( 'trim', $_POST );
      $cust_data = array(
        'firstname' => ( $post['firstname'] == '' ) ? null : $post['firstname'],
        'lastname' => ( $post['lastname'] == '' ) ? null : $post['lastname'],
        'address' => ( $post['address'] == '' ) ? null : $post['address'],
        'contact_num' => ( $post['contact_num'] == '' ) ? null : $post['contact_num']
      );
      
      $cust_req_field_label = array( 'firstname' => 'First Name' );
      foreach( $cust_req_field_label as $key => $required_field ) {
        if ( $cust_data[$key] == '' ) {
          $error_msg[] = $required_field . " is required.<br />";
          $err_count++;
        }
      }
      
      if ( $err_count === 0 ) {
      
        // for adding new chix
        if ( "add" === $_GET['action'] ) {
            $last_id = $customer->insert( 'customers', $cust_data ); // mysqli inserted id
            
            /**
             * Check if id is generated (should be greater than zero), meaning our mysql insert is successful
             */
            if ( $last_id !== NULL && is_numeric($last_id) && $last_id > 0) {
                // redirect to homepage
                redirect( site_url( 'customer' ) );
            } else {
                $data['form_is_error'] = TRUE;
                $data['error_msg'] = array( "Unable to insert new customer" );
            }
        } 
        // for editing existing chix
        elseif ( "edit" === $_GET['action'] ) {
            
            // for saving
            if ( isset( $post['save'] ) ) {
                $is_update = $customer->update( 'customers', $cust_data, array( 'id' => $cust_id ) );
                if ( $is_update ) {
                    // redirect to homepage
                    redirect( site_url( 'customer' ) );
                } else {
                    $data['form_is_error'] = TRUE;
                    $data['error_msg'] = array( "Unable to update customer <strong>$post[firstname]</strong>" );
                }
            } 
            // for deleting
            elseif ( isset( $post['delete'] ) ) {
                $is_deleted = $customer->delete( 'customers', array( 'id' => $cust_id ) );
                if ( $is_deleted ) {
                     // redirect to homepage
                    redirect( site_url( 'customer' ) );
                } else {
                    $data['form_is_error'] = TRUE;
                    $data['error_msg'] = array( "Unable to delete product <strong>$post[firstname]</strong>" );
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


$data['title'] = 'Edit Customer';
$data['css'] = 'dashboard';
$data['js'] = array( 'jquery.min', 'bootstrap.min' );

$data['user'] = $_SESSION[ VAR_PREFIX . 'user' ];

load_view( 'includes/header_view', $data );
load_view( 'includes/header_nav_view', $data );
load_view( 'edit_customer_view', $data );
load_view( 'includes/footer_view', $data );