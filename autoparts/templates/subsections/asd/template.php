<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<h1><?=TDM_H1?></h1>
<?TDMShowBreadCumbs()?>
<hr style="width:86%;">
<div class="autopic" title="<?=$arResult['MFA_MFC_CODE']?>" style="background:url(<?=$arResult['BRAND_LOGO_SRC']?>)"></div>
<?=TDMShowSEOText("TOP")?>

<?jsLinkJqueryUi()?>
<script> 
	$(function(){
		$( "#subsections" ).accordion({active:false, collapsible: true, heightStyle:"30px"});
		$("#subsections a").click(function(){
			window.location = $(this).attr('href');
			return false;
		});
	}); 
</script>

<?if($arResult['CNT']>0){?>

	<table width="100%"><tr><td style="vertical-align:top;">
		<div class="rsecs" style="background-image:url(<?=$arResult['RSECTION_PICTURE']?>);">
			<div class="rseclinks">
			<?if(is_array($arResult['ROOT_SECTIONS'])){
				foreach($arResult['ROOT_SECTIONS'] as $arRSec){?>
					<a href="<?=$arRSec['LINK']?>" <?if($arRSec['ACTIVE']=="Y"){?>class="rsactive"<?}?> ><?=$arRSec['NAME']?></a>
				<?}
			}else{?>
				<a href="<?=$arRSec['RSEC_LINK']?>"><span>&#65513;</span> <?=Lng('All_sections',0,0)?></a>
			<?}?>
			</div>
		</div>
	</td><td width="90%" style="vertical-align:top;">
		
		<h2><?=Lng('Subsections_of_parts')?>:</h2>
		<?if(!$arResult['FILTER_BY_TYPE'] AND TDM_ISADMIN){?>
			<div class="ignored_admin_note">The type of model is ignored - all subsections viewed</div>
		<?}?>
		
		<div id="subsections">
<?		foreach($arResult['SECTIONS'][$arResult['ROOT_SID']] as $arSec){
			if($arSec['URL']=='' AND count($arResult['SECTIONS'][$arSec['STR_ID']])<=0){ continue; } //Hide if TD childs was moved out?>
			<div class="shead"><?if($arSec['URL']!=''){echo '<a href="'.$arResult['CSEC_LINK'].$arSec['URL'].'" class="rtlink">'.$arSec['NAME'].'</a>';}else{echo '&#9660; '.$arSec['NAME'];}?></div>
			<div class="sbody">
<?			if(is_array($arResult['SECTIONS'][$arSec['STR_ID']])){
			foreach($arResult['SECTIONS'][$arSec['STR_ID']] as $arSec2){?>
				<div class="levl2">
					<?if($arSec2['URL']!=''){echo '<a href="'.$arResult['CSEC_LINK'].$arSec2['URL'].'">'.$arSec2['NAME'].'</a>';}else{echo $arSec2['NAME'];}?>
					<?if($arSec2['MOVED']!="" AND TDM_ISADMIN){?><div class="movedsec" title="Section moved from: <?=$arSec2['MOVED']?>"></div><?}?>
				</div>
<?				if(is_array($arResult['SECTIONS'][$arSec2['STR_ID']])){
				foreach($arResult['SECTIONS'][$arSec2['STR_ID']] as $arSec3){?>
					<div class="levl3">&#8627; 
						<?if($arSec3['URL']!=''){?><a href="<?=$arResult['CSEC_LINK'].$arSec3['URL']?>"><?=$arSec3['NAME']?></a><?}else{echo $arSec3['NAME'];}?> 
						<?if($arSec3['MOVED']!="" AND TDM_ISADMIN){?><div class="movedsec" title="Section moved from: <?=$arSec3['MOVED']?>"></div><?}?>
					</div>
<?				}
				}
			}
			}?>
			</div>
<?
		}?>
		</div>
		
	</table>
	
<?}else{?>
	<br><br>
	<b><?=Lng('No_parts_for_model')?>...</b>
	<br><br><br><br>
		<script>
		jQuery(function($){
			$(document).ready(function() {
				$('#search ul #tecdoc').removeClass('active');
				$('#search ul #tecdoc > li').addClass('active');
				$('input[name=\'search\']').attr('value', "<?=$_REQUEST['article']?>");
				$('.button-search').click();
			});
		});
	</script>

<?}?>



<div class="tclear"></div>

<?=TDMShowSEOText("BOT")?>
<br>
<br>


<?//echo '<pre>'; print_r($arResult); echo '</pre>';?>