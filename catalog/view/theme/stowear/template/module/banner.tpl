<div id="banner<?php echo $module; ?>" class="banner <?php if(count($banners) > 1) echo 'cycle-slideshow'; ?>" data-cycle-fx="flipHorz" data-cycle-timeout="4000">
  <?php foreach ($banners as $banner) { ?>
	  <?php if ($banner['link']) { ?>
	  <img src="<?php echo $banner['image']; ?>" class="with-link" onclick="location.href = '<?php echo $banner['link']; ?>';" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" />
	  <?php } else { ?>
	  <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" />  
	  <?php } ?>
  <?php } ?>
</div>