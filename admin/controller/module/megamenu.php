<?php
/* 
Version: 1.0
Author: Artur Sułkowski
Website: http://artursulkowski.pl
*/

class ControllerModuleMegaMenu extends Controller {
	
	private $error = array(); 
	
	public function index() {  
	
		//Load the language file for this module
		$this->language->load('module/megamenu');

		//Set the title from the language file $_['heading_title'] string
		$this->document->setTitle('MegaMenu'); 
		
		//Load the settings model. You can also add any other models you want to load here.
		$this->load->model('setting/setting');
		
		// Dodawanie plików css i js do <head>
		$this->document->addStyle('view/stylesheet/megamenu.css');
		$this->document->addScript('view/javascript/jquery/jquery.nestable.js');
		
		// Ładowanie modelu megamenu
		$this->load->model('menu/megamenu');
		
		// Instalacja megamenu w bazie danych
		$this->model_menu_megamenu->install();
		
		// Multilanguage
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->data['language_id'] = 0;
		foreach($this->data['languages'] as $value) {
			if($value['code'] == $this->config->get('config_language')) {
				$this->data['language_id'] = $value['language_id'];
			}
		}
		
		// Usuwanie menu
		if(isset($_GET['delete'])) {
			if($this->validate()){
				if($this->model_menu_megamenu->deleteMenu(intval($_GET['delete']))) {
					$this->session->data['success'] = 'This menu has been properly removed from the database.';
				} else {
					$this->session->data['error_warning'] = $this->model_menu_megamenu->displayError();
				}
			} else {
				$this->session->data['error_warning'] = $this->language->get('error_permission');
			}
			$this->redirect(HTTPS_SERVER . 'index.php?route=module/megamenu&token=' . $this->session->data['token']);
		}
		
		// Dodawanie menu
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if(isset($_POST['button-create'])) {
				if($this->validate()) {
					$error = false;
					$lang_id = $this->data['language_id'];
					if($this->request->post['name'][$lang_id] == '') $error = true;
					if($error == true) {
						$this->session->data['error_warning'] = $this->language->get('text_warning');
					} else {
						$this->model_menu_megamenu->addMenu($this->request->post);
						$this->session->data['success'] = $this->language->get('text_success');
					}
				} else {
					$this->session->data['error_warning'] = $this->language->get('error_permission');
				}
				$this->redirect(HTTPS_SERVER . 'index.php?route=module/megamenu&token=' . $this->session->data['token']);
			}
		}
		
