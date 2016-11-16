<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<h1><?=TDM_H1?></h1>
<?TDMShowBreadCumbs()?>
<hr style="width:86%;">
<div class="autopic" title="<?=$arResult['MFA_MFC_CODE']?>" style="background:url(<?=$arResult['BRAND_LOGO_SRC']?>)"></div>
<?=TDMShowSEOText("TOP")?>


<?if($arComSets['SECTIONS_TREE']==1 AND $arResult['CNT']>0){?>
	<?jsLinkJqueryUi()?>
	<script>$(function() {$( "#tabs" ).tabs();});</script>
	<div id="tabs">
		<ul>
			<li><a href="<?=$_SERVER['REQUEST_URI']?>#main" class="tbcars"><?=Lng('Main_sections',1,0)?></a></li>
			<li><a href="<?=$_SERVER['REQUEST_URI']?>#tree" class="tbtracks"><?=Lng('Full_sections_tree',1,0)?></a></li>
		</ul>
		<div id="main">
<?}?>

<?if($arResult['CNT']>0){?>
	<?foreach($arResult['SECTIONS'] as $arSec){?>
		<div class="secnode" title="<?=$arSec['TITLE']?>" style="background-image:url(<?=$arSec['PICTURE']?>);">
			<a href="<?=$arSec['URL']?>" ><?=$arSec['NAME']?></a>
		</div>
	<?}?>
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

<?if($arComSets['SECTIONS_TREE']==1 AND $arResult['CNT']>0){?>
		</div>
		<div id="tree">
			
			<script type="text/javascript" language="javascript" src="/<?=TDM_ROOT_DIR?>/media/js/jqtree/jquery.jstree.js"></script>
			<script type="text/javascript" src="/<?=TDM_ROOT_DIR?>/media/js/jqtree/script.js"></script>
			
			<div id="jtree" class="jtree" style="float:left;"></div>
			<div class="cler"></div>
			
			<script type="text/javascript">
				$(function () {
					$("#jtree").jstree({
						"json_data" : {
							"ajax" : {
								"url" : "/<?=TDM_ROOT_DIR?>/tdmcore/sectree.php?rd=autoparts&brand=<?=$arResult['BRAND']?>&model=<?=$arResult['MOD_ID']?>&type=<?=$arResult['TYPE_ID']?>&mod_name=<?=$_REQUEST['mod_name']?>&type_name=<?=$_REQUEST['type_name']?>",
								"data" : function (node) {
									return { id : node.attr ? node.attr("id") : 0 }; 
								},
								"type": "POST"
							}
						},
						"types" : {
							"types" : {
								"file" : {
									"icon":{"image" : "/<?=TDM_ROOT_DIR?>/media/js/jqtree/file.png"}
								}
							}
						},
						"themes" : {"theme" : "default"},
						"plugins" : [ "themes", "json_data", "types", "ui" ]
					})
					.bind("select_node.jstree", function(e, data){
						var href = data.rslt.obj.attr("href");
						if(href){ window.location=href;}
					});
				});
				$("#jtree").delegate("a","click", function (e){
					if(this.className.indexOf('icon') == -1){
						$("#jtree").jstree("toggle_node", this);
						e.preventDefault(); 
						return false;
					}
				});
			</script>
			<div class="tclear"></div>
	

		</div>
	</div>
<?}?>



<div class="tclear"></div>

<?=TDMShowSEOText("BOT")?>
<br>
<br>


<?//echo '<pre>'; print_r($arResult); echo '</pre>';?>