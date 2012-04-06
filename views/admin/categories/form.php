<section class="title">
	<h4><?php echo lang('categories:'.$this->method); ?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
   
		<div class="form_inputs" >
            <ul>
                <li class="<?php echo alternator('', 'even'); ?>">
                    <label for="name"><?php echo lang('categories:name'); ?> <span>*</span></label>
                    <div class="input"><?php echo form_input('name', set_value('name', $categories->name), 'class="width-15"'); ?></div>
                </li>
                <li class="<?php echo alternator('', 'even'); ?>">
					<label for="description"><?php echo lang('categories:description'); ?></label><br /><br />
					<div>
						<?php echo form_textarea('description', $categories->description, 'class="wysiwyg-simple"'); ?>
					</div>
				</li>
            </ul>
		</div>
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
       
	<?php echo form_close(); ?>

</section>