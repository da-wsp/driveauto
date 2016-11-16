<?php
/* 
Version: 1.0
Author: Artur Sułkowski
Website: http://artursulkowski.pl
*/

class ControllerModuleMegamenu extends Controller {
	protected function index($setting) {
		
		// Ładowanie modelu MegaMenu
		$this->load->model('menu/megamenu');
		
		// Cache MegaMenu	
		if(!isset($setting['status_cache'])) $setting['status_cache'] = 0;	
		$file_cache = 'catalog/model/menu/cache/cache_' . $this->config->get('config_language_id') . '.json';
		if($setting['status_cache'] == 1 && is_writable('catalog/model/menu/cache')) {
			$cache_life = $setting['cache_time']*3600;
			if(!file_exists($file_cache) or (time() - filemtime($file_cache) >= $cache_life)) {
				file_put_contents($file_cache, json_encode($this->model_menu_megamenu->getMenu()));
			}
			$this->data['menu'] = json_decode(file_get_contents($file_cache), true);
		} else {
			$this->data['menu'] = $this->model_menu_megamenu->getMenu();
		}
		
		// Pobranie ustawień
		$lang_id = $this->config->get('config_language_id');
		$this->data['ustawienia'] = array(
			'orientation' => $setting['orientation'],
			'search_bar' => $setting['search_bar'],
			'navigation_text' => $setting['navigation_text'],
			'full_width' => $setting['full_width'],
			'home_item' => $setting['home_item'],
			'home_text' => $setting['home_text'],
			'animation' => $setting['animation'],
			'animation_time' => $setting['animation_time']
		);
		$this->data['navigation_text'] = 'Navigation';
		if(isset($setting['navigation_text'][$lang_id])) {
			if(!empty($setting['navigation_text'][$lang_id])) {
				$this->data['navigation_text'] = $setting['navigation_text'][$lang_id];
			}
		}
		$this->data['home_text'] = 'Home';
		if(isset($setting['home_text'][$lang_id])) {
			if(!empty($setting['home_text'][$lang_id])) {
				$this->data['home_text'] = $setting['home_text'][$lang_id];
			}
		}
		
		$this->data['home'] = $this->url->link('common/home');
		$this->data['lang_id'] = $this->config->get('config_language_id');
		
		// Search
		$this->language->load('common/header');
		$this->data['text_search'] = $this->language->get('text_search');
		if (isset($this->request->get['search'])) {
			$this->data['search'] = $this->request->get['search'];
		} else {
			$this->data['search'] = '';
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/megamenu.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/megamenu.tpl';
		} else {
			$this->template = 'default/template/module/megamenu.tpl';
		}

		$this->render();
	}
}
?>