<!--
<?php if (count($currencies) > 1) { ?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="currency_form">
	 Currency 
	<div class="dropdown">
		<?php foreach ($currencies as $currency) { ?>
		<?php if ($currency['code'] == $currency_code) { ?>
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $currency['title']; ?> <b class="caret"></b></a>
		<?php } ?>
		<?php } ?>
		<ul class="dropdown-menu">
		  <?php foreach ($currencies as $currency) { ?>
		  <li><a href="javascript:;" onclick="$('input[name=\'currency_code\']').attr('value', '<?php echo $currency['code']; ?>'); $('#currency_form').submit();"><?php echo $currency['title']; ?></a></li>
		  <?php } ?>
		</ul>
	</div>
	
    <input type="hidden" name="currency_code" value="" />
    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
<?php } ?>
-->
