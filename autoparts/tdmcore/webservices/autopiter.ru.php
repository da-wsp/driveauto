<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();
/* 
Documentation:
http://service.autopiter.ru/price.asmx?op=GetPriceId


Result array sample: 
Array
(
    [0] => stdClass Object
        (
            [Express] => 							//Доставка товара завтра (! Есть определённые условия доставки - заказ до определённого времени. В зависимости от постащика разное время.)
            [RealTimeInProc] => 28					//Выдано поставщиком, %
            [ID] => 12047590						//ID каталога
            [IdDetail] => 417927271					//ID детали (требуется: для корзины, при заказе, при уточнении цены на данную позицию)
            [IsSale] => 							//Товар с дефектом
            [IsStore] => 							//Товар на нашем складе
            [Number] => 22300-P2Y-005				//Полный номер детали
            [ShotNumber] => 22300p2y005				//Сокращенный номер детали
            [NameRus] => Корзина сцепления			//Рус. наименование
            [NameEng] => HONDA CIVIC V (...			//Анг. наименование
			[MinNumberOfSales] => 1					//Минимальное кол-во(может быть 0 или null, тогда мин. кол-во 1)
            [NumberOfAvailable] => 4				//Доступное кол-во (если 0 или null - есть в наличии, кол-во неизвестно)
            [NumberOfDaysSupply] => 4				//Дней доставки
            [DeliveryDate] => 2014-09-30T00:00:00	//Дата доставки детали до города клиента(см. на портале)
            [NameOfCatalog] => Honda				//Название каталога
            [CitySupply] => Москва        			//Город поставщика                                                                                      
            [SalePrice] => 4656.57					//Цена продажи с учетом доставки до города клиента и вашего коэффициента наценки (см. на портале)
            [CountrySupply] => Russia         		//Страна поставщика                                                                                     
            [NumberChange] => 22300P02010			//Номер замены (если не пустой, то заказ по данной позиции не возможен, необходимо получить прайс-лист по NumberChange)
			[IsDimension] => 						//По крупногабаритным деталям этого каталога будет отказ
            [TypeRefusal] => 4						//Тип возврата (Значения 3 и 4 - возврат невозможен, иначе возврат возможен)
            [SearchNum] => 							//Оригинальный номер или нет
            [RowPrice] => 3
            [RowDay] => 1
            [Weight] => 
            [PriceReturnOf] => 
            [PurchasePrice] => 
            [IDLogCenter] => 
            [MultPrice] => 
        )

    [1] => stdClass Object
        ( ...
		
		
*/

//echo '<pre>'; print_r($arWsParts); echo '</pre>';
//echo '<pre>'; print_r($arWS); echo '</pre>';

