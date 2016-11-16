<?php
// Данная модель (аналог model/setting/setting.php) отвечает за манипулирование
// данными из таблицы OC_setting
class ModelPriceImportSetting extends Model {

    // Название временной таблицы
    private $tmp_tbl_name = 'tmp_table_price';

    // Кэширование ID производителей
    private $manufacture_id_cache = array();

    /**
     * Добавление нового профайла
     * @param string $group   имя группы
     * @param string $profile имя профайла (ключ)
     * @param array  $post    данные из формы
     */
    public function add_setting($group, $profile, $post)
    {
		$data = $this->model_setting_setting->getSetting($group);
		$data += array($profile => serialize($post));
		$this->model_setting_setting->editSetting($group, $data);
    }


    /*
     * Можно было бы использовать этот код:
     * $this->model_setting_setting->editSettingValue($group, $profile, $post);
     * но в данном методе есть ошибки, которые описаны:
     * http://forum.opencart.com/viewtopic.php?f=161&t=99563
     */
    public function update_setting($group, $profile, $post)
    {
		$data = $this->model_setting_setting->getSetting($group);
		$data[$profile] = serialize($post);
		$this->model_setting_setting->editSetting($group, $data);
	}

	public function delete_setting($group, $profile)
	{
		$data = $this->model_setting_setting->getSetting($group);
		unset($data[$profile]);
		$this->model_setting_setting->editSetting($group, $data);
    }

    /**
     * Получение доступных профайлов
     * @param  string $group имя группы
     * @return array  имя_профайла => array(значения_полей)
     */
    public function get_profiles($group)
    {
		$settings = $this->model_setting_setting->getSetting($group);

		$data = array();

		foreach ($settings as $k => $v)
		{
			$v = unserialize($v);

			$data[$k] = $v['profile_name'];
		}

		return $data;
    }

    /*
     * Создание временной таблиц, куда будут заноситься данные из excel-файла
     */
    public function create_tmp_table()
    {
		$this->db->query('DROP TABLE IF EXISTS '.$this->tmp_tbl_name);
			$this->db->query('CREATE TABLE '.$this->tmp_tbl_name.' (
			id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			manufacturer int(10) NOT NULL,
			sku varchar(32) NOT NULL,
			descr tinytext DEFAULT NULL,
			in_stock tinytext NOT NULL,
			price float(8, 2) UNSIGNED DEFAULT NULL,
			price_new float(8, 2) UNSIGNED NOT NULL DEFAULT "0.00",
			PRIMARY KEY (id)
			  )
			  ENGINE = INNODB
			  AUTO_INCREMENT = 1
			  CHARACTER SET utf8
			  COLLATE utf8_general_ci');
    }

    /**
     * Наполнение вр. таблицы
     * @param array $data
     */
    public function fill_tmp_table(array $data)
    {
		$this->db->query(sprintf('INSERT INTO %s SET `manufacturer`=%d, `sku`="%s", `descr`="%s", `in_stock`=%d, `price`=%f, `price_new`=`price`',
			$this->tmp_tbl_name,
			$this->db->escape($data['manufacturer']),
			$this->db->escape($data['sku']),
			$this->db->escape($data['descr']),
			$this->db->escape($data['in_stock']),
			$this->db->escape($data['price'])
		));
    }

    /**
     * Добавляет новый бренд, если он раннее не был определен
     * @param  integer $manufacturer
     * @param  string  $manufacturer
     * @return integer
     */
    public function find_manufacturer($manufacturer)
    {
		if (is_string($manufacturer)) {
			// Все бренды в верхнем регистре
			$manufacturer = strtoupper($manufacturer);

			// Если метод "участвует" в итерации, то возвращаем раннее полученное
			// значение, если оно есть
			if (isset($this->manufacture_id_cache[$manufacturer]))
				return $this->manufacture_id_cache[$manufacturer];

			// Модель по управлению производителями
			$this->load->model('catalog/manufacturer');

			// Если такого бренда нет, но он есть в таблице производителей -
			// сохраняем его в кэш и возвращаем результат
			if ( ! is_null($manufacturer_id = $this->get_manufacturers($manufacturer))) {
				$this->manufacture_id_cache[$manufacturer] = $manufacturer_id;

				return $manufacturer_id;
			}

			$this->load->helper('inflector');

			$config = $this->cache->get('current_profile');
			$stores = $config['product_store'];

			if (empty($stores)) {
				$stores = array(0);
			}

			// Если это новый бренд - заносим его в таблицу oc_manufacturer
			$this->model_catalog_manufacturer->addManufacturer(array(
				'name'               => $manufacturer,
				'sort_order'         => 0,
				// На всякий случай переводим всё в латиницу, заменяем пробелы
				// на знак '_'
				'keyword'            => strtolower(translit($manufacturer)),
				// :TODO: добавить выборку всех магазинов
				'manufacturer_store' => $stores, // узнать больше:
				// \admin\controller\catalog\manufacturer.php:350
			));

			// Так как метод addManufacturer не возвращает присвоенный id, то
			// воспользуемся данным методом:
			$manufacturer_id = $this->get_manufacturers($manufacturer);

			$this->manufacture_id_cache[$manufacturer] = $manufacturer_id;

			return $manufacturer_id;
		}

		return $manufacturer;
    }

