<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<?
//Save changes
if($_POST['editme']=="Y"){
	if($_POST['TEMPLATE']==""){ErAdd(Lng('A_required_field')." - ".Lng('Template'),1);}
	if(ErCheck()){
		$arNAME = $arComSets['NAME'];
		foreach($_POST['NAME'] as $nSID=>$nVal){ $nVal=trim($nVal); if($nVal!=''){$arNAME[$nSID] = $nVal;} }
		$arCODE = $arComSets['CODE'];
		foreach($_POST['CODE'] as $nSID=>$nVal){ $nVal=trim($nVal); if($nVal!=''){$arCODE[$nSID] = StrForURL($nVal);} }
		$SvRes = TDMSaveSetsFile(TDMGetSetsPath($CompCode),"arComSets",Array(
			Array("S","TEMPLATE",$_POST['TEMPLATE']),
			Array("I","CACHE",intval($_POST['CACHE'])),
			Array("I","SECTIONS_TREE",intval($_POST['SECTIONS_TREE'])),
			Array("A","ACTIVE",$_POST['ACTIVE'],Array(0,0,0,0)), //WithKeys,NewLine,KeyStr,ValStr
			Array("A","NAME",$arNAME,Array(1,0,0,1)),
			Array("A","SORT",$_POST['SORT'],Array(1,0,0,0)),
			Array("A","CODE",$arCODE,Array(1,0,0,1)),
		));
		if($SvRes){
			NtAdd(Lng("Settings_saved"));
			$arComSets = TDMGetSets($CompCode);
			//clear cache
			array_map('unlink', glob(TDM_PATH.'/tdmcore/cache/'.$CompCode.'/*'));
		}else{ErAdd("False to save settings!",2);}
	}
}

$TDMCore->DBConnect("TECDOC");
$rsSec = TDSQL::GetSectionsRoot(10001);
?>
<?ErShow();?>
<table class="formtab" >
<tr>
	<td class="fname"><?=Lng('Component_cache')?>: </td>
	<td class="ftext">
		<input type="checkbox" name="CACHE" value="1" <?if($arComSets['CACHE']==1){?> checked <?}?> > 
	</td>
</tr><tr>
	<td class="fname"><?=Lng('Template')?>: </td>
	<td class="fvalues">
		<select name="TEMPLATE" style="width:200px;">
			<?$arTemps = TDMGetTemplates($CompCode);
			FShowSelectOptions($arTemps,$arComSets['TEMPLATE']);?>
		</select>
	</td>
</tr>
<?/*
<tr>
	<td class="fname"><?=Lng('Full_sections_tree')?>: </td>
	<td class="ftext">
		<input type="checkbox" name="SECTIONS_TREE" value="1" <?if($arComSets['SECTIONS_TREE']==1){?> checked <?}?> > 
	</td>
</tr>*/?>
<tr><td colspan="2"><hr></td></tr>
</table>

<span class="tiptext"><?=Lng('All_fields_are_required')?>:</span>
<table class="eftab" style="margin-top:5px;">
	<tr class="head">
		<td>SID</td>
		<td><?=Lng('On_')?></td>
		<td>TecDoc <?=Lng('Name')?></td>
		<td><?=Lng('Sort')?></td>
		<td title="<?=strip_tags(Tip('Language_phrases_in_field'));?>"><?=Lng('Rename_to')?>*</td>
		<td>URL code</td>
	</tr>
	<?while($arSec = $rsSec->Fetch()){
		$SID = $arSec['STR_ID'];
		if($arComSets['SORT'][$SID]<=0){$arComSets['SORT'][$SID]=99;}
		$arSections[] = $arSec;
		$arSortKeys[] = $arComSets['SORT'][$SID];
	}
	array_multisort($arSortKeys, $arSections);
	
	foreach($arSections as $arSec){
		$SID = $arSec['STR_ID'];
		if(in_array($SID,$arComSets['ACTIVE'])){$IsSel="checked";}else{$IsSel="";}
		?>
		<tr><td class="gcolor"><?=$SID?></td>
			<td><input type="checkbox" name="ACTIVE[]" value="<?=$SID?>" <?=$IsSel?> ></td>
			<td><?=UWord($arSec['STR_DES_TEXT'])?></td>
			<td><input type="text" name="SORT[<?=$SID?>]" value="<?=$arComSets['SORT'][$SID]?>" size="4" maxlength="4" style="width:36px;"></td>
			<td><input type="text" name="NAME[<?=$SID?>]" value="<?=$arComSets['NAME'][$SID]?>" style="width:230px;"></td>
			<td><input type="text" name="CODE[<?=$SID?>]" value="<?=$arComSets['CODE'][$SID]?>" style="width:230px;"></td>
		</tr>
	<?}?>
</table>
<br>
<span class="tiptext">* <?=Tip('Language_phrases_in_field');?></span>
<br><br>
