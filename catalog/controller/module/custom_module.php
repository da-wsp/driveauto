<?php  
/* 
Version: 1.0
Author: Artur Sułkowski
Website: http://artursulkowski.pl
*/

class ControllerModuleCustomModule extends Controller {
	protected function index($setting) {
		if(isset($setting['html'][$this->config->get('config_language_id')])) {
			$this->data['text'] = html_entity_decode($setting['html'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['text'] = 'You must set text in the module Custom Module!';
		}
		
		if(isset($setting['block_heading'][$this->config->get('config_language_id')])) {
			$this->data['block_heading'] = html_entity_decode($setting['block_heading'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['block_heading'] = 'You must set block heading in the module Custom Module!';
		}
		
		if(isset($setting['block_content'][$this->config->get('config_language_id')])) {
			$this->data['block_content'] = html_entity_decode($setting['block_content'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['block_content'] = 'You must set block content in the module Custom Module!';
		}
		
		$this->data['type'] = $setting['type'];
		$this->data['position'] = $setting['position'];

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/custom_module.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/custom_module.tpl';
		} else {
			$this->template = 'default/template/module/custom_module.tpl';
		}
		
		$this->render();
	}
}
?>