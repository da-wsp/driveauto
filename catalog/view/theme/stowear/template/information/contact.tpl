<?php echo $header; ?>
	<?php include('catalog/view/theme/'.$this->config->get('config_template').'/template/new_elements/wrapper_top.tpl'); ?>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1327.9105934641582!2d25.925167116456784!3d48.26781555855643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x473408b4d2b31cc5%3A0x7e5acedc091977ae!2z0LLRg9C70LjRhtGPINCT0LXRgNC-0ZfQsiDQnNCw0LnQtNCw0L3RgywgMTg0LCDQp9C10YDQvdGW0LLRhtGWLCDQp9C10YDQvdGW0LLQtdGG0YzQutCwINC-0LHQu9Cw0YHRgtGM!5e0!3m2!1sru!2sua!4v1479211470303" width="800" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
  <div class="row">
  	<div class="col-sm-<?php if($this->theme_options->get( 'custom_block', 'contact_page', $this->config->get( 'config_language_id' ), 'status' ) == 1) { echo 9; } else { echo 12; } ?>">
	    <h2><?php echo $text_location; ?></h2>
	    <div class="contact-info">
<style>
#addr{
font-size:18px;
}
</style>
	      <div class="content"><div class="left"><b><?php echo $text_address; ?></b><br />
	       <div id="addr"> <?php echo $store; ?><br />
	        <?php echo $address; ?></div></div>
	      <div class="right">
	        <?php if ($telephone) { ?>
 <div id="addr">
	        <b><?php echo $text_telephone; ?></b><br />
	        <?php echo $telephone; ?><br />
	        <br />
	        <?php } ?>
	        <?php if ($fax) { ?>
	        <b><?php echo $text_fax; ?></b><br />
	        <?php echo $fax; ?>
	        <?php } ?>
	      </div>    </div>
	    </div>
	    </div>
	    <h2><?php echo $text_contact; ?></h2>
	    <div class="content">
	    <b><?php echo $entry_name; ?></b><br />
	    <input type="text" name="name" value="<?php echo $name; ?>" />
	    <br />
	    <?php if ($error_name) { ?>
	    <span class="error"><?php echo $error_name; ?></span>
	    <?php } ?>
	    <br />
	    <b><?php echo $entry_email; ?></b><br />
	    <input type="text" name="email" value="<?php echo $email; ?>" />
	    <br />
	    <?php if ($error_email) { ?>
	    <span class="error"><?php echo $error_email; ?></span>
	    <?php } ?>
	    <br />
	    <b><?php echo $entry_enquiry; ?></b><br />
	    <textarea name="enquiry" cols="40" rows="10" style="width: 100%;"><?php echo $enquiry; ?></textarea>
	    <br />
	    <?php if ($error_enquiry) { ?>
	    <span class="error"><?php echo $error_enquiry; ?></span>
	    <?php } ?>
	    <br />
	    <b><?php echo $entry_captcha; ?></b><br />
	    <input type="text" name="captcha" value="<?php echo $captcha; ?>" />
	    <br />
	    <img src="index.php?route=information/contact/captcha" alt="" />
	    <?php if ($error_captcha) { ?>
	    <span class="error"><?php echo $error_captcha; ?></span>
	    <?php } ?>
	    </div>
    </div>
    
    <?php if($this->theme_options->get( 'custom_block', 'contact_page', $this->config->get( 'config_language_id' ), 'status' ) == 1) { ?>
    <div class="col-sm-3">
    	<div class="product-block">
    		<?php if($this->theme_options->get( 'custom_block', 'contact_page', $this->config->get( 'config_language_id' ), 'heading' ) != '') { ?>
    		<h4 class="title-block"><?php echo $this->theme_options->get( 'custom_block', 'contact_page', $this->config->get( 'config_language_id' ), 'heading' ); ?></h4>
    		<div class="strip-line"></div>
    		<?php } ?>
    		<div class="block-content">
    			<?php echo html_entity_decode($this->theme_options->get( 'custom_block', 'contact_page', $this->config->get( 'config_language_id' ), 'text' )); ?>
    		</div>
    	</div>
    </div>
    <?php } ?>
  </div>
  
    <div class="buttons">
      <div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></div>
    </div>
  </form>
 <?php include('catalog/view/theme/'.$this->config->get('config_template').'/template/new_elements/wrapper_bottom.tpl'); ?>
 <?php echo $footer; ?>