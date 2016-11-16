<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();
/*
Documentation:
http://www.mikado-parts.ru/ws/service.asmx?op=Code_Search
http://www.mikado-parts.ru/office/HelpWS.asp

Для получения разрешения на доступ сервису обращайтесь с запросом к администратору gmv@mikado-parts.ru. 
В запросе обязательно укажите ваш клиентский номер, для чего будет использоваться WebService, IP адрес, 
с которого будет осуществляться доступ, адрес страницы WEB-сайта, на которой будут использоваться функции сервиса (если возможно).

Result array sample: 
[4] => stdClass Object
	(
		[ZakazCode] => v264-12345
		[Supplier] => Склад №264 [FEBI BILSTEIN]
		[ProducerBrand] => FEBI BILSTEIN
		[ProducerCode] => 12345
		[Brand] => FEBI BILSTEIN
		[Country] => Евросоюз
		[Name] => Опора двигателя
		[Price] => 17.15
		[PriceRUR] => 878
		[Srock] => 6 дн.
		[CodeType] => Aftermarket
		[Source] => stdClass Object
			(
				[SourceProducer] => FEBI BILSTEIN
				[SourceCode] => 12345
			)
		[PrefixLength] => 5
	)


*/

//echo '<pre>'; print_r($arWsParts); echo '</pre>';
//echo '<pre>'; print_r($arWS); echo '</pre>';

if(extension_loaded('soap')){
	$SClient = @new SoapClient("http://www.mikado-parts.ru/ws/service.asmx?WSDL");
	foreach($arWsParts as $arPart){
		$ParCnt++;
		if(!in_array($arPart['ARTICLE'],$arARTs)){
			try{
				$obCRes = $SClient->Code_Search(Array("Search_Code"=>$arPart['ARTICLE'], "ClientID"=>$arWS['LOGIN'], "Password"=>$arWS['PASSW'])); //
			}catch(Exception $e){
				$ERROR = $e->getMessage();
			}
		}else{$obCRes=$arCacheData[$arPart['ARTICLE']];}
		
		//echo $arPart['ARTICLE'].'<pre>'; print_r($obCRes); echo '</pre>'; die();  
		if($obCRes->Code_SearchResult->Code_Search!=''){$ResCnt++;}
		if(count($obCRes->Code_SearchResult->List->Code_List_Row)>0){
			if(!in_array($arPart['ARTICLE'],$arARTs)){
				$arARTs[]=$arPart['ARTICLE'];
				$arCacheData[$arPart['ARTICLE']]=$obCRes;
			}
			foreach($obCRes->Code_SearchResult->List->Code_List_Row as $obRes){
				$PriCnt++;
				$MikadoBrand = (string)$obRes->ProducerBrand;
				if(TDMSingleKey($MikadoBrand ,true)==$arPart['BKEY']){//Only searched BRAND
					//Make valid Price array
					$arPrice = TDMPriceArray($arPart); 
					
					$arPrice["ARTICLE"] = (string)$obRes->ProducerCode;
					$arPrice["ALT_NAME"] = (string)$obRes->Name;
					$arPrice["BRAND"] = $MikadoBrand;
					$arPrice["PRICE"] = (string)$obRes->PriceRUR;
					$arPrice["CURRENCY"] = "RUB";
					$arPrice["DAY"] = (string)$obRes->Srock;
					$arPrice["AVAILABLE"] = (string)$obRes->OnStock;
					$arPrice["STOCK"] = (string)$obRes->Supplier;
					$arPrice["OPTIONS"] = '';
					//Price options
					$arOps = Array();
					$arPrice["OPTIONS"] = TDMOptionsImplode($arOps,$arPrice);
					$arPrices[] = $arPrice; //Add record
				}
			}
		}
	}
	//die(); 
	if($ParCnt==$ResCnt AND $PriCnt<=0){
		$ERROR = 'Empty prices returned for all <b>'.$ResCnt.'</b> queries. Register your site IP on supplier service.';
	}
	
}else{$ERROR = 'PHP extension "sockets" is not loading!';}
?>
