<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<?
$RSID = intval($_REQUEST['sec_id']);
if($RSID<=0){ErAdd('Root section ID is not set');}

//Save changes
if($_POST['editme']=="Y"){
	if($_POST['TEMPLATE']==""){ErAdd(Lng('A_required_field')." - ".Lng('Template'),1);}
	if(ErCheck()){
		$arACTIVE = $arComSets['ACTIVE']; //Add records of other brands models to
		$arACTIVE[$RSID] = $_POST['ACTIVE'];
		$arNAME = $arComSets['NAME'];
		foreach($_POST['NAME'] as $nSID=>$nVal){ $nVal=trim($nVal);  $arNAME[$nSID] = $nVal; }
		$arCODE = $arComSets['CODE'];
		foreach($_POST['CODE'] as $nSID=>$nVal){ $nVal=trim($nVal); if($nVal!=''){ $arCODE[$nSID] = StrForURL($nVal);} }
		$arPARENT = $arComSets['PARENT'];
		foreach($_POST['PARENT'] as $nSID=>$nVal){ $nVal=trim($nVal); if($nVal!=''){ $arPARENT[$nSID] = intval($nVal);} }
		$arIGNORE = $arComSets['IGNORE'];
		$arIGNORE[$RSID] = intval($_POST['IGNORE']);
		$SvRes = TDMSaveSetsFile(TDMGetSetsPath($CompCode),"arComSets",Array(
			Array("S","TEMPLATE",$_POST['TEMPLATE']),
			Array("I","CACHE",intval($_POST['CACHE'])),
			Array("A","IGNORE",$arIGNORE,Array(1,1,0,0)),
			Array("A","ACTIVE",$arACTIVE,Array(1,1,0,0)), //WithKeys,NewLine,KeyStr,ValStr
			Array("A","NAME",$arNAME,Array(1,1,0,1)),
			Array("A","PARENT",$arPARENT,Array(1,1,0,0)),
			Array("A","CODE",$arCODE,Array(1,1,0,1)),
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
$arSections = Array();
$rsSec2 = TDSQL::GetSections(0,$RSID,'DESCENDANTS');
while($arSec2 = $rsSec2->Fetch()){
	$arSections[] = $arSec2;
	$rsSec3 = TDSQL::GetSections(0,$arSec2['STR_ID']);
	while($arSec3 = $rsSec3->Fetch()){
		$arSections[] = $arSec3;
		$rsSec4 = TDSQL::GetSections(0,$arSec3['STR_ID']);
		while($arSec4 = $rsSec4->Fetch()){
			$arSections[] = $arSec4;
		}
	}
}

//Section picture
$SPicSrc = '/'.TDM_ROOT_DIR.'/media/sections/'.$RSID.'.jpg';
if(file_exists($_SERVER["DOCUMENT_ROOT"].$SPicSrc)){$RSPICTURE = $SPicSrc;}
else{$RSPICTURE = '/'.TDM_ROOT_DIR.'/media/sections/default.png';}

$arRComSets = TDMGetSets('sections');
foreach($arRComSets["CODE"] as $RtSID=>$RCode){
	$RtName = Lng($arRComSets["NAME"][$RtSID],0,0);
	if($RtName!=''){$arRSecs[$RtSID]=$RtName;}else{$arRSecs[$RtSID]='- '.UWord($RCode);}
}
?>
<?ErShow();?>
<div class="secrpic" style="background-image:url(<?=$RSPICTURE?>);"></div>


<table class="formtab" >
<tr>
	<td class="fname"><?=Lng('Section')?>: </td>
	<td class="fvalues">
		<select name="RSECTION" style="width:300px;" onchange="window.location = '?to=subsections&brand=<?=$_REQUEST['brand']?>&sec_id='+$(this).val();">
			<?FShowSelectOptionsK($arRSecs,$RSID);?>
		</select>
	</td>
</tr>
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
</tr><tr>
	<td class="fname"><?=Lng('Ignore_type_of_car')?>: </td>
	<td class="ftext">
		<input type="checkbox" name="IGNORE" value="1" <?if($arComSets['IGNORE'][$RSID]==1){?> checked <?}?> >  
		<span class="tiptext"><?=Tip('Not_check_in_db_type_car')?></span>
	</td>
</tr>
<tr><td colspan="2"><hr></td></tr>
</table>


<table class="eftab">
	<tr class="head">
		<td title="TecDoc Section ID">SID</td>
		<td title="Dynamic Parent Section ID">PID</td>
		<td title="TecDoc fixed Parent Section ID">TID</td>
		<td><?=Lng('Off_')?></td>
		<td><?=Lng('Name')?></td>
		<td title="<?=strip_tags(Tip('Language_phrases_in_field'));?>"><?=Lng('Rename_to')?>*</td>
		<td>URL code <?/*<a href="javascript:void(0);" onclick="AddFormPost('FILLCODE')"><img src="images/fill.png" width="16px" height="16px" title="<?=Tip('Automatically_fillin_CODE_fields')?>"/></a>*/?></td>
	</tr>
	<?
	$arACTIVE = Array();
	if(is_array($arComSets['ACTIVE'][$RSID])){$arACTIVE=$arComSets['ACTIVE'][$RSID];}
	foreach($arSections as $arSec){
		$SID = $arSec['STR_ID']; $NStyle='';
		if($arComSets['PARENT'][$SID]>0 AND $arComSets['PARENT'][$SID]!=$arSec['PID']){$PID=$arComSets['PARENT'][$SID]; $PIDStyle='color:#ff0000;';}else{$PID=$arSec['PID']; $PIDStyle='';}
		if(in_array($SID,$arACTIVE)){$IsSel="checked";}else{$IsSel="";}
		if($arSec['STR_LEVEL']<4){$Lvl = ''; $NStyle='style="font-weight:bold;"'; if($Cnt>0){?><tr><td colspan="5"><hr></td></tr><?} $Cnt=0; }
		if($arSec['STR_LEVEL']==4){$Lvl = '&nbsp;&nbsp;&nbsp;&raquo;'; $Cnt++;}
		if($arSec['STR_LEVEL']==5){$Lvl = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;';}
		
		?>
		<tr><td class="gcolor"><?=$SID?></td>
			<td><input type="text" name="PARENT[<?=$SID?>]" value="<?=$PID?>" style="width:50px; <?=$PIDStyle?>"></td>
			<td class="gcolor"><?=$arSec['PID']?></td>
			<td><input type="checkbox" name="ACTIVE[]" value="<?=$SID?>" <?=$IsSel?> ></td>
			<td <?=$NStyle?> ><?=$Lvl?> <?=UWord($arSec['STR_DES_TEXT'])?></td>
			<td><input type="text" name="NAME[<?=$SID?>]" value="<?=$arComSets['NAME'][$SID]?>" style="width:220px;"></td>
			<td>
				<?if($arSec['DESCENDANTS']<=0){
					if($_POST['ADDFIELD']=="FILLCODE" AND $arComSets['CODE'][$SID]==''){$arComSets['CODE'][$SID]=StrForURL($arSec['STR_DES_TEXT'],false);}?>
					<input type="text" name="CODE[<?=$SID?>]" value="<?=$arComSets['CODE'][$SID]?>" style="width:180px;">
				<?}?>
			</td>
		</tr>
	<?}?>
</table>


<br>
<span class="tiptext">* <?=Tip('Language_phrases_in_field');?></span>
<br><br>