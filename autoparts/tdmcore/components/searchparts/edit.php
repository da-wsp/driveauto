<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<?

//Save changes
if($_POST['editme']=="Y"){
	if($_POST['TEMPLATE']==""){ErAdd(Lng('A_required_field')." - ".Lng('Template'),1);}
	if(ErCheck()){
		$SvRes = TDMSaveSetsFile(TDMGetSetsPath($CompCode),"arComSets",Array(
			Array("S","TEMPLATE",$_POST['TEMPLATE']),
			Array("I","DEFAULT_VIEW",intval($_POST['DEFAULT_VIEW'])),
			Array("I","LIST_PRICES_LIMIT",intval($_POST['LIST_PRICES_LIMIT'])),
			Array("I","HIDE_NOPRICES",intval($_POST['HIDE_NOPRICES'])),
			Array("I","HIDE_PRICES_NOAVAIL",intval($_POST['HIDE_PRICES_NOAVAIL'])),
			Array("I","ALLOW_ORDER",intval($_POST['ALLOW_ORDER'])),
			Array("I","ITEMS_SORT",intval($_POST['ITEMS_SORT'])),
			Array("I","SHOW_ITEM_PROPS",intval($_POST['SHOW_ITEM_PROPS'])),
		));
		if($SvRes){
			NtAdd(Lng("Settings_saved"));
			$arComSets = TDMGetSets($CompCode);
		}else{ErAdd("False to save settings!",2);}
	}
}

?>
<?ErShow();?>

<table class="formtab" >
<tr><td class="fname"><?=Lng('Template')?>: </td>
	<td class="fvalues">
		<select name="TEMPLATE" style="width:200px;">
			<?$arTemps = TDMGetTemplates($CompCode);
			FShowSelectOptions($arTemps,$arComSets['TEMPLATE']);?>
		</select>
	</td>
</tr>
<tr><td class="fname"><?=Lng('Default_view')?>: </td>
	<td class="fvalues">
		<select name="DEFAULT_VIEW" style="width:100px;">
			<?FShowSelectOptions(Array('CARD','LIST'),$arComSets['DEFAULT_VIEW']);?>
		</select>
	</td>
</tr>

<tr><td class="fname"><?=Lng('Number_visible_prices')?>: </td>
	<td class="fvalues">
		<select name="LIST_PRICES_LIMIT" style="width:80px;">
			<?FShowSelectOptions(Array(2,3,4,5,6,7,8,9,10,11,12),$arComSets['LIST_PRICES_LIMIT']);?>
		</select> <span class="tiptext"><?=Lng('View')?> LIST</span>
	</td>
</tr>
<tr><td class="fname"><?=Lng('Show_item_properties')?>: </td>
	<td class="ftext">
		<input type="checkbox" name="SHOW_ITEM_PROPS" value="1" <?if($arComSets['SHOW_ITEM_PROPS']==1){?> checked <?}?> > 
	</td>
</tr>
<tr><td colspan="2"><hr></td></tr>
<tr><td class="fname"><?=Lng('Hide_prices_availability_0')?>: </td>
	<td class="ftext">
		<input type="checkbox" name="HIDE_PRICES_NOAVAIL" value="1" <?if($arComSets['HIDE_PRICES_NOAVAIL']==1){?> checked <?}?> > 
	</td>
</tr>
<tr><td class="fname"><?=Lng('Hide_items_without_prices')?>: </td>
	<td class="ftext">
		<input type="checkbox" name="HIDE_NOPRICES" value="1" <?if($arComSets['HIDE_NOPRICES']==1){?> checked <?}?> > 
	</td>
</tr>
<?if($arComSets['HIDE_NOPRICES']==1){?>
	<tr><td class="fname tiptext"><?=Lng('Allow_order_without_price')?>: </td>
		<td class="ftext">
			<input type="checkbox" name="ALLOW_ORDER" value="1" <?if($arComSets['ALLOW_ORDER']==1){?> checked <?}?> disabled="disabled" > 
		</td>
	</tr>
<?}else{?>
	<tr><td class="fname"><?=Lng('Allow_order_without_price')?>: </td>
		<td class="ftext">
			<input type="checkbox" name="ALLOW_ORDER" value="1" <?if($arComSets['ALLOW_ORDER']==1){?> checked <?}?> > 
		</td>
	</tr>
<?}?>
<tr><td class="fname"><?=Lng('Sort_by_default')?>: </td>
	<td class="fvalues">
		<select name="ITEMS_SORT" style="width:300px;">
			<?$arSorts=Array(1=>Lng('Sort_brand_rating_price',1,false), 2=>Lng('Sort_description_price',1,false),
							3=>Lng('Sort_lowest_price',1,false), 4=>Lng('Sort_lowest_delivery_time',1,false), 5=>Lng('Sort_photo_available',1,false),);
			FShowSelectOptionsK($arSorts,$arComSets['ITEMS_SORT']);?>
		</select>
	</td>
</tr>





</table>
