<section class="title">
	<h4><?php echo lang('fields:'.$this->method); ?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
   
		<div class="form_inputs" >
            <ul>
                <li class="<?php echo alternator('', 'even'); ?>">
                    <label for="name"><?php echo lang('fields:name'); ?> <span>*</span></label>
                    <div class="input"><?php echo form_input('name', set_value('name', $fields->name), 'class="width-15"'); ?></div>
                </li>
                <li class="<?php echo alternator('', 'even'); ?>">
               		<label for="type"><?php echo lang('fields:type'); ?> <span>*</span></label>
                    <div class="input">
						<?php $options = array('text' => lang('fields:option:text'), 'textarea' => lang('fields:option:textarea')); ?>
                        <?php echo form_dropdown('type', $options, $fields->type);?>
                    </div>
                </li>
            </ul>
		</div>
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
       
	<?php echo form_close(); ?>

</section>