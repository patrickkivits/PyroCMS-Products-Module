<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Products extends Module {

public $version = '2.1';

public function info()
{
	return array(
		'name' => array(
			'en' => 'Products',
			'nl' => 'Producten'
		),
		'description' => array(
			'en' => 'Manage products, categories and specials.',
			'nl' => 'Beheer producten, categorieen en aanbiedingen.'
		),
		'frontend' => TRUE,
		'backend' => TRUE,
		'menu' => 'content',
		'sections' => array(
			'products' => array(
				'name' 	=> 'products:label',
				'uri' 	=> 'admin/products',
					'shortcuts' => array(
						'create' => array(
							'name' 	=> 'products:create',
							'uri' 	=> 'admin/products/create',
							'class' => 'add'
						)
					)
			),
			'fields' => array(
				'name' 	=> 'fields:label',
				'uri' 	=> 'admin/products/fields',
					'shortcuts' => array(
						'create' => array(
							'name' 	=> 'fields:create',
							'uri' 	=> 'admin/products/fields/create',
							'class' => 'add'
						)
					)
			),
			'categories' => array(
				'name' 	=> 'categories:label',
				'uri' 	=> 'admin/products/categories',
					'shortcuts' => array(
						'create' => array(
							'name' 	=> 'categories:create',
							'uri' 	=> 'admin/products/categories/create',
							'class' => 'add'
						)
					)
			),
			'specials' => array(
				'name' 	=> 'specials:label',
				'uri' 	=> 'admin/products/specials',
					'shortcuts' => array(
						'create' => array(
							'name' 	=> 'specials:create',
							'uri' 	=> 'admin/products/specials/create',
							'class' => 'add'
						)
					)
			)
		)
	);
}

public function install()
{
	$this->dbforge->drop_table('specials');
	$this->dbforge->drop_table('products');
	$this->dbforge->drop_table('categories');
	$this->dbforge->drop_table('specials_x_products');
	$this->dbforge->drop_table('fields');
	$this->dbforge->drop_table('products_x_fields');
	$this->db->delete('settings', array('module' => 'products'));
	
	$tables = array(
		'specials' => array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
			'slug' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => '', 'unique' => true),
			'start' => array('type' => 'DATETIME'),
			'end' => array('type' => 'DATETIME'),
			'description' => array('type' => 'TEXT'),
		),
		'products' => array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
			'slug' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => '', 'unique' => true),
			'category' => array('type' => 'INT', 'constraint' => 11),
			'thumbnail' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
			'image' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
			'description' => array('type' => 'TEXT'),
		),
		'categories' => array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
			'slug' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => '', 'unique' => true),
			'description' => array('type' => 'TEXT'),
		),
		'fields' => array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
			'slug' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => '', 'unique' => true),
			'type' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
			'order' => array('type' => 'INT', 'constraint' => 11),
		),
		'specials_x_products' => array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
			'special' => array('type' => 'INT', 'constraint' => 11),
			'product' => array('type' => 'INT', 'constraint' => 11),
			'old_price' => array('type' => 'FLOAT(8,2)'),
			'new_price' => array('type' => 'FLOAT(8,2)'),
		),
		'products_x_fields' => array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
			'product' => array('type' => 'INT', 'constraint' => 11),
			'field' => array('type' => 'INT', 'constraint' => 11),
			'value' => array('type' => 'TEXT'),
		),
	);
	
	$thumbnail_width = array(
		'slug' => 'thumbnail_width',
		'title' => 'Thumbnail width',
		'description' => 'Specify the width for the product thumbnail',
		'`default`' => '250',
		'`value`' => '',
		'type' => 'text',
		'`options`' => '',
		'is_required' => 0,
		'is_gui' => 1,
		'module' => 'products'
	);
	
	$thumbnail_height = array(
		'slug' => 'thumbnail_height',
		'title' => 'Thumbnail height',
		'description' => 'Specify the height for the product thumbnail',
		'`default`' => '150',
		'`value`' => '',
		'type' => 'text',
		'`options`' => '',
		'is_required' => 0,
		'is_gui' => 1,
		'module' => 'products'
	);
	
	if ( ! $this->install_tables($tables))
	{
		return false;
	}
	
	if( ! $this->db->insert('settings', $thumbnail_width))
	{
		return FALSE;
	}
	
	if( ! $this->db->insert('settings', $thumbnail_height))
	{
		return FALSE;
	}
	
	if ( ! is_dir($this->upload_path.'products') AND ! @mkdir($this->upload_path.'products',0777,TRUE))
	{
		return FALSE;
	}
	
	return TRUE;
}

public function uninstall()
{
	$this->dbforge->drop_table('specials');
	$this->dbforge->drop_table('products');
	$this->dbforge->drop_table('categories');
	$this->dbforge->drop_table('specials_x_products');
	$this->dbforge->drop_table('fields');
	$this->dbforge->drop_table('products_x_fields');
	
	$this->db->delete('settings', array('module' => 'products'));

	return TRUE;
}


public function upgrade($old_version)
{
	return TRUE;
}

public function help()
{
	return "Help is not available for this module";
}

}
/* End of file details.php */