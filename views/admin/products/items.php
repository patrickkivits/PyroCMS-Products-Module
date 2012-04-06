<section class="title">
	<h4><?php echo lang('products:item_list'); ?></h4>
</section>

<section class="item">
	<?php echo form_open('admin/products/delete');?>
	
	<?php if (!empty($items)): ?>
	
		<table>
			<thead>
				<tr>
					<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
					<th><?php echo lang('products:name'); ?></th>
                    <th><?php echo lang('products:category'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach( $items as $item ): ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $item->id); ?></td>
					<td><?php echo $item->name; ?></td>
                    <td><?php echo $item->category_name ? $item->category_name : lang('products:no_category'); ?></td>
					<td class="actions">
						<?php echo
						anchor('admin/products/edit/'.$item->id, lang('general:edit'), 'class="button"').' '.
						anchor('admin/products/delete/'.$item->id, 	lang('general:delete'), array('class'=>'button')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="table_action_buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
		</div>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('products:no_items'); ?></div>
	<?php endif;?>
	
	<?php echo form_close(); ?>
</section>