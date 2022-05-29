<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
    <?php $slug = slug(); ?>
    <li<?php echo ( '' == $slug ) ? ' class="active"' : ''; ?>><a href="<?php echo site_url(); ?>">Sales Register</a></li>
    <li<?php echo ( 'reports' == $slug ) ? ' class="active"' : ''; ?>><a href="<?php echo site_url( 'reports' ); ?>">Reports</a></li>
    <li<?php echo ( 'analytics' == $slug ) ? ' class="active"' : ''; ?>><a href="#">Analytics</a></li>
    <li<?php echo ( 'export' == $slug ) ? ' class="active"' : ''; ?>><a href="#">Export</a></li>
  </ul>
  <ul class="nav nav-sidebar">
    <li<?php echo ( 'product' == $slug ) ? ' class="active"' : ''; ?>><a href="<?php echo site_url( 'product' ); ?>"><span class="glyphicon glyphicon-th-large"></span> Products</a></li>
    <li<?php echo ( 'edit-product' == $slug ) ? ' class="active"' : ''; ?>><a href="<?php echo site_url( 'edit-product?action=add' ); ?>"><span class="glyphicon glyphicon-chevron-right"></span> Add New</a></li>
    <li<?php echo ( 'category' == $slug ) ? ' class="active"' : ''; ?>><a href="<?php echo site_url( 'category' ); ?>"><span class="glyphicon glyphicon-list-alt"></span> Category</a></li>
    <li<?php echo ( 'edit-category' == $slug ) ? ' class="active"' : ''; ?>><a href="<?php echo site_url( 'edit-category?action=add' ); ?>"><span class="glyphicon glyphicon-chevron-right"></span> Add New</a></li>
    <li<?php echo ( 'customer' == $slug ) ? ' class="active"' : ''; ?>><a href="<?php echo site_url( 'customer' ); ?>"><span class="glyphicon glyphicon-user"></span> Customer</a></li>
    <li<?php echo ( 'edit-customer' == $slug ) ? ' class="active"' : ''; ?>><a href="<?php echo site_url( 'edit-customer?action=add' ); ?>"><span class="glyphicon glyphicon-chevron-right"></span> Add New</a></li>
  </ul>
</div>