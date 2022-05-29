<div class="container-fluid">
  <div class="row">
    <?php load_view( 'includes/sidebar_view' ); ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h2 class="sub-header">Customer List <a class="btn btn-primary" href="<?php 
        echo site_url( 'edit-customer?action=add' ); ?>"><span class="glyphicon glyphicon-plus"></span> Add New</a></h2>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>Contact #</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php if ( $data['customers'] && is_array( $data['customers'] ) ) : ?>
            <?php foreach( $data['customers'] as $customer ) : ?>
            <tr>
              <td><?php echo $customer['id']; ?></td>
              <td><?php echo ucwords( $customer['firstname'] . ' ' . $customer['lastname'] ); ?></td>
              <td><?php echo ucwords( $customer['address'] ); ?></td>
              <td><?php echo $customer['contact_num']; ?></td>
              <td><a title="Edit Customer" href="<?php echo site_url( 'edit-customer?action=edit&id=' . $customer['id'] ); ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>