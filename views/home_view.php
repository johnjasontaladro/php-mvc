<div class="container-fluid">
  <div class="row">
    <?php load_view( 'includes/sidebar_view' ); ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-pushpin"></span> <?php _e( 'Sales Register' ); ?></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-8">        
              <form class="form-inline search-item" role="form">
                <div class="form-group">
                  <div class="input-group">                
                    <select class="form-control populate placeholder" id="search-products" placeholder="Start Typing Item Name">
                      <option></option>
                      <?php if ( isset( $data['all_cat'] ) && is_array( $data['all_cat'] ) ) : ?>
                      <?php foreach( $data['all_cat'] as $cat ) : ?>
                      <optgroup label="<?php echo $cat['category_name']; ?>">
                        <?php $products = get_products_by_cat( $cat['id'] ); ?>
                        <?php if ( is_array( $products ) ) : ?>
                          <?php foreach( $products as $product ) : ?>
                          <option value="<?php echo $product['id']; ?>"><?php echo $product['product_name']; ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </optgroup>
                      <?php endforeach; ?>
                      <?php endif; ?>
                    </select>                 
                  </div>
                  <button type="button" class="btn btn-primary" id="add-item-to-cart"><span class="glyphicon glyphicon-plus"></span> Add New Item</button>
                </div>              
              </form>
              
              <div class="clearfix">&nbsp;</div>
              
              <div class="table-responsive table-cart-wrapper">
                <table class="table table-striped table-cart">
                  <thead class="primary">
                    <tr>
                      <th>Qty</th>
                      <th>Product Name</th>
                      <th class="text-right">Price</th>
                      <th class="text-right">Total</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody id="item-list">                  
                    <?php if ( isset( $_SESSION['cart'] ) && is_array( $_SESSION['cart'] ) ) : ?>
                    <?php foreach( $_SESSION['cart'] as $key => $item ) : ?>
                    <?php $prod_item = get_product( $item['prod_id'] ); ?>
                    <tr>
                      <td><input type="text" class="text-right qty number" data-prod-id="<?php echo $item['prod_id']; ?>" value="<?php echo $item['qty']; ?>"></td>
                      <td><?php echo $prod_item['product_name']; ?></td>
                      <td class="text-right">Php <?php echo number_format( $prod_item['selling_price'], 2 ); ?></td>
                      <td class="text-right">Php <?php echo number_format( ( $item['qty'] * $prod_item['selling_price'] ), 2 ); ?></td>
                      <td>
                        <a href="javascript:void(0);" class="increase-item" data-prod-id="<?php echo $item['prod_id']; ?>">
                          <span title="increase item" alt="increase item" class="glyphicon glyphicon-plus-sign"></span>
                        </a>
                        <a href="javascript:void(0);" class="decrease-item" data-prod-id="<?php echo $item['prod_id']; ?>">
                          <span title="decrease item" alt="decrease item" class="glyphicon glyphicon-minus-sign"></span>
                        </a>
                        <a href="javascript:void(0);" class="remove-item" data-cart-key="<?php echo $key;?>">
                          <span title="remove item" alt="remove item" class="glyphicon glyphicon-remove-sign"></span>
                        </a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
              
            </div>
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-6">
                  <button class="btn btn-warning btn-block" disabled="disabled">Suspend Sale</button>
                </div>
                <div class="col-sm-6">
                  <button class="btn btn-danger btn-block" id="cancel-sale" data-loading-text="Cancelling..." data-complete-text="Sale Cancelled!">Cancel Sale <span class="glyphicon glyphicon-remove"></span></button>
                </div>
              </div>
              <div class="clearfix">&nbsp;</div>
              <div class="well well-sm">
                <h5 class="text-center"><strong>Select a Customer (Optional)</strong></h5>
                <form class="form-ajax" role="form">
                  <div class="form-group">
                    <select class="form-control" id="customer" placeholder="Start Typing Name...">
                      <option></option>
                      <?php if ( isset( $data['customers'] ) && is_array( $data['customers'] ) ) : ?>
                      <?php foreach( $data['customers'] as $customer ) : ?>
                      <option value="<?php echo $customer['id']; ?>"><?php echo ucwords( $customer['firstname'] . ' ' . $customer['lastname'] ); ?></option>
                      <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-3">
                        <p class="form-control-static text-center"><strong>or</strong> </p>
                      </div>
                      <div class="col-sm-9">
                        <a class="btn btn-primary btn-block" id="new-customer" href="<?php echo site_url( "edit-customer?action=add" ); ?>">
                          New Customer <span class="glyphicon glyphicon-plus"></span>
                        </a>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-8">
              <div class="well well-sm">
                <table class="table table-bordered table-total">
                  <tbody>
                    <tr>
                      <td><strong>Sub Total</strong></td>
                      <td class="text-right"><strong>Php <span id="sub-total"><?php echo number_format( $data['cart']['subtotal'], 2 ) ?></span></strong></td>
                    </tr>
                    <tr>
                      <td><strong>Tax</strong></td>
                      <td class="text-right"><strong>0.00</strong></td>
                    </tr>
                    <tr class="warning">
                      <td><strong>TOTAL</strong></td>
                      <td class="text-right">
                        <strong>Php <span id="total-amount"><?php echo number_format( $data['cart']['total'], 2 ) ?></span></strong>
                        <input type="hidden" id="total-amount-value" value="<?php echo $data['cart']['total'];?>">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <form class="form-horizontal form-ajax" role="form">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Payment Type</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="payment-type">
                        <option value="cash">Cash</option>
                        <option value="credit">Credit</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">&nbsp;&nbsp;Amount</label>
                    <div class="col-sm-9">
                      <div class="input-group">
                        <span class="input-group-addon">Php</span>
                        <input type="text" class="form-control text-right" id="amount-pay">
                        <span class="input-group-btn">
                          <button class="btn btn-success" id="amount-pay-btn" type="button">PAY</button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="alert alert-success clearfix hidden" id="change-label" role="alert">
                    <div class="pull-left">
                      <strong>Change:</strong>
                    </div>
                    <div class="pull-right">
                      <span class="h3">Php <span id="change-amount">0.00</span></span>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="complete-sale">
                <textarea class="form-control" id="order-comment" rows="8" placeholder="Add Comment..."></textarea>
                <div class="clearfix">&nbsp;</div>
                <button class="btn btn-success btn-block" id="save-transaction" type="button" disabled="disabled" data-loading-text="Saving..." data-complete-text="Transaction saved!">Complete Sale</button>
              </div>
            </div>
          </div>
          
        </div>
      </div>      
    </div>
  </div>
</div>