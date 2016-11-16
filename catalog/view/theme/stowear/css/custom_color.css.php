<?php header('Content-type: text/css; charset=utf-8'); ?>

<?php if(!isset($_GET['color_status'])) { ?>
	<?php if($_GET['body_text_color'] == '737373' || $_GET['body_fixed_content_background_color'] == '121212' || $_GET['dropdown_background_color'] == '121212') { ?>
	.mini-cart-total,
	.box-category ul ul,
	.box-category ul ul:before,
	.ui-autocomplete li {
		background: url(../img/bg-menu2.png) top left repeat-x !important;
	}
	
	div.pagination {
		background: url(../img/bg-menu2.png) top left repeat-x;
	}
	
	.standard-body .copyright .background,
	.copyright .background {
		background-image: url(../img/bg-menu2.png);
	}
	
	.center-column h1,
	.center-column h2,
	.center-column h3,
	.center-column h4,
	.center-column h5,
	.center-column h6,
	.box .box-heading,
	.refine_search,
	.product-info .description,
	.product-info .price,
	.product-info .options,
	.product-info .cart,
	#quickview .description,
	#quickview .price,
	#quickview .options,
	#quickview .cart,
	.product-block .title-block,
	.custom-footer h4,
	.footer h4,
	.htabs,
	.center-column .tab-content,
	.filter-product .filter-tabs,
	ul.megamenu .sub-menu .content > .border,
	ul.megamenu li .sub-menu .content .static-menu a.main-menu,
	.checkout-heading,
	.category-list {
		background: url(../img/bg-menu2.png) bottom left repeat-x;
	}
	<?php } ?>

	<?php if($_GET['body_text_color'] != '') { ?>
	body {
		color: #<?php echo $_GET['body_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['body_headlines_color'] != '') { ?>
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.center-column h1,
	.center-column h2,
	.center-column h3,
	.center-column h4,
	.center-column h5,
	.center-column h6,
	.box .box-heading,
	.product-block .title-block {
		color: #<?php echo $_GET['body_headlines_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['body_links_color'] != '') { ?>
	a,
	.box-category ul li .head a {
		color: #<?php echo $_GET['body_links_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['body_links_hover_color'] != '') { ?>
	a:hover,
	div.testimonial p {
		color: #<?php echo $_GET['body_links_hover_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['price_text_color'] != '') { ?>
	.table .price-new, 
	.product-grid .product .price, 
	.product-list .actions > div .price,
	.product-info .price .price-new,
	ul.megamenu li .product .price,
	.mini-cart-total td:last-child,
	.cart-total table tr td:last-child,
	.mini-cart-info td.total,
	#quickview .price .price-new,
	.product-list .price {
		color: #<?php echo $_GET['price_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['price_new_text_color'] != '') { ?>
	.product-grid .product .price .price-new,
	.product-list .price .price-new,
	.table .price-new {
		color: #<?php echo $_GET['price_new_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['price_old_text_color'] != '') { ?>
	.price-old {
		color: #<?php echo $_GET['price_old_text_color']; ?> !important;
	}
	<?php } ?>
	
	<?php if($_GET['body_background_color'] != '') { ?>
	body {
		background: #<?php echo $_GET['body_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['body_fixed_content_background_color'] != '') { ?>
	.main-fixed,
	.standard-body .fixed .background {
		background: #<?php echo $_GET['body_fixed_content_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['dropdown_text_color'] != '') { ?>
	.dropdown-menu,
	.dropdown-menu a,
	.ui-autocomplete li a,
	.mini-cart-info .remove a,
	.modal-content,
	.modal-content .close,
	.my-mfp-zoom-in .mfp-content,
	.mfp-content h1, .mfp-content h2, .mfp-content h3, .mfp-content h4, .mfp-content h5,
	.cart-module > div {
		color: #<?php echo $_GET['dropdown_text_color']; ?>;
	}
	
	.ui-autocomplete li a {
		color: #<?php echo $_GET['dropdown_text_color']; ?> !important;
	}
	
	.modal-content .close {
		text-shadow: none;
		opacity: 1;
	}
	
	.modal-header {
		background: url(../img/bg-menu.png) bottom left repeat-x;
		border: none;
	}
	
	.mini-cart-info .remove a {
		border-color: #<?php echo $_GET['dropdown_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['dropdown_border_color'] != '') { ?>
	.dropdown-menu,
	.ui-autocomplete,
	#top #cart_block.open .cart-heading {
		border-color: #<?php echo $_GET['dropdown_border_color']; ?> !important;
	}
	
	.bootstrap-datetimepicker-widget:after {
		border-bottom-color: #<?php echo $_GET['dropdown_border_color']; ?> !important;
	}
	<?php } ?>
	
	<?php if($_GET['dropdown_background_color'] != '') { ?>
	.dropdown-menu,
	.ui-autocomplete,
	.modal-content,
	.modal-footer,
	.review-list .text,
	.my-mfp-zoom-in .mfp-content,
	.cart-module > div {
		background: #<?php echo $_GET['dropdown_background_color']; ?> !important;
	}
	
	.review-list .text:after,
	.cart-module > div:after {
		border-bottom-color: #<?php echo $_GET['dropdown_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['dropdown_item_hover_background_color'] != '') { ?>
	.dropdown-menu > li > a:hover,
	.dropdown-menu > li > a:focus,
	.ui-autocomplete li a.ui-state-focus {
		background-color: #<?php echo $_GET['dropdown_item_hover_background_color']; ?> !important;
	}
	
	@media (max-width: 960px) {
		.responsive ul.megamenu > li.active > a,
		.responsive ul.megamenu > li:hover > a,
		.responsive ul.megamenu > li.active .close-menu {
			background-color: #<?php echo $_GET['dropdown_item_hover_background_color']; ?> !important;
		}
	}
	<?php } ?>
	
	<?php if($_GET['input_text_color'] != '') { ?>
	textarea, 
	input[type="text"], 
	input[type="password"], 
	input[type="datetime"], 
	input[type="datetime-local"], 
	input[type="date"], 
	input[type="month"], 
	input[type="time"], 
	input[type="week"], 
	input[type="number"], 
	input[type="email"], 
	input[type="url"], 
	input[type="search"], 
	input[type="tel"], 
	input[type="color"], 
	.uneditable-input,
	select,
	.product-info .cart .add-to-cart .quantity #q_up,
	.product-info .cart .add-to-cart .quantity #q_down {
		color: #<?php echo $_GET['input_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['input_border_color'] != '') { ?>
	textarea, 
	input[type="text"], 
	input[type="password"], 
	input[type="datetime"], 
	input[type="datetime-local"], 
	input[type="date"], 
	input[type="month"], 
	input[type="time"], 
	input[type="week"], 
	input[type="number"], 
	input[type="email"], 
	input[type="url"], 
	input[type="search"], 
	input[type="tel"], 
	input[type="color"], 
	.uneditable-input,
	select,
	.product-info .cart .add-to-cart .quantity #q_up,
	.product-info .cart .add-to-cart .quantity #q_down {
		border-color: #<?php echo $_GET['input_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['input_focus_border_color'] != '') { ?>
	textarea:focus,
		input[type="text"]:focus,
		input[type="password"]:focus,
		input[type="datetime"]:focus,
		input[type="datetime-local"]:focus,
		input[type="date"]:focus,
		input[type="month"]:focus,
		input[type="time"]:focus,
		input[type="week"]:focus,
		input[type="number"]:focus,
		input[type="email"]:focus,
		input[type="url"]:focus,
		input[type="search"]:focus,
		input[type="tel"]:focus,
		input[type="color"]:focus,
		.uneditable-input:focus {
		border-color: #<?php echo $_GET['input_focus_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['input_background_color'] != '') { ?>
	textarea, 
	input[type="text"], 
	input[type="password"], 
	input[type="datetime"], 
	input[type="datetime-local"], 
	input[type="date"], 
	input[type="month"], 
	input[type="time"], 
	input[type="week"], 
	input[type="number"], 
	input[type="email"], 
	input[type="url"], 
	input[type="search"], 
	input[type="tel"], 
	input[type="color"], 
	.uneditable-input,
	select {
		background-color: #<?php echo $_GET['input_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['table_border_color'] != '') { ?>
	table.attribute,
	table.list,
	.wishlist-product table,
	.wishlist-info table,
	.compare-info,
	.cart-info table,
	.checkout-product table,
	.table,
	table.attribute td,
	table.list td,
	.wishlist-product table td,
	.wishlist-info table td,
	.compare-info td,
	.cart-info table td,
	.checkout-product table td,
	.table td ,
	.manufacturer-list,
	.manufacturer-heading,
	.center-column .panel-body,
	.review-list .text,
	.checkout-content,
	.cart-module > div,
	.download-list .download-content, .order-list .order-content,
	.return-list .return-content {
		border-color: #<?php echo $_GET['table_border_color']; ?>;
	}
	
	.review-list .text:before,
	.cart-module > div:before {
		border-bottom-color: #<?php echo $_GET['table_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['top_bar_text_color'] != '') { ?>
	#top-bar .container,
	#top-bar .container > div > div > div > a,
	#top-bar .container > div > div > form > div > a,
	#top-bar .top-bar-links li a {
		color: #<?php echo $_GET['top_bar_text_color']; ?>;
	}
	
	#top-bar .dropdown .caret {
		border-top-color: #<?php echo $_GET['top_bar_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['top_bar_border_color'] != '') { ?>
	#top-bar .dropdown {
		border-color: #<?php echo $_GET['top_bar_border_color']; ?> !important;
	}
	<?php } ?>
	
	<?php if($_GET['top_bar_background_color'] != '') { ?>
	#top-bar .background {
		background-color: #<?php echo $_GET['top_bar_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['top_links_color'] != '') { ?>
	#top .header-links li a {
		color: #<?php echo $_GET['top_links_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['search_input_text_color'] != '') { ?>
	#top .search_form input,
	.search_form .button-search, 
	.search_form .button-search2 {
		color: #<?php echo $_GET['search_input_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['search_input_border_color'] != '') { ?>
	#top .search_form input {
		border-color: #<?php echo $_GET['search_input_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['search_input_focus_border_color'] != '') { ?>
	#top .search_form input:focus {
		border-color: #<?php echo $_GET['search_input_focus_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['search_input_background_color'] != '') { ?>
	#top .search_form input {
		background-color: #<?php echo $_GET['search_input_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['price_in_cart_color'] != '') { ?>
	#top #cart_block .cart-heading span {
		color: #<?php echo $_GET['price_in_cart_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['top_background_gradient_top'] != '' && $_GET['top_background_gradient_bottom'] != '') { ?>
	#top .background {
		background: #<?php echo $_GET['top_background_gradient_bottom']; ?>; /* Old browsers */
		background: -moz-linear-gradient(top, #<?php echo $_GET['top_background_gradient_bottom']; ?> 0%, #<?php echo $_GET['top_background_gradient_top']; ?> 0%, #<?php echo $_GET['top_background_gradient_bottom']; ?> 99%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#<?php echo $_GET['top_background_gradient_bottom']; ?>), color-stop(0%,#<?php echo $_GET['top_background_gradient_top']; ?>), color-stop(99%,#<?php echo $_GET['top_background_gradient_bottom']; ?>)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, #<?php echo $_GET['top_background_gradient_bottom']; ?> 0%,#<?php echo $_GET['top_background_gradient_top']; ?> 0%,#<?php echo $_GET['top_background_gradient_bottom']; ?> 99%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, #<?php echo $_GET['top_background_gradient_bottom']; ?> 0%,#<?php echo $_GET['top_background_gradient_top']; ?> 0%,#<?php echo $_GET['top_background_gradient_bottom']; ?> 99%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, #<?php echo $_GET['top_background_gradient_bottom']; ?> 0%,#<?php echo $_GET['top_background_gradient_top']; ?> 0%,#<?php echo $_GET['top_background_gradient_bottom']; ?> 99%); /* IE10+ */
		background: linear-gradient(to bottom, #<?php echo $_GET['top_background_gradient_bottom']; ?> 0%,#<?php echo $_GET['top_background_gradient_top']; ?> 0%,#<?php echo $_GET['top_background_gradient_bottom']; ?> 99%); /* W3C */
	}
	<?php } ?>
	
	<?php if($_GET['menu_main_links_color'] != '') { ?>
	ul.megamenu > li > a,
	.megamenuToogle-wrapper .container .background-megamenu {
		color: #<?php echo $_GET['menu_main_links_color']; ?>;
	}
	
	.megamenuToogle-wrapper .container > div span {
		background: #<?php echo $_GET['menu_main_links_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['menu_main_links_hover_color'] != '') { ?>
	ul.megamenu > li > a:hover, 
	ul.megamenu > li.active > a {
		color: #<?php echo $_GET['menu_main_links_hover_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['menu_main_links_hover_border_bottom'] != '') { ?>
	ul.megamenu > li > a:before {
		background: #<?php echo $_GET['menu_main_links_hover_border_bottom']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['menu_icon_home_color'] != '') { ?>
	ul.megamenu > li > a > .fa-home {
		color: #<?php echo $_GET['menu_icon_home_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['menu_background_gradient_top'] != '' && $_GET['menu_background_gradient_bottom'] != '') { ?>
	.megamenu-wrapper,
	.megamenuToogle-wrapper {
		background: #<?php echo $_GET['menu_background_gradient_bottom']; ?>; /* Old browsers */
		background: -moz-linear-gradient(top, #<?php echo $_GET['menu_background_gradient_bottom']; ?> 0%, #<?php echo $_GET['menu_background_gradient_top']; ?> 0%, #<?php echo $_GET['menu_background_gradient_bottom']; ?> 99%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#<?php echo $_GET['menu_background_gradient_bottom']; ?>), color-stop(0%,#<?php echo $_GET['menu_background_gradient_top']; ?>), color-stop(99%,#<?php echo $_GET['menu_background_gradient_bottom']; ?>)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, #<?php echo $_GET['menu_background_gradient_bottom']; ?> 0%,#<?php echo $_GET['menu_background_gradient_top']; ?> 0%,#<?php echo $_GET['menu_background_gradient_bottom']; ?> 99%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, #<?php echo $_GET['menu_background_gradient_bottom']; ?> 0%,#<?php echo $_GET['menu_background_gradient_top']; ?> 0%,#<?php echo $_GET['menu_background_gradient_bottom']; ?> 99%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, #<?php echo $_GET['menu_background_gradient_bottom']; ?> 0%,#<?php echo $_GET['menu_background_gradient_top']; ?> 0%,#<?php echo $_GET['menu_background_gradient_bottom']; ?> 99%); /* IE10+ */
		background: linear-gradient(to bottom, #<?php echo $_GET['menu_background_gradient_bottom']; ?> 0%,#<?php echo $_GET['menu_background_gradient_top']; ?> 0%,#<?php echo $_GET['menu_background_gradient_bottom']; ?> 99%); /* W3C */
	}
	<?php } ?>
	
	<?php if($_GET['menu_icon_plus_minus_color'] != '') { ?>
	@media (max-width: 960px) {
		.responsive ul.megamenu > li.click:before, 
		.responsive ul.megamenu > li.hover:before,
		.responsive ul.megamenu > li.active .close-menu:before {
			color: #<?php echo $_GET['menu_icon_plus_minus_color']; ?>;
		}
	}
	<?php } ?>
	
	<?php if($_GET['submenu_text_color'] != '') { ?>
	ul.megamenu li .sub-menu .content {
		color: #<?php echo $_GET['submenu_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['submenu_link_color'] != '') { ?>
	ul.megamenu li .sub-menu .content a {
		color: #<?php echo $_GET['submenu_link_color']; ?>;
	}
	
	@media (max-width: 960px) {
		.responsive ul.megamenu > li > a {
			color: #<?php echo $_GET['submenu_link_color']; ?>;
		}
	}
	<?php } ?>
	
	<?php if($_GET['submenu_link_hover_color'] != '') { ?>
	ul.megamenu li .sub-menu .content a:hover {
		color: #<?php echo $_GET['submenu_link_hover_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['submenu_border_color'] != '') { ?>
	ul.megamenu li .sub-menu .content {
		border-color: #<?php echo $_GET['submenu_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['submenu_background_color'] != '') { ?>
	ul.megamenu li .sub-menu .content {
		background-color: #<?php echo $_GET['submenu_background_color']; ?>;
	}
	
	@media (max-width: 960px) {
		.responsive .megamenu-wrapper {
			background-color: #<?php echo $_GET['submenu_background_color']; ?> !important;
		}
	}
	<?php } ?>
	
	<?php if($_GET['button_text_color'] != '') { ?>
	.button,
	.btn {
		color: #<?php echo $_GET['button_text_color']; ?> !important;
	}
	<?php } ?>
	
	<?php if($_GET['button_background_color'] != '') { ?>
	.button,
	.btn {
		background: #<?php echo $_GET['button_background_color']; ?>;
		border-color: #<?php echo $_GET['button_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['button_hover_text_color'] != '') { ?>
	.button:hover,
	.btn:hover {
		color: #<?php echo $_GET['button_hover_text_color']; ?> !important;
	}
	<?php } ?>
	
	<?php if($_GET['button_hover_background_color'] != '') { ?>
	.button:hover,
	.btn:hover {
		background: #<?php echo $_GET['button_hover_background_color']; ?>;
		border-color: #<?php echo $_GET['button_hover_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['second_button_text_color'] != '') { ?>
	.buttons .left .button,
	.buttons .center .button,
	.btn-default,
	.input-group-btn .btn-primary {
		color: #<?php echo $_GET['second_button_text_color']; ?> !important;
	}
	<?php } ?>
	
	<?php if($_GET['second_button_border_color'] != '') { ?>
	.buttons .left .button,
	.buttons .center .button,
	.btn-default,
	.input-group-btn .btn-primary{
		border-color: #<?php echo $_GET['second_button_border_color']; ?> !important;
	}
	<?php } ?>
	
	<?php if($_GET['second_button_background_color'] != '') { ?>
	.buttons .left .button,
	.buttons .center .button,
	.btn-default,
	.input-group-btn .btn-primary{
		background-color: #<?php echo $_GET['second_button_background_color']; ?> !important;
	}
	<?php } ?>
	
	<?php if($_GET['second_button_hover_text_color'] != '') { ?>
	.buttons .left .button:hover,
	.buttons .center .button:hover,
	.btn-default:hover,
	.input-group-btn .btn-primary:hover {
		color: #<?php echo $_GET['second_button_hover_text_color']; ?> !important;
	}
	<?php } ?>
	
	<?php if($_GET['second_button_hover_border_color'] != '') { ?>
	.buttons .left .button:hover,
	.buttons .center .button:hover,
	.btn-default:hover,
	.input-group-btn .btn-primary:hover {
		border-color: #<?php echo $_GET['second_button_hover_border_color']; ?> !important;
	}
	<?php } ?>
	
	<?php if($_GET['second_button_hover_background_color'] != '') { ?>
	.buttons .left .button:hover,
	.buttons .center .button:hover,
	.btn-default:hover,
	.input-group-btn .btn-primary:hover {
		background-color: #<?php echo $_GET['second_button_hover_background_color']; ?> !important;
	}
	<?php } ?>
	
	<?php if($_GET['carousel_button_background'] != '') { ?>
	.tab-content .prev-button, 
	.tab-content .next-button,
	.box > .prev, 
	.box > .next,
	.jcarousel-control-prev,
	.jcarousel-control-next {
		background: #<?php echo $_GET['carousel_button_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['carousel_button_hover_background'] != '') { ?>
	.tab-content .prev-button:hover, 
	.tab-content .next-button:hover,
	.box > .prev:hover, 
	.box > .next:hover,
	.jcarousel-control-prev:hover,
	.jcarousel-control-next:hover {
		background: #<?php echo $_GET['carousel_button_hover_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['carousel_bullet_background'] != '') { ?>
	.carousel-indicators li {
		background: #<?php echo $_GET['carousel_bullet_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['carousel_bullet_active_background'] != '') { ?>
	.carousel-indicators .active {
		background: #<?php echo $_GET['carousel_bullet_active_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['slider_button_background'] != '') { ?>
	.camera_wrap .owl-controls .owl-buttons .owl-next:before,
		.camera_wrap .owl-controls .owl-buttons .owl-prev:before,
	.nivo-directionNav a,
	.fullwidthbanner-container .tp-leftarrow,
	.fullwidthbanner-container .tp-rightarrow {
		background: #<?php echo $_GET['slider_button_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['slider_bullet_background'] != '') { ?>
	.camera_wrap .owl-controls .owl-pagination span,
	.tp-bullets .bullet {
		background: #<?php echo $_GET['slider_bullet_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['slider_bullet_active_background'] != '') { ?>
	.tp-bullets .selected, 
	.tp-bullets .bullet:hover,
	.camera_wrap .owl-controls .owl-pagination .active span {
		background: #<?php echo $_GET['slider_bullet_active_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_grid_button_text_color'] != '') { ?>
	.product-grid .product .image .product-actions a {
		color: #<?php echo $_GET['product_grid_button_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_grid_button_background_color'] != '') { ?>
	.product-grid .product .image .product-actions a {
		background: #<?php echo $_GET['product_grid_button_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_grid_button_hover_text_color'] != '') { ?>
	.product-grid .product .image .product-actions a:hover {
		color: #<?php echo $_GET['product_grid_button_hover_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_grid_button_hover_background_color'] != '') { ?>
	.product-grid .product .image .product-actions a:hover {
		background: #<?php echo $_GET['product_grid_button_hover_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_list_button_text_color'] != '') { ?>
	.product-list .product-actions div a {
		color: #<?php echo $_GET['product_list_button_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_list_button_border_color'] != '') { ?>
	.product-list .product-actions div a {
		border-color: #<?php echo $_GET['product_list_button_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_list_button_background_color'] != '') { ?>
	.product-list .product-actions div a {
		background-color: #<?php echo $_GET['product_list_button_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_list_button_hover_text_color'] != '') { ?>
	.product-list .product-actions div a:hover {
		color: #<?php echo $_GET['product_list_button_hover_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_list_button_hover_border_color'] != '') { ?>
	.product-list .product-actions div a:hover {
		border-color: #<?php echo $_GET['product_list_button_hover_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_list_button_hover_background_color'] != '') { ?>
	.product-list .product-actions div a:hover {
		background-color: #<?php echo $_GET['product_list_button_hover_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['sale_color_text'] != '') { ?>
	.sale {
		color: #<?php echo $_GET['sale_color_text']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['sale_background_color'] != '') { ?>
	.sale {
		background: #<?php echo $_GET['sale_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['rating_icon_background_color'] != '') { ?>
	.rating i {
		color: #<?php echo $_GET['rating_icon_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['rating_icon_active_background_color'] != '') { ?>
	.rating i.active {
		color: #<?php echo $_GET['rating_icon_active_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['custom_block_border_color'] != '') { ?>
	.product-block {
		border-color: #<?php echo $_GET['custom_block_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['box_categories_border_color'] != '') { ?>
	.box-category {
		border-color: #<?php echo $_GET['box_categories_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['box_categories_links_active_color'] != '') { ?>
	.box-category ul li a.active {
		color: #<?php echo $_GET['box_categories_links_active_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_filter_icon_color'] != '') { ?>
	.product-filter .options .button-group button {
		color: #<?php echo $_GET['product_filter_icon_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_filter_icon_hover_color'] != '') { ?>
	.product-filter .options .button-group button:hover, 
	.product-filter .options .button-group .active {
		color: #<?php echo $_GET['product_filter_icon_hover_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['tab_link_color'] != '') { ?>
	.htabs a,
	.filter-product .filter-tabs ul > li > a {
		color: #<?php echo $_GET['tab_link_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['tab_link_active_color'] != '') { ?>
	.htabs a.selected,
	.htabs a:hover,
	.filter-product .filter-tabs ul > li.active > a, 
	.filter-product .filter-tabs ul > li > a:hover, 
	.filter-product .filter-tabs ul > li.active > a:focus {
		color: #<?php echo $_GET['tab_link_active_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['tab_link_active_border_color'] != '') { ?>
	.htabs a.selected {
		border-color: #<?php echo $_GET['tab_link_active_border_color']; ?>;
	}
	
	.filter-product .filter-tabs ul > li:before {
		background: #<?php echo $_GET['tab_link_active_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['pagination_link_border_color'] != '') { ?>
	div.pagination-results ul li,
	div.pagination .links a,
	div.pagination .links b {
		border-color: #<?php echo $_GET['pagination_link_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['pagination_link_active_border_color'] != '') { ?>
	div.pagination-results ul li.active,
	div.pagination .links b {
		border-color: #<?php echo $_GET['pagination_link_active_border_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['customfooter_text_color'] != '') { ?>
	.custom-footer .pattern,
	ul.contact-us li {
		color: #<?php echo $_GET['customfooter_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['customfooter_headlines_color'] != '') { ?>
	.custom-footer h4 {
		color: #<?php echo $_GET['customfooter_headlines_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['customfooter_icon_phone_background_color'] != '') { ?>
	ul.contact-us li i.fa-phone {
		background: #<?php echo $_GET['customfooter_icon_phone_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['customfooter_icon_mail_background_color'] != '') { ?>
	ul.contact-us li i.fa-envelope {
		background: #<?php echo $_GET['customfooter_icon_mail_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['customfooter_icon_skype_background_color'] != '') { ?>
	ul.contact-us li i.fa-skype {
		background: #<?php echo $_GET['customfooter_icon_skype_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['customfooter_background_color'] != '') { ?>
	.custom-footer .background,
	.standard-body .custom-footer .background {
		background: #<?php echo $_GET['customfooter_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['footer_text_color'] != '') { ?>
	.footer .pattern,
	.footer .pattern a,
	.copyright .pattern,
	.copyright .pattern a {
		color: #<?php echo $_GET['footer_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['footer_headlines_color'] != '') { ?>
	.footer h4 {
		color: #<?php echo $_GET['footer_headlines_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['footer_background_color'] != '') { ?>
	.footer .background,
	.standard-body .footer .background,
	.copyright .background,
	.standard-body .copyright .background {
		background-color: #<?php echo $_GET['footer_background_color']; ?>;
	}
	<?php } ?>
<?php } ?>

<?php if($_GET['font_status'] == '1') { ?>
body {
	font-size: <?php echo $_GET['body_font_px']; ?>px;
	font-weight: <?php echo $_GET['body_font_weight']*100; ?>;
	<?php if(isset($_GET['body_font'])) { ?>
	font-family: <?php echo $_GET['body_font']; ?>;
	<?php } ?>
}

#top-bar .container, 
#top .header-links li a, 
.sale {
	font-size: <?php echo $_GET['body_font_smaller_px']; ?>px;
}

ul.megamenu > li > a strong {
	font-size: <?php echo $_GET['categories_bar_px']; ?>px;
	font-weight: <?php echo $_GET['categories_bar_weight']*100; ?>;
	<?php if(isset($_GET['categories_bar_font'])) { ?>
	font-family: <?php echo $_GET['categories_bar_font']; ?>;
	<?php } ?>
}

.megamenuToogle-wrapper .container {
	font-weight: <?php echo $_GET['categories_bar_weight']*100; ?>;
	<?php if(isset($_GET['categories_bar_font'])) { ?>
	font-family: <?php echo $_GET['categories_bar_font']; ?>;
	<?php } ?>
}

.box .box-heading,
.center-column h1, 
.center-column h2, 
.center-column h3, 
.center-column h4, 
.center-column h5, 
.center-column h6,
.filter-product .filter-tabs,
.htabs a,
legend {
	font-size: <?php echo $_GET['headlines_px']; ?>px;
	font-weight: <?php echo $_GET['headlines_weight']*100; ?>;
	<?php if(isset($_GET['headlines_font'])) { ?>
	font-family: <?php echo $_GET['headlines_font']; ?>;
	<?php } ?>
	text-transform: <?php if($_GET['headlines_transform'] == 1) { echo 'uppercase'; } else { echo 'none'; } ?>;
}

.footer h4,
.custom-footer h4 {
	font-size: <?php echo $_GET['footer_headlines_px']; ?>px;
	font-weight: <?php echo $_GET['footer_headlines_weight']*100; ?>;
	<?php if(isset($_GET['footer_headlines_font'])) { ?>
	font-family: <?php echo $_GET['footer_headlines_font']; ?>;
	<?php } ?>
	text-transform: <?php if($_GET['footer_headlines_transform'] == 1) { echo 'uppercase'; } else { echo 'none'; } ?>;
}

.breadcrumb .container h2 {
	font-size: <?php echo $_GET['page_name_px']; ?>px;
	font-weight: <?php echo $_GET['page_name_weight']*100; ?>;
	<?php if(isset($_GET['page_name_font'])) { ?>
	font-family: <?php echo $_GET['page_name_font']; ?>;
	<?php } ?>
	text-transform: <?php if($_GET['page_name_transform'] == 1) { echo 'uppercase'; } else { echo 'none'; } ?>;
}

.button,
.btn {
	font-size: <?php echo $_GET['button_font_px']; ?>px;
	font-weight: <?php echo $_GET['button_font_weight']*100; ?> !important;
	text-transform: <?php if($_GET['button_font_transform'] == 1) { echo 'uppercase'; } else { echo 'none'; } ?>;
	<?php if(isset($_GET['button_font'])) { ?>
	font-family: <?php echo $_GET['button_font']; ?>;
	<?php } ?>
}

<?php if(isset($_GET['custom_price_font'])) { ?>
.product-grid .product .price, 
.hover-product .price, 
.product-list .price, 
.product-info .price .price-new,
ul.megamenu li .product .price,
#top #cart_block .cart-heading span,
.mini-cart-info td.total,
.mini-cart-total td:last-child {
	font-family: <?php echo $_GET['custom_price_font']; ?>;
}
<?php } ?>

.product-grid .product .price,
ul.megamenu li .product .price,
.product-list .price,
.mini-cart-info td.total {
	font-size: <?php echo $_GET['custom_price_px_small']; ?>px;
	font-weight: <?php echo $_GET['custom_price_weight']*100; ?>;
}

.mini-cart-total td:last-child,
.cart-total table tr td:last-child {
	font-weight: <?php echo $_GET['custom_price_weight']*100; ?>;
}

.product-info .price .price-new {
	font-size: <?php echo $_GET['custom_price_px']; ?>px;
	font-weight: <?php echo $_GET['custom_price_weight']*100; ?>;
}

#top #cart_block .cart-heading span {
	font-size: <?php echo $_GET['custom_price_px_medium']; ?>px;
	font-weight: <?php echo $_GET['custom_price_weight']*100; ?>;
}

.price-old {
	font-size: <?php echo $_GET['custom_price_px_old_price']; ?>px;
}
<?php } ?>