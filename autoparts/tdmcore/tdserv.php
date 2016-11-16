<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();

class TDSQL{
	static function GetManufs($CType){
		$Params = array(
			'cached' => 1,
			'countriesCarSelection' => 'ru',
			'lang' => 'ru',
			'favouredList'=> 1,
			'countryGroupFlag'=> false,
			'carType'=> 1,
			'countriesCarSelection'=> 'ru',
			'evalFavor'=> false
		);
		$arRes = TDWebservSCon("http://tecdoc.com.ua/1.2/",$Params,'getVehicleManufacturers');
		foreach($arRes as $key=>$arValue){
			$arIRes[] = Array('MFA_ID'=>$arValue['manuId'], 'MFA_BRAND'=>$arValue['manuName'], 'MFA_PC_MFC'=>1, 'MFA_MFC_CODE'=>$arValue['manuName']);
		}
		$TDSObj = new TDSObj;
		$TDSObj->arItems = $arIRes;
		//echo '<pre>'; print_r($TDSObj); echo '</pre>'; //die();
		
		return $TDSObj;
    }
	
}


function TDWebservSCon($Source,$Params,$Method){
	if(extension_loaded('soap')){
		$TDSClient = new SoapClient(null, array('location'=>$Source,'uri'=>$Source));
		try{
			$Res = $TDSClient->{$Method}($Params);
			return $Res;
		}catch(SoapFault $ex){
			ErAdd($ex->getMessage()); 
		}
	}else{ErAdd('PHP extension SOAP is not loaded',1);}
}

class TDSObj{
	var $arItems = Array();
	var $Position = 0;
	function Fetch(){
		if(array_key_exists($this->Position,$this->arItems)){
			$this->Position++;
			return $this->arItems[$this->Position];
		}else{
			return false;
		}
	}
}
?>