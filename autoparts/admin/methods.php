<?php

function FShowSelectOptions($arValues, $Selected) {
	foreach ($arValues as $Value) {
		if ($Selected == $Value) {
			$IsSel = "selected";
		}
		else {
			$IsSel = "";
		}
		echo("<option value=\"" . $Value . "\" " . $IsSel . " >" . $Value . "</option>");
	}
}

function FShowSelectOptionsK($arKValues, $Selected) {
	foreach ($arKValues as $Value => $Label) {
		if ($Selected == $Value) {
			$IsSel = "selected";
		}
		else {
			$IsSel = "";
		}
		echo("<option value=\"" . $Value . "\" " . $IsSel . " >" . $Label . "</option>");
	}
}

function FShowInputRadio($Name, $arKValues, $Selected) {
	foreach ($arKValues as $Value => $Label) {
		if ($Selected == $Value) {
			$IsSel = "checked";
		}
		else {
			$IsSel = "";
		}
		echo("<label><input type=\"radio\" name=\"" . $Name . "\" value=\"" . $Value . "\" " . $IsSel . "/> " . $Label . "</label><br />");
	}
}

define("TDM_PROLOG_INCLUDED", true);

