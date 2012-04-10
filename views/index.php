<div class="products-container">

	<?php if(!$items_exist) : ?>
		<p><?php echo lang('products:no_items') ?></p>
	<?php else : ?>
    
		<div class="products-data">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo lang('products:name') ?></th>
				</tr>
				<?php foreach($items as $item) : ?>
				<tr>
					<td><a href="<? echo base_url().$this->module?>/product/<?php echo $item->id ?>"><?php echo $item->name ?></a></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	
		{{ pagination:links }}
	
	<?php endif; ?>
	
</div>