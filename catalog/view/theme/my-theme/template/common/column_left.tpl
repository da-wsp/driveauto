<?php if ($modules) { ?>
<aside id="column-left" class="col-sm-4">
  <?php //foreach ($modules as $module) { ?>
  <?php //echo $module; ?>
  <?php //} ?>
	
	<?php

		if (!isset($_GET['route']) || $_GET['route']=='common/home'){

	?><div class="left-sidebar">
				
		<h1>Каталог</h1>

		<ul>
			<li><a href="#">Амортизатори</a><span></span></li>
			<li><a href="#">Автоаксесуари</a><span></span></li>
			<li><a href="#">Автомасла</a><span></span></li>
			<li><a href="#">Авторезина</a><span></span></li>
			<li><a href="#">Автодиски</a><span></span></li>
			<li><a href="#">Гідравлика</a><span></span></li>
			<li><a href="#">Акумулятори</a><span></span></li>
			<li><a href="#">Амортизатори</a><span></span></li>
			<li><a href="#">Автохімія</a><span></span></li>
			<li><a href="#">Автотюнинг</a><span></span></li>
		</ul>

	</div><!-- end left-sidebar -->

	<div class="banners-list">
				
		<a href="#">
			<div class="banner banner-youtube">

				<img src="catalog/view/theme/my-theme/image/banner-youtube.jpg" height="62" width="205" alt="See us in youtube" />

				<span>Огляд<br /> запчастин</span>

			</div><!-- end banner -->
		</a>
				
		<a href="#">
			<div class="banner banner-spare">
						
				<img src="catalog/view/theme/my-theme/image/banner-sparepart.jpg" height="195" width="357" alt="Spare Part" />

			</div><!-- end banner -->
		</a>

	</div><!-- end banners-list -->
<?php } ?>
</aside>
<?php } ?>
