<div class="container-fluid">
  <div class="row">
    <?php load_view( 'includes/sidebar_view' ); ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h2 class="sub-header">Category List <a class="btn btn-primary" href="<?php 
        echo site_url( 'edit-category?action=add' ); ?>"><span class="glyphicon glyphicon-plus"></span> Add New</a></h2>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Category Name</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php if ( $data['all_cat'] && is_array( $data['all_cat'] ) ) : ?>
            <?php foreach( $data['all_cat'] as $cat ) : ?>
            <tr>
              <td><?php echo $cat['id']; ?></td>
              <td><?php echo $cat['category_name']; ?></td>
              <td><a title="Edit Category" href="<?php echo site_url( 'edit-category?action=edit&id=' . $cat['id'] ); ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>