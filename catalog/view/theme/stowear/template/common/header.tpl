<?php 
if($this->registry->has('theme_options') == false) { 
	header("location: themeinstall/index.php"); 
	exit; 
} 

$theme_options = $this->registry->get('theme_options');
$config = $this->registry->get('config');
$model_url = $this->registry->get('url');

require_once( DIR_TEMPLATE.$config->get('config_template')."/lib/module.php" );
$modules = new Modules($this->registry);
?>
<!DOCTYPE html>
<!--[if IE 7]> <html lang="<?php echo $lang; ?>" class="ie7 <?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no-'; } ?>responsive"> <![endif]-->  
<!--[if IE 8]> <html lang="<?php echo $lang; ?>" class="ie8 <?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no-'; } ?>responsive"> <![endif]-->  
<!--[if IE 9]> <html lang="<?php echo $lang; ?>" class="ie9 <?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no-'; } ?>responsive"> <![endif]-->  
<!--[if !IE]><!--> <html lang="<?php echo $lang; ?>" class="<?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no-'; } ?>responsive"> <!--<![endif]-->  
<head>
	<title><?php echo $title; ?></title>
	<base href="<?php echo $base; ?>" />

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<?php if($theme_options->get( 'responsive_design' ) != '0') { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php } ?>
	<?php if ($description) { ?>
	<meta name="description" content="<?php echo $description; ?>" />
	<?php } ?>
	<?php if ($keywords) { ?>
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<?php } ?>
	
	<?php if ($icon) { ?>
	<link href="<?php echo $icon; ?>" rel="icon" />
	<?php } ?>
	<?php foreach ($links as $link) { ?>
	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
	<?php } ?>
	
	<!-- Google Fonts -->
