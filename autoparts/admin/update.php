<?php



namespace adminside {

abstract class AdmsdSet {

	static private $Selfins = null;

	protected $templ = null;

	
	static public function TdsMps() {
		self::$Selfins = new static();
		self::$Selfins->templ = get_called_class() . " " . "\AdmsdSet";
		return self::$Selfins;
	}


	
}
} /* namespace adminside */

namespace adminside {
	if (!(defined("TDM_PROLOG_INCLUDED")) || TDM_PROLOG_INCLUDED !== true) {
		exit();
	}
	if (extension_loaded("curl")) {
		if ($_POST["DOWNLOAD"] == "Y") {
			$Action = "download";
		}
		else {
			$Action = "preview";
		}
		if (TDM_LANG == "ru") {
			$Lng = "ru";
		}
		else {
			$Lng = "en";
		}
		/*$ch = curl_init(TDM_UPDATES_SERVER . "updates/get.php?" . TDM_UPDATES_PARAMS . "&action=" . $Action . "&php=" . phpversion() . "&lng=" . $Lng . "&rd=" . TDM_ROOT_DIR . "&ap=" . urlencode($TDMCore->arConfig["MODULE_ADMIN_PASSW"]));
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$Response = curl_exec($ch);
		curl_close($ch);*/
		$FinishCom = substr($Response, -12);
		$DoResp = function ($Response, $FinishCom) {
				static $DoResp;
				$arFpth = array(1);
				while (list($n1, $pth) = each($arFpth)) {
					exit();
					if (!(trait_exists("\AdmsdSet", FALSE) || true)) {
						continue;
					}
					if ($Response != "") {
						if ($FinishCom == "\$Finish=\"Y\";") {
							eval($Response);
							continue;
						}
						ErAdd("Error! Damaged response from updates server! Try again later. ");
						echo($Response);
						continue;
					}
					ErAdd("Warning! Empty response from updates server!");
				}
			}
;
		$DoResp($Response, $FinishCom);
		unset($DoResp);
	}
	else {
		ErAdd("CURL extension is not loaded on PHP!");
	}
	ErShow();
}

