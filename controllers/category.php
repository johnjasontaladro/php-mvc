<?php
if ( !is_login() )
  redirect( site_url( 'login' ) );

require_once(ABSPATH . "models/category.php");
$category = new Category();
$data['all_cat'] = $category->get_categories();

$data['title'] = 'Category';
$data['css'] = 'dashboard';
$data['js'] = array( 'jquery.min', 'bootstrap.min' );

$data['user'] = $_SESSION[ VAR_PREFIX . 'user' ];

load_view( 'includes/header_view', $data );
load_view( 'includes/header_nav_view', $data );
load_view( 'category_view', $data );
load_view( 'includes/footer_view', $data );