<?php echo $header; 
$theme_options = $this->registry->get('theme_options');
$config = $this->registry->get('config'); 
include('catalog/view/theme/'.$config->get('config_template').'/template/new_elements/wrapper_top.tpl'); ?>

<?php if ($products) { ?>
<table class="table table-bordered">
  <thead>
    <tr>
      <td colspan="<?php echo count($products) + 1; ?>"><strong><?php echo $text_product; ?></strong></td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $text_name; ?></td>
      <?php foreach ($products as $product) { ?>
      <td><a href="<?php echo $products[$product['product_id']]['href']; ?>"><strong><?php echo $products[$product['product_id']]['name']; ?></strong></a></td>
      <?php } ?>
    </tr>
    <tr>
      <td><?php echo $text_image; ?></td>
      <?php foreach ($products as $product) { ?>
      <td class="text-center"><?php if ($products[$product['product_id']]['thumb']) { ?>
        <img src="<?php echo $products[$product['product_id']]['thumb']; ?>" alt="<?php echo $products[$product['product_id']]['name']; ?>" title="<?php echo $products[$product['product_id']]['name']; ?>" class="img-thumbnail" />
        <?php } ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td><?php echo $text_price; ?></td>
      <?php foreach ($products as $product) { ?>
      <td><?php if ($products[$product['product_id']]['price']) { ?>
        <?php if (!$products[$product['product_id']]['special']) { ?>
        <?php echo $products[$product['product_id']]['price']; ?>
        <?php } else { ?>
        <span class="price-old"><?php echo $products[$product['product_id']]['price']; ?> </span> <span class="price-new"> <?php echo $products[$product['product_id']]['special']; ?> </span>
        <?php } ?>
        <?php } ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td><?php echo $text_model; ?></td>
      <?php foreach ($products as $product) { ?>
      <td><?php echo $products[$product['product_id']]['model']; ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td><?php echo $text_manufacturer; ?></td>
      <?php foreach ($products as $product) { ?>
      <td><?php echo $products[$product['product_id']]['manufacturer']; ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td><?php echo $text_availability; ?></td>
      <?php foreach ($products as $product) { ?>
      <td><?php echo $products[$product['product_id']]['availability']; ?></td>
      <?php } ?>
    </tr>
    <?php if ($review_status) { ?>
    <tr>
      <td><?php echo $text_rating; ?></td>
      <?php foreach ($products as $product) { ?>
      <td class="rating"><div class="rating"><i class="fa fa-star<?php if($products[$product['product_id']]['rating'] >= 1) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($products[$product['product_id']]['rating'] >= 2) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($products[$product['product_id']]['rating'] >= 3) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($products[$product['product_id']]['rating'] >= 4) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($products[$product['product_id']]['rating'] >= 5) { echo ' active'; } ?>"></i></div>
        <?php echo $products[$product['product_id']]['reviews']; ?></td>
      <?php } ?>
    </tr>
    <?php } ?>
    <tr>
      <td><?php echo $text_summary; ?></td>
      <?php foreach ($products as $product) { ?>
      <td class="description"><?php echo $products[$product['product_id']]['description']; ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td><?php echo $text_weight; ?></td>
      <?php foreach ($products as $product) { ?>
      <td><?php echo $products[$product['product_id']]['weight']; ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td><?php echo $text_dimension; ?></td>
      <?php foreach ($products as $product) { ?>
      <td><?php echo $products[$product['product_id']]['length']; ?> x <?php echo $products[$product['product_id']]['width']; ?> x <?php echo $products[$product['product_id']]['height']; ?></td>
      <?php } ?>
    </tr>
  </tbody>
  <?php foreach ($attribute_groups as $attribute_group) { ?>
  <thead>
    <tr>
      <td colspan="<?php echo count($products) + 1; ?>"><strong><?php echo $attribute_group['name']; ?></strong></td>
    </tr>
  </thead>
  <?php foreach ($attribute_group['attribute'] as $key => $attribute) { ?>
  <tbody>
    <tr>
      <td><?php echo $attribute['name']; ?></td>
      <?php foreach ($products as $product) { ?>
      <?php if (isset($products[$product['product_id']]['attribute'][$key])) { ?>
      <td><?php echo $products[$product['product_id']]['attribute'][$key]; ?></td>
      <?php } else { ?>
      <td></td>
      <?php } ?>
      <?php } ?>
    </tr>
  </tbody>
  <?php } ?>
  <?php } ?>
  <tr>
    <td></td>
    <?php foreach ($products as $product) { ?>
    <td><input type="button" value="<?php echo $button_cart; ?>" class="btn btn-primary btn-block" onclick="cart.add('<?php echo $product['product_id']; ?>');" />
      <a href="<?php echo $product['remove']; ?>" class="btn btn-danger btn-block"><?php echo $button_remove; ?></a></td>
    <?php } ?>
  </tr>
</table>
<?php } else { ?>
<p><?php echo $text_empty; ?></p>
<div class="buttons">
  <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-default"><?php echo $button_continue; ?></a></div>
</div>
<?php } ?>
  
<?php include('catalog/view/theme/'.$config->get('config_template').'/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>