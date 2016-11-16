<?php echo $header; ?>
<?php include('catalog/view/theme/'.$this->config->get('config_template').'/template/new_elements/wrapper_top.tpl'); ?>
  <?php echo $text_description; ?>
  <div class="login-content">
    <div class="left">
      <h2><?php echo $text_new_affiliate; ?></h2>
      <div class="content"><?php echo $text_register_account; ?> <a href="<?php echo $register; ?>" class="button"><?php echo $button_continue; ?></a></div>
    </div>


    <div class="right">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
       <div id="reg"> <?php echo $text_returning_affiliate; ?></div>
	<style>
#reg {
font-size:18px;
}
#reg p {
padding-top: 50px;
}
#ddd {
position:absolute;	
padding-top:0px;
}
</style>
        <div class="content">
          <p><?php echo $text_i_am_returning_affiliate; ?></p>
<br>
<div id="ddd"><b><?php echo $entry_email; ?></b></div><br />
          <input type="text" name="email" value="<?php echo $email; ?>" />
          <br />
          <br />
    
          <b><?php echo $entry_password; ?></b><br />
          <input type="password" name="password" value="<?php echo $password; ?>" />
          <br />
          <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a><br />
          <br />
          <input type="submit" value="<?php echo $button_login; ?>" class="button" />
          <?php if ($redirect) { ?>
          <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
          <?php } ?>
        </div>
      </form>
    </div>
  </div>
<?php include('catalog/view/theme/'.$this->config->get('config_template').'/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>