<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();

//com_jshopping
function JoomlaJShoppingAddToCart(){
	if(defined('TDM_ADD_TO_CART') AND TDM_ADD_TO_CART){
		global $arCartPrice;
		if(is_array($arCartPrice)){
			$CurQNT = intval($_SESSION['tdm_cart'][$arCartPrice['CPID']]['quantity']);
			if($CurQNT>0){
				$CurQNT = $CurQNT+1;
				if($CurQNT>$arCartPrice['AVAILABLE']){$CurQNT=$arCartPrice['AVAILABLE'];}
				$_SESSION['tdm_cart'][$arCartPrice['CPID']]['quantity'] = $CurQNT;
			}else{
				$arTDCart = array();
				$arTDCart['tdm'] = "Y";
				//$arTDCart['product_id'] = 0;
				//$arTDCart['category_id'] = 0;
				$arTDCart['price'] = $arCartPrice['PRICE_CONVERTED'];
				$arTDCart['quantity'] = 1;
				$arTDCart['name'] = $arCartPrice['NAME'];
				$arTDCart['available'] = $arCartPrice['AVAILABLE'];
				$arTDCart['image'] = $arCartPrice['IMG_SRC'];
				$arTDCart['brand'] = $arCartPrice['BRAND'];
				$arTDCart['product_url'] = $arCartPrice['ADD_URL'];
				$arTDCart['day'] = $arCartPrice['DAY'];
				$arTDCart['supplier'] = $arCartPrice['SUPPLIER_STOCK'];
				$arTDCart['article'] = $arCartPrice['ARTICLE'];
				$_SESSION['tdm_cart'][$arCartPrice['CPID']] = $arTDCart;
			}
			return true;
		}
	}
	return false;
}


//global $TDMContent; defined for print TDM content in Joomla main template
//Run Joomla:
define('_JREQUEST_NO_CLEAN',true);
$_SERVER['REQUEST_URI']='/';
$_SERVER['SCRIPT_NAME']='/index.php';
chdir($_SERVER["DOCUMENT_ROOT"]);
require($_SERVER["DOCUMENT_ROOT"]."/index.php");




?>