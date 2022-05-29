    <div class="container">

      <form class="form-signin" role="form" method="POST">
        <h2 class="form-signin-heading"><?php _e( 'Please sign in' ); ?></h2>
        <?php if ( isset( $data['error'] ) ) : ?>
          <div class="alert alert-danger">
            <p><?php echo $data['error']; ?></p>
          </div>
        <?php endif; ?> 
        <input type="text" class="form-control" placeholder="Username" name="username" required autofocus>
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <input type="hidden" name="action" value="login">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
        <button class="btn btn-lg btn-primary btn-block" type="submit"><?php _e( 'Sign in' ); ?></button>
      </form>

    </div> <!-- /container -->