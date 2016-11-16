<?php

if (!(defined("TDM_PROLOG_INCLUDED")) || TDM_PROLOG_INCLUDED !== true) {
	exit();
}
$arBrnd = GetURLBrand();
$MOD_ID = intval($_REQUEST["mod_id"]);
$arResult["TYPES"] = array();
$arResult["UBRAND"] = $arBrnd["uname"];
$arResult["BRAND"] = $arBrnd["name"];
if ($arResult["UBRAND"]) {
	$TDMCore->DBSelect("TECDOC");
	TDMSetTime();
	$rsManuf = TDSQL::GetManufByCode($arResult["UBRAND"]);
	TDMSetTime("GetManufByCode");
	if ($arManuf = $rsManuf->Fetch()) {
		$arResult["MFA_MFC_CODE"] = $arManuf["MFA_MFC_CODE"];
		$rsModel = TDSQL::GetModelByID($arManuf["MFA_ID"], $MOD_ID);
		TDMSetTime("GetModelByID");
		if ($arModel = $rsModel->Fetch()) {
			$rsTypes = TDSQL::GetTypes($arModel["MOD_ID"]);
			TDMSetTime("GetTypes");
			if (0 < $rsTypes->NumRows) {
				$DateFr = TDDateFormat($arModel["MOD_PCON_START"], Lng("to_pt"), "year");
				$DateTo = TDDateFormat($arModel["MOD_PCON_END"], Lng("to_pt"), "year");
				while ($arType = $rsTypes->Fetch()) {
					$arType["START"] = TDDateFormat($arType["TYP_PCON_START"], Lng("to_pt"), "year");
					$arType["END"] = TDDateFormat($arType["TYP_PCON_END"], Lng("to_pt"), "year");
					$arType["URL"] = TDMGenerateURL(array("BRAND" => $arBrnd["code"], "MOD_NAME" => $_REQUEST["mod_name"], "MOD_ID" => $MOD_ID, "TYP_ID" => $arType["TYP_ID"], "ENGINE" => $arType["ENG_CODE"], "TYPE_NAME" => $arType["TYP_CDS_TEXT"]));
					$arResult["TYPES"][] = $arType;
				}
				$arResult["MOD_ID"] = $MOD_ID;
				$arResult["MODEL"] = $arModel["MOD_CDS_TEXT"];
				$arResult["YEAR"] = "(" . $DateFr . " - " . $DateTo . ")";
				$TypeSrc = "/" . TDM_ROOT_DIR . "/media/types/" . $arBrnd["name"] . "/" . $arModel["MOD_ID"] . ".png";
				if (file_exists($_SERVER["DOCUMENT_ROOT"] . $TypeSrc)) {
					$arResult["PIC_SRC"] = $TypeSrc;
					$arResult["PIC_TYPE"] = "MODEL_TYPE";
				}
				else {
					$arResult["PIC_TYPE"] = "BRAND_LOGO";
					$BrandLogoSrc = "/" . TDM_ROOT_DIR . "/media/brands/90/" . $arResult["MFA_MFC_CODE"] . ".png";
					if (file_exists($_SERVER["DOCUMENT_ROOT"] . $BrandLogoSrc)) {
						$arResult["PIC_SRC"] = $BrandLogoSrc;
					}
					else {
						$arResult["PIC_SRC"] = "/" . TDM_ROOT_DIR . "/media/brands/" . $arResult["MFA_MFC_CODE"] . ".png";
					}
				}
				SetComMeta("TYPES", array("BRAND" => $arResult["UBRAND"], "MODEL" => $arResult["MODEL"], "DATE" => $arResult["YEAR"]));
			}
			else {
				ErAdd("There is no types of model of brand \"" . $arResult["UBRAND"] . "\"");
			}
		}
		else {
			TDMRedirect($arBrnd["name"]);
		}
	}
	else {
		TDMRedirect();
	}
}
else {
	TDMRedirect();
}

