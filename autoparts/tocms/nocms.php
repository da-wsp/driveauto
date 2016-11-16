<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();

//Add to cart
if(defined('TDM_ADD_TO_CART') AND TDM_ADD_TO_CART){
	global $arCartPrice;
	//echo '<pre>'; print_r($arCartPrice); echo '</pre>';
}
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
		<?=$TDMContent;?>
	</div>
</body>
</html>