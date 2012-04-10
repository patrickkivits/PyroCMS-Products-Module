<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Products Module
 *
 * @author 		Patrick Kivits - Woodits Webbureau
 * @website		http://woodits.nl
 * @package 	PyroCMS
 * @subpackage 	Products Module
 */
class Products extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('products_m');
		$this->load->model('fields_m');
		$this->lang->load('general');
		$this->lang->load('products');
	}

	public function index($offset = 0)
	{
		$limit = 5;
		
		$data->items = $this->products_m->limit($limit)
			->offset($offset)
			->get_all();
			
		if (count($data->items))
		{
			$data->items_exist = TRUE;
		}
		else
		{
			$data->items_exist = FALSE;
		}

		// Params: (module/method, total count, limit, uri segment)
		$data->pagination = create_pagination('products/index', $this->products_m->count_all(), $limit, 3);

		$this->template->title($this->module_details['name'], lang('products:label'))
			->build('index', $data);
	}
	
	public function product()
	{
		$data->items = $this->products_m->get($this->uri->segment(3));
			
		if (count($data->items))
		{
			$data->items_exist = TRUE;
		}
		else
		{
			$data->items_exist = FALSE;
		}
		
//		echo "<pre>";
//		print_r($data);
//		die();

		$data->fields = $this->fields_m->get_all();

		$this->template->title($this->module_details['name'], '')
			->build('product', $data);
	}
	
	public function category()
	{		
		$data->items = $this->products_m->get_by_category($this->uri->segment(3));
			
		if (count($data->items))
		{
			$data->items_exist = TRUE;
		}
		else
		{
			$data->items_exist = FALSE;
		}

		$this->template->title($this->module_details['name'], lang('products:category'))
			->build('category', $data);
	}
}