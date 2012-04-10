<div class="products-container">

	<?php if(!$items_exist) : ?>
		<p><?php echo lang('products:no_items') ?></p>
	<?php else : ?>
    
    <div class="products-data">
    	
        <h1><a href="<?php echo base_url() . $this->module?>"><?php echo lang('products:label') ?></a> &raquo; <?php echo $items->name ?></h1>
        
        <img src="<?=base_url().'uploads/default/products/'.$items->thumbnail ?>" alt="<?php echo $items->name ?>" />
    	
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td><?php echo lang('products:category') ?></td>
                <td><?php echo $items->category_name ? $items->category_name : lang('products:no_category') ?></td>
            </tr>
           <?php foreach($fields as $field) : ?>
           <tr>
            	<td><?php echo $field->name ?></td>
                <td><?php echo $items->custom_fields[$field->id]; ?></td>
            </tr>
            <?php endforeach; ?>
           	<tr>
            	<td><?php echo lang('products:description') ?></td>
                <td><?php echo $items->description ?></td>
            </tr>
        </table>
    </div>
    	
	<?php endif; ?>
	
</div>