    /**
     * Получение всех данных подгруженного прайса
     * @param integer $limit
     * @param integer $offset
     * @return array
     */
    public function get_tmp_data($start, $limit)
    {
		return $query = $this->db->query(sprintf('
			SELECT
			t2.`name` AS `manufacturer`,
			t1.`sku`,
			t1.`descr`,
			t1.`in_stock`,
			t1.`price`,
			t1.`price_new`
			FROM
			%s AS t1
			INNER JOIN
			%s AS t2
			ON t1.manufacturer=t2.manufacturer_id
			LIMIT %d, %d
			', $this->tmp_tbl_name, DB_PREFIX.'manufacturer', $start, $limit));
    }

    public function get_total_tmp_data()
    {
      	$query = $this->db->query('SELECT COUNT(*) AS total FROM '.$this->tmp_tbl_name);

		return $query->row['total'];
    }

    /**
     * Установление цены с учетом валюты, скидки и наценки
     * Сначала обновляется:
     * 1. Расчет относительно курса
     * 2. Расчет скидки
     * 3. Расчет наценки
     * Каждый шаг округляется в бОльшую сторону
     * @param array $config
     */
    public function update_price(array $config)
    {
		$this->load->model('localisation/currency'); // Валюты

		$res = $this->model_localisation_currency->getCurrency($config['currency']);

		$this->db->query(sprintf('UPDATE %s SET `price_new`=CEILING(`price`*%f)', $this->tmp_tbl_name, $res['value']));

		if ($config['discount'] !== '') {
			$this->db->query(sprintf('UPDATE %s SET `price_new`=CEILING(`price_new`*%f)', $this->tmp_tbl_name, $config['discount']));
		}

		if ($config['margin'] !== '') {
			$this->db->query(sprintf('UPDATE %s SET `price_new`=CEILING(`price_new`*%f)', $this->tmp_tbl_name, $config['margin']));
		}
    }

    public function insert_products()
    {
		// Если в таблице product у колонки sku отсутствует индекс - добавляем
		$this->check_index('product', 'sku', 1);

		// Первое. Обновляем существующие товарные позиции
		// Обновляем только наличие и цену
		$this->db->query('UPDATE '.DB_PREFIX.'product AS p SET p.`quantity`=0');

		$this->db->query('
			UPDATE '.DB_PREFIX.'product AS t1, '.$this->tmp_tbl_name.' AS t2
			SET t1.`price` = t2.price_new,
			t1.`quantity` = t2.in_stock,
			t1.`date_modified` = NOW(),
			t1.`status` = 1
			WHERE t1.sku = t2.sku AND t1.manufacturer_id = t2.manufacturer;
		');

		// Второе. Если во временной таблице есть позиции, которых нет в основной
		// добавляем их.
		$this->db->query('
			INSERT INTO '.DB_PREFIX.'product (`model`, `sku`, `upc`, `ean`, `jan`, `isbn`, `mpn`, `location`, `quantity`, `stock_status_id`, `image`, `manufacturer_id`, `shipping`, `price`, `tax_class_id`, `date_available`, `status`, `date_added`)
			SELECT `sku`, `sku`, "", "", "", "", "", "", `in_stock`, '.(int)$this->config->get('config_stock_status_id').', "no_image.jpg", `manufacturer`, 1, `price_new`, 0, NOW(), 1, NOW() FROM
			(SELECT
			  t1.`sku`, t1.`in_stock`, t1.`manufacturer`, t1.`price_new`
			FROM '.$this->tmp_tbl_name.' AS t1
			  LEFT JOIN '.DB_PREFIX.'product AS t2
				ON t1.sku = t2.sku AND t1.manufacturer = t2.manufacturer_id
			WHERE t2.sku IS NULL) AS subtable
		');

		// Третье. Если во временной таблице есть позиции, которых нет в основной
		// добавляем описание к ним
		$languages = $this->cache->get('language');

		if (empty($languages)) {
			$this->load->model('localisation/language');
			$languages = $this->model_localisation_language->getLanguages();
		}

		foreach ($languages as $language)
		{
			$this->db->query('
				INSERT IGNORE INTO '.DB_PREFIX.'product_description (`product_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`, `tag`) SELECT * FROM (
				SELECT
				  t1.product_id,
				  '. (int) $language['language_id'].',
				  CONCAT(t4.`name`, " ", t1.sku) AS `name`,
				  t3.descr AS description,
				  t3.descr AS meta_description,
				  "" AS meta_keyword,
				  t1.sku AS tag
				FROM '.DB_PREFIX.'product AS t1
				  LEFT JOIN '.DB_PREFIX.'product_description AS t2
					ON t2.product_id = t1.product_id
				  INNER JOIN '.$this->tmp_tbl_name.' AS t3
					ON t3.sku = t1.sku AND t3.manufacturer = t1.manufacturer_id
				  INNER JOIN '.DB_PREFIX.'manufacturer AS t4 ON t4.manufacturer_id=t1.manufacturer_id
				WHERE t2.product_id IS NULL OR t2.language_id <> '. (int) $language['language_id'].'
				  ) AS subtable
			');
		}

//		$this->db->query('TRUNCATE TABLE '.DB_PREFIX.'product_to_store');

		$config = $this->cache->get('current_profile');
		$stores = $config['product_store'];

		if (empty($stores)) {
			$stores = array(0);
		}

		foreach ($stores as $store)
		{
			$this->db->query('INSERT IGNORE INTO '.DB_PREFIX.'product_to_store SELECT product_id, '.$store.' FROM oc_product');
		}

		// SEO url
		$this->db->query('DELETE FROM '.DB_PREFIX.'url_alias WHERE `query` LIKE "product_id%"');
		$this->db->query('
			INSERT INTO '.DB_PREFIX.'url_alias (`query`, `keyword`)
			SELECT
			  CONCAT("product_id=", t1.product_id) AS `query`,
			  LOWER(CONCAT(t2.`name`, "_", t1.sku)) AS `keyword`
			FROM '.DB_PREFIX.'product AS t1
			  INNER JOIN '.DB_PREFIX.'manufacturer AS t2 USING (manufacturer_id)
		');

		$this->cache->delete('product');
    }

    public function update_image_products()
    {
		$this->db->query('
			UPDATE '.DB_PREFIX.'product AS t1, (
			SELECT
			'.DB_PREFIX.'product.product_id
			   , tof_graphics.name_c
			FROM
			  tof_article
			INNER JOIN tof_graphics
			ON tof_article.art_id = tof_graphics.art_id
			INNER JOIN '.DB_PREFIX.'product
			ON tof_article.article_nr = '.DB_PREFIX.'product.sku
			) AS t2 SET t1.image = CONCAT("data/products/", t2.name_c) WHERE t1.product_id=t2.product_id
		');
    }

    /**
     * Проверка существование индекса у колонки
     * @param  string  $table  имя таблицы без префикса
     * @param  mixed  $column  имя колонки, у которой надо проверить индекс
     * @param  boolean $action 1 - добавить индекс, 2 - удалить, NULL - ничего не делать
     */
    public function check_index($table, $column, $action = NULL, $type = 'INDEX')
    {
		$is_index = FALSE;

		if (is_array($column)) {
			$column = implode(', ', $column);
		}

		// Определение существования индекса
		$res = $this->db->query('SHOW INDEX FROM '.DB_PREFIX.$table);

		if ($res->num_rows) {
			foreach ($res->rows as $row)
			{
				if(strcasecmp($row['Column_name'], $column) == 0) {
					$is_index = TRUE;
				}
			}
		}

		switch ($action)
		{
			case 1: if ( ! $is_index) $this->db->query('ALTER IGNORE TABLE '.DB_PREFIX.$table.' ADD '.$type.' ('.$column.')');
			break;
			case 2: if ($is_index) $this->db->query('ALTER TABLE '.DB_PREFIX.$table.' DROP '.$type.' ('.$column.')');
			break;
		}
    }

    public function truncate_products()
    {
		$this->db->query('DELETE FROM '.DB_PREFIX.'url_alias WHERE `query` LIKE "product_id%"');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_attribute');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_description');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_discount');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_filter');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_image');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_option');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_option_value');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_related');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_reward');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_special');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_to_category');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_to_download');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_to_layout');
		$this->db->query('TRUNCATE '.DB_PREFIX.'product_to_store');
		if (substr(VERSION, 5) == '1.5.6')
		{
			// ошибка в 1.5.5.1 и ниже
			$this->db->query('TRUNCATE '.DB_PREFIX.'product_profile');
		}
		$this->db->query('TRUNCATE '.DB_PREFIX.'review');

		$this->cache->delete('product');
    }

    /**
     * Получение списка производителей
     * @param  string  $name manufacturer
     * @return integer manufacturer_id
     * @return null
     */
    private function get_manufacturers($name)
    {
		// возвращает многоменрынй массив
		$results = $this->model_catalog_manufacturer->getManufacturers(array(
			'filter_name' => $name,
		));

		if ( ! empty($results))
			return $results[0]['manufacturer_id'];

		return NULL;
    }
}
?>
