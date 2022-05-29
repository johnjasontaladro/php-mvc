<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo site_url(); ?>"><?php _e( 'Lina Store' ); ?></a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Signed in as <u><?php echo $data['user']['fname']; ?></u></a></li>
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Settings</a></li>
        <li><a href="#">Help</a></li>
        <li><a href="<?php echo site_url( 'logout' ); ?>">Logout</a></li>
      </ul>
    </div>
  </div>
</div>