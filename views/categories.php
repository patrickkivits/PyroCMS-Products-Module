<div class="products-container">

	<?php if(!$items_exist) : ?>
		<p><?php echo lang('products:no_items') ?></p>
	<?php else : ?>
    
    <div class="products-data">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo lang('categories:name') ?></th>
                <th><?php echo lang('categories:description') ?></th>
            </tr>
            <?php foreach($items as $item) : ?>
            <tr>
                <td><a href="<? echo base_url() . $this->module?>/category/<?php echo $item->id ?>"><?php echo $item->name ?></a></td>
                <td><?php echo $item->description ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    {{ pagination:links }}
    
    <?php endif; ?>
	
</div>