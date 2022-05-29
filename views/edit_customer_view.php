<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12 main">
      <h1 class="page-header"><?php echo ( "edit" === $_GET['action'] ) ? "Edit " : "Add New "; ?>Customer</h1>
      
      <?php if ( isset( $data['form_is_error'] ) && isset( $data['error_msg'] ) ) : ?>
      <div class="alert alert-danger" role="alert">
        <strong>Error!</strong>
        <ul>
          <?php foreach( $data['error_msg'] as $error ) : ?>
          <li><?php echo $error; ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>
      <div class="well">
        <form method="post" class="form-horizontal" role="form">
            <input type="hidden" name="action" value="<?php echo ( "edit" === $_GET['action'] ) ? "edit" : "add"; ?>">
            
            <div class="form-group">
                <label class="col-sm-2 control-label">First Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="firstname" value="<?php echo ( isset( $data['customer']['firstname'] ) ) ? $data['customer']['firstname'] : ''; ?>">
                </div>
                <label class="col-sm-2 control-label">Last Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="lastname" value="<?php echo ( isset( $data['customer']['lastname'] ) ) ? $data['customer']['lastname'] : ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label">Address</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="address" value="<?php echo ( isset( $data['customer']['address'] ) ) ? $data['customer']['address'] : ''; ?>">
                </div>
                <label class="col-sm-2 control-label">Contact #</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="contact_num" value="<?php echo ( isset( $data['customer']['contact_num'] ) ) ? $data['customer']['contact_num'] : ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <a class="btn btn-default" href="<?php echo site_url( 'customer' ); ?>">Cancel</a>
                    <button class="btn btn-success" type="submit" name="save">Save</button>
                    <?php if ( "edit" === $_GET['action'] ) : ?>
                    <button class="btn btn-danger" type="submit" name="delete" onClick="javascript:if(confirm('Are you sure?')){ return true;} else { return false;};">Delete</button>
                    <?php endif; ?>
                </div>
            </div>

        </form>
      </div>
      
    </div>
  </div>
</div>