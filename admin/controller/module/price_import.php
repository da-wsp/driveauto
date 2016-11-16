<?php
class ControllerModulePriceImport extends Controller {
	private $error = array();
	private $group = 'price_import';
	private $cache_methods = array(
			'Memory'           => 'cache_in_memory',
			'MemoryGZip'       => 'cache_in_memory_gzip',
			'MemorySerialized' => 'cache_in_memory_serialized',
//		    'APC'              => 'cache_to_apc',
//		    'Memcache'         => 'cache_to_memcache',
//		    'SQLite'           => 'cache_to_sqlite',
//		    'SQLite3'          => 'cache_to_sqlite3',
		);
	private $valid_types = array('xls', 'xlsx'); // Доступные расширения файлов

	public function index() {
		$this->language->load('module/price_import');

		$this->load->model('setting/setting');
		$this->load->model('price_import/setting');

		// Если нажата кнопка
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			// Редактирование профайла
			if (isset($this->request->post['edit_profile'])) {
				if (isset($this->request->post['profile']) OR ! empty($this->request->post['profile'])) {
					$this->redirect($this->url->link('module/price_import/edit_profile', 'profile='.$this->request->post['profile'].'&token=' . $this->session->data['token'], 'SSL'));
				}
			}

			// Удаление профайла
			if (isset($this->request->post['delete_profile'])) {
				if (isset($this->request->post['profile']) OR ! empty($this->request->post['profile'])) {
					$this->redirect($this->url->link('module/price_import/delete_profile', 'profile='.$this->request->post['profile'].'&token=' . $this->session->data['token'], 'SSL'));
				}
			}

			// Предварительная загрузка прайс-листа
			if (isset($this->request->post['preload'])) {
				// Выбран ли файл?
				if (empty($_FILES['import']['name'])) {
					$this->session->data['error'] = $this->language->get('error_file_not_select');

					$this->redirect($this->url->link('module/price_import', 'token=' . $this->session->data['token'], 'SSL'));
				}

			if (isset($this->request->post['profile']) OR ! empty($this->request->post['profile'])) {
				// Замер времени чтения файла
				$start_time = microtime(TRUE);

				$value = $this->upload();

				if (is_string($value)) {

					if ( ! file_exists($value)) {
						$this->session->data['error'] = $this->language->get('error_file_not_found');
					}

					// Получение профайла
					$config = unserialize($this->config->get($this->request->post['profile']));

					$this->cache->delete('current_profile');
					$this->cache->set('current_profile', $config);

					$this->read_file($value);

				} elseif (is_int($value)) {

					if ($value == 1) {
						$this->session->data['error'] = $this->language->get('error_valid_ext');
					}

					if ($value == 2) {
						$this->session->data['error'] = $this->language->get('error_save_file');
					}
				}

				$this->session->data['success'] = sprintf($this->language->get('text_preload_success'), microtime(TRUE)-$start_time);

				$this->redirect($this->url->link('module/price_import/uploaded_file', 'profile='.$this->request->post['profile'].'&token=' . $this->session->data['token'], 'SSL'));
			}
			}
		}

		$this->document->addStyle('view/stylesheet/price_import.css');
		$this->document->setTitle($this->language->get('heading_title_2'));

		// H1
		$this->data['heading_title'] = $this->language->get('heading_title_2');

		$this->data['text_select_profile'] = $this->language->get('text_select_profile');
		$this->data['text_edit_title'] = $this->language->get('text_edit_title');
		$this->data['text_delete_title'] = $this->language->get('text_delete_title');
		$this->data['text_to_delete'] = $this->language->get('text_to_delete');
		$this->data['text_no_profiles'] = $this->language->get('text_no_profiles');
		$this->data['text_select_file'] = $this->language->get('text_select_file');
		$this->data['text_valid_types'] = implode(', ', $this->valid_types);

		$this->data['help_select_file'] = $this->language->get('help_select_file');
		$this->data['help_preload'] = $this->language->get('help_preload');

		// Список доступных профайлов
		$this->data['input_profile_list'] = $this->model_price_import_setting->get_profiles($this->group);

		$this->data['input_add_profile'] = $this->language->get('input_add_profile');
		$this->data['input_edit'] = $this->language->get('input_edit');
		$this->data['input_delete'] = $this->language->get('input_delete');
		$this->data['input_preload'] = $this->language->get('input_preload');
		$this->data['input_manage_backup'] = $this->language->get('input_manage_backup');
		$this->data['input_update_image'] = $this->language->get('input_update_image');
		$this->data['input_truncate_products'] = $this->language->get('input_truncate_products');

