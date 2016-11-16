<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
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
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>

<?php } ?>
<!--[if IE 7]> 
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php if ($stores) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
<?php foreach ($stores as $store) { ?>
$('body').prepend('<iframe src="<?php echo $store; ?>" style="display: none;"></iframe>');
<?php } ?>
});
//--></script>
<?php } ?>
<?php echo $google_analytics; ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="catalog/view/javascript/fancybox/jquery.fancybox.css" rel="stylesheet" />
<script src="catalog/view/javascript/fancybox/jquery.fancybox.pack.js"></script>
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet" />
<link href="catalog/view/theme/default/stylesheet/main.css" rel="stylesheet" />
<link href="catalog/view/theme/default/stylesheet/media.css" rel="stylesheet" />
<link href="catalog/view/theme/default/stylesheet/fonts.css" />
</head>
<body class="<?php echo $class; ?>">
<div id="wrapper">
<div id="header">
  <?php if ($logo) { ?>
  <div id="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></div>
  <?php } ?>
  <?php echo $language; ?>
  <?php echo $currency; ?>
  <?php echo $cart; ?>

   <ul class="list-inline">

             </div>
  
</div>
<?php if ($categories) { ?>
<div class="menu-line">
  <div class="container">
    <nav id="menu" class="navbar">
      <div class="navbar-header"><span id="category" class="visible-xs"><?php echo $text_category; ?></span>
        <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
      </div>
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
          <?php foreach ($categories as $category) { ?>
          <?php if ($category['children']) { ?>
          <li class="dropdown"><a href="<?php echo $category['href']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $category['name']; ?></a>
            <div class="dropdown-menu">
              <div class="dropdown-inner">
                <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
                <ul class="list-unstyled">
                  <?php foreach ($children as $child) { ?>
                  <li class="li-child"><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
                  <?php } ?>
                </ul>
                 <?php } ?>
              </div>
              <a href="<?php echo $category['href']; ?>" class="see-all"><?php echo $text_all; ?> <?php echo $category['name']; ?></a> </div>
              <img src="catalog/view/theme/default/image/border-right-img-li.png" height="91" width="4" alt="" />
          </li>
         <?php } else { ?>
                <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a><img src="catalog/view/theme/my-theme/image/border-right-img-li.png" height="91" width="4" alt="" /></li>
          <?php } ?>
          <?php } ?>
<li><a href="http://driveavto.com.ua/autoparts/">Каталог</a></li>
        </ul>
        <?php } ?>
      </div>
   </div>
</div>

<?php if ($error) { ?>
    
    <div class="warning"><?php echo $error ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
    
<?php } ?>

				<?php if($ajaxadvancesearch_status){ ?>
				<!--
				/**
					*Ajax advanced search starts
					*/
				-->
				<script type="text/javascript" language="javascript"><!--
					// Ajax advanced search starts
					$(document).ready(function(){
						
						$('input[name="search"]').autocomplete({
							delay: 500,
							source: function(request, response) {
								$.ajax({
									url: 'index.php?route=common/header/ajaxLiveSearch&filter_name=' +  encodeURIComponent(request.term),
									dataType: 'json',
									success: function(json) {
										response($.map(json, function(item) {
											return {
												label: item.name,
												name: item.name1,
												value: item.product_id,
												model: item.model,
												stock_status: item.stock_status,
												image: item.image,
												manufacturer: item.manufacturer,
												price: item.price,
												special: item.special,
												category: item.category,
												rating: item.rating,
												reviews: item.reviews,
											}
										}));
									}
								});
							}, 
							select: function(event, ui) {
								if(ui.item.value){
									location = 'index.php?route=product/product/&product_id='+ui.item.value;
								}else{
									$('.button-search').trigger('click');
								}
								return false;
							},
							focus: function(event, ui) {
								return false;
							}
						}).data("autocomplete")._renderItem = function(ul, item){
								var html = '<div id="ajaxadvance">';
									if(item.product_id!=0){
										html += '<div class="image">';
										if(item.image){
										html += '<img title="'+item.name+'" src="'+item.image+'"/>';
										}
										html += '</div>';
										html += '<div class="content">';
										html += 	'<h3 class="name">'+item.label+'</h3>';
										if(item.model){
										html += 	'<div class="model">';
										html +=		'<?php echo $ajaxadvancedsearch_model; ?> '+ item.model;
										html +=		'</div>';
										}
										if(item.manufacturer){
										html += 	'<div class="manufacturer">';
										html +=		'<?php echo $ajaxadvancedsearch_manufacturer; ?> '+ item.manufacturer;			
										html +=		'</div>';		
										}
										if(item.price){
										html += 	'<div class="price"> <?php echo $ajaxadvancedsearch_price; ?> ';
											if (!item.special) { 
										html +=			 item.price;
											} else {	
										html +=			'<span class="price-old">'+ item.price +'</span> <span class="price-new">'+ item.special +'</span>';
											}	
										html +=		'</div>';
										}
										if(item.stock_status){
										html += 	'<div class="stock_status">';
										html +=		'<?php echo $ajaxadvancedsearch_stock; ?> '+ item.stock_status;			
										html +=		'</div>';
										}
										if (item.rating) {
										html +=		'<div class="rating"> <?php echo $ajaxadvancedsearch_rating; ?> <img src="catalog/view/theme/default/image/stars-'+ item.rating+ '.png" alt="'+ item. reviews +'" /></div>';
										}
										html +='</div>';
									}
								html += '</div>';
								return $('<li></li>')
									 .data('item.autocomplete', item)
									 .append('<a>' + html + '</a>')
									 .appendTo(ul);
						};
					});
					//Ajax advanced search ends
				//--></script>
				<style>
				.ui-menu {z-index: 666 !important; background: #fff; }
				.ui-menu li:nth-child(even){background: #FFFFFF;  border: 1px solid #dbdee1;}
				.ui-menu li:nth-child(odd){background: #E4EEF7;  border: 1px solid #fff;}
				.ui-menu li, .ui-menu .ui-menu-item { margin-bottom: 10px;}
				.ui-menu a {border-radius: 0 ;}
				#ajaxadvance { display:inline-flex; }
				#ajaxadvance .name { margin:0; }
				#ajaxadvance .image { display:inline-block; float: left;	margin-right:10px; width: <?php echo $ajaxadvancesearch_imagewidth;?>px;}
				#ajaxadvance .content { display:inline-block; max-width: 300px;}
				#ajaxadvance .content > div { margin-top:5px;	}
				#ajaxadvance .price-old {color: #ff0000; text-decoration: line-through; }
				#ajaxadvance .highlight {color: #38b0e3; }
				</style>
				<!--
				/**
					*Ajax advanced search ends
					*/
				-->
				<?php } ?>
			
<div id="notification"></div>
