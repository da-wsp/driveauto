<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();

//User group price type - from 1 to 5
if(!TDM_ISADMIN){
	global $TDMCore;
	$arPGID = $TDMCore->arPriceGID;
	foreach($arPGID as $TDM_GID=>$CMS_GID){
		if($_SESSION['TDM_CMS_USER_GROUP']==$CMS_GID){
			if($_SESSION['TDM_USER_GROUP']!=$TDM_GID){$_SESSION['TDM_USER_GROUP']=$TDM_GID; Header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);}
			break;
		} 
	}
}

//Add to cart
if(defined('TDM_ADD_TO_CART') AND TDM_ADD_TO_CART){
	global $arCartPrice;
	if(is_array($arCartPrice)){
		$OC_CURRENCY = $_SESSION['TDM_CMS_DEFAULT_CUR'];
		if($OC_CURRENCY==''){$OC_CURRENCY=TDM_CUR;}
		if($arCartPrice['OPTIONS']['MINIMUM']>1){$QUANTITY=$arCartPrice['OPTIONS']['MINIMUM'];}else{$QUANTITY=1;}
		$arOCBasket = array();
		$arOCBasket['tecdoc'] = "Y";
		$arOCBasket['product_id'] = $arCartPrice['CPID'];
		$arOCBasket['key'] = $arCartPrice['CPID'];
		$arOCBasket['price'] = TDMConvertPrice($arCartPrice['CURRENCY'],$OC_CURRENCY,$arCartPrice['PRICE']); 
		$arOCBasket['quantity'] = $QUANTITY;
		$arOCBasket['stock'] = $arCartPrice['AVAILABLE'];
		$arOCBasket['name'] = $arCartPrice['NAME'];
		$arOCBasket['image'] = $arCartPrice['IMG_SRC'];
		$arOCBasket['brand'] = $arCartPrice['BRAND'];
		$arOCBasket['product_url'] = $arCartPrice['ADD_URL'];
		$arOCBasket['day'] = $arCartPrice['DAY'];
		$arOCBasket['article'] = $arCartPrice['ARTICLE'];
		//Minimum
		$arOCBasket['minimum'] = 1;
		if($arCartPrice['OPTIONS']['MINIMUM']>0){ $arOCBasket['minimum']=$arCartPrice['OPTIONS']['MINIMUM']; }
		//Weight
		$arOCBasket['weight'] = '';
		$arOCBasket['weight_prefix'] = '';
		$arOCBasket['weight_class_id'] = 2; //1-Kg. 2-Gr
		if($arCartPrice['OPTIONS']['WEIGHT']>0){ $arOCBasket['weight']=$arCartPrice['OPTIONS']['WEIGHT']; }
		//Points
		$arOCBasket['points'] = '';
		$arOCBasket['points_prefix'] = Lng('Pcs',1,false).'.';
		if($arCartPrice['OPTIONS']['SET']>0){ $arOCBasket['points']=$arCartPrice['OPTIONS']['SET']; }
		//Options
		$arOCBasket['option'][] = Array('name'=>Lng('Article',1,false),'option_value'=>$arCartPrice['ARTICLE'],'type'=>'text');
		$arOCBasket['option'][] = Array('name'=>Lng('Supplier',1,false),'option_value'=>$arCartPrice['SUPPLIER_STOCK'],'type'=>'text');
		$arOCBasket['option'][] = Array('name'=>Lng('Dtime_delivery',1,false),'option_value'=>$arCartPrice['DAY'],'type'=>'text');
		$arOCBasket['option'][] = Array('name'=>Lng('Availability',1,false),'option_value'=>$arCartPrice['AVAILABLE'],'type'=>'text');
		$arOCBasket['option'][] = Array('name'=>'Price','option_value'=>$arCartPrice['PRICE'].' '.$arCartPrice['CURRENCY'],'type'=>'text');
		$arOCBasket['option'][] = Array('name'=>'Date','option_value'=>$arCartPrice['DATE_FORMATED'],'type'=>'text');
		$arOCBasket['option'][] = Array('name'=>'Code','option_value'=>$arCartPrice['CODE'],'type'=>'text');
		if(is_array($arCartPrice['OPTIONS']) AND count($arCartPrice['OPTIONS'])>0){
			foreach($arCartPrice['OPTIONS'] as $OpCode=>$OpValue){
				$OpName = $arCartPrice['OPTIONS_NAMES'][$OpCode];
				if($OpName==''){$OpName=$OpCode;}
				$arOCBasket['option'][] = Array('name'=>$OpName,'option_value'=>$OpValue,'type'=>'text');
			}
		}
		$_SESSION['cart'][$arCartPrice['CPID']] = $arOCBasket;
	}
}


//Login in module if OC admin
if($_SESSION['TDM_ISADMIN']!="Y"){
	if(isset($_SESSION['user_id']) AND $_SESSION['user_id']>0 AND strlen($_SESSION['token'])==32){
		//$_SESSION['TDM_ISADMIN']="Y";
	}
}


		
//Header & footer OC		
$_GET['route']='common/tecdoc_module';
chdir($_SERVER["DOCUMENT_ROOT"]);
include($_SERVER["DOCUMENT_ROOT"]."/index.php");

 

/*
Global variable $TDMContent is defined for OpenCart template view


Next OpenCart processed scripts:
---------------------------------------------------------------------------------------------------------
/catalog/controller/common/tecdoc_module.php
/catalog/view/theme/your_theme/template/common/tecdoc_module.tpl



Additional modified scripts:
---------------------------------------------------------------------------------------------------------
/system/library/cart.php
/catalog/controller/checkout/cart.php
/catalog/controller/module/cart.php
/catalog/view/theme/your_theme/template/checkout/cart.tpl
/catalog/view/theme/your_theme/template/module/cart.tpl



Custom modified scripts:
---------------------------------------------------------------------------------------------------------
/catalog/view/theme/your_theme/template/module/currency.tpl
/catalog/view/theme/your_theme/template/module/language.tpl
/catalog/view/javascript/common.js

*/
?>