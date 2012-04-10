<div class="products-container">

	<?php if(!$items_exist) : ?>
		<p><?php echo lang('specials:no_items') ?></p>
	<?php else : ?>
    
		<div class="products-data">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th width="25%"><?php echo lang('specials:name') ?></th>
					<th width="25%"><?php echo lang('specials:start') ?></th>
                    <th width="25%"><?php echo lang('specials:end') ?></th>
                    <th width="25%"><?php echo lang('specials:description') ?></th>
				</tr>
				<?php foreach($items as $item) : ?>
				<tr>
					<td width="25%"><a href="<? echo base_url() . $this->module?>/specials/special/<?php echo $item->id ?>"><?php echo $item->name ?></a></td>
					<td width="25%"><?php echo date($this->settings->date_format, strtotime($item->start)) ?></td>
                    <td width="25%"><?php echo date($this->settings->date_format, strtotime($item->end)) ?></td>
                    <td width="25%"><?php echo $item->description ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
        
        <br />
        <?php if($this->uri->segment(3) == 'archive') : ?>
        	<a href="<? echo base_url() . $this->module?>/specials"><?php echo lang('specials:view_current') ?></a>
		<?php else : ?>
        	<a href="<? echo base_url() . $this->module?>/specials/archive"><?php echo lang('specials:view_archive') ?></a>
        <?php endif; ?>
    	
		{{ pagination:links }}
	
	<?php endif; ?>
	
</div>