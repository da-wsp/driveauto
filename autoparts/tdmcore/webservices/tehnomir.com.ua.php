<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();
/*
Documentation:
http://tehnomir.com.ua/index.php?act=show_page&cmd=webservices 

Result array sample: 
Array(
	[0] => Array(
		[Brand] => BOGE
		[Number] => 30B28A
		[Name] => Амортизатор передний
		[Price] => 1504.39
		[Currency] => UAH
		[Quantity] => 2
		[Weight] => 1.82
		[SupplierCode] => RRMA
		[DeliveryTime] => 9
		[DamagedFlag] => N
		[UsedFlag] => N
		[RestoredFlag] => N
	)
)

Result Error sample:
Array(
    [Error] => No result by partnumber: MR8307
)
*/

//echo '<pre>'; print_r($arWsParts); echo '</pre>';
//echo '<pre>'; print_r($arWS); echo '</pre>';

if(extension_loaded('soap')){
	$SClient = new SoapClient("http://tehnomir.com.ua/ws/soap.wsdl", array('encoding'=>'utf8'));
	foreach($arWsParts as $arPart){
		try{
			$arCRes = $SClient->GetPrice($arPart['ARTICLE'], $arPart['BRAND'], $arWS['LOGIN'], $arWS['PASSW'], $arWS['CURRENCY']); //Number, Brand, Login, Pass, Currency (Бренд и валюта не обязательные поля)
		}catch(Exception $e){
			$ERROR = $e->getMessage();
			//echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
		}
		//echo '<pre>'; print_r($arCRes); echo '</pre>';
		if(isset($arCRes) AND is_array($arCRes) AND $arCRes['Error']==''){
			foreach($arCRes as $arRes){
				//Make valid Price array
				$arPrice = TDMPriceArray($arPart); 
				//Webservice data
				$arPrice["ARTICLE"] = $arRes['Number'];
				$arPrice["ALT_NAME"] = $arRes['Name'];
				$arPrice["BRAND"] = $arRes['Brand'];
				$arPrice["PRICE"] = floatval($arRes['Price']);
				$arPrice["CURRENCY"] = $arRes['Currency'];
				$arPrice["DAY"] = $arRes['DeliveryTime'];
				$arPrice["AVAILABLE"] = $arRes['Quantity'];
				$arPrice["STOCK"] = $arRes['SupplierCode'];
				//Price options
				$arOps = Array();
				if($arRes['Weight']>0){$arOps['WEIGHT']=($arRes['Weight']*1000);}
				if($arRes['DamagedFlag']=='Y'){$arOps['DAMAGED']=1;}
				if($arRes['UsedFlag']=='Y'){$arOps['USED']=1;}
				if($arRes['RestoredFlag']=='Y'){$arOps['RESTORED']=1;}
				$arPrice["OPTIONS"] = TDMOptionsImplode($arOps,$arPrice);
				//Add new record
				$arPrices[] = $arPrice;
			}
		}else{
			if($arCRes['Error']=='Details http://tehnomir.com.ua/index.php?act=show_page&cmd=limits'){
				$ERROR = 'Error. <a href="http://tehnomir.com.ua/index.php?act=show_page&cmd=limits" target="_blank">Details here</a>';
			}
		}
	}
}else{$ERROR = 'Warning! PHP extension SOAP is not loaded';}
?>