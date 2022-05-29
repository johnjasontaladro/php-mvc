<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12 main">
      <h1 class="page-header"><?php echo ( "edit" === $_GET['action'] ) ? "Edit " : "Add New "; ?>Product</h1>
      
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
                <label class="col-sm-2 control-label">Category</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <select class="form-control" name="cat_id">
                      <option>-- SELECT CATEGORY--</option>
                    <?php if ( isset( $data['categories'] ) && is_array( $data['categories'] ) ) : ?>
                      <?php foreach( $data['categories'] as $cat ) : ?>
                      <option value="<?php echo $cat['id']; ?>" <?php echo ( isset( $data['product']['cat_id'] ) && $data['product']['cat_id'] === $cat['id'] ) ? 'selected' : ''; ?>><?php echo $cat['category_name']; ?></option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                    </select>
                    <span class="input-group-btn">
                      <a class="btn btn-primary" href="<?php echo site_url( 'edit-category?action=add' ); ?>"><span class="glyphicon glyphicon-plus"></span> Add New</a>
                    </span>
                  </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="product_name" value="<?php echo ( isset( $data['product']['product_name'] ) ) ? $data['product']['product_name'] : ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Quantity</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control text-right number" name="qty" value="<?php echo ( isset( $data['product']['qty'] ) ) ? $data['product']['qty'] : ''; ?>">
                </div>
                <label class="col-sm-2 control-label">Reorder Level</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control text-right number" name="reorder_lvl" value="<?php echo ( isset( $data['product']['reorder_lvl'] ) ) ? $data['product']['reorder_lvl'] : ''; ?>">
                </div>
            </div>
            
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Unit Price</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control text-right decimal" name="unit_price" value="<?php echo ( isset( $data['product']['unit_price'] ) ) ? $data['product']['unit_price'] : ''; ?>">
                </div>
                <label class="col-sm-2 control-label">Selling Price</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control text-right decimal" name="selling_price" value="<?php echo ( isset( $data['product']['selling_price'] ) ) ? $data['product']['selling_price'] : ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                  <a class="btn btn-default" href="<?php echo site_url( 'product' ); ?>">Cancel</a>
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