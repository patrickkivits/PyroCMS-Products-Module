<section class="title">
	<h4><?php echo lang('products:'.$this->method); ?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
	<?php echo form_hidden('thumbnail', $products->thumbnail); ?>
	<?php echo form_hidden('image', $products->image); ?>
    
    <div class="tabs">

		<ul class="tab-menu">
			<li><a href="#products-content"><span><?php echo lang('products:product_label');?></span></a></li>
			<li><a href="#products-image"><span><?php echo lang('products:image_label');?></span></a></li>
		</ul>
    
		<!-- Content tab -->
		<div class="form_inputs" id="products-content">
        	<fieldset>
            <ul>
                <li class="<?php echo alternator('', 'even'); ?>">
                    <label for="name"><?php echo lang('products:name'); ?> <span>*</span></label>
                    <div class="input"><?php echo form_input('name', set_value('name', $products->name), 'class="width-15"'); ?></div>
                </li>
                <li class="<?php echo alternator('', 'even'); ?>">
                    <label for="category"><?php echo lang('products:category'); ?></label>
                    <div class="input">
						<?php if(isset($categories)) : ?>
                        	<?php $select_categories[0] = lang('products:no_category');?>
						<?php foreach($categories as $category) : ?>
                            <?php $select_categories[$category->id] = $category->name;?>
                        <?php endforeach; ?>
                        <?php if(isset($select_categories)) : ?>
                        <?php echo form_dropdown('category', $select_categories, $products->category);?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php echo anchor('admin/products/categories/create', lang('products:add_category'), 'style="padding: 8px; position:absolute;"'); ?>
                    </div>
                </li>
                <?php foreach($fields as $field) : ?>
                	<?php if($field->type == 'text') : ?>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="<?php echo $field->slug ?>"><?php echo $field->name ?></label>
						<div class="input"><?php echo form_input('custom_field['.$field->id.']', set_value($field->slug, isset($products->custom_fields[$field->id]) ? $products->custom_fields[$field->id] : ''), 'class="width-15"'); ?></div>
					</li>
                    <?php endif; ?>
                    <?php if($field->type == 'textarea') : ?>
					<li class="<?php echo alternator('', 'even'); ?>">
                        <label for="<?php echo $field->slug ?>"><?php echo $field->name ?></label><br /><br />
                        <div>
                            <?php echo form_textarea('custom_field['.$field->id.']', set_value($field->slug, isset($products->custom_fields[$field->id]) ? $products->custom_fields[$field->id] : ''), 'class="wysiwyg-simple"'); ?>
                        </div>
                    </li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <li class="<?php echo alternator('', 'even'); ?>">
					<label for="description"><?php echo lang('products:description'); ?></label><br /><br />
					<div>
						<?php echo form_textarea('description', $products->description, 'class="wysiwyg-simple"'); ?>
					</div>
				</li>
            </ul>
            </fieldset>
            <div class="buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
			</div>
            
            <?php echo form_close(); ?>
		</div>
        
        <!-- Content tab -->
		<div class="form_inputs" id="products-image">
        	<fieldset>
        	<ul>
				<li class="<?php echo alternator('', 'even'); ?>">
                	<label for="file"><?php echo lang('products:image'); ?></label><br /><br />
					<div style="clear: both; height: <?php echo $this->settings->thumbnail_height ?>;">
                    	<div style="float: left;">
                            <div id="thumbnail" style="border: 1px solid #D3D3D3; border-radius: 5px 5px 5px 5px; padding: 5px; width: <?php echo $this->settings->thumbnail_width ?>; margin-right: 10px;">
                                <img src="<?php echo $products->thumbnail ? base_url().'uploads/default/products/'.$products->thumbnail : 'http://placehold.it/'.$this->settings->thumbnail_width.'x'.$this->settings->thumbnail_height ?>" alt="<?php echo lang('products:image'); ?>" />
                            </div><br />
                            <a id="delete-image-button" class="btn red" href="#"><?php echo lang('products:delete_image'); ?></a>
                        </div>
                        <div style="float: left;">
							<form action="<?php echo base_url().'index.php/admin/products/ajax_upload_image'?>" method="post" enctype="multipart/form-data" id="ajax-form-upload">
                                <input type="file" name="file"><br />
                                <input type="submit" value="<?php echo lang('products:upload_image'); ?>">
                            </form>
                            
                            <div class="progress">
                                <div class="bar"></div >
                                <div class="percent">0%</div >
                            </div>
                            
                        </div>
					</div>
                </li>
            </ul>
            </fieldset>
        </div>
	</div>

</section>