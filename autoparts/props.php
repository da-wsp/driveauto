<?define('TDM_PROLOG_INCLUDED',true);
require_once("tdmcore/defines.php");
require_once("tdmcore/init.php");
?>
<link rel="stylesheet" href="/<?=TDM_ROOT_DIR?>/styles.css" type="text/css">
<div style="padding:30px;">
<?
$AID=intval($_GET['of']);
if($AID<=0){echo 'Error! Invalid number parameters.'; die();}

$TDMCore->DBSelect("TECDOC");
$rsProps = TDSQL::GetPropertys($AID);
$arUnqs=Array();
while($arProp = $rsProps->Fetch()){
	$Unq=$arProp['NAME'].$arProp['VALUE'];
	if(!in_array($Unq,$arUnqs)){
		$arUnqs[] = $Unq;
		$arProps[] = $arProp;
	}
}
if(count($arProps)>0){?>
	<table class="chartab"><tr class="head"><td colspan="2"><?=Lng('Characteristics',1,0)?>:</td></tr>
	<?
	foreach($arProps as $arProp){
		$arProp['NAME'] = str_replace('/мм?','/мм²',$arProp['NAME']);
		$arProp['NAME'] = str_replace('? ','Ø ',$arProp['NAME']);
		if(strpos($arProp['NAME'],'[')>0){
			$Dim = substr($arProp['NAME'],strpos($arProp['NAME'],'['));
			$arProp['NAME'] = str_replace(' '.$Dim,'',$arProp['NAME']);
			$Dim = str_replace('[','',$Dim); $Dim = str_replace(']','',$Dim);
			$arProp['VALUE'] = $arProp["VALUE"].' '.$Dim;
		}
		?>
		<tr><td class="tarig"><?=UWord($arProp['NAME'])?>: </td><td><?=$arProp['VALUE']?></td></tr>
		<?
	}
	?>
	</table>
	<br>
	<div class="tclear"></div>
<?}?>


<?$rsNums = TDSQL::LookupAnalog($AID,Array(2,3,5)); //2-Торговый, 3-Оригинальный, 4-Неоригинальный, 5-Штрих код
while($arNum = $rsNums->Fetch()){
	$arNums[] = $arNum;
}
if(count($arNums)>0){?>
	<table class="chartab" style="float:left;"><tr class="head"><td colspan="2"><?=Lng('Related_numbers',1,0)?>:</td><td><?=Lng('Number_type',1,0)?></td></tr>
	<?
	foreach($arNums as $arNum){$Srch='';
		if($arNum['ARTICLE']==""){continue;}
		if($arNum['TYPE']==2){$arNum['TYPE']='<span class="artkind_trade">'.Lng('Trade',1,0).'</span>'; $Srch='Y';}
		if($arNum['TYPE']==3){$arNum['TYPE']='<span class="artkind_original">'.Lng('Original',1,0).'</span>'; $Srch='Y';}
		if($arNum['TYPE']==4){$arNum['TYPE']='<span class="artkind_analog">'.Lng('Analog',1,0).'</span>'; $Srch='Y';}
		if($arNum['TYPE']==5){$arNum['TYPE']='<span class="artkind_barcode">'.Lng('Barcode',1,0).'</span>';}
		?>
		<tr><td class="tarig"><?=$arNum['BRAND']?></td>
			<td><?if($Srch=="Y"){?><a href="/<?=TDM_ROOT_DIR?>/search/<?=TDMSingleKey($arNum['ARTICLE'])?>/"><?}?><?=$arNum['ARTICLE']?></a></td>
			<td><?=$arNum['TYPE']?></td>
		</tr>
		<?
	}
	?>
	</table>
<?}?>
<?
$rsPDFs = TDSQL::GetPDFs($AID);
while($arPDF = $rsPDFs->Fetch()){
	echo '<a href="http://'.TECDOC_FILES_PREFIX.$arPDF['PATH'].'" title="Download PDF"><img src="/'.TDM_ROOT_DIR.'/media/images/pdf32.png" width="32px" height="32px" style="float:left; margin:4px 0px 0px 16px; "/></a>';
}
?>
<div class="tclear"></div>
	<br>
	<input type="button" value="<?=Lng('Close',1,0)?>" onClick="parent.$.fn.colorbox.close()" class="abutton grbut"/>
</div>