		// Zapisywanie menu
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if(isset($_POST['button-edit'])) {
				if($this->validate()) {
					$error = false;
					$lang_id = $this->data['language_id'];
					if($this->request->post['name'][$lang_id] == '') $error = true;
					if($error == true) {
						$this->session->data['error_warning'] = $this->language->get('text_warning');
					} else {
						$this->model_menu_megamenu->saveMenu($this->request->post);
						$this->session->data['success'] = $this->language->get('text_success');
					}
				} else {
					$this->session->data['error_warning'] = $this->language->get('error_permission');
				}
				$this->redirect(HTTPS_SERVER . 'index.php?route=module/megamenu&token=' . $this->session->data['token']);
			}
		}
		
		// Generowanie menu z lewej strony
		$this->data['nestable_list'] = $this->model_menu_megamenu->generate_nestable_list($this->data['language_id']);
				
		// Zapisywanie ustawień
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if(isset($_POST['button-save'])){
				$megamenu = array();
				if(isset($this->request->post['search_bar'])) {
					$search_bar = 1;
				} else {
					$search_bar = 0;
				}
				if(!isset($this->request->post['layout_id'])) $this->request->post['layout_id'] = 100;
				if(!isset($this->request->post['position'])) $this->request->post['position'] = 'menu';
				if(!isset($this->request->post['status'])) $this->request->post['status'] = 1;
				if(!isset($this->request->post['sort_order'])) $this->request->post['layout_id'] = 0;
				if(!isset($this->request->post['orientation'])) $this->request->post['orientation'] = 0;
				if(!isset($this->request->post['navigation_text'])) $this->request->post['navigation_text'] = 0;
				if(!isset($this->request->post['home_text'])) $this->request->post['home_text'] = 0;
				if(!isset($this->request->post['full_width'])) $this->request->post['full_width'] = 0;
				if(!isset($this->request->post['home_item'])) $this->request->post['home_item'] = 0;
				if(!isset($this->request->post['animation'])) $this->request->post['animation'] = 'slide';
				if(!isset($this->request->post['animation_time'])) $this->request->post['animation_time'] = 500;
				if(!isset($this->request->post['status_cache'])) $this->request->post['status_cache'] = 0;
				if(!isset($this->request->post['cache_time'])) $this->request->post['cache_time'] = 1;
				$megamenu['megamenu_module'] = array(
					array(
						'layout_id'  => $this->request->post['layout_id'],
						'position'   => $this->request->post['position'],
						'status'     => $this->request->post['status'],
						'sort_order' => intval($this->request->post['sort_order']),
						'orientation' =>  $this->request->post['orientation'],
						'search_bar' => $search_bar,
						'navigation_text' => $this->request->post['navigation_text'],
						'home_text'  => $this->request->post['home_text'],
						'full_width' => $this->request->post['full_width'],
						'home_item'  => $this->request->post['home_item'],
						'animation'  => $this->request->post['animation'],
						'animation_time'  => intval($this->request->post['animation_time']),
						'status_cache'  => intval($this->request->post['status_cache']),
						'cache_time'  => intval($this->request->post['cache_time'])
					)
				);
				$this->model_setting_setting->editSetting('megamenu', $megamenu);
				$this->session->data['success'] = $this->language->get('text_success');
				$this->redirect(HTTPS_SERVER . 'index.php?route=module/megamenu&token=' . $this->session->data['token']);	
			}
		}
		
		// Zapisywanie kolejności linków
		if (isset($_GET['jsonstring'])) {
			if($this->validate()){
				$jsonstring = $_GET['jsonstring'];
				$jsonDecoded = json_decode(html_entity_decode($jsonstring));
				
				function parseJsonArray($jsonArray, $parentID = 0) {
					$return = array();
					foreach ($jsonArray as $subArray) {
						$returnSubSubArray = array();
						if (isset($subArray->children)) {
							$returnSubSubArray = parseJsonArray($subArray->children, $subArray->id);
						}
						$return[] = array('id' => $subArray->id, 'parentID' => $parentID);
						$return = array_merge($return, $returnSubSubArray);
					}
				
					return $return;
				}
				
				
				$readbleArray = parseJsonArray($jsonDecoded);
								
				foreach ($readbleArray as $key => $value) {
					if (is_array($value)) {
						$this->model_menu_megamenu->save_rang($value['parentID'], $value['id'], $key);
					}	
				}

				die("The list was updated ".date("y-m-d H:i:s")."!");
				
			} else {
				die($this->language->get('error_permission'));
			}
		}
		
		// Pobranie ustawień
		if($this->config->get('megamenu_module') != '') {
			$ustawienia = $this->config->get('megamenu_module');
			$this->data['layout_id'] = $ustawienia[0]['layout_id'];
			$this->data['status'] = $ustawienia[0]['status'];
			$this->data['position'] = $ustawienia[0]['position'];
			$this->data['orientation'] = $ustawienia[0]['orientation'];
			$this->data['search_bar'] = $ustawienia[0]['search_bar'];
			$this->data['sort_order'] = $ustawienia[0]['sort_order'];
			$this->data['navigation_text'] = $ustawienia[0]['navigation_text'];
			$this->data['home_text'] = $ustawienia[0]['home_text'];
			$this->data['full_width'] = $ustawienia[0]['full_width'];
			$this->data['home_item'] = $ustawienia[0]['home_item'];
			$this->data['animation'] = $ustawienia[0]['animation'];
			$this->data['animation_time'] = $ustawienia[0]['animation_time'];
			if(isset($ustawienia[0]['status_cache'])) {
				$this->data['status_cache'] = $ustawienia[0]['status_cache'];
				$this->data['cache_time'] = $ustawienia[0]['cache_time'];
			} else {
				$this->data['status_cache'] = '0';
				$this->data['cache_time'] = '1';
			}
		} else {
			$this->data['layout_id'] = 100;
			$this->data['status'] = 1;
			$this->data['orientation'] = 0;
			$this->data['position'] = 'menu';   
			$this->data['search_bar'] = 0;
			$this->data['sort_order'] = 0;
			$this->data['full_width'] = 0;
			$this->data['home_item'] = 'icon';
			$this->data['animation'] = 'slide';
			$this->data['animation_time'] = '500';
			$data['status_cache'] = '0';
			$data['cache_time'] = '1';
		}
		
		// Dodawanie menu
		$this->data['action_type'] = 'basic';
		if(isset($_GET['action'])) {
			if($_GET['action'] == 'create') {
				$this->data['action_type'] = 'create';
				$this->data['name'] = '';
				$this->data['description'] = '';
				$this->data['icon'] = '';
				$this->data['link'] = '';
				$this->data['new_window'] = '';
				$this->data['status'] = '';
				$this->data['position'] = '';
				$this->data['submenu_width'] = '100%';
				$this->data['display_submenu'] = '';
				$this->data['content_width'] = '4';
				$this->data['content_type'] = '0';
				$this->data['content'] = array(
					'html' => array(
							'text' => array()
						),
					'product' => array(
							'id' => '',
							'name' => '',
							'width' => '400',
							'height' => '400'
						),
					'categories' => array(
							'categories' => array(),
							'columns' => '',
							'submenu' => '',
							'submenu_columns' => ''
						)
				);
				$this->data['list_categories'] = false;
			}
		}
		
		// Edycja menu
		if(isset($_GET['edit'])) {
			$this->data['action_type'] = 'edit';
			$dane = $this->model_menu_megamenu->getMenu(intval($_GET['edit']));
			if($dane) {
				$this->data['name'] = $dane['name'];
				$this->data['description'] = $dane['description'];
				$this->data['icon'] = $dane['icon'];
				$this->data['link'] = $dane['link'];
				$this->data['new_window'] = $dane['new_window'];
				$this->data['status'] = $dane['status'];
				$this->data['position'] = $dane['position'];
				$this->data['submenu_width'] = $dane['submenu_width'];
				$this->data['display_submenu'] = $dane['display_submenu'];
				$this->data['content_width'] = $dane['content_width'];
				$this->data['content_type'] = $dane['content_type'];
				$this->data['content'] = $dane['content'];
				$this->data['list_categories'] = $this->model_menu_megamenu->getCategories($dane['content']['categories']['categories']);
			} else {
				$this->session->data['error_warning'] = 'This menu does not exist!';
				$this->redirect(HTTPS_SERVER . 'index.php?route=module/megamenu&token=' . $this->session->data['token']);	
			}
		}
		
		// Layouts
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
		if (isset($this->session->data['error_warning'])) {
			$this->data['error_warning'] = $this->session->data['error_warning'];
			unset($this->session->data['error_warning']);
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		    unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->data['action'] = $this->url->link('module/megamenu', 'token=' . $this->session->data['token'], 'SSL');
		
		//Choose which template file will be used to display this request.
		$this->template = 'module/megamenu.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		
		//Send the output.
		$this->response->setOutput($this->render());
	
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/megamenu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
}

?>