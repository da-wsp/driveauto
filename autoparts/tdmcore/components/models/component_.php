<?php

function TDMakeModelItem($arModel) {
	if (0 < strpos($arModel["MOD_CDS_TEXT"], "(US)")) {
		$arModel["MOD_CDS_TEXT"] = str_replace("[USA]", "", $arModel["MOD_CDS_TEXT"]);
	}
	$arModel["DATE_FROM"] = TDDateFormat($arModel["MOD_PCON_START"], Lng("to_pt", 1, 0), "year");
	$arModel["DATE_TO"] = TDDateFormat($arModel["MOD_PCON_END"], Lng("to_pt", 1, 0), "year");
	return $arModel;
}

if (!(defined("TDM_PROLOG_INCLUDED")) || TDM_PROLOG_INCLUDED !== true) {
	exit();
}
$arBrnd = GetURLBrand();
$arResult["UBRAND"] = $arBrnd["uname"];
$arResult["BRAND"] = $arBrnd["name"];
$arResult["MODELS"] = array();
if ($arResult["UBRAND"]) {
	$TDMCore->DBSelect("TECDOC");
	TDMSetTime();
	$rsManuf = TDSQL::GetManufByCode($arResult["UBRAND"]);
	TDMSetTime("GetManufByCode query");
	if ($arManuf = $rsManuf->Fetch()) {
		$arResult["MFA_MFC_CODE"] = $arManuf["MFA_MFC_CODE"];
		$arResult["MODELS_COUNT"] = 0;
		if (1 < $arComSets["SHOW_HIDE_SELECTED"][$arBrnd["uname"]]) {
			$NOTFilter = 1;
			$StateN = "hidden";
		}
		else {
			$StateN = "showed";
		}
		if (0 < $arComSets["SHOW_HIDE_SELECTED"][$arBrnd["uname"]]) {
			$arIDFilter = $arComSets["SELECTED_ITEMS"][$arBrnd["uname"]];
			if (is_array($arIDFilter) && 0 < count($arIDFilter)) {
				TDMSetTime("Filtered models ##" . $StateN . " items: " . count($arIDFilter));
			}
		}
		$rsModels = TDSQL::GetModels($arManuf["MFA_ID"], TDM_LANG_ID, $arIDFilter, $NOTFilter, $YearFrom, $arBrnd["trucks"], $arComSets["HIDE_USA"]);
		TDMSetTime("GetModels query");
		if (0 < $rsModels->NumRows) {
			require_once(TDM_PATH . "/tdmcore/components/models/model_groups.php");
			$arTMods = array();
			$arTitlMods = array();
			$TCom = "";
			$TitleModels = "";
			while ($arModel = $rsModels->Fetch()) {
				$arModel = TDMakeModelItem($arModel);
				if (array_key_exists($arResult["UBRAND"], $arHardGroups)) {
					foreach ($arHardGroups[$arResult["UBRAND"]] as $GrMod) {
						if (!(strstr($arModel["MOD_CDS_TEXT"], $GrMod))) {
							continue;
						}
						$arModel["GROUPED"] = "Y";
						if (!(in_array($GrMod, $arTMods))) {
							$arTMods[] = $GrMod;
						}
						$CurModel = $GrMod;
					}
				}
				if ($arModel["GROUPED"] != "Y") {
					$arMd = explode(" ", $arModel["MOD_CDS_TEXT"]);
					if (!(in_array($arMd[0], $arTMods))) {
						$arTMods[] = $arMd[0];
						$CurModel = $arMd[0];
					}
				}
				if ($arRenamesRegroup[$arResult["UBRAND"]][$CurModel] != "") {
					$CurModel = $arRenamesRegroup[$arResult["UBRAND"]][$CurModel];
				}
				if (!(in_array($CurModel, $arTitlMods))) {
					$arTitlMods[] = $CurModel;
				}
				$PicModelName = str_replace(" ", "_", $CurModel);
				$PicModelName = str_replace("/", "_", $PicModelName);
				$ClrMod = str_replace("\xc3\xab", "e", $arResult["BRAND"]);
				$ClrMod = str_replace("\xc3\x8b", "e", $arResult["BRAND"]);
				$ClrMod = str_replace(" ", "_", $arResult["BRAND"]);
				$ModelPicSrc = "/" . TDM_ROOT_DIR . "/media/models/" . $ClrMod . "/" . $PicModelName . ".jpg";
				if (file_exists($_SERVER["DOCUMENT_ROOT"] . $ModelPicSrc)) {
					$arResult["MODEL_PICS"][$CurModel] = $ModelPicSrc;
				}
				else {
					$arResult["MODEL_PICS"][$CurModel] = "/" . TDM_ROOT_DIR . "/media/models/default.jpg";
				}
				$arModel["URL"] = TDMGenerateURL(array("BRAND" => $arBrnd["code"], "MOD_NAME" => StrForURL($CurModel), "MOD_ID" => $arModel["MOD_ID"]));
				if ((string)intval($CurModel) == $CurModel && 0 < !(strpos($CurModel, " "))) {
					$CurModel = $CurModel . " ";
				}
				$arResult["MODELS"][$CurModel][] = $arModel;
			}
			$arResult["MODELS_COUNT"] = count($arResult["MODELS"]);
			$BrandLogoSrc = "/" . TDM_ROOT_DIR . "/media/brands/90/" . $arResult["MFA_MFC_CODE"] . ".png";
			if (file_exists($_SERVER["DOCUMENT_ROOT"] . $BrandLogoSrc)) {
				$arResult["BRAND_LOGO_SRC"] = $BrandLogoSrc;
			}
			else {
				$arResult["BRAND_LOGO_SRC"] = "/" . TDM_ROOT_DIR . "/media/brands/" . $arResult["MFA_MFC_CODE"] . ".png";
			}
			foreach ($arTitlMods as $TMod) {
				$TitleModels .= $TCom . $TMod;
				$TCom = ", ";
			}
			SetComMeta("MODELS", array("BRAND" => $arResult["UBRAND"], "MODELS_LIST" => $TitleModels));
			$Sorts = array();
			foreach ($arResult["MODELS"] as $GrName => $arMod) {
				$Sorts[] = $GrName;
			}
			array_multisort($Sorts, SORT_ASC, SORT_STRING, $arResult["MODELS"]);
		}
		else {
			TDMRedirect();
		}
	}
	else {
		TDMRedirect();
	}
}
else {
	TDMRedirect();
}

