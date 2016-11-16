<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();
/*
Documentation:
http://twinauto.net/web_service/

Result array sample: 
Array(
    [0] => Array
        (
            [Brand] => Ford
            [Oem] => 1069403
            [Description] => BEZUG - VORDERSITZLEH
            [Price] => 212.43
            [Kvo] => xxl
            [Sklad] => EUR:TWIN
            [SkladDescr] => Склад 1
            [Weight] => 
        )
	...
	
	
*/
 
//echo '<pre>'; print_r($arWsParts); echo '</pre>';
//echo '<pre>'; print_r($arWS); echo '</pre>';

if(extension_loaded('soap')){
	$arARTs=Array();
	$SClient = new SoapClient("http://twinauto.net/wsdl/server.php?wsdl", array('encoding'=>'utf-8','connection_timeout'=>120));
	foreach($arWsParts as $arPart){
		if(!in_array($arPart['ARTICLE'],$arARTs)){
			try{
				$arCRes = $SClient->getPartsPrice($arPart['ARTICLE'], $arWS['LOGIN'], $arWS['PASSW'], '', ''); //OemCode, UserLogin, UserPassword, SearchRegion, SrchMethod
				//SearchRegion - Регион поиска (возможно указание нескольких регионов через запятую [ukr,uae,usa,eur,korea]) либо пустое значение для поиска по всем регионам
				//SrchMethod - Условие поиска - пустое значение для поиска по полному номеру, либо 'notfull' для поиска по неполному номеру
			}catch(Exception $e){
				$ERROR = $e->getMessage();
				//echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
			}
		}else{$arCRes=$arCacheData[$arPart['ARTICLE']];}
		//echo '<pre>'; print_r($arPart); echo '</pre>';
		//echo '<pre>'; print_r($arCRes); echo '</pre>';
		if(is_array($arCRes) AND count($arCRes)>0){
			if(!in_array($arPart['ARTICLE'],$arARTs)){
				$arARTs[]=$arPart['ARTICLE'];
				$arCacheData[$arPart['ARTICLE']]=$arCRes;
			}
			foreach($arCRes as $arRes){
				if($arRes['Brand']!='' AND TDMSingleKey($arRes['Brand'],true)==$arPart['BKEY']){//Only searched BRAND
					//Make valid Price array
					$arPrice = TDMPriceArray($arPart); 
					//Webservice data
					$arPrice["ARTICLE"] = $arRes['Oem'];
					$arPrice["ALT_NAME"] = $arRes['Description'];
					$arPrice["BRAND"] = $arRes['Brand'];
					$arPrice["PRICE"] = floatval($arRes['Price']);
					$arPrice["CURRENCY"] = $arRes['Currency'];
					$arPrice["AVAILABLE"] = $arRes['Kvo'];
					$arPrice["STOCK"] = $arRes['Sklad'].' / '.$arRes['SkladDescr'].'';
					if($arPrice["AVAILABLE"]=='xxl'){$arPrice["AVAILABLE"]=99;}
					//Price options
					$arOps = Array();
					if($arRes['Weight']>0){$arOps['WEIGHT']=$arRes['Weight'];}
					$arPrice["OPTIONS"] = TDMOptionsImplode($arOps,$arPrice);
					//Add new record
					$arPrices[] = $arPrice;
				}
			}
		}
	}
}else{$ERROR = 'Warning! PHP extension SOAP is not loaded';}
//die();
?>
