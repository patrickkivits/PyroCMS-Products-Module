<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Products Module
 *
 * @author 		Patrick Kivits - Woodits Webbureau
 * @website		http://woodits.nl
 * @package 	PyroCMS
 * @subpackage 	Products Module
 */
class Admin_specials extends Admin_Controller
{
	protected $section = 'specials';

	public function __construct()
	{
		parent::__construct();

		$this->load->model('specials_m');
		$this->load->library('form_validation');
		$this->lang->load('general');
		$this->lang->load('specials');
		$this->lang->load('products');
		
		$this->data->hours = array_combine($hours = range(0, 23), $hours);
		$this->data->minutes = array_combine($minutes = range(0, 59), $minutes);

		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('specials:name'),
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'start',
				'label' => lang('specials:start'),
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'end',
				'label' => lang('specials:end'),
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'old_price',
				'label' => lang('specials:old_price'),
				'rules' => 'trim'
			),
			array(
				'field' => 'new_price',
				'label' => lang('specials:new_price'),
				'rules' => 'trim'
			),
			array(
				'field' => 'description',
				'label' => lang('specials:description'),
				'rules' => 'trim'
			)
		);
	}

	public function index()
	{
		$items = $this->specials_m->get_all();

		$this->template
			->title($this->module_details['name'])
			->set('items', $items)
			->build('admin/specials/items');
	}

	public function create()
	{
		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run())
		{
			if($this->specials_m->create($this->input->post()))
			{
				$this->session->set_flashdata('success', lang('general:success'));
				redirect('admin/'.$this->module.'/specials');
			}
			else
			{
				$this->session->set_flashdata('error', lang('general:error'));
				redirect('admin/'.$this->module.'/specials/create');
			}
		}
		
		foreach ($this->item_validation_rules AS $rule)
		{
			$specials->{$rule['field']} = $this->input->post($rule['field']);
		}
		
		$products = $this->specials_m->get_products();

		$this->template
			->title($this->module_details['name'], lang('specials:create'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_js('module::jquery.cookie.js')
			->append_js('module::form.js')
			->append_js('module::specials.js')
			->set('products', $products)
			->set('specials', $specials)
			->build('admin/specials/form', $this->data);
	}
	
	public function ajax_add_product()
	{
		if($this->input->is_ajax_request()) {
			$this->specials_m->add_product($this->input->post());
		}
	}
	
	public function ajax_edit_product()
	{
		if($this->input->is_ajax_request()) {
			$this->specials_m->edit_product($this->input->post());
		}
	}
	
	public function ajax_delete_product()
	{
		if($this->input->is_ajax_request()) {
			$this->specials_m->delete_product($this->input->post());
		}
	}
	
	public function ajax_get_products()
	{
		if($this->input->is_ajax_request()) {
			$data['products'] = $this->specials_m->get_special_products($this->uri->segment(5));
			$this->load->view('admin/specials/ajax/products', $data);	
		}
	}
	
	public function ajax_get_special_product()
	{
		if($this->input->is_ajax_request()) {
			$this->data->products = $this->specials_m->get_special_product($this->input->get('id'));
			echo(json_encode($this->data->products));
		}
	}
	
	public function edit($id = 0)
	{
		$id = $this->uri->segment(5);
		$id or redirect('admin/'.$this->module);
		
		$specials = $this->specials_m->get($id);

		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run())
		{
			unset($_POST['btnAction']);
			
			if($this->specials_m->update($id, $this->input->post()))
			{
				$this->session->set_flashdata('success', lang('specials:success'));
				redirect('admin/'.$this->module.'/specials');
			}
			else
			{
				$this->session->set_flashdata('error', lang('specials:error'));
				redirect('admin/'.$this->module.'/specials/create');
			}
		}
		
		$specials->old_price = $this->input->post('old_price');
		$specials->new_price = $this->input->post('new_price');
		
		$products = $this->specials_m->get_products();
		
		$this->template->title($this->module_details['name'], lang('specials:edit'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_js('module::jquery.cookie.js')
			->append_js('module::form.js')
			->append_js('module::specials.js')
			->set('products', $products)
			->set('specials', $specials)
			->build('admin/specials/form', $this->data);
	}
	
	public function delete($id = 0)
	{
		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{
			$this->specials_m->delete_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			$this->specials_m->delete($id);
		}
		redirect('admin/'.$this->module.'/specials');
	}
}