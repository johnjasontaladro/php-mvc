<?php
function get_category_name( $id ) {
  require_once(ABSPATH . "models/category.php");
  $category = new Category();
  return $category->get_category_name( $id );
}

function get_products_by_cat( $cat_id ) {
  require_once(ABSPATH . "models/product.php");
  $product = new Product();
  return $product->get_products_by_cat( $cat_id );
}

function get_product( $prod_id) {
  require_once(ABSPATH . "models/product.php");
  $product = new Product();
  return $product->get_product( $prod_id );
}

function selected( $selected, $current, $echo = true ) {
  $html =  ( $selected == $current ) ? 'selected="selected"' : '';
  if ( $echo )
    echo $html;
  else
    return $html;
}