<section class="title">
	<h4><?php echo lang('specials:item_list'); ?></h4>
</section>

<section class="item">
	<?php echo form_open('admin/products/delete');?>
	<?php if (!empty($specials)): ?>
	
		<table>
			<thead>
				<tr>
					<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
					<th><?php echo lang('specials:name'); ?></th>
                    <th><?php echo lang('specials:start'); ?></th>
                    <th><?php echo lang('specials:end'); ?></th>
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
				<?php foreach( $specials as $item ): ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $item->id); ?></td>
					<td><?php echo $item->name; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($item->start)) ?></td>
                    <td><?php echo date("d-m-Y", strtotime($item->end)); ?></td>
					<td class="actions">
						<?php echo
						anchor('admin/products/specials/edit/'.$item->id, lang('general:edit'), 'class="button"').' '.
						anchor('admin/products/specials/delete/'.$item->id, 	lang('general:delete'), array('class'=>'button')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="table_action_buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
		</div>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('specials:no_items'); ?></div>
	<?php endif;?>
	
	<?php echo form_close(); ?>
</section>