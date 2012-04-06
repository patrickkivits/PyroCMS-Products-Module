<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Specials Module
 *
 * @author 		Patrick Kivits - Woodits Webbureau
 * @website		http://woodits.nl
 * @package 	PyroCMS
 * @subpackage 	Specials Module
 */
class Products_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->_table = 'products';
	}
	
	public function get_all()
	{
		$this->db
			->select('p.*, c.name as category_name')
			->from('products as p')
			->join('categories as c', 'c.id = p.category', 'left')
			->order_by('category_name', 'asc')
			->order_by('name', 'asc');
		
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get($id)
	{
		$this->db
			->from('products')
			->where('id', $id);
			
		$query = $this->db->get();
		$product = $query->row();
	
		$this->db
			->from('products_x_fields as x')
			->join('fields as f', 'f.id = x.field', 'left')
			->where('x.product', $product->id);
			
		$query = $this->db->get();
		$fields = $query->result();
		
		foreach($fields as $field) {
			// Put the custom fields in there own array
			$custom_field[$field->field] = $field->value;
			
			// And also in the main array for easy refference
			if(!isset($product->{$field->slug})) {
				// Only if the array not already contains the key
				$product->{$field->slug} = $field->value;
			}
		}
		if(isset($custom_field)) {
			$product->custom_fields = $custom_field;
		}
	
		return $product;
	}
	
	public function get_by_category($category)
	{
		$this->db
			->select('p.*, c.name as category_name')
			->from('products as p')
			->join('categories as c', 'c.id = p.category', 'left')
			->where('p.category', $category)
			->order_by('category_name', 'asc')
			->order_by('name', 'asc');
		
		$query = $this->db->get();
		return $query->result();
	}
	
	//create a new item
	public function create($input)
	{	
		$to_insert = array(
			'name' => $input['name'],
			'slug' => $this->_check_slug($input['name']),
			'category' => $input['category'],
			'thumbnail' => $input['thumbnail'],
			'image' => $input['image'],
			'description' => $input['description']
		);
		
		$this->db->insert($this->_table, $to_insert);
		
		if($input['custom_field']) {
			
			$product = $this->db->insert_id();
			foreach($input['custom_field'] as $field => $value) {
				$to_insert = array(
					'product' => $product,
					'field' => $field,
					'value' => $value
				);
				
				$this->db->insert('products_x_fields', $to_insert);
			}
		}
		return true;
	}

	//make sure the slug is valid
	public function _check_slug($slug)
	{
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', url_title($slug, 'dash', TRUE));

		return $slug;
	}
	
	//create a new item
	public function update($id, $input)
	{	
		$to_insert = array(
			'name' => $input['name'],
			'slug' => $this->_check_slug($input['name']),
			'category' => $input['category'],
			'thumbnail' => $input['thumbnail'],
			'image' => $input['image'],
			'description' => $input['description']
		);
		
		$this->db->where('id', $id);
		$this->db->update($this->_table, $to_insert);
		
		if($input['custom_field']) {
	
			foreach($input['custom_field'] as $field => $value) {
				$to_insert = array(
					'product' => $id,
					'field' => $field,
					'value' => $value
				);
				
				$this->db->where('product', $id);
				$this->db->insert('products_x_fields', $to_insert);
			}
		}
		return true;
	}
	
	public function get_categories()
	{
		return $this->db->get('categories')->result();
	}	
	
}