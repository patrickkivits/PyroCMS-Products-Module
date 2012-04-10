<div class="products-container">
	
	<?php if(!$items_exist) : ?>
    	<h1><a href="<? echo base_url().$this->module?>/specials"><?php echo lang('specials:label') ?></a> &raquo; <?php echo lang('specials:no_items') ?></h1>
		<p><?php echo lang('specials:no_items') ?></p>
	<?php else : ?>
    
		<div class="products-data">
        	<h1><a href="<? echo base_url().$this->module?>/specials"><?php echo lang('specials:label') ?></a> &raquo; <?php echo $specials->name ?></h1>
            <small><?php echo date($this->settings->date_format, strtotime($specials->start)) ?> / <?php echo date($this->settings->date_format, strtotime($specials->end)) ?></small>
			<br /><br />
            <table cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo lang('specials:name') ?></th>
                    <th><?php echo lang('specials:old_price') ?></th>
                    <th><?php echo lang('specials:new_price') ?></th>
				</tr>
				<?php foreach($items as $item) : ?>
				<tr>
					<td><a href="<? echo base_url().$this->module?>/product/<?php echo $item->product_id ?>"><?php echo $item->name ?></a></td>
                    <td><?php echo $item->old_price ?></td>
                    <td><?php echo $item->new_price ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	
		{{ pagination:links }}
	
	<?php endif; ?>
	
</div>