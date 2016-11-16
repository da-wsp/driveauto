<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error) { ?>
  <div class="warning"><?php echo $error; ?></div>
  <?php } ?>
  <?php if ($warning) { ?>
  <div class="attention"><?php echo $warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	  <div>
	      <a onclick="supex_dumper();" class="button"><img src="view/image/price_import/sypex_logo.png" alt="sypex dumper" height="14" width="47" style="vertical-align: middle;" />&nbsp;&nbsp;<?php echo $input_make_backup; ?></a>
	  </div>
	  <br />
	  <div>
	      <!--label>Тип операции:&nbsp;
	      <select name="operation">
		  <option value="add_replace">Добавить и заменить</option>
		  <option value="update_add">Обновить и добавить</option>
	      </select>
	      </label>&nbsp;-->
	      <a onclick="$('#form').submit();" class="button"><?php echo $input_save; ?></a> <span class="tooltip"><img src="view/image/attention.png" alt="помощь" style="vertical-align: middle" /><span><?php echo $help_save; ?></span></span>
	  </div>
	  <br />
	  <div>
	      <a href="<?php echo $cancel; ?>" class="button"><?php echo $input_cancel_import; ?></a>
	  </div>
	  <br />
	  <table class="list">
	      <thead>
		  <tr>
		      <td class="left"><?php echo $text_manufacturer; ?></td>
		      <td class="left"><?php echo $text_article; ?></td>
		      <td class="left"><?php echo $text_description; ?></td>
		      <td class="left"><?php echo $text_quantity; ?></td>
		      <td class="left"><?php echo $text_price_new; ?> <span class="tooltip"><img src="view/image/price_import/help.png" alt="помощь" style="vertical-align: middle;" /><span style="font-weight: normal"><?php echo $help_price_new; ?></span></span></td>
		      <td class="left"><?php echo $text_file_price; ?></td>
		  </tr>
	      </thead>
	      <tbody>
	      <?php foreach ($result_data->rows as $row): ?>
	      <tr>
		  <td class="left"><?php echo $row['manufacturer']; ?></td>
		  <td class="left"><?php echo $row['sku']; ?></td>
		  <td class="left"><?php echo $row['descr']; ?></td>
		  <td class="left"><?php echo $row['in_stock']; ?></td>
		  <td class="left"><?php echo $row['price_new']; ?></td>
		  <td class="left"><?php echo $row['price']; ?></td>
	      </tr>
	      <?php endforeach; ?>
	      </tbody>
	  </table>
	  <div class="pagination">
	  <?php echo $pagination; ?>
	  </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
//<![CDATA[
function supex_dumper()
{
    var sxd = window.open("/vendor/sxd/","sxd","height=462,width=586,top=200,left=200");
}
//]]>
</script>
<?php echo $footer; ?>