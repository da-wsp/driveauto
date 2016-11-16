<?php echo $header; ?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:600' rel='stylesheet' type='text/css'>

<div id="content">
	<?php if ($error_warning) { ?>
	  <div class="warning"><?php echo $error_warning; ?></div>
	  <?php } else { ?>
	  <?php if ($success) { ?>
	  <div class="success"><?php echo $success; ?></div>
	  <?php } } ?>
	
	<!-- Camera slider -->
	<div class="set-size" id="camera-slider">
		<h3>Camera slider</h3>
		
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<?php if(isset($slider_id)) { ?>
			<input type="hidden" name="slider_id" value="<?php echo $slider_id; ?>">
			<?php } ?>
			<!-- Content -->
			<div class="content">
				<div>
					<div class="bg-tabs clearfix">
						<!-- Tabs module -->
						<div id="tabs_slider">
							<a href="#tab-generaloptions">General options</a>
							<?php $module_row = 1; ?>
							<?php foreach ($sliders as $slider) { ?>
							<a href="#tab-slide-<?php echo $module_row; ?>" id="slide-<?php echo $module_row; ?>">Slide <?php echo $module_row; ?> &nbsp;<img src="view/image/delete.png"  alt="" onclick="$('#tabs_slider a:first').trigger('click'); $('#slide-<?php echo $module_row; ?>').remove(); $('#tab-slide-<?php echo $module_row; ?>').remove(); return false;" /></a>
							<?php $module_row++; ?>
							<?php } ?>
							<span id="slide-add">Add Slide &nbsp;<img src="view/image/add.png" alt="" onclick="addSlide();" /></span>
						</div>
						
						<div class="tab-content2" id="tab-generaloptions">
							<h4>General settings</h4>
							
							<!-- Input -->
							<div class="input clearfix">
								<p>Slider name</p>
								<input type="text" name="slider_name" value="<?php echo $slider_name; ?>" style="width:155px">
							</div>
							
							<!-- Input -->
							<div class="input clearfix">
								<p>Width slider (px)</p>
								<input type="text" name="slider_width" value="<?php echo $slider_width; ?>" style="width:155px">
							</div>
							
							<!-- Input -->
							<div class="input clearfix">
								<p>Height slider (px)</p>
								<input type="text" name="slider_height" value="<?php echo $slider_height; ?>" style="width:155px">
							</div>

							<!-- Input -->
							<div class="input clearfix">
								<p>Layout Type</p>
								<select name="layout_type">
									<option value="0" <?php if($layout_type == '0'){echo ' selected="selected"';} ?>>Full width</option>
									<option value="1" <?php if($layout_type == '1'){echo ' selected="selected"';} ?>>Fixed</option>
								</select>
							</div>
						</div>
						
						<?php $module_row = 1; ?>
						<?php foreach ($sliders as $slider) { ?>
						<div class="tab-content" id="tab-slide-<?php echo $module_row; ?>">
							<div id="tab-slider-<?php echo $module_row; ?>-language" class="tab-slider-language">
							<?php foreach ($languages as $language) { ?>
								<a href="#tab_slider_<?php echo $module_row; ?>_language_<?php echo $language['language_id']; ?>"><img src="../image/flags/<?php echo $language['image'] ?>" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><span><?php echo $language['name']; ?></span></a>
							<?php } ?>
							</div>
							
							<?php foreach ($languages as $language) { ?>
							<?php $language_id = $language['language_id']; ?>
							<div id="tab_slider_<?php echo $module_row; ?>_language_<?php echo $language_id; ?>" class="tab-content3">
							
										<!-- Status -->
										
										<?php if(isset($slider[$language_id]['status'])) { ?>
										<?php if($slider[$language_id]['status'] == 1) { echo '<div class="status status-on" title="1" rel="slider_'.$module_row.'_'.$language_id.'_status"></div>'; } else { echo '<div class="status status-off" title="0" rel="slider_'.$module_row.'_'.$language_id.'_status"></div>'; } ?>
										
										<input name="slider[<?php echo $module_row; ?>][<?php echo $language_id; ?>][status]" value="<?php echo $slider[$language_id]['status']; ?>" id="slider_<?php echo $module_row; ?>_<?php echo $language_id; ?>_status" type="hidden" />
										<?php } else { ?>
										<?php echo '<div class="status status-off" title="0" rel="slider_'.$module_row.'_'.$language_id.'_status"></div>'; ?>
										<input name="slider[<?php echo $module_row; ?>][<?php echo $language_id; ?>][status]" value="0" id="slider_<?php echo $module_row; ?>_<?php echo $language_id; ?>_status" type="hidden" />
										<?php } ?>
								
										<div class="slider" onclick="image_upload('slider_<?php echo $module_row; ?>_<?php echo $language_id; ?>_slider', 'preview_<?php echo $module_row; ?>_<?php echo $language_id; ?>');">
										
											<input type="hidden" name="slider[<?php echo $module_row; ?>][<?php echo $language_id; ?>][slider]" value="<?php echo $slider[$language_id]['slider']; ?>" id="slider_<?php echo $module_row; ?>_<?php echo $language_id; ?>_slider" />
											<img src="../image/<?php echo $slider[$language_id]['slider']; ?>" alt="" id="preview_<?php echo $module_row; ?>_<?php echo $language_id; ?>" />
										
										</div>
										
										<!-- Input -->
										<div class="input clearfix">
										
											<p>Link</p>
											<?php if(isset($slider[$language_id]['link'])) { ?>
											<input type="text" name="slider[<?php echo $module_row; ?>][<?php echo $language_id; ?>][link]" value="<?php echo $slider[$language_id]['link']; ?>" style="float:right;margin-right:0px;width:332px" />
											<?php } else { ?>
											<input type="text" name="slider[<?php echo $module_row; ?>][<?php echo $language_id; ?>][link]" value="" style="float:right;margin-right:0px;width:332px" />
											<?php } ?>
										
											<div class="clear"></div>
										
										</div>
										<!-- End Input -->
							</div>
							<?php } ?>
							
							<script type="text/javascript"><!--
							
							$('#tab-slider-<?php echo $module_row; ?>-language a').tabs();
							
							//--></script> 
							
						</div>
						<?php $module_row++; ?>
						<?php } ?>
					</div>
					
					<div>
						<?php if(isset($slider_id)) { ?>
						<!-- Buttons -->
						<div class="buttons"><input type="submit" name="button-save" class="button-save" value=""></div>
						<?php } else { ?>
						<div class="buttons"><input type="submit" name="button-add" class="button-save" value=""></div>
						<?php } ?>
					</div>
				</div>
			</div>	
		</form>	
	</div>
