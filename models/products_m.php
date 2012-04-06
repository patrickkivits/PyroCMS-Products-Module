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

		return $this->db->insert($this->_table, $to_insert);
	}

	//make sure the slug is valid
	public function _check_slug($slug)
	{
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', url_title($slug, 'dash', TRUE));

		return $slug;
	}
	
	public function get_categories()
	{
		return $this->db->get('categories')->result();
	}	
	
}