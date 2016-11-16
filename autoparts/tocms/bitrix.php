<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();

//Prolog
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

//User group price type - from 2 to 5
if(!TDM_ISADMIN){
	global $TDMCore;
	$arPGID = $TDMCore->arPriceGID;
	global $USER;
	$arGroups = $USER->GetUserGroupArray();
	foreach($arPGID as $TDM_GID=>$CMS_GID){
		if(in_array($CMS_GID,$arGroups)){
			if($_SESSION['TDM_USER_GROUP']!=$TDM_GID){
				$_SESSION['TDM_USER_GROUP']=$TDM_GID; 
				LocalRedirect("");die(); 
			}
			break;
		}
	}
}

//Add to cart
if(defined('TDM_ADD_TO_CART') AND TDM_ADD_TO_CART AND CModule::IncludeModule("sale")){
	global $arCartPrice;
	if(is_array($arCartPrice)){
		if($arCartPrice['OPTIONS']['MINIMUM']>1){$QUANTITY=$arCartPrice['OPTIONS']['MINIMUM'];}else{$QUANTITY=1;}
		$arFields = Array(
			"LID"				=> "s1", 	//обязательно
			"NOTES"				=> $arCartPrice['TYPE_NAME'],
			"PRODUCT_ID"		=> $arCartPrice['CPID'],
			"PRICE"				=> $arCartPrice['PRICE_CONVERTED'],
			"CURRENCY"			=> $arCartPrice['CURRENCY_CONVERTED'],
			"QUANTITY"			=> $QUANTITY,
			"NAME"				=> $arCartPrice['NAME'],
			"DELAY"				=> "N",
			"CAN_BUY"			=> "Y",
			"DETAIL_PAGE_URL"	=> $arCartPrice['ADD_URL'],
			"PRODUCT_PROVIDER_CLASS"=>false,
			"PROPS" => Array(
				Array("NAME"=>"Артикул",		"CODE"=>"ARTICLE",			"VALUE"=>$arCartPrice['ARTICLE'],							"SORT"=>1),
				Array("NAME"=>"Производитель",	"CODE"=>"BRAND",			"VALUE"=>$arCartPrice['BRAND'],								"SORT"=>2),
				Array("NAME"=>"Срок поставки",	"CODE"=>"DAY",				"VALUE"=>$arCartPrice['DAY'],								"SORT"=>3),
				Array("NAME"=>"Наличие",		"CODE"=>"AVAILABLE",		"VALUE"=>$arCartPrice['AVAILABLE'],							"SORT"=>4),
				Array("NAME"=>"Поставщик",		"CODE"=>"SUPPLIER*",		"VALUE"=>$arCartPrice['SUPPLIER_STOCK'],					"SORT"=>5), //Помечайте поле "CODE" звездочкой * что бы свойство не было видно покупателю в корзине..
				Array("NAME"=>"Код прайса",		"CODE"=>"CODE*",			"VALUE"=>$arCartPrice['CODE'],								"SORT"=>6),
				Array("NAME"=>"Исходная цена",	"CODE"=>"PRICE*",			"VALUE"=>$arCartPrice['PRICE'].' '.$arCartPrice['CURRENCY'],"SORT"=>7),
				Array("NAME"=>"Дата прайса",	"CODE"=>"DATE_FORMATED*",	"VALUE"=>$arCartPrice['DATE_FORMATED'],						"SORT"=>8),
				Array("NAME"=>"Ссылка на фото",	"CODE"=>"IMG_SRC*",			"VALUE"=>$arCartPrice['IMG_SRC'],							"SORT"=>9),
				//Array("NAME"=>"Статус доставки","CODE"=>"DELIVERY",			"VALUE"=>"В обработке",										"SORT"=>10)
			)
		);
		if($arCartPrice['OPTIONS']['WEIGHT']>0){
			$arFields['WEIGHT']=$arCartPrice['OPTIONS']['WEIGHT'];
		}
		if($arCartPrice['DISCOUNT']>0 AND isset($arCartPrice['DISCOUNT_PRICE'])){
			$arFields['DISCOUNT_NAME']=$arCartPrice['TYPE_NAME'];
			$arFields['DISCOUNT_VALUE']=$arCartPrice['DISCOUNT'];
			$arFields['DISCOUNT_PRICE']=$arCartPrice['DISCOUNT_PRICE'];
		}
		if(is_array($arCartPrice['OPTIONS']) AND count($arCartPrice['OPTIONS'])>0){
			foreach($arCartPrice['OPTIONS'] as $OpCode=>$OpValue){
				$OpName = $arCartPrice['OPTIONS_NAMES'][$OpCode];
				if($OpName==''){$OpName=$OpCode;}
				$arFields["PROPS"][] = Array("NAME"=>$OpName,"CODE"=>$OpCode.'*',"VALUE"=>$OpValue);
			}
		}
		CSaleBasket::Add($arFields);
	}
}


//Meta
global $APPLICATION;
$APPLICATION->SetPageProperty("title", TDM_TITLE);
$APPLICATION->SetPageProperty("keywords", TDM_KEYWORDS);
$APPLICATION->SetPageProperty("description", TDM_DESCRIPTION);


//Login in module if Bitrix admin
if($_SESSION['TDM_ISADMIN']!="Y"){
	global $USER;
	if($USER->IsAdmin()){
		$_SESSION['TDM_ISADMIN']="Y";
	}
}


//Header
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	
//TDMod content
echo $TDMContent;

//Footer
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>