<link href="catalog/view/theme/stowear/css/hover.css" rel="stylesheet" media="all">
	<link href="//fonts.googleapis.com/css?family=Raleway:800,700,600,500,400,300,200" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Jura|Roboto+Condensed|Russo+One" rel="stylesheet">
	<?php 
	if( $theme_options->get( 'font_status' ) == '1' ) {
		$lista_fontow = array();
		if( $theme_options->get( 'body_font' ) != '' && $theme_options->get( 'body_font' ) != 'standard' && $theme_options->get( 'body_font' ) != 'Arial' && $theme_options->get( 'body_font' ) != 'Georgia' && $theme_options->get( 'body_font' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'body_font' );
			$lista_fontow[$font] = $font;
		}
		
		if( $theme_options->get( 'categories_bar' ) != '' && $theme_options->get( 'categories_bar' ) != 'standard' && $theme_options->get( 'categories_bar' ) != 'Arial' && $theme_options->get( 'categories_bar' ) != 'Georgia' && $theme_options->get( 'categories_bar' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'categories_bar' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'headlines' ) != '' && $theme_options->get( 'headlines' ) != 'standard' && $theme_options->get( 'headlines' ) != 'Arial' && $theme_options->get( 'headlines' ) != 'Georgia' && $theme_options->get( 'headlines' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'headlines' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'footer_headlines' ) != '' && $theme_options->get( 'footer_headlines' ) != 'standard'  && $theme_options->get( 'footer_headlines' ) != 'Arial' && $theme_options->get( 'footer_headlines' ) != 'Georgia' && $theme_options->get( 'footer_headlines' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'footer_headlines' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'page_name' ) != '' && $theme_options->get( 'page_name' ) != 'standard' && $theme_options->get( 'page_name' ) != 'Arial' && $theme_options->get( 'page_name' ) != 'Georgia' && $theme_options->get( 'page_name' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'page_name' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'button_font' ) != '' && $theme_options->get( 'button_font' ) != 'standard' && $theme_options->get( 'button_font' ) != 'Arial' && $theme_options->get( 'button_font' ) != 'Georgia' && $theme_options->get( 'button_font' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'button_font' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'custom_price' ) != '' && $theme_options->get( 'custom_price' ) != 'standard' && $theme_options->get( 'custom_price' ) != 'Arial' && $theme_options->get( 'custom_price' ) != 'Georgia' && $theme_options->get( 'custom_price' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'custom_price' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		foreach($lista_fontow as $font) {
			echo '<link href="//fonts.googleapis.com/css?family=' . $font . ':800,700,600,500,400,300" rel="stylesheet" type="text/css">';
			echo "\n";
		}
	}
	?>
	
	<?php $lista_plikow = array(
			'catalog/view/theme/'.$config->get( 'config_template' ).'/css/bootstrap.css',
			'catalog/view/theme/'.$config->get( 'config_template' ).'/css/jquery-ui.css',
			'catalog/view/theme/'.$config->get( 'config_template' ).'/css/stylesheet.css',
			'catalog/view/theme/'.$config->get( 'config_template' ).'/css/responsive.css',
			'catalog/view/theme/'.$config->get( 'config_template' ).'/css/blog.css',
			'catalog/view/theme/'.$config->get( 'config_template' ).'/css/owl.carousel.css',
			'catalog/view/theme/'.$config->get( 'config_template' ).'/css/menu.css',
			'catalog/view/theme/'.$config->get( 'config_template' ).'/css/magnific-popup.css',
			'catalog/view/theme/'.$config->get( 'config_template' ).'/css/font-awesome.min.css'
	); 
	
	// Camera slider
	if($config->get( 'camera_slider_module' ) != '') $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/css/camera_slider.css';
	
	// Category wall
	if($config->get( 'category_wall_module' ) != '') $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/css/category_wall.css';
	
	// Filter product
	if($config->get( 'filter_product_module' ) != '') $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/css/filter_product.css';
	
	// Revolution slider
	if($config->get( 'revolution_slider_module' ) != '') $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/css/slider.css';
	
	// Carousel brands
	if($config->get( 'carousel_module' ) != '') $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/css/carousel.css';
	
	// Wide width		
	if($theme_options->get( 'page_width' ) == 1) $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/css/wide-grid.css';
	
	// Normal width
	if($theme_options->get( 'page_width' ) == 3) $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/css/standard-grid.css';
	
	// Nivo slider
	if($config->get( 'slideshow_module' ) != '') $lista_plikow[] = 'catalog/view/theme/' . $config->get( 'config_template' ) . '/css/nivo-slider.css';
		
	if($theme_options->get( 'colors_status' ) == 1 || $theme_options->get( 'font_status' ) == 1) {
		$url = false;
		if($theme_options->get( 'colors_status' ) == 1) {
			$array = array(
					'body_text_color',
					'body_headlines_color',
					'body_links_color',
					'body_links_hover_color',
					'price_text_color',
					'price_new_text_color',
					'price_old_text_color',
					'body_background_color',
					'body_fixed_content_background_color',
					'dropdown_text_color',
					'dropdown_border_color',
					'dropdown_background_color',
					'dropdown_item_hover_background_color',
					'input_text_color',
					'input_border_color',
					'input_focus_border_color',
					'input_background_color',
					'table_border_color',
					'top_bar_text_color',
					'top_bar_border_color',
					'top_bar_background_color',
					'top_links_color',
					'search_input_text_color',
					'search_input_border_color',
					'search_input_focus_border_color',
					'search_input_background_color',
					'cart_icon',
					'price_in_cart_color',
					'top_background_gradient_top',
					'top_background_gradient_bottom',
					'menu_main_links_color',
					'menu_main_links_hover_color',
					'menu_main_links_hover_border_bottom',
					'menu_icon_home_color',
					'menu_background_gradient_top',
					'menu_background_gradient_bottom',
					'menu_icon_plus_minus_color',
					'submenu_text_color',
					'submenu_link_color',
					'submenu_link_hover_color',
					'submenu_border_color',
					'submenu_background_color',
					'button_text_color',
					'button_background_color',
					'button_hover_text_color',
					'button_hover_background_color',
					'second_button_text_color',
					'second_button_border_color',
					'second_button_background_color',
					'second_button_hover_text_color',
					'second_button_hover_border_color',
					'second_button_hover_background_color',
					'carousel_button_background',
					'carousel_button_hover_background',
					'carousel_bullet_background',
					'carousel_bullet_active_background',
					'slider_button_background',
					'slider_bullet_background',
					'slider_bullet_active_background',
					'product_grid_button_text_color',
					'product_grid_button_background_color',
					'product_grid_button_hover_text_color',
					'product_grid_button_hover_background_color',
					'product_list_button_text_color',
					'product_list_button_border_color',
					'product_list_button_background_color',
					'product_list_button_hover_text_color',
					'product_list_button_hover_border_color',
					'product_list_button_hover_background_color',
					'sale_color_text',
					'sale_background_color',
					'rating_icon_background_color',
					'rating_icon_active_background_color',
					'custom_block_border_color',
					'box_categories_border_color',
					'box_categories_links_active_color',
					'product_filter_icon_color',
					'product_filter_icon_hover_color',
					'tab_link_color',
					'tab_link_active_color',
					'tab_link_active_border_color',
					'pagination_link_border_color',
					'pagination_link_active_border_color',
					'customfooter_text_color',
					'customfooter_headlines_color',
					'customfooter_icon_phone_background_color',
					'customfooter_icon_mail_background_color',
					'customfooter_icon_skype_background_color',
					'customfooter_background_color',
					'footer_text_color',
					'footer_headlines_color',
					'footer_background_color'
			);
				
			$i = 0;
			foreach($array as $color) {
				if($i != 0) {
					$url .= '&';
				} 
				$url .= $color.'='.str_replace(array('#', ' '), '', $theme_options->get( $color ));
				$i++;
			}
		} else {
			$url = 'color_status=0';
		}
		
		if( $theme_options->get( 'font_status' ) == '1' ) {
			$url .= '&font_status=1';
			if( $theme_options->get( 'body_font' ) != '' && $theme_options->get( 'body_font' ) != 'standard' ) {
				$url .= '&body_font=' . str_replace(" ", "+", $theme_options->get( 'body_font' ));
			}
			
			if( $theme_options->get( 'categories_bar' ) != '' && $theme_options->get( 'categories_bar' ) != 'standard' ) {
				$url .= '&categories_bar_font=' . str_replace(" ", "+", $theme_options->get( 'categories_bar' ));
			}
			
			if( $theme_options->get( 'headlines' ) != '' && $theme_options->get( 'headlines' ) != 'standard' ) {
				$url .= '&headlines_font=' . str_replace(" ", "+", $theme_options->get( 'headlines' ));
			}
			
			if( $theme_options->get( 'footer_headlines' ) != '' && $theme_options->get( 'footer_headlines' ) != 'standard' ) {
				$url .= '&footer_headlines_font=' . str_replace(" ", "+", $theme_options->get( 'footer_headlines' ));
			}
			
			if( $theme_options->get( 'page_name' ) != '' && $theme_options->get( 'page_name' ) != 'standard' ) {
				$url .= '&page_name_font=' . str_replace(" ", "+", $theme_options->get( 'page_name' ));
			}
			
			if( $theme_options->get( 'button_font' ) != '' && $theme_options->get( 'button_font' ) != 'standard' ) {
				$url .= '&button_font=' . str_replace(" ", "+", $theme_options->get( 'button_font' ));
			}
			
			if( $theme_options->get( 'custom_price' ) != '' && $theme_options->get( 'custom_price' ) != 'standard' ) {
				$url .= '&custom_price_font=' . str_replace(" ", "+", $theme_options->get( 'custom_price' ));
			}
			
			$url .= '&body_font_px=' . $theme_options->get( 'body_font_px' );
			$url .= '&body_font_weight=' . $theme_options->get( 'body_font_weight' );
			$url .= '&body_font_smaller_px=' . $theme_options->get( 'body_font_smaller_px' );
			$url .= '&categories_bar_weight=' . $theme_options->get( 'categories_bar_weight' );
			$url .= '&categories_bar_px=' . $theme_options->get( 'categories_bar_px' );
			$url .= '&headlines_weight=' . $theme_options->get( 'headlines_weight' );
			$url .= '&headlines_px=' . $theme_options->get( 'headlines_px' );
			$url .= '&headlines_transform=' . $theme_options->get( 'headlines_transform' );
			$url .= '&footer_headlines_weight=' . $theme_options->get( 'footer_headlines_weight' );
			$url .= '&footer_headlines_px=' . $theme_options->get( 'footer_headlines_px' );
			$url .= '&footer_headlines_transform=' . $theme_options->get( 'footer_headlines_transform' );
			$url .= '&page_name_weight=' . $theme_options->get( 'page_name_weight' );
			$url .= '&page_name_px=' . $theme_options->get( 'page_name_px' );
			$url .= '&page_name_transform=' . $theme_options->get( 'page_name_transform' );
			$url .= '&button_font_weight=' . $theme_options->get( 'button_font_weight' );
			$url .= '&button_font_px=' . $theme_options->get( 'button_font_px' );
			$url .= '&button_font_transform=' . $theme_options->get( 'button_font_transform' );
			$url .= '&custom_price_weight=' . $theme_options->get( 'custom_price_weight' );
			$url .= '&custom_price_px=' . $theme_options->get( 'custom_price_px' );
			$url .= '&custom_price_px_medium=' . $theme_options->get( 'custom_price_px_medium' );
			$url .= '&custom_price_px_small=' . $theme_options->get( 'custom_price_px_small' );
			$url .= '&custom_price_px_old_price=' . $theme_options->get( 'custom_price_px_old_price' );
		}
			
		$lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/css/custom_color.css.php?'.$url;
	} ?>
		
	<?php echo $theme_options->compressorCodeCss( $config->get( 'config_template' ), $lista_plikow, $theme_options->get( 'compressor_code_status' ), HTTP_SERVER ); ?>
	
	<?php if($theme_options->get( 'background_status' ) == 1) { ?>
	<style type="text/css">
		<?php if($theme_options->get( 'body_background_background' ) == '1') { ?> 
		body { background-image:none !important; }
		<?php } ?>
		<?php if($theme_options->get( 'body_background_background' ) == '2') { ?> 
		body { background-image:url(image/<?php echo $theme_options->get( 'body_background' ); ?>);background-position:<?php echo $theme_options->get( 'body_background_position' ); ?>;background-repeat:<?php echo $theme_options->get( 'body_background_repeat' ); ?> !important;background-attachment:<?php echo $theme_options->get( 'body_background_attachment' ); ?> !important; }
		<?php } ?>
		<?php if($theme_options->get( 'body_background_background' ) == '3') { ?> 
		body { background-image:url(image/subtle_patterns/<?php echo $theme_options->get( 'body_background_subtle_patterns' ); ?>);background-position:<?php echo $theme_options->get( 'body_background_position' ); ?>;background-repeat:<?php echo $theme_options->get( 'body_background_repeat' ); ?> !important;background-attachment:<?php echo $theme_options->get( 'body_background_attachment' ); ?> !important; }
		<?php } ?>
		
		<?php if($theme_options->get( 'header_background_background' ) == '1') { ?> 
		#top .background { background-image:none !important; }
		<?php } ?>
		<?php if($theme_options->get( 'header_background_background' ) == '2') { ?> 
		#top .background { background-image:url(image/<?php echo $theme_options->get( 'header_background' ); ?>);background-position:<?php echo $theme_options->get( 'header_background_position' ); ?>;background-repeat:<?php echo $theme_options->get( 'header_background_repeat' ); ?> !important;background-attachment:<?php echo $theme_options->get( 'header_background_attachment' ); ?> !important; }
		<?php } ?>
		<?php if($theme_options->get( 'header_background_background' ) == '3') { ?> 
		#top .background { background-image:url(image/subtle_patterns/<?php echo $theme_options->get( 'header_background_subtle_patterns' ); ?>);background-position:<?php echo $theme_options->get( 'header_background_position' ); ?>;background-repeat:<?php echo $theme_options->get( 'header_background_repeat' ); ?> !important;background-attachment:<?php echo $theme_options->get( 'header_background_attachment' ); ?> !important; }
		<?php } ?>
	</style>
	<?php } ?>
	
	<?php if($theme_options->get( 'custom_code_css_status' ) == 1) { ?>
	<link rel="stylesheet" href="catalog/view/theme/<?php echo $config->get( 'config_template' ); ?>/skins/store_<?php echo $theme_options->get( 'store' ); ?>/<?php echo $theme_options->get( 'skin' ); ?>/css/custom_code.css">
	<?php } ?>
	
	<?php foreach ($styles as $style) { ?>
		<?php if($style['href'] != 'catalog/view/theme/default/stylesheet/slideshow.css' && $style['href'] != 'catalog/view/theme/default/stylesheet/carousel.css') { ?>
		<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
		<?php } ?>
	<?php } ?>
	
	<?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) > 900) { ?>
	<style type="text/css">
		.standard-body .full-width .container {
			max-width: <?php echo $theme_options->get( 'max_width' ); ?>px;
			<?php if($theme_options->get( 'responsive_design' ) == '0') { ?>
			width: <?php echo $theme_options->get( 'max_width' ); ?>px;
			<?php } ?>
		}
		
		.standard-body .fixed .background,
		.main-fixed {
			max-width: <?php echo $theme_options->get( 'max_width' )-40; ?>px;
			<?php if($theme_options->get( 'responsive_design' ) == '0') { ?>
			width: <?php echo $theme_options->get( 'max_width' )-40; ?>px;
			<?php } ?>
		}
	</style>
	<?php } ?>
    
    <?php $lista_plikow = array(); 
    
    $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/js/jquery.min.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/js/jquery-migrate-1.2.1.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/js/jquery.easing.1.3.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/js/bootstrap.min.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/js/twitter-bootstrap-hover-dropdown.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/js/common.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/js/owl.carousel.min.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/js/jquery.cookie.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/js/jquery.magnific-popup.min.js';
    
    // Revolution slider
    if($config->get( 'revolution_slider_module' ) != '') {
		$lista_plikow[] = 'catalog/view/theme/' . $config->get( 'config_template' ) . '/js/jquery.themepunch.plugins.min.js';
    	$lista_plikow[] = 'catalog/view/theme/' . $config->get( 'config_template' ) . '/js/jquery.themepunch.revolution.min.js';
    }
    
    // Nivo slider
    if($config->get( 'slideshow_module' ) != '') $lista_plikow[] = 'catalog/view/theme/' . $config->get( 'config_template' ) . '/js/jquery.nivo.slider.pack.js';
    
    // Fixed header
    if($theme_options->get( 'fixed_header' ) == 1) $lista_plikow[] = 'catalog/view/theme/' . $config->get( 'config_template' ) . '/js/jquery.sticky.js';
    
    // Fixed menu
    if($theme_options->get( 'fixed_menu' ) == 1) $lista_plikow[] = 'catalog/view/theme/' . $config->get( 'config_template' ) . '/js/jquery.sticky2.js';
    
    // Carousel brands
    if($config->get( 'carousel_module' ) != '') $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/js/jquery.jcarousel.min.js';
    
    // Banner module
    if($config->get( 'banner_module' ) != '') $lista_plikow[] = 'catalog/view/theme/'.$config->get( 'config_template' ).'/js/jquery.cycle2.min.js';
    
    ?>
        	
    <?php echo $theme_options->compressorCodeJs( $config->get( 'config_template' ), $lista_plikow, $theme_options->get( 'compressor_code_status' ), HTTP_SERVER ); ?>
    
    <script type="text/javascript" src="catalog/view/theme/<?php echo $config->get( 'config_template' ); ?>/js/jquery-ui.js"></script>
	
	<script type="text/javascript">
	var transition = 'fade';
	var animation_time = 200;
	var responsive_design = '<?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no'; } else { echo 'yes'; } ?>';
	</script>
	<?php foreach ($scripts as $script) { ?>
		<?php if($script != 'catalog/view/javascript/jquery/jquery.jcarousel.min.js' && $script != 'catalog/view/javascript/jquery/nivo-slider/jquery.nivo.slider.pack.js') { ?>
		<script type="text/javascript" src="<?php echo $script; ?>"></script>
		<?php } ?>
	<?php } ?>
	<?php if($theme_options->get( 'custom_code_javascript_status' ) == 1) { ?>
	<script type="text/javascript" src="catalog/view/theme/<?php echo $config->get( 'config_template' ); ?>/skins/store_<?php echo $theme_options->get( 'store' ); ?>/<?php echo $theme_options->get( 'skin' ); ?>/js/custom_code.js"></script>
	<?php } ?>
	
	<?php echo $google_analytics; ?>    
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="catalog/view/theme/<?php echo $config->get( 'config_template' ); ?>/js/respond.min.js"></script>
	<![endif]-->
