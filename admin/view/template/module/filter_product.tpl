<?php echo $header; ?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:600' rel='stylesheet' type='text/css'>
<div id="content">
	<?php if ($error_warning) { ?>
		<div class="warning"><?php echo $error_warning; ?></div>
	<?php } elseif ($success) {  ?>
		<div class="success"><?php echo $success; ?></div>
	<?php } ?>
	<?php $element = 1; ?>
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<div class="set-size" id="filter_product">
			<h3>Filter Product</h3>
			<div class="content">
				<div>
					<div class="tabs clearfix">
						<!-- Tabs module -->
						<div id="tabs" class="htabs main-tabs">
							<?php $module_row = 1; ?>
							<?php foreach ($modules as $module) { ?>
							<a href="#tab-module-<?php echo $module_row; ?>" id="module-<?php echo $module_row; ?>">Module <?php echo $module_row; ?> &nbsp;<img src="view/image/delete.png"  alt="" onclick="$('.vtabs a:first').trigger('click'); $('#module-<?php echo $module_row; ?>').remove(); $('#tab-module-<?php echo $module_row; ?>').remove(); return false;" /></a>
							<?php $module_row++; ?>
							<?php } ?>
							<span id="module-add">Add Module &nbsp;<img src="view/image/add.png" alt="" onclick="addModule();" /></span>
						</div>
						
						<?php $module_row = 1; ?>
						<?php foreach ($modules as $module) { ?>
						<div id="tab-module-<?php echo $module_row; ?>" class="tab-content">
							<div id="tabs_filter_product_<?php echo $module_row; ?>" class="htabs tabs-product">
								<a href="#tab_filter_product_<?php echo $module_row; ?>_tab" class="ttab"><span>Module tab</span></a>
								<a href="#tab_filter_product_<?php echo $module_row; ?>_setting" class="tsetting"><span>Module setting</span></a>
							</div>
							
							<div id="tab_filter_product_<?php echo $module_row; ?>_tab" style="padding:20px">
								<table class="tabs-list">
									<thead>
										<tr>
											<td class="first">Title</td>
											<td>Get product from</td>
											<td>Remove</td>
										</tr>
									</thead>
									<?php if(isset($module['tabs'])) { foreach($module['tabs'] as $tab) { ?>
									<tbody id="module-tabs-<?php echo $module_row; ?>-<?php echo $element; ?>">
										<tr>
											<td class="first">
												<?php foreach ($languages as $language) { $lang_id = $language['language_id']; ?>
												<div class="language"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><input type="text" name="filter_product_module[<?php echo $module_row; ?>][tabs][<?php echo $element; ?>][heading][<?php echo $language['language_id']; ?>]" value="<?php if(isset($tab['heading'][$lang_id])) { echo $tab['heading'][$lang_id]; } ?>"></div>
												<?php } ?>
											</td>
											<td style="width:430px">
												<select name="filter_product_module[<?php echo $module_row; ?>][tabs][<?php echo $element; ?>][title]" title="<?php echo $module_row; ?>_<?php echo $element; ?>" class="get_product_from">
													<option value="latest"<?php if($tab['title'] == 'latest') { echo ' selected="selected"'; } ?>>Latest Products</option>
													<option value="special"<?php if($tab['title'] == 'special') { echo ' selected="selected"'; } ?>>Special Products</option>
													<option value="bestsellers"<?php if($tab['title'] == 'bestsellers') { echo ' selected="selected"'; } ?>>Bestsellers Products</option>
													<option value="products"<?php if($tab['title'] == 'products') { echo ' selected="selected"'; } ?>>Choose a products</option>
													<option value="category"<?php if($tab['title'] == 'category') { echo ' selected="selected"'; } ?>>Choose a category</option>
												</select>
												
												<div class="filter_product_module_<?php echo $module_row; ?>_<?php echo $element; ?>_products panel-products-autocomplete"<?php if($tab['title'] != 'products') { echo ' style="display:none"'; } ?>>
													<div class="products-autocomplete clearfix">
														<p>Products:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>
														<div><input type="text" alt="<?php echo $module_row; ?>" title="<?php echo $element; ?>" name="filter_product_module[<?php echo $module_row; ?>][tabs][<?php echo $element; ?>][product]" value="" /></div>
													</div>
													<div class="scrollbox">
														<?php $products = explode(',', $tab['products']); ?>
														<?php $class = 'odd'; ?>
														<?php foreach ($products as $product) { if($product > 0) { ?>
														<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
														<?php 
															$product_info = $this->model_catalog_product->getProduct($product); 
															$product_name = false;
															if($product_info) { 
																$product_name = $product_info['name'];
															} 
														?>
														<div id="product-<?php echo $module_row; ?>-<?php echo $element; ?>-<?php echo $product; ?>" class="<?php echo $class; ?>"><?php echo $product_name; ?> <img src="view/image/delete.png" alt="<?php echo $module_row; ?>" title="<?php echo $element; ?>" />
														  <input type="hidden" value="<?php echo $product; ?>" />
														</div>
														<?php } } ?>
													</div>
													<input type="hidden" name="filter_product_module[<?php echo $module_row; ?>][tabs][<?php echo $element; ?>][products]" value="<?php echo $tab['products']; ?>" />
												</div>
												
												<script type="text/javascript">
												$('input[name=\'filter_product_module[<?php echo $module_row; ?>][tabs][<?php echo $element; ?>][product]\']').autocomplete({
													delay: 500,
													source: function(request, response) {
														$.ajax({
															url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
															dataType: 'json',
															success: function(json) {		
																response($.map(json, function(item) {
																	return {
																		label: item.name,
																		value: item.product_id
																	}
																}));
															}
														});
													}, 
													select: function(event, ui) {
														$('#product-' + $(this).attr("alt") + '-' + $(this).attr("title") + '-' + ui.item.value).remove();
														
														$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_products .scrollbox').append('<div id="product-' + $(this).attr("alt") + '-' + $(this).attr("title") + '-' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="' + $(this).attr("alt") + '" title="' + $(this).attr("title") + '" /><input type="hidden" value="' + ui.item.value + '" /></div>');
												
														$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_products .scrollbox div:odd').attr('class', 'odd');
														$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_products .scrollbox div:even').attr('class', 'even');
														
														data = $.map($('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_products .scrollbox input'), function(element){
															return $(element).attr('value');
														});
																		
														$('input[name=\'filter_product_module[' + $(this).attr("alt") + '][tabs][' + $(this).attr("title") + '][products]\']').attr('value', data.join());
																	
														return false;
													},
													focus: function(event, ui) {
												      	return false;
												   	}
												});
												</script>
												
												<div class="filter_product_module_<?php echo $module_row; ?>_<?php echo $element; ?>_categories panel-categories-autocomplete"<?php if($tab['title'] != 'category') { echo ' style="display:none"'; } ?>>
													<div class="products-autocomplete clearfix">
														<p>Categories:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>
														<div><input type="text" alt="<?php echo $module_row; ?>" title="<?php echo $element; ?>" name="filter_product_module[<?php echo $module_row; ?>][tabs][<?php echo $element; ?>][category]" value="" /></div>
													</div>
													<div class="scrollbox">
														<?php $categories = explode(',', $tab['categories']); ?>
														<?php $class = 'odd'; ?>
														<?php foreach ($categories as $category) { if($category > 0) { ?>
														<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
														<?php 
															$category_info = $this->model_catalog_category->getCategory($category); 
															$category_name = false;
															if($category_info) { 
																$category_name = $category_info['name'];
															} 
														?>
														<div id="category-<?php echo $module_row; ?>-<?php echo $element; ?>-<?php echo $category; ?>" class="<?php echo $class; ?>"><?php echo $category_name; ?> <img src="view/image/delete.png" alt="<?php echo $module_row; ?>" title="<?php echo $element; ?>" />
														  <input type="hidden" value="<?php echo $category; ?>" />
														</div>
														<?php } } ?>
													</div>
													<input type="hidden" name="filter_product_module[<?php echo $module_row; ?>][tabs][<?php echo $element; ?>][categories]" value="<?php echo $tab['categories']; ?>" />
												</div>
												
												<script type="text/javascript">
												$('input[name=\'filter_product_module[<?php echo $module_row; ?>][tabs][<?php echo $element; ?>][category]\']').autocomplete({
													delay: 500,
													source: function(request, response) {
														$.ajax({
															url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
															dataType: 'json',
															success: function(json) {		
																response($.map(json, function(item) {
																	return {
																		label: item.name,
																		value: item.category_id
																	}
																}));
															}
														});
													}, 
													select: function(event, ui) {
														$('#category-' + $(this).attr("alt") + '-' + $(this).attr("title") + '-' + ui.item.value).remove();
														
														$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_categories .scrollbox').append('<div id="category-' + $(this).attr("alt") + '-' + $(this).attr("title") + '-' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="' + $(this).attr("alt") + '" title="' + $(this).attr("title") + '" /><input type="hidden" value="' + ui.item.value + '" /></div>');
												
														$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_categories .scrollbox div:odd').attr('class', 'odd');
														$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_categories .scrollbox div:even').attr('class', 'even');
														
														data = $.map($('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_categories .scrollbox input'), function(element){
															return $(element).attr('value');
														});
																		
														$('input[name=\'filter_product_module[' + $(this).attr("alt") + '][tabs][' + $(this).attr("title") + '][categories]\']').attr('value', data.join());
																	
														return false;
													},
													focus: function(event, ui) {
												      	return false;
												   	}
												});
												</script>
											</td>
											<td><a onclick="$('#module-tabs-<?php echo $module_row; ?>-<?php echo $element; ?>').remove();">Remove</a></td>
										</tr>
									</tbody>
									<?php $element++; } } ?>
									<tfoot></tfoot>
								</table>
								<a onclick="addTabs(<?php echo $module_row; ?>);" class="add-module">Add item</a>
							</div>
							
							<div id="tab_filter_product_<?php echo $module_row; ?>_setting" style="padding:20px">
								<table class="form">
									<tr>
										<td>Carousel:</td>
										<td>
											<select name="filter_product_module[<?php echo $module_row; ?>][carousel]">
												<?php if ($module['carousel']) { ?>
												<option value="1" selected="selected">Enabled</option>
												<option value="0">Disabled</option>
												<?php } else { ?>
												<option value="1">Enabled</option>
												<option value="0" selected="selected">Disabled</option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Dimension (W x H) and Resize Type:</td>
										<td><input type="text" name="filter_product_module[<?php echo $module_row; ?>][width]" value="<?php echo $module['width']; ?>">&nbsp; <input type="text" name="filter_product_module[<?php echo $module_row; ?>][height]" value="<?php echo $module['height']; ?>"></td>
									</tr>
									<tr>
										<td>Max Items - Max Columns - Limit Items In Carousel:</td>
										<td><input type="text" name="filter_product_module[<?php echo $module_row; ?>][itemsperpage]" value="<?php echo $module['itemsperpage']; ?>"> - <input type="text" name="filter_product_module[<?php echo $module_row; ?>][cols]" value="<?php echo $module['cols']; ?>"> - <input type="text" name="filter_product_module[<?php echo $module_row; ?>][limit]" value="<?php echo $module['limit']; ?>"></td>
									</tr>
									<tr>
										<td>Layout:</td>
										<td>
											<select name="filter_product_module[<?php echo $module_row; ?>][layout_id]">
												<?php if (99999 == $module['layout_id']) { ?>
												<option value="99999" selected="selected">All pages</option>
												<?php } else { ?>
												<option value="99999">All pages</option>
												<?php } ?>
												<?php foreach ($layouts as $layout) { ?>
												<?php if ($layout['layout_id'] == $module['layout_id']) { ?>
												<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Position:</td>
										<td>
											<select name="filter_product_module[<?php echo $module_row; ?>][position]">
												<?php if ($module['position'] == 'menu') { ?>
												<option value="menu" selected="selected">Menu</option>
												<?php } else { ?>
												<option value="menu">Menu</option>
												<?php } ?>
												<?php if ($module['position'] == 'slideshow') { ?>
												<option value="slideshow" selected="selected">Slideshow</option>
												<?php } else { ?>
												<option value="slideshow">Slideshow</option>
												<?php } ?>
												<?php if ($module['position'] == 'preface_left') { ?>
												<option value="preface_left" selected="selected">Preface left</option>
												<?php } else { ?>
												<option value="preface_left">Preface left</option>
												<?php } ?>
												<?php if ($module['position'] == 'preface_right') { ?>
												<option value="preface_right" selected="selected">Preface right</option>
												<?php } else { ?>
												<option value="preface_right">Preface right</option>
												<?php } ?>
												<?php if ($module['position'] == 'preface_fullwidth') { ?>
												<option value="preface_fullwidth" selected="selected">Preface fullwidth</option>
												<?php } else { ?>
												<option value="preface_fullwidth">Preface fullwidth</option>
												<?php } ?>
												<?php if ($module['position'] == 'column_left') { ?>
												<option value="column_left" selected="selected">Column left</option>
												<?php } else { ?>
												<option value="column_left">Column left</option>
												<?php } ?>
												<?php if ($module['position'] == 'content_big_column') { ?>
												<option value="content_big_column" selected="selected">Content big column</option>
												<?php } else { ?>
												<option value="content_big_column">Content big column</option>
												<?php } ?>
												<?php if ($module['position'] == 'content_top') { ?>
												<option value="content_top" selected="selected">Content top</option>
												<?php } else { ?>
												<option value="content_top">Content top</option>
												<?php } ?>
												<?php if ($module['position'] == 'column_right') { ?>
												<option value="column_right" selected="selected">Column right</option>
												<?php } else { ?>
												<option value="column_right">Column right</option>
												<?php } ?>
												<?php if ($module['position'] == 'content_bottom') { ?>
												<option value="content_bottom" selected="selected">Content bottom</option>
												<?php } else { ?>
												<option value="content_bottom">Content bottom</option>
												<?php } ?>
												<?php if ($module['position'] == 'customfooter_top') { ?>
												<option value="customfooter_top" selected="selected">CustomFooter Top</option>
												<?php } else { ?>
												<option value="customfooter_top">CustomFooter Top</option>
												<?php } ?>
												<?php if ($module['position'] == 'customfooter_bottom') { ?>
												<option value="customfooter_bottom" selected="selected">CustomFooter Bottom</option>
												<?php } else { ?>
												<option value="customfooter_bottom">CustomFooter Bottom</option>
												<?php } ?>
												<?php if ($module['position'] == 'footer_top') { ?>
												<option value="footer_top" selected="selected">Footer top</option>
												<?php } else { ?>
												<option value="footer_top">Footer top</option>
												<?php } ?>
												<?php if ($module['position'] == 'footer_left') { ?>
												<option value="footer_left" selected="selected">Footer left</option>
												<?php } else { ?>
												<option value="footer_left">Footer left</option>
												<?php } ?>
												<?php if ($module['position'] == 'footer_right') { ?>
												<option value="footer_right" selected="selected">Footer right</option>
												<?php } else { ?>
												<option value="footer_right">Footer right</option>
												<?php } ?>
												<?php if ($module['position'] == 'footer_bottom') { ?>
												<option value="footer_bottom" selected="selected">Footer bottom</option>
												<?php } else { ?>
												<option value="footer_bottom">Footer bottom</option>
												<?php } ?>
												<?php if ($module['position'] == 'bottom') { ?>
												<option value="bottom" selected="selected">Bottom</option>
												<?php } else { ?>
												<option value="bottom">Bottom</option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Status:</td>
										<td>
											<select name="filter_product_module[<?php echo $module_row; ?>][status]">
												<?php if ($module['status']) { ?>
												<option value="1" selected="selected">Enabled</option>
												<option value="0">Disabled</option>
												<?php } else { ?>
												<option value="1">Enabled</option>
												<option value="0" selected="selected">Disabled</option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Sort Order:</td>
										<td><input type="text" name="filter_product_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
									</tr>
								</table>
							</div>
						</div>
						<script type="text/javascript">
						$('#tabs_filter_product_<?php echo $module_row; ?> a').tabs();
						</script>
						<?php $module_row++; ?>
						<?php } ?>
					</div>
					
					<!-- Buttons -->
					<div class="buttons"><input type="submit" name="button-save" class="button-save" value=""></div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript"><!--
$('.main-tabs a').tabs();
//--></script> 

<script type="text/javascript"><!--
<?php $module_row = 1; ?>
<?php foreach ($modules as $module) { ?>
$('#language-<?php echo $module_row; ?> a').tabs();
<?php $module_row++; ?>
<?php } ?> 
//--></script> 

<script type="text/javascript"><!--
<?php $module_row = 1; ?>
<?php foreach ($modules as $module) { ?>
<?php $module_row++; ?>
<?php } ?>
//--></script> 

<script type="text/javascript">
$(document).ready(function() {

	$("select.select-type").live("change", function () {
		var id_module = $(this).attr("id");
		$("#" + id_module +" option:selected").each(function() {
			if($(this).val() == 1) {
				$(".html" + id_module + "").hide();
				$(".block" + id_module + "").show();
			} else {
				$(".html" + id_module + "").show();
				$(".block" + id_module + "").hide();
			}
		});
	});
	
});
</script>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<div id="tab-module-' + module_row + '" class="tab-content">';
	html += '	<div id="tabs_filter_product_' + module_row + '" class="htabs tabs-product">'; 
	html += '		<a href="#tab_filter_product_' + module_row + '_tab" class="ttab"><span>Module tab</span></a>';
	html += '		<a href="#tab_filter_product_' + module_row + '_setting" class="tsetting"><span>Module setting</span></a>';
	html += '	</div>';
	
	html += '	<div id="tab_filter_product_' + module_row + '_tab" style="padding:20px">';
	html += '		<table class="tabs-list">';
	html += '			<thead>';
	html += '				<tr>';
	html += '					<td class="first">Title</td>';
	html += '					<td>Get product from</td>';
	html += '					<td>Remove</td>';
	html += '				</tr>';
	html += '			</thead>';
	html += '			<tfoot></tfoot>';
	html += '		</table>';
	html += '		<a onclick="addTabs(' + module_row + ');" class="add-module">Add item</a>';
	html += '	</div>';
	
	html += '	<div id="tab_filter_product_' + module_row + '_setting" style="padding:20px">';
	html += '  <table class="form">';
	html += '    <tr>';
	html += '      <td>Carousel:</td>';
	html += '      <td><select name="filter_product_module[' + module_row + '][carousel]">';
	html += '           <option value="1">Enabled</option>';
	html += '           <option value="0">Disabled</option>';
	html += '      </select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td>Dimension (W x H) and Resize Type:</td>';
	html += '      <td><input type="text" name="filter_product_module[' + module_row + '][width]">&nbsp; <input type="text" name="filter_product_module[' + module_row + '][height]"></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td>Max Items - Max Columns - Limit Items In Carousel:</td>';
	html += '      <td><input type="text" name="filter_product_module[' + module_row + '][itemsperpage]"> - <input type="text" name="filter_product_module[' + module_row + '][cols]"> - <input type="text" name="filter_product_module[' + module_row + '][limit]"></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td>Layout:</td>';
	html += '      <td><select name="filter_product_module[' + module_row + '][layout_id]">';
	html += '           <option value="99999">All pages</option>';
	<?php foreach ($layouts as $layout) { ?>
	html += '           <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '      </select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td>Position:</td>';
	html += '      <td><select name="filter_product_module[' + module_row + '][position]">';
	html += '       		<option value="menu">Menu</option>';
	html += '				<option value="slideshow">Slideshow</option>';
	html += '				<option value="preface_left">Preface left</option>';
	html += '				<option value="preface_right">Preface right</option>';
	html += '				<option value="preface_fullwidth">Preface fullwidth</option>';
	html += '				<option value="column_left">Column left</option>';
	html += '				<option value="content_big_column">Content big column</option>';
	html += '				<option value="content_top">Content top</option>';
	html += '				<option value="column_right">Column right</option>';
	html += '				<option value="content_bottom">Content bottom</option>';
	html += '				<option value="customfooter_top">CustomFooter Top</option>';
	html += '				<option value="customfooter_bottom">CustomFooter Bottom</option>';
	html += '				<option value="footer_top">Footer top</option>';
	html += '				<option value="footer_left">Footer left</option>';
	html += '				<option value="footer_right">Footer right</option>';
	html += '				<option value="footer_bottom">Footer bottom</option>';
	html += '				<option value="bottom">Bottom</option>';
	html += '      </select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td>Status:</td>';
	html += '      <td><select name="filter_product_module[' + module_row + '][status]">';
	html += '        <option value="1">Enabled</option>';
	html += '        <option value="0">Disabled</option>';
	html += '      </select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td>Sort Order:</td>';
	html += '      <td><input type="text" name="filter_product_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    </tr>';
	html += '  </table>'; 
	html += '	</div>';
	html += '</div>';
	
	$('.tabs').append(html);
	
	$('#tabs_filter_product_' + module_row + ' a').tabs();

	$('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '">Module ' + module_row + ' &nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); return false;" /></a>');
	
	$('.main-tabs a').tabs();
	
	$('#module-' + module_row).trigger('click');
	
	module_row++;
}
//--></script> 
<script type="text/javascript">
var element = <?php echo $element; ?>;
function addTabs(module_row) {
	html  = '<tbody id="module-tabs-' + module_row + '-' + element + '">';
	html += '  <tr>';
	html += '    <td class="first">';
	<?php foreach ($languages as $language) { ?>
	html += '		<div class="language"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><input type="text" value="" name="filter_product_module[' + module_row + '][tabs][' + element + '][heading][<?php echo $language['language_id']; ?>]"></div>';
	<?php } ?>
	html += '    </td>';
	html += '	 <td style="width:430px">';
	html += '		<select name="filter_product_module[' + module_row + '][tabs][' + element + '][title]" title="' + module_row + '_' + element + '" class="get_product_from">';
	html += '			<option value="latest">Latest Products</option>';
	html += '			<option value="special">Special Products</option>';
	html += '			<option value="bestsellers">Bestsellers Products</option>';
	html += '			<option value="products">Choose a products</option>';
	html += '			<option value="category">Choose a category</option>';
	html += '		</select>';
	html += '		<div class="filter_product_module_' + module_row + '_' + element + '_products panel-products-autocomplete" style="display: none">';
	html += '			<div class="products-autocomplete clearfix">';
	html += '				<p>Products:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>';
	html += '				<div><input type="text" alt="' + module_row + '" title="' + element + '" name="filter_product_module[' + module_row + '][tabs][' + element + '][product]" value="" /></div>';
	html += '			</div>';
	html += '			<div class="scrollbox">';
	html += '			</div>';
	html += '			<input type="hidden" name="filter_product_module[' + module_row + '][tabs][' + element + '][products]" value="" />';
	html += '		</div>';
	html += '		<div class="filter_product_module_' + module_row + '_' + element + '_categories panel-categories-autocomplete" style="display:none">';
	html += '			<div class="products-autocomplete clearfix">';
	html += '				<p>Categories:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>';
	html += '				<div><input type="text" alt="' + module_row + '" title="' + element + '" name="filter_product_module[' + module_row + '][tabs][' + element + '][category]" value="" /></div>';
	html += '			</div>';
	html += '			<div class="scrollbox">';
	html += '			</div>';
	html += '			<input type="hidden" name="filter_product_module[' + module_row + '][tabs][' + element + '][categories]" value="" />';
	html += '		</div>';
	html += '    </td>';
	html += '    <td><a onclick="$(\'#module-tabs-' + module_row + '-' + element + '\').remove();">Remove</a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#tab_filter_product_' + module_row + '_tab .tabs-list tfoot').before(html);
	
	$('input[name=\'filter_product_module[' + module_row + '][tabs][' + element + '][category]\']').autocomplete({
		delay: 500,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						return {
							label: item.name,
							value: item.category_id
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			$('#category-' + $(this).attr("alt") + '-' + $(this).attr("title") + '-' + ui.item.value).remove();
			
			$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_categories .scrollbox').append('<div id="category-' + $(this).attr("alt") + '-' + $(this).attr("title") + '-' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="' + $(this).attr("alt") + '" title="' + $(this).attr("title") + '" /><input type="hidden" value="' + ui.item.value + '" /></div>');
	
			$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_categories .scrollbox div:odd').attr('class', 'odd');
			$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_categories .scrollbox div:even').attr('class', 'even');
			
			data = $.map($('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_categories .scrollbox input'), function(element){
				return $(element).attr('value');
			});
							
			$('input[name=\'filter_product_module[' + $(this).attr("alt") + '][tabs][' + $(this).attr("title") + '][categories]\']').attr('value', data.join());
						
			return false;
		},
		focus: function(event, ui) {
	      	return false;
	   	}
	});
	
	$('input[name=\'filter_product_module[' + module_row + '][tabs][' + element + '][product]\']').autocomplete({
		delay: 500,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						return {
							label: item.name,
							value: item.product_id
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			$('#product-' + $(this).attr("alt") + '-' + $(this).attr("title") + '-' + ui.item.value).remove();
			
			$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_products .scrollbox').append('<div id="product-' + $(this).attr("alt") + '-' + $(this).attr("title") + '-' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="' + $(this).attr("alt") + '" title="' + $(this).attr("title") + '" /><input type="hidden" value="' + ui.item.value + '" /></div>');
	
			$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_products .scrollbox div:odd').attr('class', 'odd');
			$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_products .scrollbox div:even').attr('class', 'even');
			
			data = $.map($('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_products .scrollbox input'), function(element){
				return $(element).attr('value');
			});
							
			$('input[name=\'filter_product_module[' + $(this).attr("alt") + '][tabs][' + $(this).attr("title") + '][products]\']').attr('value', data.join());
						
			return false;
		},
		focus: function(event, ui) {
	      	return false;
	   	}
	});
	
	element++;
}

$('.panel-products-autocomplete .scrollbox img').live('click', function() {
	$(this).parent().remove();
	
	$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_products .scrollbox div:odd').attr('class', 'odd');
	$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_products .scrollbox div:even').attr('class', 'even');

	data = $.map($('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_products .scrollbox input'), function(element){
		return $(element).attr('value');
	});
					
	$('input[name=\'filter_product_module[' + $(this).attr("alt") + '][tabs][' + $(this).attr("title") + '][products]\']').attr('value', data.join());
});

$('.panel-categories-autocomplete .scrollbox img').live('click', function() {
	$(this).parent().remove();
	
	$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_categories .scrollbox div:odd').attr('class', 'odd');
	$('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_categories .scrollbox div:even').attr('class', 'even');

	data = $.map($('.filter_product_module_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_categories .scrollbox input'), function(element){
		return $(element).attr('value');
	});
					
	$('input[name=\'filter_product_module[' + $(this).attr("alt") + '][tabs][' + $(this).attr("title") + '][categories]\']').attr('value', data.join());
});

$(document).ready(function() {
	$("select.get_product_from").live("change", function () {
		var modules = $(this).attr("title");
		$('.filter_product_module_' + modules + '_products').hide();
		$('.filter_product_module_' + modules + '_categories').hide();
		if($(this).find("option:selected").val() == 'products') {
			$('.filter_product_module_' + modules + '_products').show();
		}
		if($(this).find("option:selected").val() == 'category') {
			$('.filter_product_module_' + modules + '_categories').show();
		}
	});
});
</script>
<?php echo $footer; ?>