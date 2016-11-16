<?php

if (!(defined("TDM_PROLOG_INCLUDED")) || TDM_PROLOG_INCLUDED !== true) {
	exit();
}

$arResult["ALL_BRANDS"] = array();
$arResult["ALL_BRANDS_LETTERS"] = array();
if (0 < count($arPARTS_noP)) {
	$TDMCore->DBSelect("MODULE");
	$rsLinks = new TDMQuery();
	$LinksCnt = 0;
	$CrRNum = 0;
	$CrLNum = 0;
	if ($arComSets["HIDE_ANALOGS_OF_ANALOGS"] == 1 && isset($SrPKEYc) && $SrPKEYc != "") {
		$arSrCrParts[$SrPKEYc] = array();
	}
	else {
		$arSrCrParts = $arPARTS_noP;
		if (isset($SrPKEY) && $SrPKEY != "") {
			$arSrCrParts[$SrPKEY] = array();
		}
	}
	//ошибеа
	foreach ($arSrCrParts as $PKEY => $arTPart) {
		$CrSQL = "SELECT * FROM TDM_LINKS WHERE PKEY1=\"" . $PKEY . "\" AND SIDE IN (0,1) ";
		$rsLinks->SimpleSelect($CrSQL);
		while ($arLink = $rsLinks->Fetch()) {
			++$CrRNum;
			if ($arLink["SIDE"] == 1) {
				$SLable = "&#8594;";
			}
			else {
				if ($arLink["SIDE"] == 2) {
					$SLable = "&#8592;";
				}
				else {
					$SLable = "&#8596;";
				}
			}
			$arPARTS_noP[$arLink["PKEY2"]] = array("PKEY" => $arLink["PKEY2"], "BKEY" => $arLink["BKEY2"], "BRAND" => $arLink["BKEY2"], "AKEY" => $arLink["AKEY2"], "ARTICLE" => $arLink["AKEY2"], "LINK_SIDE" => $arLink["SIDE"], "LINK_CODE" => $arLink["CODE"], "LINK_INFO" => "<b>" . $arLink["BKEY1"] . "</b> " . $arLink["AKEY1"] . " " . $SLable . " <b>" . $arLink["BKEY2"] . "</b> " . $arLink["AKEY2"], "IMG_SRC" => "/" . TDM_ROOT_DIR . "/media/images/nopic.jpg");
		}
		$CrSQL = "SELECT * FROM TDM_LINKS WHERE PKEY2=\"" . $PKEY . "\" AND SIDE IN (0,2) ";
		$rsLinks->SimpleSelect($CrSQL);
		
		/*while (!($arLink = $rsLinks->Fetch())) {
			continue;
		}
		++$CrLNum;
		if ($arLink["SIDE"] == 1) {
			$SLable = "&#8594;";
		}
		else {
			if ($arLink["SIDE"] == 2) {
				$SLable = "&#8592;";
			}
			else {
				$SLable = "&#8596;";
			}
		}*/
		$arPARTS_noP[$arLink["PKEY1"]] = array("PKEY" => $arLink["PKEY1"], "BKEY" => $arLink["BKEY1"], "BRAND" => $arLink["BKEY1"], "AKEY" => $arLink["AKEY1"], "ARTICLE" => $arLink["AKEY1"], "LINK_SIDE" => $arLink["SIDE"], "LINK_CODE" => $arLink["CODE"], "LINK_INFO" => "<b>" . $arLink["BKEY1"] . "</b> " . $arLink["AKEY1"] . " " . $SLable . " <b>" . $arLink["BKEY2"] . "</b> " . $arLink["AKEY2"], "IMG_SRC" => "/" . TDM_ROOT_DIR . "/media/images/nopic.jpg");
		continue;
	}
	if (0 < $CrRNum) {
		TDMSetTime("GetLinks(Mutual-Right) ## All section <b>LINKS</b> items count - <b>" . $CrRNum . "</b>");
	}
	if (0 < $CrLNum) {
		TDMSetTime("GetLinks(Mutual-Left) ## All section <b>LINKS</b> items count - <b>" . $CrLNum . "</b>");
	}
	$LinksCnt = $CrRNum + $CrLNum;
	$WS = new TDMWebservers();
	if (isset($arWSP) && is_array($arWSP) && 0 < count($arWSP)) {
		$arWSPartsActual = $arWSP;
	}
	else {
		$arWSPartsActual = $arPARTS_noP;
	}
	$WS->SearchPrices($arWSPartsActual, array(), array("CACHE_MODE" => true, "SID" => $SEC_ID, "PKEY" => $S_BRAND . $S_ARTICLE));
	if (0 < count($WS->arNewCrosses)) {
		foreach ($WS->arNewCrosses as $NewCrPKEY => $arNewCr) {
			$arPARTS_noP[$NewCrPKEY] = $arNewCr;
		}
	}
	if ($_SESSION["TDM_SECPARTS_SORTING"] <= 0) {
		$_SESSION["TDM_SECPARTS_SORTING"] = $arComSets["ITEMS_SORT"];
	}
	if (0 < $_POST["SORT"]) {
		$arAvailSortModes = array(1, 2, 3, 4, 5);
		if (in_array($_POST["SORT"], $arAvailSortModes)) {
			$_SESSION["TDM_SECPARTS_SORTING"] = $_POST["SORT"];
		}
	}
	$arResult["SORT"] = $_SESSION["TDM_SECPARTS_SORTING"];
	$arResult["PRICES"] = array();
	$arMinPrices = array();
	$arMinDays = array();
	if (0 < count($arPARTS_noP)) {
		$rsDBPrices = new TDMQuery();
		if ($arResult["GROUP_VIEW"] == 1) {
			$GROUP_FILTER = " AND TYPE=" . $TDMCore->UserGroup;
		}
		foreach ($arPARTS_noP as $arTPart) {
			$PrcsSQL .= $PUnion . "SELECT * FROM TDM_PRICES WHERE BKEY=\"" . $arTPart["BKEY"] . "\" AND AKEY=\"" . $arTPart["AKEY"] . "\" " . $GROUP_FILTER;
			$PUnion = " UNION ";
		}
		switch ($_SESSION["TDM_SECPARTS_SORTING"]) {
			case 1:
				$PrSort = "PRICE ASC";
				break;
			
			case 2:
				$PrSort = "PRICE ASC";
				break;
			
			case 3:
				$PrSort = "PRICE ASC";
				break;
			
			case 4:
				$PrSort = "DAY ASC";
				break;
			
			case 5:
				$PrSort = "PRICE ASC";
			
		}
		$rsDBPrices->SimpleSelect($PrcsSQL . " ORDER BY " . $PrSort);
		$arNmC = array();
		$PrCnt = 0;
		while ($arPrice = $rsDBPrices->Fetch()) {
			if ($arComSets["HIDE_PRICES_NOAVAIL"] == 1 && $arPrice["AVAILABLE"] < 1) {
				continue;
			}
			++$PrCnt;
			$PrPKey = $arPrice["BKEY"] . $arPrice["AKEY"];
			if (trim($arPrice["ALT_NAME"]) != "") {
				if (!(in_array($PrPKey, $arNmC))) {
					$arPARTS_noP[$PrPKey]["NAME"] = "";
					$arNmC[] = $PrPKey;
				}
				if (strlen($arPARTS_noP[$PrPKey]["NAME"]) < strlen($arPrice["ALT_NAME"])) {
					$arPARTS_noP[$PrPKey]["NAME"] = $arPrice["ALT_NAME"];
				}
			}
			$arPrice = TDMFormatPrice($arPrice);
			$arResult["PRICES"][$PrPKey][] = $arPrice;
			++$arPARTS_noP[$PrPKey]["PRICES_COUNT"];
			if ($arMinPrices[$PrPKey] == 0 || $arPrice["PRICE_CONVERTED"] < $arMinPrices[$PrPKey]) {
				$arMinPrices[$PrPKey] = $arPrice["PRICE_CONVERTED"];
			}
			if ($arMinDays[$PrPKey] == "" || $arPrice["DAY"] < $arMinDays[$PrPKey]) {
				$arMinDays[$PrPKey] = $arPrice["DAY"] + 1;
			}
			if (!($arPrice["PRICE_CONVERTED"] < $arResult["AB_MIN_PRICE"][$arPrice["BKEY"]] || $arResult["AB_MIN_PRICE"][$arPrice["BKEY"]] == 0)) {
				continue;
			}
			$arResult["AB_MIN_PRICE"][$arPrice["BKEY"]] = $arPrice["PRICE_CONVERTED"];
			$arResult["AB_MIN_PRICE_F"][$arPrice["BKEY"]] = $arPrice["PRICE_CONVERTED"];
		}
		unset($arNmC);
		TDMSetTime("SelectPricesQuery(PARTS) ## For all selected " . count($arPARTS_noP) . " items  - returned prices count <b>" . $PrCnt . "</b>");
	}
	if ($arComSets["HIDE_NOPRICES"] == 1) {
		$arResult["HIDE_NOPRICES"] = "Y";
		TDMSetTime("HIDDEN PARTS ## Parts without prices are <b>HIDDEN</b>");
		$arPARTS_HdP = $arPARTS_noP;
		$arPARTS_noP = array();
		$arPAIDs_noP = array();
		foreach ($arPARTS_HdP as $PKEY => $arTPart) {
			if (!(0 < $arTPart["PRICES_COUNT"])) {
				continue;
			}
			$arPARTS_noP[$PKEY] = $arTPart;
			if (!(0 < $arTPart["AID"])) {
				continue;
			}
			$arPAIDs_noP[] = $arTPart["AID"];
		}
	}
	$TDMCore->DBSelect("TECDOC");
	TDMSetTime("DBSelect(TECDOC)");
	foreach ($arPARTS_noP as $PKEY => $arTPart) {
		$arResult["ALL_BRANDS"][$arTPart["BKEY"]] = $arTPart["BRAND"];
	}
	$arResult["LETTERS_LIMIT"] = $arComSets["FILTER_BRANDS_LETTERS_LIMIT"];
	$arResult["SHOW_FILTER_BRANDS"] = $arComSets["SHOW_FILTER_BRANDS"];
	$arResult["ALL_BRANDS_COUNT"] = count($arResult["ALL_BRANDS"]);
	$arResult["FILTERED_BRANDS"] = array();
	if ($_SESSION["TDM_SECPARTS_FILTER_SECTION"] != strtok($_SERVER["REQUEST_URI"], "&")) {
		$_SESSION["TDM_SECPARTS_FILTER_SECTION"] = strtok($_SERVER["REQUEST_URI"], "&");
		$_SESSION["TDM_SECPARTS_FILTER_BRANDS"] = array();
	}
	if ($_POST["BRAND_FILTER"] != "" && array_key_exists($_POST["BRAND_FILTER"], $arResult["ALL_BRANDS"]) && !(in_array($_POST["BRAND_FILTER"], $_SESSION["TDM_SECPARTS_FILTER_BRANDS"]))) {
		$_SESSION["TDM_SECPARTS_FILTER_BRANDS"][] = $_POST["BRAND_FILTER"];
	}
	if ($_POST["BRAND_REMOVE"] != "") {
		if ($_POST["BRAND_REMOVE"] == "BFRA") {
			$_SESSION["TDM_SECPARTS_FILTER_BRANDS"] = array();
		}
		else {
			if (($DelBKEY = array_search($_POST["BRAND_REMOVE"], $_SESSION["TDM_SECPARTS_FILTER_BRANDS"])) !== false) {
				unset($_SESSION["TDM_SECPARTS_FILTER_BRANDS"][$DelBKEY]);
			}
		}
	}
	if (0 < count($_SESSION["TDM_SECPARTS_FILTER_BRANDS"])) {
		foreach ($arPARTS_noP as $PKEY => $arTPart) {
			if (!(in_array($arTPart["BKEY"], $_SESSION["TDM_SECPARTS_FILTER_BRANDS"]))) {
				unset($arPARTS_noP[$PKEY]);
				if (($PAKey = array_search($arTPart["AID"], $arPAIDs_noP)) !== false) {
					unset($arPAIDs_noP[$PAKey]);
				}
				++$FilteredBrands;
				continue;
			}
			$arResult["FILTERED_BRANDS"][$arTPart["BKEY"]] = $arTPart["BRAND"];
			if (!($arResult["LETTERS_LIMIT"] < $arResult["ALL_BRANDS_COUNT"])) {
				continue;
			}
			unset($arResult["ALL_BRANDS"][$arTPart["BKEY"]]);
		}
		$arResult["FILTERED_BRANDS_COUNT"] = count($arResult["FILTERED_BRANDS"]);
		TDMSetTime("FilteringByBrands(PARTS_noP) ## Filtered by Brands items count <b>" . $FilteredBrands . "</b>");
	}
	if (0 < $LinksCnt) {
		foreach ($arPARTS_noP as $PKey => $arTPart) {
			if (!(isset($arTPart["LINK_CODE"]))) {
				continue;
			}
			++$GetCrNum;
			$arGPart = TDSQL::GetPartByPKEY($arTPart["BKEY"], $arTPart["AKEY"]);
			if (!(0 < $arGPart["AID"])) {
				continue;
			}
			++$SetCrNum;
			$arPARTS_noP[$PKey]["AID"] = $arGPart["AID"];
			$arPARTS_noP[$PKey]["ARTICLE"] = $arGPart["ARTICLE"];
			$arPARTS_noP[$PKey]["BRAND"] = $arGPart["BRAND"];
			$arPARTS_noP[$PKey]["TD_NAME"] = $arGPart["TD_NAME"];
			if ($arPARTS_noP[$PKey]["NAME"] == "") {
				$arPARTS_noP[$PKey]["NAME"] = $arGPart["TD_NAME"];
			}
			$arPAIDs_noP[] = $arGPart["AID"];
			$arResult["ALL_BRANDS"][$arTPart["BKEY"]] = $arGPart["BRAND"];
		}
		if (0 < $GetCrNum) {
			TDMSetTime("GetPartByPKEY(PARTS) ## Get TecDoc <b>LINKS</b> info for this page items. Try get <b>" . $GetCrNum . "</b>. Returned <b>" . $SetCrNum . "</b>");
		}
	}
	$arPAIDs_noP_cnt = count($arPAIDs_noP);
	$arPImgAvail = array();
	if (0 < $arPAIDs_noP_cnt) {
		$arPImgAvail = TDSQL::ImagesAvialable($arPAIDs_noP);
		TDMSetTime("ImagesAvialable(arPAIDs_noP) ## All selected " . $arPAIDs_noP_cnt . " items  - returned rows count <b>" . count($arPImgAvail) . "</b>");
	}
	if (0 < $arPAIDs_noP_cnt && $arComSets["SHOW_ITEM_PROPS"] == 1 && $arResult["VIEW"] == "LIST") {
		$rsProps = TDSQL::GetPropertysUnion($arPAIDs_noP);
		TDMSetTime("GetPropertysUnion(PAIDs) ## For items count - " . $arPAIDs_noP_cnt);
		foreach ($arPARTS_noP as $PKey => $arTPart) {
			$ar_AID[$PKey] = $arTPart["AID"];
			$ar_PKEY[$arTPart["AID"]] = $PKey;
		}
		$arHiddenProps = array(1073);
		while ($arProp = $rsProps->Fetch()) {
			if (!($arProp["VALUE"] != "")) {
				continue;
			}
			if ($arProp["CRID"] == 836 || $arProp["CRID"] == 596) {
				$arProp["NAME"] = $arProp["VALUE"];
				$arProp["VALUE"] = "";
			}
			if (!(in_array($arProp["AID"], $ar_AID) && !(isset($arPARTS_noP[$ar_PKEY[$arProp["AID"]]]["PROPS"][$arProp["NAME"]])))) {
				continue;
			}
			if ($arProp["CRID"] == 410) {
				$arProp["VALUE"] = "<a href=\"/" . TDM_ROOT_DIR . "/templates/descriptions/spring_" . TDM_LANG . ".php?trd=" . TDM_ROOT_DIR . "\" class=\"popup\">" . $arProp["VALUE"] . "</a>";
			}
			if (TDM_ISADMIN && $arProp["VALUE"] != "") {
				$arProp["VALUE"] = "<span title=\"CRID: " . $arProp["CRID"] . "\">" . $arProp["VALUE"] . "</span>";
			}
			++$arPARTS_noP[$ar_PKEY[$arProp["AID"]]]["PROPS_COUNT"];
			$arPARTS_noP[$ar_PKEY[$arProp["AID"]]]["PROPS"][$arProp["NAME"]] = array("CRID" => $arProp["CRID"], "VALUE" => $arProp["VALUE"]);
		}
		TDMSetTime("GetPropertysUnion(PAIDs) ## Processing result");
	}
	$arSortKeys = array();
	foreach ($arPARTS_noP as $PKEY => $arTPart) {
		$SortNum = 999999999;
		if ($arResult["SORT"] == 1) {
			if (0 < $arTPart["PRICES_COUNT"]) {
				$SortNum = 999;
			}
		}
		else {
			if ($arResult["SORT"] == 2) {
				if (0 < $arTPart["PRICES_COUNT"]) {
					$SortNum = 999;
				}
				if (in_array($arTPart["AID"], $arPImgAvail)) {
					$SortNum = $SortNum - 100;
				}
				if (0 < $arPARTS_noP[$PKEY]["PROPS_COUNT"]) {
					$SortNum = $SortNum - $arPARTS_noP[$PKEY]["PROPS_COUNT"];
				}
			}
			else {
				if ($arResult["SORT"] == 3) {
					if (0 < $arMinPrices[$PKEY]) {
						$SortNum = $arMinPrices[$PKEY];
					}
				}
				else {
					if ($arResult["SORT"] == 4) {
						if (0 < $arMinDays[$PKEY]) {
							$SortNum = $arMinDays[$PKEY];
						}
					}
					else {
						if ($arResult["SORT"] == 5) {
							if (in_array($arTPart["AID"], $arPImgAvail)) {
								$SortNum = 1;
							}
						}
					}
				}
			}
		}
		$arSortKeys[] = $SortNum;
	}
	if (0 < count($arSortKeys) && 0 < count($arPARTS_noP)) {
		array_multisort($arSortKeys, $arPARTS_noP);
	}
	$arResult["PAGINATION"]["TOTAL_ITEMS"] = count($arPARTS_noP);
	$OnPage = $arComSets["ITEMS_ON_PAGE_" . $arResult["VIEW"]];
	$arResult["PAGINATION"]["TOTAL_PAGES"] = ceil($arResult["PAGINATION"]["TOTAL_ITEMS"] / $OnPage);
	$CrPage = intval($_REQUEST["page"]);
	if ($CrPage < 1) {
		$CrPage = 1;
	}
	if ($arResult["PAGINATION"]["TOTAL_PAGES"] < $CrPage) {
		$CrPage = $arResult["PAGINATION"]["TOTAL_PAGES"];
	}
	if ($OnPage < $arResult["PAGINATION"]["TOTAL_ITEMS"]) {
		if ($OnPage < 6) {
			$OnPage = 6;
		}
		if (100 < $OnPage) {
			$OnPage = 100;
		}
		$PStart = $OnPage * ($CrPage - 1);
		$PEnd = $OnPage * $CrPage;
		foreach ($arPARTS_noP as $PKey => $arTPart) {
			++$PCn;
			if ($PStart < $PCn && $PCn <= $PEnd) {
				++$ThisPg;
				$arPARTS[$PKey] = $arTPart;
				if (0 < $arTPart["AID"]) {
					$arPAIDs[] = $arTPart["AID"];
				}
			}
			if (!($PEnd <= $PCn)) {
				continue;
			}
			break;
		}
		$arResult["PAGINATION"]["ITEMS_ON_THIS_PAGE"] = $ThisPg;
		$arResult["PAGINATION"]["PAGES_LINK"] = $_SERVER["REQUEST_URI"];
	}
	else {
		$arPARTS = $arPARTS_noP;
		$arPAIDs = $arPAIDs_noP;
	}
	$arResult["PAGINATION"]["ITEMS_ON_PAGE"] = $OnPage;
	$arResult["PAGINATION"]["CURRENT_PAGE"] = $CrPage;
	TDMSetTime("Sorting & Pagination ## For items count - " . count($arPARTS_noP));
	if ($arComSets["SHOW_ITEM_PROPS"] == 1 && $arResult["VIEW"] == "LIST") {
		$arCrPrior = array(100 => 1, 410 => 2, 497 => 3);
		foreach ($arPARTS as $PKey => $arTPart) {
			if (!(0 < count($arTPart["PROPS"]))) {
				continue;
			}
			$arCProps = $arTPart["PROPS"];
			$arPARTS[$PKey]["PROPS"] = array();
			$arSortedProps = array();
			$arSortKeys = array();
			foreach ($arCProps as $PName => $arPValue) {
				$PName = str_replace("/\xd0\xbc\xd0\xbc?", "/\xd0\xbc\xd0\xbc\xc2\xb2", $PName);
				$PName = str_replace("? ", "\xc3\x98 ", $PName);
				if (0 < strpos($PName, "[")) {
					$Dim = substr($PName, strpos($PName, "["));
					$PName = str_replace(" " . $Dim, "", $PName);
					$Dim = str_replace("[", "", $Dim);
					$Dim = str_replace("]", "", $Dim);
					$arPValue["VALUE"] = $arPValue["VALUE"] . " " . $Dim;
				}
				if (!(array_key_exists(UWord($PName), $arSortedProps))) {
					if (0 < $arCrPrior[$arPValue["CRID"]]) {
						$SortNum = $arCrPrior[$arPValue["CRID"]];
					}
					else {
						$SortNum = 99999;
					}
					$arSortKeys[] = $SortNum;
					$arSortedProps[UWord($PName)] = $arPValue["VALUE"];
					continue;
				}
				$arSortedProps[UWord($PName)] .= " (" . $arPValue["VALUE"] . ")";
			}
			if (1 < count($arSortKeys) && 1 < count($arSortedProps)) {
				array_multisort($arSortKeys, $arSortedProps);
			}
			$arPARTS[$PKey]["PROPS"] = $arSortedProps;
		}
	}
	$arPAIDs_cnt = count($arPAIDs);
	if (0 < $arPAIDs_cnt) {
		$rsAppCrit = TDSQL::GetAppCriteriaUnion($arPAIDs, $TYP_ID);
		TDMSetTime("GetAppCriteriaUnion(PAIDs,TYP) ## For items count - " . $arPAIDs_cnt);
		while ($arAppCrit = $rsAppCrit->Fetch()) {
			if (!($arAppCrit["VALUE"] != "")) {
				continue;
			}
			foreach ($arPARTS as $PKey => $arTPart) {
				if (!($arTPart["AID"] == $arAppCrit["AID"])) {
					continue;
				}
				++$arPARTS[$PKey]["CRITERIAS_COUNT"];
				$CrKey = UWord($arAppCrit["CRITERIA"]);
				$arPARTS[$PKey]["CRITERIAS"][$CrKey] = $arAppCrit["VALUE"];
				break;
			}
		}
	}
	$arResult["ART_LOGOS"] = array();
	if (0 < $arPAIDs_cnt) {
		$rsImages = TDSQL::GetImagesUnion($arPAIDs);
		TDMSetTime("GetImagesUnion(PAIDs) ## For items count - " . $arPAIDs_cnt);
		while ($arImage = $rsImages->Fetch()) {
			foreach ($arPARTS as $PKey => $arTPart) {
				if (!($arTPart["AID"] == $arImage["AID"] && !(strpos($arImage["PATH"], "0/0.jpg")))) {
					continue;
				}
				if ($arPARTS[$PKey]["IMG_ZOOM"] == "") {
					$arPARTS[$PKey]["IMG_SRC"] = "http://" . TECDOC_FILES_PREFIX . $arImage["PATH"];
					$arPARTS[$PKey]["IMG_ZOOM"] = "Y";
					$arPARTS[$PKey]["IMG_FROM"] = "TecDoc";
					continue;
				}
				$arPARTS[$PKey]["IMG_ADDITIONAL"][] = "http://" . TECDOC_FILES_PREFIX . $arImage["PATH"];
			}
		}
		$rsBLogos = TDSQL::GetArtsLogoUnion($arPAIDs);
		TDMSetTime("GetArtsLogoUnion(PAIDs) ## For items count - " . $arPAIDs_cnt);
		while ($arBLogos = $rsBLogos->Fetch()) {
			$arResult["ART_LOGOS"][$arBLogos["AID"]] = "http://" . TECDOC_FILES_PREFIX . $arBLogos["PATH"];
		}
	}
	$TDMCore->DBSelect("MODULE");
	$WS = new TDMWebservers();
	if (isset($arWSP) && is_array($arWSP) && 0 < count($arWSP)) {
		$arWSPartsActual = $arWSP;
	}
	else {
		$arWSPartsActual = $arPARTS;
	}
	$WS->SearchPrices(array(), $arWSPartsActual, array("CACHE_MODE" => false, "SID" => $SEC_ID, "PKEY" => $S_BRAND . $S_ARTICLE));
	if (0 < count($WS->arOnlinePrices)) {
		$arOnlineIgnored = array();
		foreach ($WS->arOnlinePrices as $arPrice) {
			if ($arResult["GROUP_VIEW"] == 1 && $arPrice["TYPE"] != $TDMCore->UserGroup) {
				++$IgnoredByType;
				continue;
			}
			$arPrice["ONLINE"] = "Y";
			$PrPKey = $arPrice["BKEY"] . $arPrice["AKEY"];
			if (is_array($arPARTS[$PrPKey]) || $arComSets["HIDE_NOTECDOC_ONLINE_PRICES"] == 0) {
				if (!(is_array($arPARTS[$PrPKey]))) {
					$arPARTS[$PrPKey] = array("PKEY" => $PrPKey, "BKEY" => $arPrice["BKEY"], "AKEY" => $arPrice["AKEY"], "ARTICLE" => $arPrice["ARTICLE"], "BRAND" => $arPrice["BRAND"], "NAME" => $arPrice["ALT_NAME"]);
				}
				if ($arComSets["HIDE_PRICES_NOAVAIL"] == 1 && $arPrice["AVAILABLE"] < 1) {
					continue;
				}
				++$OnPrCnt;
				++$arPARTS[$PrPKey]["PRICES_COUNT"];
				if (trim($arPrice["ALT_NAME"]) != "") {
					if (strlen($arPARTS[$PrPKey]["NAME"]) < strlen($arPrice["ALT_NAME"])) {
						$arPARTS[$PrPKey]["NAME"] = $arPrice["ALT_NAME"];
					}
				}
				if ($arPrice["PRICE_CONVERTED"] < $arResult["AB_MIN_PRICE"][$arPrice["BKEY"]] || $arResult["AB_MIN_PRICE"][$arPrice["BKEY"]] == 0) {
					$arResult["AB_MIN_PRICE"][$arPrice["BKEY"]] = $arPrice["PRICE_CONVERTED"];
					$arResult["AB_MIN_PRICE_F"][$arPrice["BKEY"]] = $arPrice["PRICE_CONVERTED"];
				}
				$arResult["PRICES"][$PrPKey][] = TDMFormatPrice($arPrice);
				continue;
			}
			$arOnlineIgnored[$arPrice["SUPPLIER"]][$PrPKey] = "<b>" . $arPrice["BKEY"] . "</b> " . $arPrice["AKEY"];
		}
		if (0 < count($arOnlineIgnored)) {
			foreach ($arOnlineIgnored as $IgnSupp => $arIngParts) {
				TDMSetTime("Webserice <b>" . $IgnSupp . "</b> ## Ignored On-line prices: <br>" . implode(", ", $arIngParts));
			}
		}
		if (0 < $IgnoredByType) {
			TDMSetTime("Webserices ## On-line prices ignored by <u>TYPE " . $TDMCore->UserGroup . "</u> - <b>" . $IgnoredByType . "</b> for this page");
		}
		if (0 < $OnPrCnt) {
			TDMSetTime("Webserices ## On-line prices count returned <b>" . $OnPrCnt . "</b> for this page");
		}
	}
	$arSortKeys = array();
	foreach ($arPARTS as $PKEY => $arTPart) {
		$SortNum = 999999999;
		$MinPrice = 0;
		$MinDays = 0;
		$arItemSortKeys = array();
		if (is_array($arResult["PRICES"][$PKEY]) && 0 < count($arResult["PRICES"][$PKEY])) {
			foreach ($arResult["PRICES"][$PKEY] as $arSPr) {
				$arItemSortKeys[] = $arSPr["PRICE_CONVERTED"];
				if ($MinPrice == 0 || $arSPr["PRICE_CONVERTED"] < $MinPrice) {
					$MinPrice = $arSPr["PRICE_CONVERTED"];
				}
				if (!($MinDays == 0 || $arSPr["DAY"] < $MinDays)) {
					continue;
				}
				$MinDays = $arSPr["DAY"] + 1;
			}
			array_multisort($arItemSortKeys, $arResult["PRICES"][$PKEY]);
		}
		if ($arResult["SORT"] == 1) {
			if (0 < $arTPart["PRICES_COUNT"]) {
				$SortNum = 999;
			}
		}
		else {
			if ($arResult["SORT"] == 2) {
				if (0 < $arTPart["PRICES_COUNT"]) {
					$SortNum = 999;
				}
				if (0 < $arPARTS[$PKEY]["PROPS_COUNT"]) {
					$SortNum = $SortNum - $arPARTS[$PKEY]["PROPS_COUNT"];
				}
			}
			else {
				if ($arResult["SORT"] == 3) {
					if (0 < $MinPrice) {
						$SortNum = $MinPrice;
					}
				}
				else {
					if ($arResult["SORT"] == 4) {
						if (0 < $MinDays) {
							$SortNum = $MinDays;
						}
					}
				}
			}
		}
		$arSortKeys[] = $SortNum;
	}
	if (0 < count($arSortKeys) && 0 < count($arPARTS)) {
		array_multisort($arSortKeys, $arPARTS);
	}
}
$arResult["PARTS"] = array();
$arResult["PARTS"] = $arPARTS;
if (0 < $arResult["ALL_BRANDS_COUNT"]) {
	$arABSortKeys = array();
	foreach ($arResult["ALL_BRANDS"] as $BKEY => $BRAND) {
		if (!(in_array(substr($BKEY, 0, 1), $arResult["ALL_BRANDS_LETTERS"]))) {
			$arResult["ALL_BRANDS_LETTERS"][] = substr($BKEY, 0, 1);
		}
		if (0 < $arResult["AB_MIN_PRICE_F"][$BKEY]) {
			$arABSortKeys[] = $arResult["AB_MIN_PRICE_F"][$BKEY];
			continue;
		}
		$arABSortKeys[] = 99999999;
	}
	if (is_array($arResult["ALL_BRANDS_LETTERS"]) && 0 < count($arResult["ALL_BRANDS_LETTERS"])) {
		asort($arResult["ALL_BRANDS_LETTERS"]);
	}
	if (0 < count($arResult["ALL_BRANDS"]) && 0 < count($arABSortKeys)) {
		array_multisort($arABSortKeys, $arResult["ALL_BRANDS"]);
	}
}
$arResult["ADDED_PHID"] = TDMPerocessAddToCart($arResult["PRICES"], $arResult["PARTS"]);

?>