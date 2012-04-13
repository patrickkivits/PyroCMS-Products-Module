<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Products Module
 *
 * @author 		Patrick Kivits - Woodits Webbureau
 * @website		http://woodits.nl
 * @package 	PyroCMS
 * @subpackage 	Products Module
 */
class Admin_categories extends Admin_Controller
{
	protected $section = 'categories';

	public function __construct()
	{
		parent::__construct();

		$this->load->model('categories_m');
		$this->load->library('form_validation');
		$this->lang->load('general');
		$this->lang->load('categories');

		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('categories:name'),
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'description',
				'label' => lang('categories:description'),
				'rules' => 'trim'
			)
		);
	}

	public function index()
	{
		$items = $this->categories_m->get_all();

		$this->template
			->title($this->module_details['name'])
			->set('items', $items)
			->build('admin/categories/items');
	}

	public function create()
	{
		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run())
		{
			if($this->categories_m->create($this->input->post()))
			{
				$this->session->set_flashdata('success', lang('general:success'));
				redirect('admin/'.$this->module.'/categories');
			}
			else
			{
				$this->session->set_flashdata('error', lang('general:error'));
				redirect('admin/'.$this->module.'/categories/create');
			}
		}
		
		foreach ($this->item_validation_rules AS $rule)
		{
			$categories->{$rule['field']} = $this->input->post($rule['field']);
		}

		$this->template
			->title($this->module_details['name'], lang('categories:create'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->set('categories', $categories)
			->build('admin/categories/form');
	}
	
	public function edit($id = 0)
	{
		$id = $this->uri->segment(5);
		$id or redirect('admin/'.$this->module);
		
		$categories = $this->categories_m->get($id);

		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run())
		{
			unset($_POST['btnAction']);
			
			if($this->categories_m->update($id, $this->input->post()))
			{
				$this->session->set_flashdata('success', lang('general:success'));
				redirect('admin/'.$this->module.'/categories');
			}
			else
			{
				$this->session->set_flashdata('error', lang('general:error'));
				redirect('admin/'.$this->module.'/categories/create');
			}
		}
		
		$this->template
			->title($this->module_details['name'], lang('categories:edit'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->set('categories', $categories)
			->build('admin/categories/form');
	}
	
	public function delete($id = 0)
	{
		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{
			$this->categories_m->delete_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			$this->categories_m->delete($id);
		}
		redirect('admin/'.$this->module.'/categories');
	}
}