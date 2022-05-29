<?php
if ( !is_login() )
  redirect( site_url( 'login' ) );

require_once(ABSPATH . "models/customer.php");
$customer = new Customer();
$data['customers'] = $customer->get_customers();

$data['title'] = 'Customer';
$data['css'] = 'dashboard';
$data['js'] = array( 'jquery.min', 'bootstrap.min' );

$data['user'] = $_SESSION[ VAR_PREFIX . 'user' ];

load_view( 'includes/header_view', $data );
load_view( 'includes/header_nav_view', $data );
load_view( 'customer_view', $data );
load_view( 'includes/footer_view', $data );