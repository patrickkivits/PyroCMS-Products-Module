<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Products Module
 *
 * @author 		Patrick Kivits - Woodits Webbureau
 * @website		http://woodits.nl
 * @package 	PyroCMS
 * @subpackage 	Products Module
 */
class Admin_fields extends Admin_Controller
{
	protected $section = 'fields';

	public function __construct()
	{
		parent::__construct();

		$this->load->model('custom_fields_m');
		$this->load->library('form_validation');
		$this->lang->load('general');
		$this->lang->load('fields');

		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('categories:name'),
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'type',
				'label' => lang('categories:type'),
				'rules' => 'trim|max_length[100]|required'
			)
		);

		$this->template
			->append_js('module::jquery.min.js')
			->append_js('module::jquery.ui.js')
			->append_js('module::jquery.cookie.js')
			->append_js('module::admin.js')
			->append_css('module::admin.css');
	}

	public function index()
	{
		$items = $this->custom_fields_m->get_all();

		$this->template
			->title($this->module_details['name'])
			->set('items', $items)
			->build('admin/fields/items');
	}

	public function create()
	{
		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run())
		{
			if($this->custom_fields_m->create($this->input->post()))
			{
				$this->session->set_flashdata('success', lang('general:success'));
				redirect('admin/'.$this->module.'/fields');
			}
			else
			{
				$this->session->set_flashdata('error', lang('general:error'));
				redirect('admin/'.$this->module.'/fields/create');
			}
		}
		
		foreach ($this->item_validation_rules AS $rule)
		{
			$fields->{$rule['field']} = $this->input->post($rule['field']);
		}

		$this->template
			->title($this->module_details['name'], lang('fields:create'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->set('fields', $fields)
			->build('admin/fields/form');
	}
	
	public function edit($id = 0)
	{
		$id = $this->uri->segment(5);
		$id or redirect('admin/'.$this->module);
		
		$fields = $this->custom_fields_m->get($id);

		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run())
		{
			unset($_POST['btnAction']);
			
			if($this->custom_fields_m->update($id, $this->input->post()))
			{
				$this->session->set_flashdata('success', lang('general:success'));
				redirect('admin/'.$this->module.'/fields');
			}
			else
			{
				$this->session->set_flashdata('error', lang('general:error'));
				redirect('admin/'.$this->module.'/fields/create');
			}
		}
		
		$this->template
			->title($this->module_details['name'], lang('fields:edit'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->set('fields', $fields)
			->build('admin/fields/form');
	}
	
	public function delete($id = 0)
	{
		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{
			$this->custom_fields_m->delete_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			$this->custom_fields_m->delete($id);
		}
		redirect('admin/'.$this->module.'/fields');
	}
	
	public function order()
	{
		if($this->input->is_ajax_request()) {
			$this->custom_fields_m->order($this->input->post('order'));
		}
	}
}