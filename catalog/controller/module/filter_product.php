<?php  
/* 
Version: 1.0
Author: Artur Sułkowski
Website: http://artursulkowski.pl
*/

class ControllerModuleFilterProduct extends Controller {
	protected function index($setting) {
		$lang_id = $this->config->get('config_language_id');
		
		$this->load->model('catalog/product'); 
		$this->load->model('tool/image');
		
		$this->language->load('module/featured'); 
		$this->data['button_cart'] = $this->language->get('button_cart');
		
		$this->data['itemsperpage'] = $setting['itemsperpage'];
		$this->data['cols'] = $setting['cols'];
		$this->data['carousel'] = $setting['carousel'];
		
		if(empty($setting['limit'])) {
			$setting['limit'] = 4;
		}
		
		if(empty($setting['itemsperpage'])) {
			$this->data['itemsperpage'] = 4;
		}
		
		if(empty($setting['cols'])) {
			$this->data['cols'] = 1;
		}
		
		$this->data['tabs'] = array();
		if(is_array($setting['tabs'])) {
			$tabs = $setting['tabs'];
			foreach($tabs as $tab) {
				$products = array();
				
				// Najnowsze produkty, Specjalne produkty, Najlepiej sprzedajace się produkty, Wybrane produkty z kategorii
				if($tab['title'] == 'latest' || $tab['title'] == 'special' || $tab['title'] == 'bestsellers' || $tab['title'] == 'category') {
					if($tab['title'] == 'latest') {
						$data = array(
							'sort'  => 'p.date_added',
							'order' => 'DESC',
							'start' => 0,
							'limit' => $setting['limit']
						);
			
						$results = $this->model_catalog_product->getProducts($data);
					} elseif($tab['title'] == 'special') {
						$data = array(
							'sort'  => 'pd.name',
							'order' => 'ASC',
							'start' => 0,
							'limit' => $setting['limit']
						);
				
						$results = $this->model_catalog_product->getProductSpecials($data);
					} elseif($tab['title'] == 'bestsellers') {
						$results = $this->model_catalog_product->getBestSellerProducts($setting['limit']);
					} elseif($tab['title'] == 'category') {
						$select_categories = explode(',', $tab['categories']);	
						$results = array();
						foreach($select_categories as $category) {
							$data = array(
								'filter_category_id' => $category,
								'start'              => 0,
								'sort'               => 'p.date_added',
								'order'              => 'DESC',
								'limit'              => $setting['limit']
							);
							$results = array_merge($results, $this->model_catalog_product->getProducts($data));
						}
						$results = array_slice($results, 0, (int)$setting['limit']);	
					}
			
					foreach ($results as $result) {
						if ($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
						} else {
							$image = false;
						}
									
						if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
							$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
						} else {
							$price = false;
						}
								
						if ((float)$result['special']) {
							$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
						} else {
							$special = false;
						}
						
						if ($this->config->get('config_review_status')) {
							$rating = $result['rating'];
						} else {
							$rating = false;
						}
						
						$products[] = array(
							'product_id' => $result['product_id'],
							'thumb'   	 => $image,
							'name'    	 => $result['name'],
							'price'   	 => $price,
							'special' 	 => $special,
							'rating'     => $rating,
							'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
							'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
						);
					}
				}
				
				// Wybrane produkty
				if($tab['title'] == 'products') {
					$select_products = explode(',', $tab['products']);	
					$select_products = array_slice($select_products, 0, (int)$setting['limit']);	
					
					foreach ($select_products as $product_id) {
						$product_info = $this->model_catalog_product->getProduct($product_id);
						
						if ($product_info) {
							if ($product_info['image']) {
								$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
							} else {
								$image = false;
							}
			
							if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
								$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
							} else {
								$price = false;
							}
									
							if ((float)$product_info['special']) {
								$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
							} else {
								$special = false;
							}
							
							if ($this->config->get('config_review_status')) {
								$rating = $product_info['rating'];
							} else {
								$rating = false;
							}
								
							$products[] = array(
								'product_id' => $product_info['product_id'],
								'thumb'   	 => $image,
								'name'    	 => $product_info['name'],
								'price'   	 => $price,
								'special' 	 => $special,
								'rating'     => $rating,
								'reviews'    => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
								'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
							);
						}
					}
				}

				$heading = 'No name';
				if(isset($tab['heading'][$lang_id])) { $heading = html_entity_decode($tab['heading'][$lang_id], ENT_QUOTES, 'UTF-8'); }
				
				$this->data['tabs'][] = array(
					'heading' => $heading,
					'title' => $tab['title'],
					'products' => $products
				);
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/filter_product.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/filter_product.tpl';
		} else {
			$this->template = 'default/template/module/filter_product.tpl';
		}
		
		$this->render();
	}
}
?>