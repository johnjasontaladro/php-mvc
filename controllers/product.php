<?php
if ( !is_login() )
  redirect( site_url( 'login' ) );

require_once(ABSPATH . "functions/helpers.php");
require_once(ABSPATH . "models/product.php");
$product = new Product();
$data['all_prod'] = $product->get_products();

$data['title'] = 'Products';
$data['css'] = 'dashboard';
$data['js'] = array( 'jquery.min', 'bootstrap.min' );

$data['user'] = $_SESSION[ VAR_PREFIX . 'user' ];

load_view( 'includes/header_view', $data );
load_view( 'includes/header_nav_view', $data );
load_view( 'product_view', $data );
load_view( 'includes/footer_view', $data );