</head>

	
<body>

<?php if($theme_options->get( 'widget_facebook_status' ) == 1) { ?>
<div class="facebook_<?php if($theme_options->get( 'widget_facebook_position' ) == 1) { echo 'left'; } else { echo 'right'; } ?> hidden-xs hidden-sm">
	<div class="facebook-icon"></div>
	<div class="facebook-content">
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		
		<div class="fb-like-box fb_iframe_widget" profile_id="<?php echo $theme_options->get( 'widget_facebook_id' ); ?>" data-colorscheme="light" data-height="370" data-connections="16" fb-xfbml-state="rendered"></div>
	</div>
	
	<script type="text/javascript">    
	$(function() {  
		$(".facebook_right").hover(function() {            
			$(".facebook_right").stop(true, false).animate({right: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".facebook_right").stop(true, false).animate({right: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	
		$(".facebook_left").hover(function() {            
			$(".facebook_left").stop(true, false).animate({left: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".facebook_left").stop(true, false).animate({left: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	});  
	</script>
</div>
<?php } ?>

<?php if($theme_options->get( 'widget_twitter_status' ) == 1) { ?>
<div class="twitter_<?php if($theme_options->get( 'widget_twitter_position' ) == 1) { echo 'left'; } else { echo 'right'; } ?> hidden-xs hidden-sm">
	<div class="twitter-icon"></div>
	<div class="twitter-content">
		<a class="twitter-timeline"  href="https://twitter.com/@<?php echo $theme_options->get( 'widget_twitter_user_name' ); ?>" data-chrome="noborders" data-tweet-limit="<?php echo $theme_options->get( 'widget_twitter_limit' ); ?>"  data-widget-id="<?php echo $theme_options->get( 'widget_twitter_id' ); ?>" data-theme="light" data-related="twitterapi,twitter" data-aria-polite="assertive">Tweets by @<?php echo $theme_options->get( 'widget_twitter_user_name' ); ?></a>
	</div>
	
	<script type="text/javascript">    
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
	$(function() {  
		$(".twitter_right").hover(function() {            
			$(".twitter_right").stop(true, false).animate({right: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".twitter_right").stop(true, false).animate({right: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	
		$(".twitter_left").hover(function() {            
			$(".twitter_left").stop(true, false).animate({left: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".twitter_left").stop(true, false).animate({left: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	});  
	</script>
</div>
<?php } ?>

<?php if($theme_options->get( 'widget_custom_status' ) == 1) { ?>
<div class="custom_<?php if($theme_options->get( 'widget_custom_position' ) == 1) { echo 'left'; } else { echo 'right'; } ?> hidden-xs hidden-sm">
	<div class="custom-icon"></div>
	<div class="custom-content">
		<?php $lang_id = $config->get( 'config_language_id' ); ?>
		<?php $custom_content = $theme_options->get( 'widget_custom_content' ); ?>
		<?php if(isset($custom_content[$lang_id])) echo html_entity_decode($custom_content[$lang_id]); ?>
	</div>
	
	<script type="text/javascript">    
	$(function() {  
		$(".custom_right").hover(function() {            
			$(".custom_right").stop(true, false).animate({right: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".custom_right").stop(true, false).animate({right: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	
		$(".custom_left").hover(function() {            
			$(".custom_left").stop(true, false).animate({left: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".custom_left").stop(true, false).animate({left: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	});  
	</script>
	
</div>
<?php } ?>

<div id="notification" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php if($theme_options->get( 'confirmation_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'confirmation_text', $config->get( 'config_language_id' ) ); } else { echo 'Confirmation'; } ?></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php if($theme_options->get( 'continue_shopping_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'continue_shopping_text', $config->get( 'config_language_id' ) ); } else { echo 'Continue shopping'; } ?></button>
                <a href="<?php echo $checkout; ?>" class="btn btn-primary"><?php if($theme_options->get( 'checkout_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'checkout_text', $config->get( 'config_language_id' ) ); } else { echo 'Checkout'; } ?></a>
            </div>
        </div>
    </div>
</div>

<div id="quickview" class="modal fade bs-example-modal-lg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Product</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
        </div>
    </div>
</div>

<?php if($theme_options->get( 'quick_view' ) == 1) { ?>
<script type="text/javascript">
	$('body').on('click', '.quickview a', function () {
		$('#quickview .modal-header .modal-title').html($(this).attr('title'));
		$('#quickview .modal-body').load($(this).attr('rel') + ' #quickview_product' ,function(result){
		    $('#quickview').modal('show');
		    $('#quickview .popup-gallery').magnificPopup({
		    	delegate: 'a',
		    	type: 'image',
		    	tLoading: 'Loading image #%curr%...',
		    	mainClass: 'mfp-img-mobile',
		    	gallery: {
		    		enabled: true,
		    		navigateByImgClick: true,
		    		preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		    	},
		    	image: {
		    		tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
		    		titleSrc: function(item) {
		    			return item.el.attr('title');
		    		}
		    	}
		    });
		});
		return false;
	});
	
	$('#quickview').on('click', '#button-cart', function () {
		$('#quickview').modal('hide');
		cart.add($(this).attr("rel"));
	});
</script>
<?php } ?>

<?php if($theme_options->get( 'fixed_header' ) == 1) { ?>
<script type="text/javascript">
  $(window).load(function(){
    $("#top").sticky({ topSpacing: 0 });
  });
</script>
<?php } ?>

<?php if($theme_options->get( 'fixed_menu' ) == 1) { ?>
<script type="text/javascript">
  $(window).load(function(){
    $("#top .container-megamenu").sticky({ topSpacing: 0 });
  });
</script>
<?php } ?>

<div class="<?php if($theme_options->get( 'main_layout' ) == 2) { echo 'fixed-body'; } else { echo 'standard-body'; } ?>">
	<div id="main" class="<?php if($theme_options->get( 'main_layout' ) == 2) { echo 'main-fixed'; } ?>">
		<div class="hover-product"></div>
		<?php 
		if($theme_options->get( 'header_type' ) == 2) {
			include('catalog/view/theme/'.$config->get('config_template').'/template/common/header/header_02.tpl'); 
		} elseif($theme_options->get( 'header_type' ) == 3) {
			include('catalog/view/theme/'.$config->get('config_template').'/template/common/header/header_03.tpl');
		} else {
			include('catalog/view/theme/'.$config->get('config_template').'/template/common/header/header_01.tpl');
		}	
		?>
<!-- RedHelper -->
<script id="rhlpscrtg" type="text/javascript" charset="utf-8" async="async" 
	src="https://web.redhelper.ru/service/main.js?c=kvdvadim">
</script> 
<!--/Redhelper -->