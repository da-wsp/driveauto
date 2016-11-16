<div class="row">

<div class="col-md-12">

<div class="parnter-block-carousel">

<script>
  var banner_position = false;
</script>

<div class="partner-carousel owl-theme">
  <?php foreach ($banners as $banner) { ?>

  <!— partner —>
   <?php if ($banner['link']) { ?>
    <a href="<?=$banner['link']?>" target="_blank">
    <div class="blurb blurb-carousel">
      <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    </div><!— end blurb —>
    </a>
    <!— —>
  <?php } else { ?>
     <div class="blurb blurb-carousel">
      <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    </div><!— end blurb —>
  <?php } ?>
  <?php } ?>

</div><!— end partner-carousel —>

</div><!— end parnter-block-carousel —>

</div>

</div>
<?php foreach ($banners as $banner) { ?>

  <!— partner —>
   <?php if ($banner['link']) { ?>
    <script>

      if (banner_position==true)
      {
        $('#banners_right').append('<a href="<?=$banner['link']?>" target="_blank"><div class="blurb"><img src="<?=$banner['image']; ?>" alt="<?=$banner['title']; ?>" class="img-responsive" /></div><!-- end blurb --></a>');
        banner_position=false;
      }
      else
      {
         $('#banners_left').append('<a href="<?=$banner['link']?>" target="_blank"><div class="blurb"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></div><!-- end blurb --></a>');
        banner_position=true;
      }
    </script>
    <!— —>
  <?php } else { ?>
     <script>

      if (banner_position==true)
      {
        $('#banners_right').append('<div class="blurb"><img src="<?=$banner['image']; ?>" alt="<?=$banner['title']; ?>" class="img-responsive" /></div>');
        banner_position=false;
      }
      else
      {
         $('#banners_left').append('<div class="blurb"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></div><!-- end blurb -->');
        banner_position=true;
      }
    </script>
  <?php } ?>
  <?php } ?>