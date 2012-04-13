<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Products Module
 *
 * @author 		Patrick Kivits - Woodits Webbureau
 * @website		http://woodits.nl
 * @package 	PyroCMS
 * @subpackage 	Products Module
 */
class Custom_fields_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->_table = 'fields';
	}
	
	public function get_all()
	{
		$this->db->from($this->_table)
			->order_by('order', 'asc');
		
		$query = $this->db->get();
		return $query->result();	
	}
	
	//create a new item
	public function create($input)
	{
		$to_insert = array(
			'name' => $input['name'],
			'slug' => $this->_check_slug($input['name']),
			'type' => $input['type'],
			'order' => $this->get_order()
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
	
	public function delete($id)
	{
		$this->db
			->where('field', $id)
			->delete('products_x_fields');
		
		return $this->db->where($this->primary_key, $id)
			->delete($this->_table);
	}
	
	public function get_order()
	{
		$this->db
			->from($this->_table)	
			->order_by('order', 'desc')
			->limit(1);
			
		$query = $this->db->get();
		$result = $query->result();
		
		if(isset($result[0])) {
			return ($result[0]->order + 1);
		} else {
			return 0;	
		}
	}
	
	public function order($order)
	{
		foreach($order as $order => $id)
		{
			$this->db->where('id', $id);
			$this->db->update($this->_table, array('order' => $order));
		}
		return true;	
	}
	
}