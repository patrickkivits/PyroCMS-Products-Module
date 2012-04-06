<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Products Module
 *
 * @author 		Patrick Kivits - Woodits Webbureau
 * @website		http://woodits.nl
 * @package 	PyroCMS
 * @subpackage 	Products Module
 */
class Admin extends Admin_Controller
{
	protected $section = 'products';

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('products_m');
		$this->load->model('fields_m');
		$this->load->library('form_validation');
		$this->lang->load('general');
		$this->lang->load('products');

		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('products:name'),
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'category',
				'label' => lang('products:category'),
				'rules' => 'trim|max_length[100]'
			),
			array(
				'field' => 'description',
				'label' => lang('products:description'),
				'rules' => 'trim'
			),
			array(
				'field' => 'thumbnail',
				'label' => lang('products:thumbnail'),
				'rules' => 'trim'
			),
			array(
				'field' => 'image',
				'label' => lang('products:image'),
				'rules' => 'trim'
			)
		);

		$this->template->append_metadata(js('admin.js', $this->module))
			->append_metadata(css('admin.css', $this->module));
	}

	public function index()
	{
		$items = $this->products_m->get_all();

		$this->data->items =& $items;
		$this->template->title($this->module_details['name'])
			->build('admin/'.$this->module.'/items', $this->data);
	}

	public function create()
	{
		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run())
		{
			if($this->products_m->create($this->input->post()))
			{
				$this->session->set_flashdata('success', lang('general:success'));
				redirect('admin/'.$this->module);
			}
			else
			{
				$this->session->set_flashdata('error', lang('general:error'));
				redirect('admin/'.$this->module.'/create');
			}
		}
		
		foreach ($this->item_validation_rules AS $rule)
		{
			$products->{$rule['field']} = $this->input->post($rule['field']);
		}
		
		$this->data->categories = $this->products_m->get_categories();
		$this->data->fields = $this->fields_m->get_all();
		
		$this->data->products =& $products;
		
		$this->template->title($this->module_details['name'], lang('products:create'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_metadata( js('form.js', $this->module) )
			->append_metadata( js('jquery.form.js', $this->module) )
			->append_metadata( js('image.js', $this->module) )
			->build('admin/'.$this->module.'/form', $this->data);
	}
	
	public function edit($id = 0)
	{
		$id = $this->uri->segment(4);
		$products = $this->products_m->get($id);
		
		if ( ! $products)
		{
			$this->session->set_flashdata('error', lang('pages_page_not_found_error'));
			redirect('admin/'.$this->module.'/create');
		}

		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run())
		{
			unset($_POST['btnAction']);
	
			if($this->products_m->update($id, $this->input->post()))
			{
				$this->session->set_flashdata('success', lang('general:success'));
				redirect('admin/'.$this->module);
			}
			else
			{
				$this->session->set_flashdata('error', lang('general:error'));
				redirect('admin/'.$this->module.'/create');
			}
		}
		
		$this->data->categories =& $this->products_m->get_categories();
		
		$this->data->products =& $products;
	
		$this->template->title($this->module_details['name'], lang('products:edit'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_metadata( js('form.js', $this->module) )
			->append_metadata( js('jquery.form.js', $this->module) )
			->append_metadata( js('image.js', $this->module) )
			->build('admin/'.$this->module.'/form', $this->data);
	}
	
	public function delete($id = 0)
	{
		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{			
			foreach($this->input->post('action_to') as $key => $id)
			{
				$products = $this->products_m->get($id);
	
				if($products->thumbnail) {
					unlink(UPLOAD_PATH.$this->module.'/'.$products->thumbnail);
				}
				if($products->image) {
					unlink(UPLOAD_PATH.$this->module.'/'.$products->image);
				}
			}
			
			$this->products_m->delete_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			$products = $this->products_m->get($id);	
	
			if($products->thumbnail) {
				unlink(UPLOAD_PATH.$this->module.'/'.$products->thumbnail);
			}
			if($products->image) {
				unlink(UPLOAD_PATH.$this->module.'/'.$products->image);
			}
			
			$this->products_m->delete($id);
		}
		redirect('admin/'.$this->module);
	}
	
	public function ajax_upload_image()
	{	
		$this->load->library('upload');
	
		$upload_path = UPLOAD_PATH.$this->module.'/';
	
		if(!is_dir($upload_path))
		{
			@mkdir($upload_path,0777,TRUE);
		}
	
		if(is_dir($upload_path))
		
		$config['upload_path'] 		=  $upload_path;
		$config['allowed_types'] 	= 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
		$config['remove_spaces']	= TRUE;
		$config['overwrite']		= FALSE;
		$config['max_size']			= 0;
		$config['encrypt_name']		= TRUE;

		$this->upload->initialize($config);
		
		if($this->upload->do_upload('file')) {
			
			$upload_data = $this->upload->data();

			unset($config);
			$config['source_image'] = $upload_path.$upload_data['file_name'];
			$config['maintain_ratio'] = TRUE;
			$config['quality'] = '100%';
			$config['width'] = $this->settings->thumbnail_width;
			$config['height'] = $this->settings->thumbnail_height;
			$config['new_image'] = $upload_path.$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
			
			if($upload_data['image_width'] > $upload_data['image_height'])
			{
				$config['master_dim'] = 'width';
			}
			elseif($upload_data['image_height'] > $upload_data['image_width'])
			{
				$config['master_dim'] = 'height';
			}
			else
			{
				$config['maintain_ratio'] = TRUE;
			}
	
			$this->load->library('image_lib', $config);
			
			$this->image_lib->resize();	
			
			unset($config);
			$config['image_library'] = 'gd2';
		
			$image_size = getimagesize($upload_path.$upload_data['raw_name'].'_thumb'.$upload_data['file_ext']);
			$config['source_image'] = $upload_path.$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
				
			$config['x_axis'] = (($image_size[0] - $this->settings->thumbnail_width) / 2);
			$config['y_axis'] = (($image_size[1] - $this->settings->thumbnail_height) / 2);
			$config['width'] = $this->settings->thumbnail_width;
			$config['height'] = $this->settings->thumbnail_height;
			$config['quality'] = '100%';
			$config['maintain_ratio'] = FALSE;
			
			$this->image_lib->initialize($config);
			
			$this->image_lib->crop();
			
			$json_data = array(
				'raw_name' => $upload_data['raw_name'],
				'thumbnail' => $upload_data['raw_name'].'_thumb'.$upload_data['file_ext'],
				'image' => $upload_data['raw_name'].$upload_data['file_ext'],
				'ext' => $upload_data['file_ext'],
				'upload_path' => base_url().'uploads/default/'.$this->module.'/'
			);
			
			echo json_encode($json_data);
		}
	}
	
	public function ajax_delete_image()
	{	
		if($this->input->post('thumbnail')) {
			$image_size = getimagesize(UPLOAD_PATH.$this->module.'/'.$this->input->post('thumbnail'));
			
			unlink(UPLOAD_PATH.$this->module.'/'.$this->input->post('thumbnail'));
		}
		if($this->input->post('image')) {
			unlink(UPLOAD_PATH.$this->module.'/'.$this->input->post('image'));
		}
		
		$json_data = array(
			'width' => $image_size[0],
			'height' => $image_size[1]
		);
		
		echo json_encode($json_data);
	}
}