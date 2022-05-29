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