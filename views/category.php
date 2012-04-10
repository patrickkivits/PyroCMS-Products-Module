<div class="products-container">

	<?php if(!$items_exist) : ?>
    	<h1><a href="<? echo base_url().$this->module?>/categories"><?php echo lang('categories:label') ?></a> &raquo; <?php echo lang('products:no_items') ?></h1>
		<p><?php echo lang('products:no_items') ?></p>
	<?php else : ?>
		<div class="products-data">
        	<h1><a href="<? echo base_url().$this->module?>/categories"><?php echo lang('categories:label') ?></a> &raquo; <?php echo $items[0]->category_name ?></h1>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo lang('products:name') ?></th>
                    <th><?php echo lang('products:description') ?></th>
                    <th><?php echo lang('products:image') ?></th>
				</tr>
				<?php foreach($items as $item) : ?>
				<tr>
					<td><?php echo $item->name ?></td>
                    <td><?php echo $item->description ?></td>
                    <td><?php if($item->thumbnail) : ?><img src="<?php echo base_url().'uploads/default/products/'.$item->thumbnail ?>" alt="<?php echo $item->name ?>" /><?php endif; ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	
		{{ pagination:links }}
	
	<?php endif; ?>
	
</div>