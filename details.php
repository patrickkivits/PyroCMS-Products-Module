<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Products extends Module {

public $version = '1.0';

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
	$this->db->delete('settings', array('module' => 'products'));

	$specials = array(
        'id' => array(
			'type' => 'INT',
			'constraint' => '11',
			'auto_increment' => TRUE
		),
		'name' => array(
			'type' => 'VARCHAR',
			'constraint' => '255'
		),
		'slug' => array(
			'type' => 'VARCHAR',
			'constraint' => '255'
		),
		'start' => array(
			'type' => 'DATETIME'
		),
		'end' => array(
			'type' => 'DATETIME'
		),
		'description' => array(
			'type' => 'TEXT'
		),
	);
	
	$products = array(
        'id' => array(
			'type' => 'INT',
			'constraint' => '11',
			'auto_increment' => TRUE
		),
		'name' => array(
			'type' => 'VARCHAR',
			'constraint' => '255'
		),
		'slug' => array(
			'type' => 'VARCHAR',
			'constraint' => '255'
		),
		'categorie' => array(
			'type' => 'INT',
			'constraint' => '11',
			'null' => TRUE
		),
		'thumbnail' => array(
			'type' => 'VARCHAR',
			'constraint' => '255'
		),
		'image' => array(
			'type' => 'VARCHAR',
			'constraint' => '255'
		),
		'description' => array(
			'type' => 'TEXT'
		),
	);
	
	$categories = array(
        'id' => array(
			'type' => 'INT',
			'constraint' => '11',
			'auto_increment' => TRUE
		),
		'name' => array(
			'type' => 'VARCHAR',
			'constraint' => '255'
		),
		'slug' => array(
			'type' => 'VARCHAR',
			'constraint' => '255'
		),
		'description' => array(
			'type' => 'TEXT'
		),
	);
	
	$specials_x_products = array(
        'id' => array(
			'type' => 'INT',
			'constraint' => '11',
			'auto_increment' => TRUE
		),
		'special' => array(
			'type' => 'INT',
			'constraint' => '11',
			'null' => TRUE
		),
		'product' => array(
			'type' => 'INT',
			'constraint' => '11',
			'null' => TRUE
		),
		'old_price' => array(
			'type' => 'FLOAT',
			'constraint' => '8,2',
			'null' => TRUE
		),
		'new_price' => array(
			'type' => 'FLOAT',
			'constraint' => '8,2',
			'null' => TRUE
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
	
	$this->dbforge->add_field($specials);
	$this->dbforge->add_key('id', TRUE);

	if ( ! $this->dbforge->create_table('specials'))
	{
		return FALSE;
	}
	
	$this->dbforge->add_field($products);
	$this->dbforge->add_key('id', TRUE);
	
	if ( ! $this->dbforge->create_table('products'))
	{
		return FALSE;
	}
	
	$this->dbforge->add_field($categories);
	$this->dbforge->add_key('id', TRUE);
	
	if ( ! $this->dbforge->create_table('categories'))
	{
		return FALSE;
	}
	
	$this->dbforge->add_field($specials_x_products);
	$this->dbforge->add_key('id', TRUE);
	
	if ( ! $this->dbforge->create_table('specials_x_products'))
	{
		return FALSE;
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