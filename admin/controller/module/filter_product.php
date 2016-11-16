<?php
/* 
Version: 1.0
Author: Artur Sułkowski
Website: http://artursulkowski.pl
*/

class ControllerModuleFilterProduct extends Controller {
	private $error = array(); 
	 
	public function index() {   
		$this->language->load('module/filter_product');

		$this->document->setTitle('Filter product');
		
		$this->load->model('setting/setting');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		
		// Dodawanie plików css i js do <head>
		$this->document->addStyle('view/stylesheet/filter_product.css');
		
		// Zapisywanie modułu		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('filter_product', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/filter_product', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		// Wyświetlanie powiadomień
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		    unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->data['action'] = $this->url->link('module/filter_product', 'token=' . $this->session->data['token'], 'SSL');
				
		$this->data['token'] = $this->session->data['token'];
	
		// Ładowanie listy modułów
		$this->data['modules'] = array();
		
		if (isset($this->request->post['filter_product_module'])) {
			$this->data['modules'] = $this->request->post['filter_product_module'];
		} elseif ($this->config->get('filter_product_module')) { 
			$this->data['modules'] = $this->config->get('filter_product_module');
		}	
				
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->template = 'module/filter_product.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/filter_product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>