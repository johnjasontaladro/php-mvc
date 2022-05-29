<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $data['title']; ?></title>
    
    <!-- Bootstrap core CSS -->
    <?php echo style( 'bootstrap.min' ); ?>
    
    <?php if ( isset( $data['css'] ) ) : ?>
    <!-- Custom styles for this template -->
    <?php echo style_enqueue( $data['css'] ); ?>
    <?php endif; ?>
    
    <script type="text/javascript">
      /* <![CDATA[ */
      var APP = { "site_url" : "<?php echo site_url(); ?>", "ajax_url" : "<?php echo site_url( 'ajax' ); ?>", "session_token" : "<?php echo $_SESSION['token']; ?>" };      
      /* ]]> */
    </script>
    
  </head>

  <body>