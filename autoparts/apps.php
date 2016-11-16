<?define('TDM_PROLOG_INCLUDED',true);
require_once("tdmcore/defines.php");
require_once("tdmcore/init.php");
?>
<link rel="stylesheet" href="/<?=TDM_ROOT_DIR?>/styles.css" type="text/css">
<script src="/<?=TDM_ROOT_DIR?>/media/js/jquery-1.11.0.min.js"></script>
<style>
.brafilter a{
	line-height:22px; float:left; display:block; text-decoration:none;
	color:#4F4F4F; text-shadow:1px 1px 2px #fff; font-family:Verdana; margin:0px 10px 10px 0px; font-size:12px; padding:5px 8px 5px 8px; 
	background: -webkit-gradient(linear, center top, center bottom, from(#fff), to(#DBDBDB));
	background-image: linear-gradient(#fff, #DBDBDB);
	box-shadow:inset 0 0 0 1px #DBDBDB, 0 0 0 1px #fff, 2px 2px 4px rgba(0,0,0,0.3); -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;
}
.brafilter a:hover{color:#ff0000;
	background: -webkit-gradient(linear, center top, center bottom, from(#DBDBDB), to(#fff));
	background-image: linear-gradient(#DBDBDB, #fff);
}
.brafilter a.active {background:#ffffff;}
#uplayer{background:#ffffff; opacity:0.7; width:100%; position:absolute; z-index:10; text-align:center; color:#ff0000!important; font-weight:bold; padding-top:200px;}
</style>
<div style="padding:14px;">
<div id="uplayer">LOADING...</div>
<?
$AID=intval($_GET['of']);
if($AID<=0){echo 'Error! Invalid parameters.'; die();}

$TDMCore->DBSelect("TECDOC");
$rsApps = TDSQL::GetApplicability($AID);
$arBNames=Array();
while($arApp = $rsApps->Fetch()){
	//echo '<pre>'; print_r($arApp); echo '</pre>'; die();
	if(!in_array($arApp['MFA_BRAND'],$arBNames)){
		$BID = str_replace(' ','',$arApp['MFA_BRAND']);
		if($FstBID==''){$FstBID=$BID;}
		$arBNames[$BID]=$arApp['MFA_BRAND'];
	}
	$arApps[] = $arApp;
}
if(count($arApps)>0){
	require_once(TDM_PATH."/tdmcore/components/models/model_groups.php");
	?>
	<div class="brafilter">
	<?foreach($arBNames as $BID=>$BName){?>
		<a href="javascript:void(0)" id="fb<?=$BID?>"><?=$BName?></a>
	<?}?>
	</div>
	<div class="tclear"></div>
	<br>
	<table class="chartab" width="100%">
	<tr class="head"><td><?=Lng('Brand')?></td><td><?=Lng('Model')?></td><td><?=Lng('Year')?></td><td><?=Lng('Engine')?></td>
		<td><?=Lng('Power')?></td><td><?=Lng('Capacity')?></td><?/*<td><?=Lng('Cylinder')?></td>*/?><td><?=Lng('Fuel')?></td>
		<td><?=Lng('Body')?></td><?/*<td><?=Lng('Axis')?></td>*/?>
	</tr>
	<?foreach($arApps as $arType){
		$UrBName = str_replace(' ','-',$arType['MFA_BRAND']);
		$UBName = TDMStrToUp($UrBName);
		if(array_key_exists($UBName,$arHardGroups)){
			foreach($arHardGroups[$UBName] as $GrMod){
				if(strstr($arType['MOD_CDS_TEXT'],$GrMod)){
					$arType['GROUPED']="Y";
					$CurModel = $GrMod;
				}
			}
		}
		if($arType['GROUPED']!="Y"){
			$arMd = explode(' ',$arType['MOD_CDS_TEXT']);
			$CurModel = $arMd[0];
		}
		
		$arType['URL'] = TDMGenerateURL(Array('BRAND'=>TDMStrToLow($UrBName),'MOD_NAME'=>StrForURL($CurModel),'MOD_ID'=>$arType['MOD_ID'],
						'TYP_ID'=>$arType['TYP_ID'],'ENGINE'=>$arType['ENG_CODE'],'TYPE_NAME'=>$arType['TYP_CDS_TEXT']));
						
		$arType['START'] = TDDateFormat($arType['TYP_PCON_START'],Lng('to_pt'),'year');
		$arType['END'] = TDDateFormat($arType['TYP_PCON_END'],Lng('to_pt'),'year');
		$arType['START'] = substr($arType['START'],2,2);
		if(intval($arType['END'])>0){$arType['END'] = substr($arType['END'],2,2);}else{$arType['END']='&#8734;';}
		echo '<tr class="gtr rows" style="display:none;">';
		echo '<td class="fbra">'.$arType['MFA_BRAND'].'</td>';?>
		<td><a class="dblock" OnClick="window.opener.location.href='<?=$arType['URL']?>'; self.close();" href="javascript:void(0)"><b><?=$arType['MOD_CDS_TEXT']?></b> <?=$arType['TYP_CDS_TEXT']?></a></td>
		<?echo "<td style='white-space:nowrap;'>".$arType['START']."'-".$arType['END']."'</td>";
		echo '<td>'.$arType['ENG_CODE'].'</td>';
		echo '<td>'.$arType['TYP_KW_FROM'].'<span>'.Lng('Kv',1,0).'</span>/'.$arType['TYP_HP_FROM'].'<span>'.Lng('Hp',1,0).'</span></td>';
		echo '<td>'.$arType['TYP_CCM'].'<span style="font-size:10px;">'.Lng('sm',1,0).'<sup>3</sup></span></td>'; // 
		//echo '<td>'.$arType['TYP_CYLINDERS'].'</td>';
		echo '<td>'.$arType['TYP_FUEL_DES_TEXT'].'</td>';
		echo '<td>'.$arType['TYP_BODY_DES_TEXT'].'</td>';
		//echo '<td>'.$arType['TYP_AXLE_DES_TEXT'].'</td>';
		echo '</tr>';
	}?>
	</table>
	<br>
<?}else{?>
	<div class="brafilter"><a href="javascript:void(0)"><?=Lng('No_records',1,0)?>...</a></div>
<?}?>
</div>

<script type="text/javascript">
$(document).ready(function () {
	$('#uplayer').height($(document).height()-200);
	
	var TabRows=$('.rows');
	TabRows.hide();
	var LetsDiv = $('.brafilter > a');
	LetsDiv.click(function (){
		$('#uplayer').fadeIn(200);
		FstLet=$(this).text();
		LetsDiv.removeClass("active");
		$(this).addClass("active");
		TabRows.hide().delay(100).each(function(i){
			var AText = $(this).children('.fbra').eq(0).text();
			if(RegExp('^' + FstLet).test(AText)) {
				$(this).fadeIn(400);
			}
		});
		$('#uplayer').fadeOut(1000);
	});
	
	$( "#fb<?=$FstBID?>" ).trigger( "click" );
});
</script>