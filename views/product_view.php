<div class="container-fluid">
  <div class="row">
    <?php load_view( 'includes/sidebar_view' ); ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h2 class="sub-header"><?php _e( 'Product List' ); ?> <a class="btn btn-primary" href="<?php 
        echo site_url( 'edit-product?action=add' ); ?>"><span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add New' ); ?></a></h2>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th><?php _e( 'ID' ); ?></th>
              <th><?php _e( 'Product Name' ); ?></th>
              <th><?php _e( 'Qty' ); ?></th>
              <th><?php _e( 'Reorder Level' ); ?></th>
              <th><?php _e( 'Category' ); ?></th>
              <th><?php _e( 'Unit Price' ); ?></th>
              <th><?php _e( 'Selling Price' ); ?></th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php if ( $data['all_prod'] && is_array( $data['all_prod'] ) ) : ?>
            <?php foreach( $data['all_prod'] as $prod ) : ?>
            <tr>
              <td><?php echo $prod['id']; ?></td>
              <td><?php echo $prod['product_name']; ?></td>
              <td><?php echo $prod['qty']; ?></td>
              <td><?php echo $prod['reorder_lvl']; ?></td>
              <td><?php echo get_category_name( $prod['cat_id'] ); ?></td>
              <td><?php echo $prod['unit_price']; ?></td>
              <td><?php echo $prod['selling_price']; ?></td>
              <td><a title="Edit Product" href="<?php echo site_url( 'edit-product?action=edit&id=' . $prod['id'] ); ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>