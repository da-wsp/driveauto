<?php if($this->registry->has('theme_options') == true) { 
$theme_options = $this->registry->get('theme_options'); ?>
<?php if($ustawienia['orientation'] == 1) { echo "This template doesn't support vertical orientation!"; } else { ?>
<div class="container-megamenu <?php if($ustawienia['full_width'] != '1') { echo 'container'; } ?> <?php if($ustawienia['orientation'] == 1) { echo 'vertical'; } else { echo 'horizontal'; } ?>">
	<?php if($ustawienia['orientation'] == 1) { ?>
	<div id="menuHeading">
		<div class="megamenuToogle-wrapper">
			<div class="megamenuToogle-pattern">
				<div class="container">
					<?php echo $navigation_text; ?>
				</div>
			</div>
		</div>
	</div>
	<?php } else { ?>
	<div id="megaMenuToggle">
		<div class="megamenuToogle-wrapper">
			<div class="megamenuToogle-pattern">
				<div class="container">
					<div class="background-megamenu">
						<div><span></span><span></span><span></span></div>
						<?php echo $navigation_text; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="megamenu-wrapper">
		<div class="megamenu-pattern">
			<div class="container">
            
			    <ul class="block-menu">
                    <li><a href="/" class="three-d">
<!--                        Home-->
                        <?php if($ustawienia['home_item'] == 'icon') { ?><i class="fa fa-home"></i><?php } else { echo '<span><strong>'.$home_text.'</strong></span>'; } ?>
                        <span aria-hidden="true" class="three-d-box">
                            <span class="front"><?php if($ustawienia['home_item'] == 'icon') { ?><i class="fa fa-home"></i><?php } else { echo '<span><strong>'.$home_text.'</strong></span>'; } ?></span>
                            <span class="back1"><?php if($ustawienia['home_item'] == 'icon') { ?><i class="fa fa-home"></i><?php } else { echo '<span><strong>'.$home_text.'</strong></span>'; } ?></span>
                        </span>
                    </a></li>
                    
                    <?php foreach($menu as $row) { ?>
                    <li><a href="<?php echo $row['link']?>" class="three-d">
                        <?php echo html_entity_decode($row['name'][$lang_id]) ?>
                        <span aria-hidden="true" class="three-d-box">
                            <span class="front"><?php echo html_entity_decode($row['name'][$lang_id]) ?></span>
                            <span class="back1"><?php echo html_entity_decode($row['name'][$lang_id]) ?></span>
                        </span>
                    </a></li>
                    <?php } ?>
                    
                    <?php if($ustawienia['search_bar'] == 1) { ?>
					<li class="search pull-right">
						<!-- Search -->
						<div class="search_form">
 <div id="ssos">
<input type="text" id="artnum" name="artnum"   placeholder="Поиск по номеру запчасти" />
<img src="/image/Search.png" type="submit" id="searchIcon"  onclick="tdm_search_bubmit()" /> 
</div>
</div>
<script type="text/javascript">
function tdm_search_bubmit(){
var str=''; 
str = $('#artnum').val();
str = str.replace(/[^a-zA-Z0-9.-]+/g, '');
url = '/autoparts/search/'+str+'/';
location = url;
}
$('#artnum').keypress(function (e){
if (e.which == 13) {
tdm_search_bubmit();
return false;
}
});
</script>
							<div style="visibility:hidden" class="button-search2"></div>
							<input type="hidden" class="input-block-level search-query" name="search2" id="search_query2" value="<?php echo $search; ?>" />
							
							<?php if($theme_options->get( 'quick_search_autosuggest' ) != '0') { ?>
							<div id="autocomplete-results2" class="autocomplete-results"></div>
							
							<script type="text/javascript">
							$(document).ready(function() {
								$('#search_query2').autocomplete({
									delay: 0,
									appendTo: "#autocomplete-results2",
									source: function(request, response) {		
										$.ajax({
											url: 'index.php?route=search/autocomplete&filter_name=' +  encodeURIComponent(request.term),
											dataType: 'json',
											success: function(json) {
												response($.map(json, function(item) {
													return {
														label: item.name,
														value: item.product_id,
														href: item.href,
														thumb: item.thumb,
														desc: item.desc,
														price: item.price
													}
												}));
											}
										});
									},
									select: function(event, ui) {
										document.location.href = ui.item.href;
										
										return false;
									},
									focus: function(event, ui) {
								      	return false;
								   	},
								   	minLength: 2
								})
								.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
								  return $( "<li>" )
								    .append( "<a>" + item.label + "</a>" )
								    .appendTo( ul );
								};
							});
							</script>
							<?php } ?>
						</div>
					</li>
					<?php } ?>
                    <!-- more items here -->
                </ul>
<!--
                
				<ul class="megamenu">
					<?php if($ustawienia['home_item'] == 'icon' || $ustawienia['home_item'] == 'text') { ?>
					<li class="home"><a href="<?php echo $home; ?>"><?php if($ustawienia['home_item'] == 'icon') { ?><i class="fa fa-home"></i><?php } else { echo '<span><strong>'.$home_text.'</strong></span>'; } ?></a></li>
					<?php } ?>
-->
<!--
					<?php if($ustawienia['search_bar'] == 1) { ?>
					<li class="search pull-right">
						 Search 
						<div class="search_form">
							<div class="button-search22"></div>
							<input type="text" class="input-block-level search-query" name="search2" placeholder="<?php echo $text_search; ?>" id="search_query2" value="<?php echo $search; ?>" />
							
							<?php if($theme_options->get( 'quick_search_autosuggest' ) != '0') { ?>
							<div id="autocomplete-results2" class="autocomplete-results"></div>
							
							<script type="text/javascript">
							$(document).ready(function() {
								$('#search_query2').autocomplete({
									delay: 0,
									appendTo: "#autocomplete-results2",
									source: function(request, response) {		
										$.ajax({
											url: 'index.php?route=search/autocomplete&filter_name=' +  encodeURIComponent(request.term),
											dataType: 'json',
											success: function(json) {
												response($.map(json, function(item) {
													return {
														label: item.name,
														value: item.product_id,
														href: item.href,
														thumb: item.thumb,
														desc: item.desc,
														price: item.price
													}
												}));
											}
										});
									},
									select: function(event, ui) {
										document.location.href = ui.item.href;
										
										return false;
									},
									focus: function(event, ui) {
								      	return false;
								   	},
								   	minLength: 2
								})
								.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
								  return $( "<li>" )
								    .append( "<a>" + item.label + "</a>" )
								    .appendTo( ul );
								};
							});
							</script>
							<?php } ?>
						</div>
					</li>
					<?php } ?>
-->
<!--
					<?php
						foreach($menu as $row) {
							$class = '';
							$class_link = 'clearfix';
							$title = false;
							$target = false;
							if($row['description'] != '') { $class_link .= ' description'; }
							if(is_array($row['submenu']) && !empty($row['submenu'])) { $class .= ' with-sub-menu'; if($row['submenu_type'] == 1) { $class .= ' click'; } else { $class .= ' hover'; } }
							if($row['position'] == 1) { $class .= ' pull-right'; }
							if($row['submenu_type'] == 2) { $title = 'title="hover-intent"'; }
							if($row['new_window'] == 1) { $target = 'target="_blank"'; }
							if(!isset($row['name'][$lang_id])) { $row['name'][$lang_id] = 'Set name'; }
							echo "<li class='".$class."' ".$title."><p class='close-menu'></p>";
							echo "<a href='".$row['link']."' class='".$class_link."' ".$target."><span><strong>".$row['icon'].html_entity_decode($row['name'][$lang_id]).html_entity_decode($row['description'])."</strong></span></a>";
								if(is_array($row['submenu']) && !empty($row['submenu'])) {
									if($ustawienia['orientation'] == '1' && $row['submenu_width'] == '100%') { $row['submenu_width'] = '350%'; }
									echo '<div class="sub-menu" style="width:'.$row['submenu_width'].'">';
										echo '<div class="content">';
											echo '<div class="row">';
												$row_fluid = 0;
												foreach($row['submenu'] as $submenu) {
													if(($row_fluid+$submenu['content_width']) > 12) {
														$row_fluid = $submenu['content_width'];
														echo '</div><div class="border"></div><div class="row">';
													} else {
														$row_fluid = $row_fluid+$submenu['content_width'];
													}
													echo '<div class="col-sm-'.$submenu['content_width'].'">';
														if($submenu['content_type'] == '0') {
															echo $submenu['html'];
														} elseif($submenu['content_type'] == '1') {
															if(is_array($submenu['product'])) {
																echo '<div class="product">';
																	echo '<div class="image"><a href="'.$submenu['product']['link'].'" onclick="window.location = \''.$submenu['product']['link'].'\';"><img src="'.$submenu['product']['image'].'" alt=""></a></div>';
																	echo '<div class="name"><a href="'.$submenu['product']['link'].'" onclick="window.location = \''.$submenu['product']['link'].'\';">'.$submenu['product']['name'].'</a></div>';
																	echo '<div class="price">';
																		if (!$submenu['product']['special']) {
																			echo $submenu['product']['price'];
																		} else {
																			echo $submenu['product']['special'];
																		}
																	echo '</div>';
																echo '</div>';
															}
														} elseif($submenu['content_type'] == '2') {
															echo $submenu['categories'];
														}
													echo '</div>';
												}
											echo '</div>';
										echo '</div>';
									echo '</div>';
								}
							echo "</li>";
							echo "\n";
						}
					?>
-->
<!--				</ul>-->
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
transition = '<?php if($ustawienia['animation'] != '') { echo $ustawienia['animation']; } else { echo 'none'; } ?>';
animation_time = <?php if($ustawienia['animation_time'] > 0 && $ustawienia['animation_time'] < 5000) { echo $ustawienia['animation_time']; } else { echo 500; } ?>;
</script>
<?php } ?>
<?php } ?>