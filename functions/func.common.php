<?php
/**
 * Determine if user is login or not
 * @access public
 * @param none
 * @return boolean
 */
function is_login() {
  $user = VAR_PREFIX . 'user';
  return ( isset( $_SESSION[$user] ) ) ? TRUE : FALSE; 
}

/**
 * redirect function
 * @access public
 * @params
 * - $url - url to redirect
 * - $statusCode - http response code (defaults to 302)
 */
function redirect( $url, $statusCode = 302 ) {
   header( 'Location: ' . $url, true, $statusCode );
   die();
}

/**
 * Get current working directory
 *
 * @access public
 * @param none
 * @return string
 */
function curr_dir() {
  $curr_dir = explode("\\", ABSPATH);
  $curr_dir = "/" . $curr_dir[count($curr_dir)-1];
  return $curr_dir;
}

/**
 * Get base url of site
 *
 * @access public
 * @param $slug
 * @return string
 */
function base_url($slug = "") {
  $curr_dir = "/";
  if ($_SERVER['HTTP_HOST'] == 'localhost') :
    $curr_dir = curr_dir();
  endif;
  
  return sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['HTTP_HOST'],
    $curr_dir
  );
}

function site_url($slug = "") {
  return base_url() . "index.php/" . $slug;
}

/**
 * Get uri string from url
 *
 * @access public
 * @param none
 * @return string
 */
function uri_string() {  
  $uri = "";
  if ($_SERVER["REQUEST_URI"] == curr_dir() || $_SERVER["SCRIPT_NAME"] == $_SERVER["REQUEST_URI"]) :
    $uri = "";
  else :
    $uri = explode($_SERVER["SCRIPT_NAME"] , $_SERVER["REQUEST_URI"]);
    $uri = $uri[1];
  endif;
  
  return $uri;
}

/**
 * Gets slug from url
 *
 * @access public
 * @param none
 * @return string
 */
function slug() {
  $uri = uri_string();
  
  if ( empty($uri) || $uri[0] != "/")
    return "";
  
  $uri = substr($uri, 1);
  
  $has_param = explode("?", $uri);
  
  if (count($has_param) > 1)
    $slug = $has_param[0];
  else
    $slug = $uri;
  
  
  return trim($slug, "/");
}

function load_view( $view, $data = null ) {
  require_once(ABSPATH . "views/$view.php");
}

function _e( $string ) {
  echo sprintf("%s", $string);
}

function script( $script_name, $relative_path = false ) {
  if ( $relative_path ) : 
    return "<script src='" . base_url() . "$script_name.js' type='text/javascript'></script>";
  else :
    return "<script src='" . base_url() . "assets/js/$script_name.js' type='text/javascript'></script>";
  endif;
}

function style( $style_name, $relative_path = false ) {
  if ( $relative_path ) :
    return "<link href='" . base_url() . "$style_name.css' rel='stylesheet'>";
  else : 
    return "<link href='" . base_url() . "assets/css/$style_name.css' rel='stylesheet'>";
  endif;  
}

function script_enqueue( $scripts ) {
  $html = "";
  
  if ( isset( $scripts ) ) :
    if ( is_array( $scripts ) ) :
      foreach( $scripts as $js ) :
        if ( is_array( $js ) && $js['relative'] )
          $html .= script( $js['link'], true ) . PHP_EOL;
        else
          $html .= script( $js ) . PHP_EOL;
      endforeach;
    else :
      $html .= script( $scripts );
    endif;
  endif;
  
  return $html;
}

function style_enqueue( $styles ) {
  $html = "";
  
  if ( isset( $styles ) ) :
    if ( is_array( $styles ) ) :
      foreach( $styles as $css ) :
        if ( is_array( $css ) && $css['relative'] )
          $html .= style( $css['link'], true ) . PHP_EOL;
        else
          $html .= style( $css ) . PHP_EOL;
      endforeach;
    else :
      $html .= style( $styles );
    endif;
  endif;
  
  return $html;
}

function generate_token() {
  if(session_id() == '') {
    session_start();
  }
  $token = md5( uniqid( rand(), true ) ); //you can use any encryption
  $_SESSION['token'] = $token; //store it as session variable
}

function pr( $args ) {
  print_r("<pre>");
  if ( is_array( $args) )
    var_dump( $args );
  else
    print_r( $args );
  print_r("</pre>");
}