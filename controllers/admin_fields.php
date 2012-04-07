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

		$this->load->model('fields_m');
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
			->append_metadata(js('jquery.min.js', $this->module))
			->append_metadata(js('jquery.ui.js', $this->module))
			->append_metadata(js('admin.js', $this->module))
			->append_metadata(css('admin.css', $this->module));
	}

	public function index()
	{
		$items = $this->fields_m->get_all();

		$this->data->items =& $items;
		$this->template->title($this->module_details['name'])
			->build('admin/fields/items', $this->data);
	}

	public function create()
	{
		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run())
		{
			if($this->fields_m->create($this->input->post()))
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
		
		$this->data->fields =& $fields;

		$this->template->title($this->module_details['name'], lang('fields:create'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_metadata( js('form.js', $this->module) )
			->build('admin/fields/form', $this->data);
	}
	
	public function edit($id = 0)
	{
		$id = $this->uri->segment(5);
		$fields = $this->fields_m->get($id);
		
		if ( ! $fields)
		{
			$this->session->set_flashdata('error', lang('pages_page_not_found_error'));
			redirect('admin/'.$this->module.'/fields/create');
		}

		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run())
		{
			unset($_POST['btnAction']);
			
			if($this->fields_m->update($id, $this->input->post()))
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
		
		$this->data->fields =& $fields;
		
		$this->template->title($this->module_details['name'], lang('fields:edit'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_metadata( js('form.js', $this->module) )
			->build('admin/fields/form', $this->data);
	}
	
	public function delete($id = 0)
	{
		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{
			$this->fields_m->delete_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			$this->fields_m->delete($id);
		}
		redirect('admin/'.$this->module.'/fields');
	}
	
	public function order()
	{
		$this->fields_m->order($this->input->post('order'));
	}
}