<?php
$data['title'] = 'Login';
$data['css'] = 'signin';

if ($_POST && isset($_POST['action']) && $_POST['action'] == 'login') {

  if ( $_POST['token'] === $_SESSION['token'] ) {
  
    require_once(ABSPATH . "models/user.php");
    $user = new User();
    $post = array(
      'username' => $_POST['username'],
      'password' => md5( $_POST['password'] )
    );
    
    $is_user_exist = $user->is_user_exist( $_POST['username'] );
    
    if ( $is_user_exist ) {
      $is_login = $user->login( $post['username'], $post['password'] );
      
      if ( $is_login ) {
        $user_data = $user->user_data($is_user_exist);
        
        $prefix = VAR_PREFIX . 'user';
        $_SESSION[ $prefix ] = array(
          'u_id' => $is_user_exist,
          'fname' => $user_data['fname'],
          'lname' => $user_data['lname']
        );
        
        if ( $_GET && isset($_GET['redirect']) ) {
          redirect( $_GET['redirect'] );
        } else {
          redirect( site_url() );
        }
      } else {
        $data['error'] = "Username / Password not match.";
      }
    } else {
      $data['error'] = "Username not found.";
    
    }
    
    session_destroy();
    generate_token();
    
  } else {
    $data['error'] = "Bad request!";
  }
  
}

load_view( 'includes/header_view', $data );
load_view( 'login_view', $data );
load_view( 'includes/footer_view', $data );