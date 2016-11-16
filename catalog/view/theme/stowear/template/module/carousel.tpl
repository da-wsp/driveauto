<?php if($this->registry->has('theme_options') == true) { 
$theme_options = $this->registry->get('theme_options');
$config = $this->registry->get('config'); ?>
<div class="box">
  <div class="box-heading"><?php if($theme_options->get( 'ourbrands_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'ourbrands_text', $config->get( 'config_language_id' ) ); } else { echo 'Our brands'; } ?></div>
              <div class="jcarousel-wrapper">
                <div class="jcarousel">
                    <ul>
                    	<?php foreach ($banners as $banner) { ?>
                        <li><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a></li>
                        <?php } ?>
                    </ul>
                </div>

                <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
                <a href="#" class="jcarousel-control-next">&rsaquo;</a>
            </div>
 </div>
 <?php } ?>