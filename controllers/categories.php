<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Products Module
 *
 * @author 		Patrick Kivits - Woodits Webbureau
 * @website		http://woodits.nl
 * @package 	PyroCMS
 * @subpackage 	Products Module
 */
class Categories extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('categories_m');
		$this->lang->load('categories');
	}

	public function index($offset = 0)
	{
		$limit = 5;
		
		$data->items = $this->categories_m->limit($limit)
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
		$data->pagination = create_pagination('categories/index', $this->categories_m->count_all(), $limit, 3);

		$this->template->title($this->module_details['name'], lang('categories:label'))
			->build('categories', $data);
	}
	
}