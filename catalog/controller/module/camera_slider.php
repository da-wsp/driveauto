<?php
/* 
Version: 1.0
Author: Artur Sułkowski
Website: http://artursulkowski.pl
*/

class ControllerModuleCameraSlider extends Controller {
	protected function index($setting) {
		
		// Ładowanie modelu Camera slider
		$this->load->model('slider/camera_slider');

		// Pobranie slideru z modelu
		$this->data['slider'] = $this->model_slider_camera_slider->getSlider($setting['slider_id']);
		
		$this->data['language_id'] = $this->config->get('config_language_id');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/camera_slider.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/camera_slider.tpl';
		} else {
			$this->template = 'default/template/module/camera_slider.tpl';
		}

		$this->render();
	}
}
?>