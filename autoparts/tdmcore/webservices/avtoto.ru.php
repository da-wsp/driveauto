<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();
/*
Documentation:
http://www.avtoto.ru/services/search/docs/
Сервис поиска предложений будет работать в случае выполнения условия: сумма заказов / количество запросов > 20 после некоторого порога проценок.

Result array sample: 
Array(
    [Parts] => Array(
		[0] => Array(
				[Code] => G41242004
				[Manuf] => BORT
				[Name] => АМОРТИЗАТОР HONDA CRV I 05-02 ПЕРЕДНИЙ ГМ(BORT)
				[Price] => 855.6632748
				[Storage] => РОСТОВ-35A
				[Delivery] => 1-2
				[MaxCount] => 2
				[BaseCount] => 1
				[AvtotoData] => Array(
					[PartId] => 0
				)
			)
			[1] => ...
		)
	[Info] => Array (
		[SearchId] => 
		[Errors] => Array(
			[0] => Ваш IP временно заблокирован
		)
		[Logs] => Array()
	)
)
			
*/

//echo '<pre>'; print_r($arWsParts); echo '</pre>';
//echo '<pre>'; print_r($arWS); echo '</pre>';

if(extension_loaded('soap')){
	$arERROR = Array(); $arARTs=Array();
	if($arWS['LINKS_TAKE']==1){$search_cross='on';}else{$search_cross='off';}
	$SClient = @new SoapClient("http://www.avtoto.ru/services/search/soap.wsdl",array('soap_version' => SOAP_1_1));
	foreach($arWsParts as $arPart){
		if(!in_array($arPart['ARTICLE'],$arARTs)){
			try{
				$arCRes = $SClient->SearchParts($params = array(
					'user_id' => $arWS['CLIENT_ID'],
					'user_login' => $arWS['LOGIN'],
					'user_password' => $arWS['PASSW'],
					'search_code' => $arPart['ARTICLE'],
					'search_cross' => $search_cross
				));
			}catch(Exception $e){
				$ERROR = $e->getMessage();
				//echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
			}
		}else{$arCRes=$arCacheData[$arPart['ARTICLE']];}
		
		//echo '<pre>'; print_r($arCRes); echo '</pre>'; 
		if(is_array($arCRes['Info']['Errors']) AND count($arCRes['Info']['Errors'])>0){
			foreach($arCRes['Info']['Errors'] as $ErrMsg){$arERROR[] = $ErrMsg;}
		}elseif(is_array($arCRes['Parts']) AND count($arCRes['Parts'])>0){
			if(!in_array($arPart['ARTICLE'],$arARTs)){
				$arARTs[]=$arPart['ARTICLE'];
				$arCacheData[$arPart['ARTICLE']]=$arCRes;
			}
			foreach($arCRes['Parts'] as $arRes){
				//Make valid Price array
				$arPrice = TDMPriceArray($arPart); 
				//Webservice data
				$arPrice["ARTICLE"] = $arRes['Code'];
				$arPrice["ALT_NAME"] = $arRes['Name'];
				$arPrice["BRAND"] = $arRes['Manuf'];
				$arPrice["PRICE"] = floatval($arRes['Price']);
				$arPrice["CURRENCY"] = $arWS['CURRENCY'];
				$arPrice["DAY"] = $arRes['Delivery'];
				$arPrice["AVAILABLE"] = $arRes['MaxCount'];
				if($arPrice["AVAILABLE"]<1){continue;}
				$arPrice["STOCK"] = $arRes['Storage'];
				//Price options
				$arOps = Array();
				if($arRes['BaseCount']>1){$arOps['MINIMUM']=$arRes['BaseCount'];}
				$arPrice["OPTIONS"] = TDMOptionsImplode($arOps,$arPrice);
				//Add new record
				$arPrices[] = $arPrice;
				//echo '<pre>'; print_r($arPrice); echo '</pre>'; 
			}
		}
	}
	if(count($arERROR)>0){$ERROR = implode('<br>',array_unique($arERROR));}
}else{$ERROR = 'Warning! PHP extension SOAP is not loaded';}

	
?>