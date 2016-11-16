<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error) { ?>
  <div class="warning"><?php echo $error; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
	    <caption><h3 style="text-align: left"><?php echo $text_base_setup; ?></h3></caption>
	    <tr>
		<td><sup style="color: red;font-size: 120%">*</sup><?php echo $text_profile_name; ?>:</td>
		<td><input type="text" name="profile_name" value="<?php echo $input_profile_name; ?>" size="40" /><?php if ($error_profile_name): ?><br /><span class="error"><?php echo $error_profile_name; ?></span><?php endif; ?></td>
	    </tr>
          <tr>
            <td><?php echo $text_currency_price; ?>:</td>
            <td>
		<select name="currency">
		    <?php foreach ($input_currencies as $currency): ?>
		    <option value="<?php echo $currency['currency_id']; ?>"<?php if ($currency['currency_id'] == $input_currency): ?> selected="selected"<?php endif; ?>><?php echo $currency['title']; ?></option>
		    <?php endforeach; ?>
		</select>
		<span class="tooltip"><img src="view/image/price_import/help.png" alt="помощь" style="vertical-align: middle" /><span><?php echo $help_currency; ?></span></span>
	    </td>
          </tr>
	  <tr>
	      <td><?php echo $text_start_row; ?>:</td>
	      <td><input type="text" name="start_row" value="<?php echo $input_start_row; ?>" size="4" /><?php if ($error_start_row): ?><br /><span class="error"><?php echo $error_start_row; ?></span><?php endif; ?></td>
	  </tr>
	  <tr>
	      <td><?php echo $text_end_row; ?>:</td>
	      <td><input type="text" name="end_row" value="<?php echo $input_end_row; ?>" size="4" /><?php if ($error_end_row): ?><br /><span class="error"><?php echo $error_end_row; ?></span><?php endif; ?></td>
	  </tr>
	  <tr>
	      <td><?php echo $text_discount; ?>:</td>
	      <td><input type="text" name="discount" value="<?php echo $input_discount; ?>" size="3" /> <span class="tooltip"><img src="view/image/price_import/help.png" alt="помощь" style="vertical-align: middle" /><span><?php echo $help_discount; ?></span></span><?php if ($error_discount): ?><br /><span class="error"><?php echo $error_discount; ?></span><?php endif; ?></td>
	  </tr>
	  <tr>
	      <td><?php echo $text_margin; ?>:</td>
	      <td><input type="text" name="margin" value="<?php echo $input_margin; ?>" size="3" /><?php if ($error_margin): ?><br /><span class="error"><?php echo $error_margin; ?></span><?php endif; ?></td>
	  </tr>
	  <tr>
	      <td><?php echo $text_stores; ?>:</td>
	      <td>
              <?php foreach ($stores as $store): ?>
              <label>
                  <input style="vertical-align: middle" type="checkbox" name="product_store[]" value="<?php echo $store['store_id']; ?>"<?php if ($store['store_id'] === 0 OR in_array($store['store_id'], $product_store)): ?> checked="checked"<?php endif; ?> />
                  <?php echo $store['name']; ?>
              </label>
              <br />
              <?php endforeach; ?>
	      </td>
	  </tr>
        </table>
	  <table class="form setup_cell">
	      <thead>
		  <tr>
		      <th></th>
		      <th style="width: 15%"><?php echo $text_setup_cell_th1; ?>:</th>
		      <th></th>
		      <th><?php echo $text_setup_cell_th3; ?></th>
		      <th><?php echo $text_setup_cell_th4; ?> <span class="tooltip"><img src="view/image/price_import/help.png" alt="помощь" style="vertical-align: middle" /><span style="font-weight: normal;text-align: left"><?php echo $help_setup_cell_th4; ?></span></span></th>
		  </tr>
	      </thead>
	      <tbody>
		<tr>
		    <td><sup style="color: red;font-size: 120%">*</sup><?php echo $text_article; ?>: <span class="tooltip"><img src="view/image/price_import/help.png" alt="помощь" style="vertical-align: middle" /><span><?php echo $help_article; ?></span></span></td>
		    <td><input type="text" name="sku" value="<?php echo $input_sku; ?>" size="3" /><?php if ($error_sku): ?><br /><span class="error"><?php echo $error_sku; ?></span><?php endif; ?></td>
		    <td style="width: 10%"></td>
		    <td>-</td>
		    <td><input type="text" name="sku_replace" value="<?php echo $input_sku_replace; ?>" /></td>
		</tr>
		<tr>
		    <td><sup style="color: red;font-size: 120%">*</sup><?php echo $text_description; ?>:</td>
		    <td><input type="text" name="description" value="<?php echo $input_description; ?>" size="3" /><?php if ($error_description): ?><br /><span class="error"><?php echo $error_description; ?></span><?php endif; ?></td>
		    <td style="color: gray"><?php echo $text_or; ?></td>
		    <td><input type="text" name="description_default" value="<?php echo $input_description_default; ?>" /></td>
		    <td><input type="text" name="description_replace" value="<?php echo $input_description_replace; ?>" /></td>
		</tr>
		<tr>
		    <td><sup style="color: red;font-size: 120%">*</sup><?php echo $text_quantity; ?>:</td>
		    <td><input type="text" name="quantity" value="<?php echo $input_quantity; ?>" size="3" /><?php if ($error_quantity): ?><br /><span class="error"><?php echo $error_quantity; ?></span><?php endif; ?></td>
		    <td style="color: gray"><?php echo $text_or; ?></td>
		    <td><input type="text" name="quantity_default" value="<?php echo $input_quantity_default; ?>" size="4" /></td>
		    <td><input type="text" name="quantity_replace" value="<?php echo $input_quantity_replace; ?>" /></td>
		</tr>
		<tr>
		    <td><sup style="color: red;font-size: 120%">*</sup><?php echo $text_manufacturer; ?>: <span class="tooltip"><img src="view/image/attention.png" alt="помощь" style="vertical-align: middle" /><span><?php echo $help_manufacturer; ?></span></span></td>
		    <td><input type="text" name="manufacture" value="<?php echo $input_manufacture; ?>" size="3" /><?php if ($error_manufacture): ?><br /><span class="error"><?php echo $error_manufacture; ?></span><?php endif; ?></td>
		    <td style="color: gray"><?php echo $text_or; ?></td>
		    <td>
			<select name="manufacture_default">
			    <option value=""></option>
			    <?php foreach ($input_manufacturers as $manufacturer): ?>
			    <option value="<?php echo $manufacturer['manufacturer_id']; ?>"<?php if ($manufacturer['manufacturer_id'] == $input_manufacture_default): ?> selected="selected"<?php endif; ?>><?php echo $manufacturer['name']; ?></option>
			    <?php endforeach; ?>
			</select> <span class="tooltip"><img src="view/image/price_import/help.png" alt="помощь" style="vertical-align: middle" /><span style="text-align: left"><?php echo $help_manufacturers; ?></span></span>
		    </td>
		    <td><input type="text" name="manufacture_replace" value="<?php echo $input_manufacture_replace; ?>" /></td>
		</tr>
		<tr>
		    <td><sup style="color: red;font-size: 120%">*</sup><?php echo $text_price; ?>:</td>
		    <td><input type="text" name="price" value="<?php echo $input_price; ?>" size="3" /><?php if ($error_price): ?><br /><span class="error"><?php echo $error_price; ?></span><?php endif; ?></td>
		    <td></td>
		    <td>-</td>
		    <td><input type="text" name="price_replace" value="<?php echo $input_price_replace; ?>" /></td>
		</tr>
	      </tbody>
	  </table>
	  <table class="form" style="width: 60%">
	    <caption><h3 style="text-align: left"><?php echo $text_advance_setup; ?></h3></caption>
	      <tr>
		  <td><?php echo $text_cell_caching; ?>: <span class="tooltip"><img src="view/image/price_import/help.png" alt="помощь" style="vertical-align: middle" /><span><?php echo $help_cell_caching; ?></span></span></td>
		  <td>
		    <select name="cache_method">
			<?php foreach ($input_cache_methods as $name=>$value): ?>
			<option value="<?php echo $value; ?>"<?php if ($value == $input_cache_method): ?> selected="selected"<?php endif; ?>><?php echo $name; ?></option>
			<?php endforeach; ?>
		    </select>
		  </td>
		  <td><?php echo $text_know_more; ?> <img src="view/image/price_import/github.png" alt="github" style="vertical-align: middle" /><a href="https://github.com/PHPOffice/PHPExcel/blob/d6ec415676989782fd3b49b9e25509b9e852418e/Documentation/markdown/Overview/04-Configuration-Settings.md#phpexcel-developer-documentation" onclick="return !window.open(this.href)">PHPExcel Documentation :: Cell Caching</a></td>
	      </tr>
	  </table>
	  <!--fieldset style="width: 35%">
	      <legend>APC</legend>
	  <table class="form">
	      <tr>
		  <td><?php echo $text_timeout_cache; ?></td>
		  <td><input type="text" name="apc_cache_time" value="<?php echo $input_apc_cache_time; ?>" /></td>
	      </tr>
	  </table>
	  </fieldset>
	  <fieldset style="width: 35%">
	      <legend>Memcache</legend>
	  <table class="form">
	      <tr>
		  <td><?php echo $text_server; ?></td>
		  <td><input type="text" name="memcache_server" value="<?php echo $input_memcache_server; ?>" /></td>
	      </tr>
	      <tr>
		  <td><?php echo $text_port; ?></td>
		  <td><input type="text" name="memcache_port" value="<?php echo $input_memcache_port; ?>" /></td>
	      </tr>
	      <tr>
		  <td><?php echo $text_timeout_cache; ?></td>
		  <td><input type="text" name="memcache_cache_time" value="<?php echo $input_memcache_cache_time; ?>" /></td>
	      </tr>
	  </table>
	  </fieldset-->
	  <p><sup style="color: red;font-size: 120%">*</sup><?php echo $text_required; ?></p>
	  <p>&nbsp;</p>
	  <div>
	      <a onclick="$('#form').submit();" class="button"><?php echo $input_save; ?></a>&nbsp;&nbsp;
	    <a href="<?php echo $not_save_profile; ?>" class="button"><?php echo $input_cancel; ?></a>
	  </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
//<![CDATA[
function doBlock(which) {
  cta=document.getElementById("cache_to_apc");
  ctm=document.getElementById("cache_to_memcache");

    if (which == "cache_to_apc")
    {
	cta.style.display="table";
    }
    else
    {
	cta.style.display="none";
    }

    if (which == "cache_to_memcache")
    {
	ctm.style.display="table";
    }
    else
    {
	ctm.style.display="none";
    }
}
//]]>
</script>
<?php echo $footer; ?>