<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();

//Header
require($_SERVER["DOCUMENT_ROOT"].'/wp-blog-header.php');
get_header();

//Add to cart
if(defined('TDM_ADD_TO_CART') AND TDM_ADD_TO_CART){
	$CART_ITEM_ID = 2706;
	global $arCartPrice;
	if(is_array($arCartPrice)){
		if($arCartPrice['OPTIONS']['MINIMUM']>1){$QUANTITY=$arCartPrice['OPTIONS']['MINIMUM'];}else{$QUANTITY=1;}
		$arParams = array();
		$arParams['tecdoc'] = 1;
		$arParams['unit_price'] = $arCartPrice['PRICE_CONVERTED'];
		$arParams['tecdoc_brand'] = $arCartPrice['BRAND'];
		$arParams['tecdoc_name'] = $arCartPrice['NAME'].' ['.$arCartPrice['ARTICLE'].']';
		$arParams['quantity'] = $QUANTITY;
		$arParams['product_url'] = $arCartPrice['ADD_URL'];
		$arParams['tecdoc_day'] = $arCartPrice['DAY'];
		$arParams['tecdoc_supplier'] = $arCartPrice['SUPPLIER_STOCK'];
		$arParams['tecdoc_available'] = $arCartPrice['AVAILABLE'];
		$arParams['custom_message'] = $arCartPrice['NAME'].' ('.$arCartPrice['ARTICLE'].') '.$arCartPrice['BRAND'].' :: Поставщик '.$arCartPrice['SUPPLIER_STOCK'].' :: '.$arCartPrice['PRICE'].' '.$arCartPrice['CURRENCY'];
		if($arCartPrice['OPTIONS']['WEIGHT']>0){
			$arParams['weight']=$arCartPrice['OPTIONS']['WEIGHT'];
		}
		//$arParams['sku'] = $arCartPrice['AVAILABLE'];
		$arParams['tecdoc_img'] = $arCartPrice['IMG_SRC'];
		global $wpsc_cart;
		$status = $wpsc_cart->set_item($CART_ITEM_ID, $arParams, false);
		//echo '<pre>';print_r($status);echo '</pre>';
		
		
		
	}
}
//global $wpsc_cart;
//echo '<pre>';print_r($wpsc_cart->cart_items);echo '</pre>';

	
//TDMod content
echo $TDMContent;

//Footer
get_footer();

/*
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8" />
<title><?=TDM_TITLE?></title>
<meta name="keywords" content="<?=TDM_KEYWORDS?>" />
<meta name="description" content="<?=TDM_DESCRIPTION?>" />
</head>
<body>
	<div style="width:980px; margin:0px auto 0px auto;">
		<b>WordPress CMS integration in progreess...<br><br></b>
		<?=$TDMContent;?>
	</div>
</body>
</html>
*/?>