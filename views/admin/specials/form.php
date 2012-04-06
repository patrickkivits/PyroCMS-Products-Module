<section class="title">
	<h4><?php echo lang('specials:'.$this->method); ?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
    <?php echo form_hidden('special', $this->uri->segment(5) ? $this->uri->segment(5) : 0); ?>
    
    <div class="tabs">

		<ul class="tab-menu">
			<li><a href="#specials-content"><span><?php echo lang('specials:content_label');?></span></a></li>
			<li><a href="#specials-products"><span><?php echo lang('specials:products_label');?></span></a></li>
		</ul>
   
        <!-- Content tab -->
		<div class="form_inputs" id="specials-content">
			<fieldset>
            <ul>
                <li class="<?php echo alternator('', 'even'); ?>">
                    <label for="name"><?php echo lang('specials:name'); ?> <span>*</span></label>
                    <div class="input"><?php echo form_input('name', set_value('name', $specials->name), 'class="width-15"'); ?></div>
                </li>
                <li class="<?php echo alternator('', 'even'); ?>">
                    <label for="start"><?php echo lang('specials:start'); ?> <span>*</span></label>
                    <div class="input datetime_input"><?php echo form_input('start', $specials->start ? date("d-m-Y", strtotime($specials->start)) : '', 'maxlength="10" class="text width-20 datepicker"'); ?></div>
                </li>
                <li class="<?php echo alternator('', 'even'); ?>">
                    <label for="end"><?php echo lang('specials:end'); ?> <span>*</span></label>
                    <div class="input datetime_input"><?php echo form_input('end', $specials->end ? date("d-m-Y", strtotime($specials->end)) : '', 'maxlength="10" class="text width-20 datepicker"'); ?></div>
                </li>
                <li class="<?php echo alternator('', 'even'); ?>">
					<label for="description"><?php echo lang('specials:description'); ?></label><br /><br />
					<div>
						<?php echo form_textarea('description', $specials->description, 'class="wysiwyg-simple"'); ?>
					</div>
				</li>
            </ul>
            </fieldset>
		</div>
        
        <!-- Content tab -->
		<div class="form_inputs" id="specials-products">
			<fieldset>
            <ul>
                <li class="<?php echo alternator('', 'even'); ?>">
                    <label for="product"><?php echo lang('specials:products'); ?> <span>*</span></label>
                    <div class="input" id="product-dropdown-container">
						<?php if(isset($products)) : ?>
                        	<?php $select_products[0] = lang('specials:no_products');?>
						<?php foreach($products as $product) : ?>
                            <?php $select_products[$product->id] = $product->name;?>
                        <?php endforeach; ?>
                        <?php if(isset($select_products)) : ?>
                        <?php echo form_dropdown('product', $select_products, '');?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <a href="<?php echo base_url().'admin/products/create'?>" style="padding: 8px; position:absolute;"><?=lang('specials:add_product')?></a>
                    </div>
                    <div id="product-name"></div>
                </li>
                <li class="<?php echo alternator('', 'even'); ?>">
                    <label for="name"><?php echo lang('specials:old_price'); ?></label>
                    <div class="input"><?php echo $this->settings->currency?>&nbsp;<?php echo form_input('old_price', set_value('old_price', $specials->old_price), 'class="width-15"'); ?></div>
                </li>
                <li class="<?php echo alternator('', 'even'); ?>">
                    <label for="name"><?php echo lang('specials:new_price'); ?> <span>*</span></label>
                    <div class="input"><?php echo $this->settings->currency?>&nbsp;<?php echo form_input('new_price', set_value('new_price', $specials->new_price), 'class="width-15"'); ?></div>
                </li>
                <li class="<?php echo alternator('even', ''); ?>" id="button-container">
                	<?php echo form_hidden('special_x_product', ''); ?>
					<a id="add-product-button" class="add-product btn orange" href="#"><?php echo lang('specials:add_product'); ?></a>
                    <a id="edit-product-button" class="add-product btn orange" href="#" style="display: none;"><?php echo lang('specials:edit_product'); ?></a>
                    <a id="cancel-product-button" class="btn gray cancel" href="#" style="display: none;"><?php echo lang('buttons.cancel'); ?></a>
				</li>
            </ul>
            <br style="clear: both;" />
            <!-- ajax load products -->
            <div id="product-container"></div>
        
            </fieldset>
		</div>
    </div>
       
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
       
    <?php echo form_close(); ?>
    
</section>