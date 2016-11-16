<?php

echo("\xef\xbb\xbf");
if (!(defined("TDM_PROLOG_INCLUDED")) || TDM_PROLOG_INCLUDED !== true) {
	exit();
}
$TDMCore->DBSelect("TECDOC");
$rsManuf = TDSQL::GetManufs($arComSets["SHOW_CARS_TRUCKS"]);
$arResult["FAVORITE"] = explode(", ", $arComSets["FAVORITE_ITEMS"]);
$arBRANDS_LIST = array();
while ($arManuf = $rsManuf->Fetch()) {
	$F1 = "N";
	if ($arComSets["SELECTED_ACTION"] == 0 && in_array($arManuf["MFA_ID"], $arComSets["SELECTED_ITEMS"])) {
		$F1 = "Y";
	}
	if ($arComSets["SELECTED_ACTION"] == 1 && !(in_array($arManuf["MFA_ID"], $arComSets["SELECTED_ITEMS"]))) {
		$F1 = "Y";
	}
	if (!($F1 == "Y")) {
		continue;
	}
	++$BCout;
	$BrandURLed = str_replace(" ", "-", $arManuf["MFA_BRAND"]);
	if ($BrandURLed == "RENAULT-TRUCKS") {
		$BrandURLed = "RENAULT";
	}
	$arMan["LINK"] = "/" . TDM_ROOT_DIR . "/" . StrForURL($BrandURLed) . "";
	$arMan["NAME"] = $arManuf["MFA_BRAND"];
	$arMan["CODE"] = $arManuf["MFA_MFC_CODE"];
	$arMan["LOGO"] = str_replace(" ", "_", $arMan["CODE"]);
	$arMan["CARS"] = $arManuf["MFA_PC_MFC"];
	$arMan["TRUCKS"] = $arManuf["MFA_CV_MFC"];
	if ($arComSets["SHOW_CARS_TRUCKS"] < 2 && $arManuf["MFA_PC_MFC"] == 1) {
		$arResult["CARS"][] = $arMan;
	}
	if (0 < $arComSets["SHOW_CARS_TRUCKS"] && $arManuf["MFA_CV_MFC"] == 1) {
		$arResult["TRUCKS"][] = $arMan;
	}
	$arBRANDS_LIST[] = $arMan["NAME"];
}
$BRANDS_LIST = implode(",", $arBRANDS_LIST);
SetComMeta("MANUFACTURERS", array("BRANDS_LIST" => $BRANDS_LIST));

