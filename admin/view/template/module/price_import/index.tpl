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
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	  <table class="form">
	      <tr>
		<td><a href="<?php echo $add_profile; ?>" class="button"><?php echo $input_add_profile; ?></a></td>
	      </tr>
	  </table>
        <table class="form setup_cell">
          <tr>
	      <td><?php echo $text_select_profile; ?></td>
	    <?php if ( ! empty($input_profile_list)): ?>
            <td>
		<select name="profile">
		    <?php foreach ($input_profile_list as $k=>$v): ?>
		    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
		    <?php endforeach; ?>
		</select>
	    </td>
	    <td><input type="submit" name="edit_profile" value="<?php echo $input_edit; ?>" title="<?php echo $text_edit_title; ?>" class="button_input" /></td>
	    <td><input type="submit" name="delete_profile" value="<?php echo $input_delete; ?>" title="<?php echo $text_delete_title; ?>" class="button_input" onClick="return window.confirm('<?php echo $text_to_delete; ?>')" /></td>
	    <?php else: ?>
	    <td colspan="3" style="text-align: left;color: #e59509"><?php echo $text_no_profiles; ?></td>
	    <?php endif; ?>
          </tr>
	  <tr>
	      <td><?php echo $text_select_file; ?> <span class="tooltip"><img src="view/image/attention.png" alt="помощь" style="vertical-align: middle" /><span><?php echo $help_select_file; ?></span></span><br /><span style="color:grey">(<?php echo $text_valid_types; ?>)</span></td>
	      <td><input type="file" name="import" /></td>
	      <td></td>
	      <td></td>
	  </tr>
        </table>
	  <p>&nbsp;</p>
	  <div>
	      <input type="submit" name="preload" value="<?php echo $input_preload; ?>" class="button_input" /> <span class="tooltip"><img src="view/image/price_import/help.png" alt="помощь" style="vertical-align: middle" /><span><?php echo $help_preload; ?></span></span>
	  </div>
	  <div style="margin-top: 50px">
	      <a onclick="supex_dumper();" class="button"><img src="view/image/price_import/sypex_logo.png" alt="sypex dumper" height="14" width="47" style="vertical-align: middle;" />&nbsp;&nbsp;<?php echo $input_manage_backup; ?></a>
	  </div>
	  <br />
	  <!--div>
	      <a href="<?php //echo $update_image; ?>" class="button"><?php //echo $input_update_image; ?></a>
	  </div-->
	  <br />
	  <div>
	      <a href="<?php echo $remove_products; ?>" class="button" onClick="return window.confirm('<?php echo $text_to_delete; ?>')"><?php echo $input_truncate_products; ?></a>
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