</div>

<script type="text/javascript"><!--
$('#tabs_slider a').tabs();
//--></script> 

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addSlide() {
	html  = '<div id="tab-slide-' + module_row + '" class="tab-content">';
	html += '	<div id="tab-slider-'+ module_row +'-language" class="tab-slider-language">';
	<?php foreach ($languages as $language) { ?>
	html += '		<a href="#tab_slider_'+ module_row +'_language_<?php echo $language['language_id']; ?>"><img src="../image/flags/<?php echo $language['image'] ?>" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><span><?php echo $language['name']; ?></span></a>';
	<?php } ?>
	html += '	</div>';
	<?php foreach ($languages as $language) { ?>
	html += '	<div id="tab_slider_'+ module_row +'_language_<?php echo $language['language_id']; ?>" class="tab-content3">';
	html += '		<div class="status status-off" title="0" rel="slider_' + module_row + '_<?php echo $language['language_id']; ?>_status"></div><input name="slider[' + module_row + '][<?php echo $language['language_id']; ?>][status]" value="0" id="slider_' + module_row + '_<?php echo $language['language_id']; ?>_status" type="hidden" />';
	
	html += '		<div class="slider" onclick="image_upload(\'slider_'+ module_row +'_<?php echo $language['language_id']; ?>_slider\', \'preview_'+ module_row +'_<?php echo $language['language_id']; ?>\');">';
	html += '			<input type="hidden" name="slider['+ module_row +'][<?php echo $language['language_id']; ?>][slider]" value="" id="slider_'+ module_row +'_<?php echo $language['language_id']; ?>_slider" />';
	html += '			<img src="../image/no_image.jpg" alt="" id="preview_'+ module_row +'_<?php echo $language['language_id']; ?>" />';
	html += '		</div>';
	
	html += '		<div class="input clearfix">';
	html += '			<p>Link</p>';
	html += '			<input type="text" name="slider['+ module_row +'][<?php echo $language['language_id']; ?>][link]" value="" style="float:right;margin-right:0px;width:332px">';
	html += '		</div>';

	html += '	</div>';
	<?php } ?>
	html += '</div>';
	
	$('.bg-tabs').append(html);
	
	$('#tab-slider-'+ module_row +'-language a').tabs();
	
	$('#slide-add').before('<a href="#tab-slide-' + module_row + '" id="slide-' + module_row + '">Slide ' + module_row + ' &nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'#tabs_slider a:first\').trigger(\'click\'); $(\'#slide-' + module_row + '\').remove(); $(\'#tab-slide-' + module_row + '\').remove(); return false;" /></a>');
	
	$('#tabs_slider a').tabs();
	
	$('#slide-' + module_row).trigger('click');
	
	module_row++;
}
//--></script> 

<script type="text/javascript">
jQuery(document).ready(function($) {

	$(".status").live("click", function () {
		
		var styl = $(this).attr("rel");
		var co = $(this).attr("title");
		
		if(co == 1) {
		
			$(this).removeClass('status-on');
			$(this).addClass('status-off');
			$(this).attr("title", "0");

			$("#"+styl+"").val(0);
		
		}
		
		if(co == 0) {
		
			$(this).addClass('status-on');
			$(this).removeClass('status-off');
			$(this).attr("title", "1");

			$("#"+styl+"").val(1);
		
		}
		
	});

});	
</script>
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: 'Image manager',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<?php echo $footer; ?>