		// Хлеб
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title_2'),
			'href'      => $this->url->link('module/price_import', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		// Статусное сообщение
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$this->data['error'] = '';
		}

		// Ссылки для кнопок и формы
		$this->data['action'] = $this->url->link('module/price_import', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['add_profile'] = $this->url->link('module/price_import/add_profile', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['remove_products'] = $this->url->link('module/price_import/delete_all_products', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['update_image'] = $this->url->link('module/price_import/update_image_products', 'token=' . $this->session->data['token'], 'SSL');


		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/price_import/index.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	// Добавление профайла (Настройки для прайс-листа)
	public function add_profile() {
		$this->language->load('module/price_import');

		$this->load->model('setting/setting');
		$this->load->model('price_import/setting');

		// Если форма отправлена
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			// Перевод символов названия профайла на латиницу, т.к.
			// оно будет использоваться в качестве ключа
			$this->load->helper('inflector');
			$profile_name_curr = 'profile_'.translit($this->request->post['profile_name']);
			$profile_name_curr = strtolower($profile_name_curr);
			$this->request->post['stock_status_id'] = $this->config->get('config_stock_status_id');
			/*Array
			(
				[profile_name] =>
				[currency] => 3
				[start_row] => 2
				[end_row] =>
				[discount] =>
				[margin] =>
				[sku] =>
				[sku_replace] =>
				[description] =>
				[description_default] =>
				[description_replace] =>
				[quantity] =>
				[quantity_default] =>
				[quantity_replace] =>
				[manufacture] =>
				[manufacture_default] =>
				[manufacture_replace] =>
				[price] =>
				[price_replace] =>
				[cache_method] => cache_in_memory
			)*/

			$this->model_price_import_setting->add_setting($this->group, $profile_name_curr, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_add_profile_success');

			// Редирект, если нет ошибок
			$this->redirect($this->url->link('module/price_import', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->load->model('localisation/currency'); // Валюты
		$this->load->model('catalog/manufacturer'); // Производители

		$this->document->setTitle($this->language->get('heading_title_2'));
		$this->document->addStyle('view/stylesheet/price_import.css');

		// Тэг H1
		$this->data['heading_title'] = $this->language->get('heading_title_2');

		$this->get_form();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_add_profile'),
			'href'      => $this->url->link('module/price_import/add_profile', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/price_import/form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	// Редактирование профайла
	public function edit_profile()
	{
		$this->language->load('module/price_import');

		$this->load->model('setting/setting');
		$this->load->model('price_import/setting');

		// Если форма отправлена
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->helper('inflector');
			$profile_name_curr = 'profile_'.translit($this->request->post['profile_name']);
			$profile_name_curr = strtolower($profile_name_curr);
			$this->request->post['stock_status_id'] = $this->config->get('config_stock_status_id');

			$this->model_price_import_setting->update_setting($this->group, $profile_name_curr, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_edit_profile_success');

			// Редирект, если нет ошибок
			$this->redirect($this->url->link('module/price_import', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->load->model('localisation/currency'); // Валюты
		$this->load->model('catalog/manufacturer'); // Производители

		$this->document->setTitle($this->language->get('heading_title_2'));
		$this->document->addStyle('view/stylesheet/price_import.css');

		// Тэг H1
		$this->data['heading_title'] = $this->language->get('heading_title_2');

		$this->get_form();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_edit_profile'),
			'href'      => $this->url->link('module/price_import/edit_profile', 'profile='.$this->request->get['profile'].'&token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		// Ссылки для кнопок и формы
		$this->data['action'] = $this->url->link('module/price_import/edit_profile', 'profile='.$this->request->get['profile'].'&token=' . $this->session->data['token'], 'SSL');

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/price_import/form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	// Удаление профайла
	public function delete_profile()
	{
		$this->load->model('setting/setting');
		$this->load->model('price_import/setting');

		$this->language->load('module/price_import');

		if (isset($this->request->get['profile'])) {
			$this->model_price_import_setting->delete_setting($this->group, $this->request->get['profile']);

			$this->session->data['success'] = $this->language->get('text_delete_profile_success');

			$this->redirect($this->url->link('module/price_import', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function uploaded_file()
	{
		$this->language->load('module/price_import');

		$this->load->model('setting/setting');
		$this->load->model('price_import/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_price_import_setting->insert_products();

			$this->session->data['success'] = 'Данные сохранены';

			$this->redirect($this->url->link('module/price_import', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->document->addStyle('view/stylesheet/price_import.css');
		$this->document->setTitle($this->language->get('heading_title_2'));

		// H1
		$this->data['heading_title'] = $this->language->get('heading_title_2');

		$this->data['input_save'] = $this->language->get('input_save');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_article'] = $this->language->get('text_article');
		$this->data['text_description'] = $this->language->get('text_description');
		$this->data['text_quantity'] = $this->language->get('text_quantity');
		$this->data['text_file_price'] = $this->language->get('text_file_price');
		$this->data['text_price_new'] = $this->language->get('text_price_new');
		$this->data['input_cancel_import'] = $this->language->get('input_cancel_import');
		$this->data['input_make_backup'] = $this->language->get('input_make_backup');
		$this->data['help_save'] = $this->language->get('help_save');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$pagination = new Pagination();
		$pagination->total = $this->model_price_import_setting->get_total_tmp_data();
		$pagination->page = $page;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/price_import/uploaded_file', 'token=' . $this->session->data['token'].'&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['result_data'] = $this->model_price_import_setting->get_tmp_data(($page - 1) * $pagination->limit, $pagination->limit);

		$this->data['help_price_new'] = $this->language->get('help_price_new');

		// Хлеб
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title_2'),
			'href'      => $this->url->link('module/price_import', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_uploaded_file'),
			'href'      => $this->url->link('module/price_import/uploaded_file', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		// Статусное сообщение
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$this->data['error'] = '';
		}

		if (isset($this->session->data['warning'])) {
			$this->data['warning'] = $this->session->data['warning'];

			unset($this->session->data['warning']);
		} else {
			$this->data['warning'] = '';
		}

		$this->data['action'] = $this->url->link('module/price_import/'.__METHOD__, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('module/price_import', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/price_import/uploaded_file.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());

	}

	public function delete_all_products()
	{
		$this->load->model('price_import/setting');

		$this->model_price_import_setting->truncate_products();

		$this->session->data['success'] = 'Товары удалены';

		$this->redirect($this->url->link('module/price_import/index', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function update_image_products()
	{
		$this->load->model('price_import/setting');

		$this->model_price_import_setting->update_image_products();

		$this->session->data['success'] = 'Изображения обновлены';

		$this->redirect($this->url->link('module/price_import/index', 'token=' . $this->session->data['token'], 'SSL'));
	}

	protected function validate() {
		// Права доступа
		if (!$this->user->hasPermission('modify', 'module/price_import')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// Имя профайла
		if ( ! $this->request->post['profile_name']) {
			$this->error['profile_name'] = $this->language->get('error_profile_name');
		}

		// Артикул
		if ($this->request->post['sku'] !== '') {
			if ( ! $this->is_digit($this->request->post['sku']))
				$this->error['sku'] = $this->language->get('error_is_not_digit');
		} else {
			$this->error['sku'] = $this->language->get('error_article');
		}

		// Начало чтения файла
		if ($this->request->post['start_row'] !== '') {
			if ( ! $this->is_digit($this->request->post['start_row']))
				$this->error['start_row'] = $this->language->get('error_is_not_digit');
		}

		// Конец чтения файла
		if ($this->request->post['end_row'] !== '') {
			if ( ! $this->is_digit($this->request->post['end_row']))
				$this->error['end_row'] = $this->language->get('error_is_not_digit');
		}

		// Описание товара
		if ($this->request->post['description'] !== '') {
			if ( ! $this->is_digit($this->request->post['description']))
				$this->error['description'] = $this->language->get('error_is_not_digit');

			if ($this->request->post['description_default'] !== '')
				$this->error['description'] = $this->language->get('error_both_fields');
		} else {
			if($this->request->post['description_default'] === '')
				$this->error['description'] = $this->language->get('error_description');
		}

		// Количество товара
		if ($this->request->post['quantity'] !== '') {
			if ( ! $this->is_digit($this->request->post['quantity']))
				$this->error['quantity'] = $this->language->get('error_is_not_digit');

			if ($this->request->post['quantity_default'] !== '')
				$this->error['quantity'] = $this->language->get('error_both_fields');
		} else {
			if ($this->request->post['quantity_default'] !== '') {
				if ( ! $this->is_digit($this->request->post['quantity_default']))
					$this->error['quantity'] = $this->language->get('error_is_not_digit');
			} else {
				$this->error['quantity'] = $this->language->get('error_quantity');
			}
		}

		// Производитель
		if ($this->request->post['manufacture'] !== '') {
			if ( ! $this->is_digit($this->request->post['manufacture']))
				$this->error['manufacture'] = $this->language->get('error_is_not_digit');

			if ($this->request->post['manufacture_default'] !== '')
				$this->error['manufacture'] = $this->language->get('error_both_fields');
		} else {
			if ($this->request->post['manufacture_default'] === '')
				$this->error['manufacture'] = $this->language->get('error_manufacturer');
		}

		// Цена
		if ($this->request->post['price'] !== '') {
			if ( ! $this->is_digit($this->request->post['price']))
				$this->error['price'] = $this->language->get('error_is_not_digit');
		} else {
			$this->error['price'] = $this->language->get('error_price');
		}

		// Скидка
		if ($this->request->post['discount'] !== '') {
			if (! $this->is_digit($this->request->post['discount']))
				$this->error['discount'] = $this->language->get('error_is_not_digit');
		}

		// Наценка
		if ($this->request->post['margin'] !== '') {
			if (! $this->is_digit($this->request->post['margin']))
				$this->error['margin'] = $this->language->get('error_is_not_digit');
		}


		if ( ! $this->error) {
			return true;
		} else {
			$this->session->data['error'] = $this->language->get('error_add_profile');

			return false;
		}
	}


	protected function filters(array $data)
	{
		if ($data['start_row'] !== '') {
			$data['start_row'] = (int) $data['start_row'] - 1;
		}

		if ($data['end_row'] !== '') {
			$data['end_row'] = (int) $data['end_row'] - 1;
		}

		if ($data['sku'] !== '') {
			$data['sku'] = (int) $data['sku'] - 1;
		}

		if ($data['description'] !== '') {
			$data['description'] = (int) $data['description'] - 1;
		}

		if ($data['quantity'] !== '') {
			$data['quantity'] = (int) $data['quantity'] - 1;
		}

		if ($data['manufacture'] !== '') {
			$data['manufacture'] = (int) $data['manufacture'] - 1;
		}

		if ($data['price'] !== '') {
			$data['price'] = (int) $data['price'] - 1;
		}

		if ($data['discount'] !== '') {
			if ( (int) $data['discount'] > 0) {
				$data['discount'] = (float) (1 - ((int) $data['discount'] / 100));
			} else {
				$data['discount'] = '';
			}
		}

		if ($data['margin'] !== '') {
			if ( (int) $data['margin'] > 0) {
				$data['margin'] = (float) (1 + ((int) $data['margin'] / 100));
			} else {
				$data['margin'] = '';
			}
		}

		return $data;
	}

	/**
	 * Проверяет, являются ли символы числовыми
	 * @param  integer $val
	 * @return boolean
	 */
	private function is_digit($val)
	{
		if ((is_int($val) AND $val >= 0) OR ctype_digit($val)) {
			return TRUE;
		}

		return FALSE;
	}

	private function get_form()
	{
		// Статусные сообщения
		if (isset($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$this->data['error'] = '';
		}

		$this->load->model('localisation/currency'); // Валюты
		$this->load->model('catalog/manufacturer'); // Производители
		$this->load->model('setting/store'); // витрины

		$this->document->setTitle($this->language->get('heading_title_2'));
		$this->document->addStyle('view/stylesheet/price_import.css');

		$this->data['text_base_setup'] = $this->language->get('text_base_setup');
		$this->data['text_profile_name'] = $this->language->get('text_profile_name');
		$this->data['text_currency_price'] = $this->language->get('text_currency_price');
		$this->data['text_start_row'] = $this->language->get('text_start_row');
		$this->data['text_end_row'] = $this->language->get('text_end_row');
		$this->data['text_discount'] = $this->language->get('text_discount');
		$this->data['text_margin'] = $this->language->get('text_margin');
		$this->data['text_setup_cell_th1'] = $this->language->get('text_setup_cell_th1');
		$this->data['text_setup_cell_th3'] = $this->language->get('text_setup_cell_th3');
		$this->data['text_setup_cell_th4'] = $this->language->get('text_setup_cell_th4');
		$this->data['text_article'] = $this->language->get('text_article');
		$this->data['text_description'] = $this->language->get('text_description');
		$this->data['text_or'] = $this->language->get('text_or');
		$this->data['text_quantity'] = $this->language->get('text_quantity');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_advance_setup'] = $this->language->get('text_advance_setup');
		$this->data['text_cell_caching'] = $this->language->get('text_cell_caching');
		$this->data['text_know_more'] = $this->language->get('text_know_more');
		$this->data['text_timeout_cache'] = $this->language->get('text_timeout_cache');
		$this->data['text_server'] = $this->language->get('text_server');
		$this->data['text_port'] = $this->language->get('text_port');
		$this->data['text_required'] = $this->language->get('text_required');
		$this->data['text_stores'] = $this->language->get('text_stores');

		$this->data['help_currency'] = $this->language->get('help_currency');
		$this->data['help_setup_cell_th1'] = $this->language->get('help_setup_cell_th1');
		$this->data['help_setup_cell_th4'] = $this->language->get('help_setup_cell_th4');
		$this->data['help_article'] = $this->language->get('help_article');
		$this->data['help_manufacturer'] = $this->language->get('help_manufacturer');
		$this->data['help_manufacturers'] = $this->language->get('help_manufacturers');
		$this->data['help_cell_caching'] = $this->language->get('help_cell_caching');
		$this->data['help_discount'] = $this->language->get('help_discount');

		$this->data['input_save'] = $this->language->get('input_save');
		$this->data['input_cancel'] = $this->language->get('input_cancel');

		// Получение значений по выбранному ключу
		if (isset($this->request->get['profile'])) {
			$config = unserialize($this->config->get($this->request->get['profile']));
		}

		// Список доступных валют
		/*
			Array
			(
			[UAH] => Array
				(
				[currency_id] => 4
				[title] => Гривны
				[code] => UAH
				[symbol_left] =>
				[symbol_right] =>  грн
				[decimal_place] =>
				[value] => 1.00000000
				[status] => 1
				[date_modified] => 2012-10-03 07:25:56
				)

			)
		 */
		$this->data['input_currencies'] = $this->model_localisation_currency->getCurrencies();

		// Методы кэширования ячеек excel-файла
		$this->data['input_cache_methods'] = $this->cache_methods;

		// Список доступных производителей
		/*
			Array
			(
			[0] => Array
				(
				[manufacturer_id] => 21
				[name] => BOGE
				[image] =>
				[sort_order] => 0
				)
			)
		 */
		$this->data['input_manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

		// Магазины
		$this->data['stores'] = $this->model_setting_store->getStores();
		array_unshift($this->data['stores'], array('store_id' => 0, 'name' => $this->language->get('text_store_default')));

		if (isset($this->request->post['profile_name'])) {
			$this->data['input_profile_name'] = $this->request->post['profile_name'];
		} elseif (isset($config['profile_name'])) {
			$this->data['input_profile_name'] = $config['profile_name'];
		} else {
			$this->data['input_profile_name'] = '';
		}

		if (isset($this->request->post['product_store'])) {
			$this->data['product_store'] = $this->request->post['product_store'];
		} elseif (isset($config['product_store'])) {
			$this->data['product_store'] = $config['product_store'];
		} else {
			$this->data['product_store'] = array();
		}

		if (isset($this->request->post['currency'])) {
			$this->data['input_currency'] = $this->request->post['currency'];
		} elseif (isset($config['currency'])) {
			$this->data['input_currency'] = $config['currency'];
		} else {
			$this->data['input_currency'] = '';
		}

		if (isset($this->request->post['start_row'])) {
			$this->data['input_start_row'] = $this->request->post['start_row'];
		} elseif (isset($config['start_row'])) {
			$this->data['input_start_row'] = $config['start_row'];
		} else {
			$this->data['input_start_row'] = 2;
		}

		if (isset($this->request->post['end_row'])) {
			$this->data['input_end_row'] = $this->request->post['end_row'];
		} elseif (isset($config['end_row'])) {
			$this->data['input_end_row'] = $config['end_row'];
		} else {
			$this->data['input_end_row'] = '';
		}

		if (isset($this->request->post['discount'])) {
			$this->data['input_discount'] = $this->request->post['discount'];
		} elseif (isset($config['discount'])) {
			$this->data['input_discount'] = $config['discount'];
		} else {
			$this->data['input_discount'] = '';
		}

		if (isset($this->request->post['margin'])) {
			$this->data['input_margin'] = $this->request->post['margin'];
		} elseif (isset($config['margin'])) {
			$this->data['input_margin'] = $config['margin'];
		} else {
			$this->data['input_margin'] = '';
		}

		if (isset($this->request->post['sku'])) {
			$this->data['input_sku'] = $this->request->post['sku'];
		} elseif (isset($config['sku'])) {
			$this->data['input_sku'] = $config['sku'];
		} else {
			$this->data['input_sku'] = '';
		}

		if (isset($this->request->post['sku_replace'])) {
			$this->data['input_sku_replace'] = $this->request->post['sku_replace'];
		} elseif (isset($config['sku_replace'])) {
			$this->data['input_sku_replace'] = $config['sku_replace'];
		} else {
			$this->data['input_sku_replace'] = '';
		}

		if (isset($this->request->post['description'])) {
			$this->data['input_description'] = $this->request->post['description'];
		} elseif (isset($config['description'])) {
			$this->data['input_description'] = $config['description'];
		} else {
			$this->data['input_description'] = '';
		}

		if (isset($this->request->post['description_default'])) {
			$this->data['input_description_default'] = $this->request->post['description_default'];
		} elseif (isset($config['description_default'])) {
			$this->data['input_description_default'] = $config['description_default'];
		} else {
			$this->data['input_description_default'] = '';
		}

		if (isset($this->request->post['description_replace'])) {
			$this->data['input_description_replace'] = $this->request->post['description_replace'];
		} elseif (isset($config['description_replace'])) {
			$this->data['input_description_replace'] = $config['description_replace'];
		} else {
			$this->data['input_description_replace'] = '';
		}

		if (isset($this->request->post['quantity'])) {
			$this->data['input_quantity'] = $this->request->post['quantity'];
		} elseif (isset($config['quantity'])) {
			$this->data['input_quantity'] = $config['quantity'];
		} else {
			$this->data['input_quantity'] = '';
		}

		if (isset($this->request->post['quantity_default'])) {
			$this->data['input_quantity_default'] = $this->request->post['quantity_default'];
		} elseif (isset($config['quantity_default'])) {
			$this->data['input_quantity_default'] = $config['quantity_default'];
		} else {
			$this->data['input_quantity_default'] = '';
		}

		if (isset($this->request->post['quantity_replace'])) {
			$this->data['input_quantity_replace'] = $this->request->post['quantity_replace'];
		} elseif (isset($config['quantity_replace'])) {
			$this->data['input_quantity_replace'] = $config['quantity_replace'];
		} else {
			$this->data['input_quantity_replace'] = '';
		}

		if (isset($this->request->post['manufacture'])) {
			$this->data['input_manufacture'] = $this->request->post['manufacture'];
		} elseif (isset($config['manufacture'])) {
			$this->data['input_manufacture'] = $config['manufacture'];
		} else {
			$this->data['input_manufacture'] = '';
		}

		if (isset($this->request->post['manufacture_default'])) {
			$this->data['input_manufacture_default'] = $this->request->post['manufacture_default'];
		} elseif (isset($config['manufacture_default'])) {
			$this->data['input_manufacture_default'] = $config['manufacture_default'];
		} else {
			$this->data['input_manufacture_default'] = '';
		}

		if (isset($this->request->post['manufacture_replace'])) {
			$this->data['input_manufacture_replace'] = $this->request->post['manufacture_replace'];
		} elseif (isset($config['manufacture_replace'])) {
			$this->data['input_manufacture_replace'] = $config['manufacture_replace'];
		} else {
			$this->data['input_manufacture_replace'] = '';
		}

		if (isset($this->request->post['price'])) {
			$this->data['input_price'] = $this->request->post['price'];
		} elseif (isset($config['price'])) {
			$this->data['input_price'] = $config['price'];
		} else {
			$this->data['input_price'] = '';
		}

		if (isset($this->request->post['price_replace'])) {
			$this->data['input_price_replace'] = $this->request->post['price_replace'];
		} elseif (isset($config['price_replace'])) {
			$this->data['input_price_replace'] = $config['price_replace'];
		} else {
			$this->data['input_price_replace'] = '';
		}

		if (isset($this->request->post['cache_method'])) {
			$this->data['input_cache_method'] = $this->request->post['cache_method'];
		} elseif (isset($config['cache_method'])) {
			$this->data['input_cache_method'] = $config['cache_method'];
		} else {
			$this->data['input_cache_method'] = '';
		}

		if (isset($this->request->post['apc_cache_time'])) {
			$this->data['input_apc_cache_time'] = $this->request->post['apc_cache_time'];
		} elseif (isset($config['apc_cache_time'])) {
			$this->data['input_apc_cache_time'] = $config['apc_cache_time'];
		} else {
			$this->data['input_apc_cache_time'] = 600;
		}

		if (isset($this->request->post['memcache_server'])) {
			$this->data['input_memcache_server'] = $this->request->post['memcache_server'];
		} elseif (isset($config['memcache_server'])) {
			$this->data['input_memcache_server'] = $config['memcache_server'];
		} else {
			$this->data['input_memcache_server'] = 'localhost';
		}

		if (isset($this->request->post['memcache_port'])) {
			$this->data['input_memcache_port'] = $this->request->post['memcache_port'];
		} elseif (isset($config['memcache_port'])) {
			$this->data['input_memcache_port'] = $config['memcache_port'];
		} else {
			$this->data['input_memcache_port'] = 11211;
		}

		if (isset($this->request->post['memcache_cache_time'])) {
			$this->data['input_memcache_cache_time'] = $this->request->post['memcache_cache_time'];
		} elseif (isset($config['memcache_cache_time'])) {
			$this->data['input_memcache_cache_time'] = $config['memcache_cache_time'];
		} else {
			$this->data['input_memcache_cache_time'] = 600;
		}

		if (isset($this->request->post['product_store'])) {
			$this->data['product_store'] = $this->request->post['product_store'];
		} elseif (isset($config['product_store'])) {
			$this->data['product_store'] = $config['product_store'];
		} else {
			$this->data['product_store'] = array(0);
		}


		// Вывод ошибок
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['profile_name'])) {
			$this->data['error_profile_name'] = $this->error['profile_name'];
		} else {
			$this->data['error_profile_name'] = '';
		}

		if (isset($this->error['start_row'])) {
			$this->data['error_start_row'] = $this->error['start_row'];
		} else {
			$this->data['error_start_row'] = '';
		}

		if (isset($this->error['end_row'])) {
			$this->data['error_end_row'] = $this->error['end_row'];
		} else {
			$this->data['error_end_row'] = '';
		}

		if (isset($this->error['sku'])) {
			$this->data['error_sku'] = $this->error['sku'];
		} else {
			$this->data['error_sku'] = '';
		}

		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = '';
		}

		if (isset($this->error['quantity'])) {
			$this->data['error_quantity'] = $this->error['quantity'];
		} else {
			$this->data['error_quantity'] = '';
		}

		if (isset($this->error['manufacture'])) {
			$this->data['error_manufacture'] = $this->error['manufacture'];
		} else {
			$this->data['error_manufacture'] = '';
		}

		if (isset($this->error['price'])) {
			$this->data['error_price'] = $this->error['price'];
		} else {
			$this->data['error_price'] = '';
		}

		if (isset($this->error['discount'])) {
			$this->data['error_discount'] = $this->error['discount'];
		} else {
			$this->data['error_discount'] = '';
		}

		if (isset($this->error['margin'])) {
			$this->data['error_margin'] = $this->error['margin'];
		} else {
			$this->data['error_margin'] = '';
		}

		// Хлебец
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title_2'),
			'href'      => $this->url->link('module/price_import', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		// Ссылки для кнопок и формы
		$this->data['action'] = $this->url->link('module/price_import/add_profile', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['not_save_profile'] = $this->url->link('module/price_import', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
	}

	/**
	 * Замена символов
	 * @example искомое_значение@значение_для_замены[|искомое_значение@значение_для_замены]
	 * :NOTE: если нужно заменить символы '@' или '|', то будет проблема. Пока решения нет
	 * @param  string $str
	 * @param  string $pattern
	 * @return string
	 */
	private function replace($str, $pattern)
	{
		if (empty($pattern))
			return $str;

		$needle = array();
		$replace = array();

		$pattern = explode('|', $pattern);

		foreach ($pattern as $v)
		{
			//if (substr_count($v, '@') > 0) {}

			list($needle[], $replace[]) = explode('@', $v);
		}

		$str = str_ireplace($needle, $replace, $str);

		return $str;
	}

	/**
	 * Uploader файлов
	 * @return string  полный путь до файла
	 * @return integer
	 */
	private function upload()
	{
		$this->load->helper('inflector');

		// Имя файла [в транслите]
		$filename = translit($_FILES['import']['name']);

		$directory = DIR_DOWNLOAD;

		// Проверка на соответствие типа
		if ($this->type($_FILES['import'])) {
		$fullpath = $this->save($_FILES['import'], $directory, $filename);

			if ($fullpath) {
				return $fullpath;
			} else {
				return 2;
			}
		} else {
			return 1;
		}
	}

	/**
	 * Валидация файла
	 * @param  array $file $_FILES
	 * @return bool
	 */
	private function type(array $file)
	{
//		if ($file['error'] !== UPLOAD_ERR_OK)
//			return TRUE;

		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

		return in_array($ext, $this->valid_types);
	}

	/**
	 * Сохранение файла
	 * @param   array   $file       uploaded file data
	 * @param   string  $filename   new filename
	 * @param   string  $directory  new directory
	 * @param   integer $chmod      chmod mask
	 * @return  string  on success, full path to new file
	 * @return  FALSE   on failure
	 */
	private function save(array $file, $directory, $filename = NULL, $chmod = 0644)
	{
		if ( ! isset($file['tmp_name']) OR ! is_uploaded_file($file['tmp_name'])) {
			// Ignore corrupted uploads
			return FALSE;
		}

		if ($filename === NULL) {
			// Use the default filename, with a timestamp pre-pended
			$filename = uniqid().$file['name'];
		}

		if ( ! is_dir($directory) OR ! is_writable(realpath($directory))) {
			trigger_error('Directory '.$directory.' must be writable');
		}

		// Make the filename into a complete path
		$filename = realpath($directory).DIRECTORY_SEPARATOR.$filename;

		if (move_uploaded_file($file['tmp_name'], $filename)) {
			if ($chmod !== FALSE) {
				// Set permissions on filename
				chmod($filename, $chmod);
			}

			// Return new file path
			return $filename;
		}

		return FALSE;
	}

	/**
	 * Чтение файла, сохранение результатов во временную таблицу и обработка
	 * данных
	 * @param string $filepath
	 * @param array  $config
	 */
	private function read_file($filepath)
	{
		ini_set('max_execution_time', 600);
//	    ini_set('memory_limit', 30);

		$this->load->model('price_import/setting');

		// Путь до PHPExcel
		$phpexcel_path = realpath(DIR_SYSTEM.implode(DIRECTORY_SEPARATOR, array(
			'..',
			'vendor',
			'PHPExcel',
			'PHPExcel.php'
		)));

		require $phpexcel_path;


		$cache_settings = array();
		$config = $this->filters($this->cache->get('current_profile'));

		if (strcasecmp($config['cache_method'], 'cache_to_apc') == 0) {
			$cache_settings['cacheTime'] = $config['apc_cache_time'];
		}

		if (strcasecmp($config['cache_method'], 'cache_to_memcache') == 0) {
			$cache_settings['memcacheServer'] = $config['memcache_server'];
			$cache_settings['memcachePort']   = $config['memcache_port'];
			$cache_settings['cacheTime']      = $config['memcache_cache_time'];
		}

		// Устанавливаем метод кэширования
		PHPExcel_Settings::setCacheStorageMethod($config['cache_method'], $cache_settings);

		// Определение типа формата
		$input_file_type = PHPExcel_IOFactory::identify($filepath);

		// Создание ридера на основе определенного типа
		$obj_reader = PHPExcel_IOFactory::createReader($input_file_type);

		unset($input_file_type, $cache_settings, $phpexcel_path);

		// Создание структуры временной таблицы
		$this->model_price_import_setting->create_tmp_table();

		// Только чтение
		$obj_reader->setReadDataOnly(TRUE);

		// Чтение только первого листа
		$obj_reader->setLoadSheetsOnly(0);

		// Load only the rows that match our filter
		$obj_PHP_excel = $obj_reader->load($filepath);

		// Do some processing here
		$sheet_data = $obj_PHP_excel->getActiveSheet()->toArray(NULL, FALSE, FALSE, FALSE);

		// Чтение со строки n
		$start_row = $config['start_row'];

		// Чтение до строки m
		$end_row = $config['end_row'];

		foreach ($sheet_data as $k=>$row)
		{
			// Диапазон чтения данных
			// Аналог фильтру chunkReadFilter() из документации
			if (is_int($start_row) AND $start_row > $k)
				continue;

			if (is_int($end_row) AND $end_row < $k)
				break;

			// Итерация будет продолжаться до тех пор, пока данные
			// в колонке с артикулом существуют
			// Аналог методу setIterateOnlyExistingCells();
			if (is_null($row[$config['sku']]))
				break;

			$data = array(
						'sku'          => $this->replace($row[$config['sku']], $config['sku_replace']),
						'manufacturer' => (
					$config['manufacture'] !== ''
					? $this->model_price_import_setting->find_manufacturer($this->replace($row[$config['manufacture']], $config['manufacture_replace']))
					: $config['manufacture_default']
				),
						'descr'        => (
					$config['description'] !== ''
					? $this->replace($row[$config['description']], $config['description_replace'])
					: $config['description_default']
				),
						'in_stock'     => (
					$config['quantity'] !== ''
					? $this->replace($row[$config['quantity']], $config['quantity_replace'])
					: $config['quantity_default']
				),
				'price'        => $this->replace($row[$config['price']], $config['price_replace']),
					);

			// Сохранение данных во временную таблицу
			$this->model_price_import_setting->fill_tmp_table($data);

			++$start_row;
		}

		// Выгрузка из памяти
		$obj_PHP_excel->disconnectWorksheets();
		unset($sheet_data, $obj_PHP_excel);

		// Расчет курса валюты, скидки и наценки
		$this->model_price_import_setting->update_price($config);
	}
}
?>