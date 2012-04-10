<div class="products-container">

	<?php if(!$items_exist) : ?>
		<p><?php echo lang('specials:no_items') ?></p>
	<?php else : ?>
    
		<div class="products-data">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo lang('specials:name') ?></th>
					<th><?php echo lang('specials:start') ?></th>
                    <th><?php echo lang('specials:end') ?></th>
                    <th><?php echo lang('specials:description') ?></th>
				</tr>
				<?php foreach($items as $item) : ?>
				<tr>
					<td><?php echo $item->name ?></td>
					<td><?php echo $item->start ?></td>
                    <td><?php echo $item->end ?></td>
                    <td><?php echo $item->description ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	
		{{ pagination:links }}
	
	<?php endif; ?>
	
</div>