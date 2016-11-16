<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<h1><?=TDM_H1?></h1>
<?TDMShowBreadCumbs()?>
<hr style="width:86%;">
<div class="autopic" title="<?=$arResult['MFA_MFC_CODE']?>" style="background:url(<?=$arResult['BRAND_LOGO_SRC']?>)"></div>
<div style="padding:3px;"></div>
<?=TDMShowSEOText("TOP")?>

<?if($arResult['MODELS_COUNT']>12){?>
	<script>var AllLng = '<?=Lng('All',1,0)?>'; ShowNFilter=1;</script>
	<div class="modelsfilter">
		<a href="javascript:void(0)"><?=Lng('All',1,0)?></a>
	</div>
<?}?>

<?if($arResult['MODELS_COUNT']>0){?>
	<?foreach($arResult['MODELS'] as $CurModel=>$arModels){
		$CurModel=trim($CurModel);?>
		<div class="modelsdiv" style="background-image:url(<?=$arResult['MODEL_PICS'][$CurModel]?>);">
			<div class="modelname"><?=$CurModel?></div>
			<?if(count($arModels)<=1){
				$arModel = $arModels[0];
				$arModel['MOD_CDS_TEXT'] = str_replace(trim($CurModel),'',$arModel['MOD_CDS_TEXT']);
				$arModel['MOD_CDS_TEXT'] = str_replace('[USA]','(US)',$arModel['MOD_CDS_TEXT']);?>
				<a href="<?=$arModel['URL']?>" class="ampick" title="<?=$arModel['MOD_CDS_TEXT']?> <?=$arModel['DATE_FROM']?> - <?=$arModel['DATE_TO']?>"><?=$arModel['MOD_CDS_TEXT']?> <?=$arModel['DATE_FROM']?> - <?=$arModel['DATE_TO']?></a>
			<?}else{?>
				<ul class="ddmodel">
					<li class="ddpick"><a href="javascript:void(0)" >- <?=Lng('select_model',2,0)?> -</a>
						<ul>
						<?foreach($arModels as $arModel){?>
							<li><a href="<?=$arModel['URL']?>"><?=$arModel['MOD_CDS_TEXT']?> <?=$arModel['DATE_FROM']?> - <?=$arModel['DATE_TO']?></a></li>
						<?}?>
						</ul>
					</li>
				</ul>
			<?}?>
		</div>
		<?
	}?>
<?}else{?>
	<?=Lng('No_models');?> ...
<?}?>
<?=TDMShowSEOText("BOT")?>
<br>
<br>


<?if($arResult['MODELS_COUNT']>0){?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.ddpick').bind('mousedown', openSubMenu);
			$('.ddpick').bind('mouseleave', closeSubMenu);
			function openSubMenu() {
				$(this).find('ul').css('display', 'block');	
			};
			function closeSubMenu() {
				$(this).find('ul').css('display', 'none');	
			};	   
		});
	</script>
<?}?>

<?//echo '<pre>'; print_r($arResult); echo '</pre>';?>