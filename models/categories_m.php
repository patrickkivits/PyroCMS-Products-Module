<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Specials Module
 *
 * @author 		Patrick Kivits - Woodits Webbureau
 * @website		http://woodits.nl
 * @package 	PyroCMS
 * @subpackage 	Specials Module
 */
class Categories_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->_table = 'categories';
	}
	
	//create a new item
	public function create($input)
	{
		$to_insert = array(
			'name' => $input['name'],
			'slug' => $this->_check_slug($input['name']),
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
	
}