<?php
/** Start session **/
if(session_id() == '') {
  session_start();
}

/** Define ABSPATH as this file's directory */
define( 'ABSPATH', dirname(__FILE__) . '/' );

/** The config file resides in ABSPATH **/
require_once( ABSPATH . 'config.php' );


require_once( ABSPATH . 'settings/class.db.php' );  /** Loads the db class **/
require_once( ABSPATH . 'functions/func.common.php' ); /** Loads the common function **/

if ( !$_POST ) {
  generate_token();
}

$controller = slug();

if ( empty($controller) ) {
  if (isset($_SESSION['a_id']))
    require_once(ABSPATH . "controllers/admin/home.php");
  else
    require_once(ABSPATH . "controllers/home.php");
} else {
  if (file_exists(ABSPATH . "controllers/$controller.php")) {
    require_once(ABSPATH . "controllers/$controller.php");
  } else {
    // if ($controller == "admin")
      // require_once(ABSPATH . "controllers/admin/home.php");
    // else
      die("Invalid URL");
  }
}