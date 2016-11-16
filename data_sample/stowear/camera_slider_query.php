<?php 

$query = $this->db->query("
	DROP TABLE IF EXISTS `".DB_PREFIX ."camera_slider`
");

$query = $this->db->query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."camera_slider` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`name` text,
			`settings` text,
			`content` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1
");

$language_id = 2;
foreach($this->data['languages'] as $language) {
	if($language['language_id'] != 1) {
		$language_id = $language['language_id'];
	}
}

$query = $this->db->query("
		INSERT INTO `".DB_PREFIX."camera_slider` (`id`, `name`, `settings`, `content`) VALUES
		(1, 'Standard slider', 'a:3:{s:13:\"slider_height\";s:3:\"500\";s:12:\"slider_width\";s:4:\"1170\";s:11:\"layout_type\";s:1:\"1\";}', 'a:2:{i:1;a:2:{i:" . $language_id . ";a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:21:\"catalog/slider-01.png\";s:4:\"link\";s:1:\"#\";}i:1;a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:21:\"catalog/slider-01.png\";s:4:\"link\";s:1:\"#\";}}i:2;a:2:{i:" . $language_id . ";a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:21:\"catalog/slider-01.png\";s:4:\"link\";s:1:\"#\";}i:1;a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:21:\"catalog/slider-01.png\";s:4:\"link\";s:0:\"\";}}}'),
		(2, 'Jewerly slider', 'a:3:{s:13:\"slider_height\";s:3:\"500\";s:12:\"slider_width\";s:4:\"1170\";s:11:\"layout_type\";s:1:\"1\";}', 'a:2:{i:1;a:2:{i:" . $language_id . ";a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:26:\"catalog/slider-jewerly.png\";s:4:\"link\";s:1:\"#\";}i:1;a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:26:\"catalog/slider-jewerly.png\";s:4:\"link\";s:1:\"#\";}}i:2;a:2:{i:" . $language_id . ";a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:26:\"catalog/slider-jewerly.png\";s:4:\"link\";s:0:\"\";}i:1;a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:26:\"catalog/slider-jewerly.png\";s:4:\"link\";s:1:\"#\";}}}'),
		(3, 'Tools slider', 'a:3:{s:13:\"slider_height\";s:3:\"500\";s:12:\"slider_width\";s:4:\"1170\";s:11:\"layout_type\";s:1:\"1\";}', 'a:2:{i:1;a:2:{i:" . $language_id . ";a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:24:\"catalog/slider-tools.png\";s:4:\"link\";s:1:\"#\";}i:1;a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:24:\"catalog/slider-tools.png\";s:4:\"link\";s:1:\"#\";}}i:2;a:2:{i:" . $language_id . ";a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:24:\"catalog/slider-tools.png\";s:4:\"link\";s:1:\"#\";}i:1;a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:24:\"catalog/slider-tools.png\";s:4:\"link\";s:1:\"#\";}}}'),
		(4, 'Kids slider', 'a:3:{s:13:\"slider_height\";s:3:\"500\";s:12:\"slider_width\";s:4:\"1170\";s:11:\"layout_type\";s:1:\"1\";}', 'a:2:{i:1;a:2:{i:" . $language_id . ";a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:23:\"catalog/slider-kids.png\";s:4:\"link\";s:1:\"#\";}i:1;a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:23:\"catalog/slider-kids.png\";s:4:\"link\";s:1:\"#\";}}i:2;a:2:{i:" . $language_id . ";a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:23:\"catalog/slider-kids.png\";s:4:\"link\";s:1:\"#\";}i:1;a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:23:\"catalog/slider-kids.png\";s:4:\"link\";s:1:\"#\";}}}'),
		(5, 'Sport slider', 'a:3:{s:13:\"slider_height\";s:3:\"400\";s:12:\"slider_width\";s:3:\"870\";s:11:\"layout_type\";s:1:\"1\";}', 'a:2:{i:1;a:2:{i:" . $language_id . ";a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:24:\"catalog/slider-sport.png\";s:4:\"link\";s:1:\"#\";}i:1;a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:24:\"catalog/slider-sport.png\";s:4:\"link\";s:1:\"#\";}}i:2;a:2:{i:" . $language_id . ";a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:24:\"catalog/slider-sport.png\";s:4:\"link\";s:1:\"#\";}i:1;a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:24:\"catalog/slider-sport.png\";s:4:\"link\";s:1:\"#\";}}}'),
		(6, 'Computer slider', 'a:3:{s:13:\"slider_height\";s:3:\"500\";s:12:\"slider_width\";s:4:\"1170\";s:11:\"layout_type\";s:1:\"1\";}', 'a:2:{i:1;a:2:{i:" . $language_id . ";a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:27:\"catalog/slider-computer.png\";s:4:\"link\";s:1:\"#\";}i:1;a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:27:\"catalog/slider-computer.png\";s:4:\"link\";s:1:\"#\";}}i:2;a:2:{i:" . $language_id . ";a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:27:\"catalog/slider-computer.png\";s:4:\"link\";s:1:\"#\";}i:1;a:3:{s:6:\"status\";s:1:\"1\";s:6:\"slider\";s:27:\"catalog/slider-computer.png\";s:4:\"link\";s:1:\"#\";}}}')
");

?>