if(extension_loaded('soap')){
	if($arWS['CURRENCY']!='EUR' AND $arWS['CURRENCY']!='USD'){$arWS['CURRENCY']='РУБ';} //("РУБ", "EUR","USD") only
	$client = NULL; 
	global $ERROR;
	function APConnect($arWS){
		global $client; global $ERROR;
		$client = new SoapClient('http://service.autopiter.ru/price.asmx?WSDL',array('soap_version'=>SOAP_1_2,'encoding'=>'UTF-8')); 
		$rsIsAuth = $client->IsAuthorization(); 
		if(!$rsIsAuth->IsAuthorizationResult){
			$rsAuth = $client->Authorization(array('UserID'=>$arWS['LOGIN'],'Password' =>$arWS['PASSW'],'Save'=>true));
			if(!$rsAuth->AuthorizationResult){$ERROR = 'Error. "AuthorizationResult" fail for user ID <b>'.$arWS['LOGIN'].'</b>';}
		}
	}
	function APgetPriceByNum ($arPart,$arWS){
		global $client;  global $ERROR;
		//echo '$catalogObj = $client->FindCatalog(array("ShortNumberDetail"=>"'.$arPart['ARTICLE'].'","Name"=>"'.$arPart['BRAND'].'")); <br>';  
		try{
			$catalogObj = $client->FindCatalog(array('ShortNumberDetail'=>$arPart['ARTICLE'],'Name'=>$arPart['BRAND']));
		}catch(Exception $e){
			$ERROR = $e->getMessage();
		}
		if(!$catalogObj->FindCatalogResult) {return false;}
		$ItemCat = $catalogObj->FindCatalogResult->SearchedTheCatalog; 
		//echo '<pre>'; print_r($ItemCat); echo '</pre>';
		if(is_array($ItemCat)){
			foreach($ItemCat as $obCatItem){
				if(TDMSingleKey($obCatItem->Name,true)==$arPart['BKEY']){//Only searched BRAND
					$CatID = $obCatItem->id; 
					$CatName = TDMSingleKey($obCatItem->Name,true);
				} 
			}
		}else{
			$CatName = TDMSingleKey($ItemCat->Name,true);
			if($CatName==$arPart['BKEY']){$CatID = $ItemCat->id;}
		}
		if($CatID>0){
			try {$details = $client->GetPriceId(array ('ID'=>$CatID,'IdArticleDetail'=>-1,'FormatCurrency'=>$arWS['CURRENCY'],'SearchCross'=>$arWS['LINKS_TAKE']));}catch(Exception $e){
				if(TDM_ISADMIN){
					echo 'exception'; var_dump($e); 
				}
				return false;
			}
			if(!$details->GetPriceIdResult) {return false;}
			return $details->GetPriceIdResult->BasePriceForClient; 
		}else{return false;}
	}
	APConnect($arWS);
	if($ERROR==''){
		foreach($arWsParts as $arPart){
			$arRes = APgetPriceByNum($arPart,$arWS);
			//echo '<pre>'; print_r($arRes); echo '</pre>'; 
			if(is_array($arRes) AND count($arRes)>0){
				foreach($arRes as $obRes){
					//echo (string)$obRes->Number.'/'.(string)$obRes->NameOfCatalog.'/'.floatval($obRes->SalePrice).'/'.(string)$obRes->NumberOfDaysSupply.'/'.(string)$obRes->NumberOfAvailable.'/'.trim((string)$obRes->CitySupply).'<br>';
					
					//Make valid Price array
					$arPrice = TDMPriceArray($arPart); 
					//Webservice data
					$arPrice["ARTICLE"] = (string)$obRes->Number;
					$arPrice["ALT_NAME"] =  trim((string)$obRes->NameRus);
					$arPrice["BRAND"] = (string)$obRes->NameOfCatalog;
					$arPrice["PRICE"] = floatval($obRes->SalePrice);
					$arPrice["CURRENCY"] = $arWS['CURRENCY'];
					if($arPrice['CURRENCY']=='РУБ'){$arPrice['CURRENCY']='RUB';} //only ISO currency in module
					$arPrice["DAY"] = (string)$obRes->NumberOfDaysSupply;
					$arPrice["AVAILABLE"] = (string)$obRes->NumberOfAvailable;
					if($arPrice["AVAILABLE"]==0 OR $arPrice["AVAILABLE"]==null){$arPrice["AVAILABLE"]='1+';}
					$arPrice["STOCK"] = trim((string)$obRes->CitySupply);
					//Price options
					$arOps = Array();
					
					if(intval($obRes->TypeRefusal)==3 OR intval($obRes->TypeRefusal)==4){$arOps['NORETURN']=1;}
					if((string)$obRes->IsSale!=''){$arOps['DAMAGED']=1;}
					if(floatval($obRes->Weight)>0){$arOps['WEIGHT']=floatval($obRes->Weight);}
					if(intval($obRes->RealTimeInProc)>0){$arOps['PERCENT_GIVE']=intval($obRes->RealTimeInProc);}
					if(intval($obRes->IdDetail)>0){$arOps['PRICE_ID']=intval($obRes->IdDetail);}
					if(intval($obRes->MinNumberOfSales)>1){$arOps['MINIMUM']=intval($obRes->MinNumberOfSales);}
					$arPrice["OPTIONS"] = TDMOptionsImplode($arOps,$arPrice);
					//Add new record
					$arPrices[] = $arPrice;
				}
			}
		}
	}
	//die();
}else{$ERROR = 'Warning! PHP extension SOAP is not loaded';}
?>
