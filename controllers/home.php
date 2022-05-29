<?php

if ( !is_login() )
  redirect( site_url( 'login' ) );

require_once(ABSPATH . "models/category.php");
require_once(ABSPATH . "models/customer.php");
require_once(ABSPATH . "models/cart.php");
require_once(ABSPATH . "functions/helpers.php");
$customer = new Customer();
$category = new Category();
$cart = new Cart();

$data['customers'] = $customer->get_customers();
$data['all_cat'] = $category->get_categories();

$data['title'] = 'Home';
$data['css'] = array( 
  array( 'relative' => true, 'link' => 'assets/js/select2-3.5.1/select2' ), 
  array( 'relative' => true, 'link' => 'assets/js/select2-3.5.1/select2-bootstrap' ), 
  'dashboard' 
);
$data['js'] = array( 
  'jquery.min', 'bootstrap.min', 
  array( 'relative' => true, 'link' => 'assets/js/select2-3.5.1/select2' ),
  'jquery.number.min', 'global', 'app' 
);

$data['user'] = $_SESSION[ VAR_PREFIX . 'user' ];
$data['cart']['subtotal'] = $cart->compute_subtotal();
$data['cart']['total'] = $cart->compute_total();

load_view( 'includes/header_view', $data );
load_view( 'includes/header_nav_view', $data );
load_view( 'home_view', $data );
load_view( 'includes/footer_view', $data );