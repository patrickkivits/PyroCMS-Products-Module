<table>
<thead>
    <tr>
        <th><?php echo lang('products:name'); ?></th>
        <th><?php echo lang('products:category'); ?></th>
        <th><?php echo lang('specials:old_price'); ?></th>
        <th><?php echo lang('specials:new_price'); ?></th>
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
    <?php foreach( $products as $item ): ?>
    <tr>
        <td><?php echo $item->name; ?></td>
        <td><?php echo $item->category_name ? $item->category_name : lang('products:no_category'); ?></td>
        <td><?php echo $this->settings->currency?>&nbsp;<?php echo number_format($item->old_price, 2, ',', '.') ?></td>
        <td><?php echo $this->settings->currency?>&nbsp;<?php echo number_format($item->new_price, 2, ',', '.') ?></td>
        <td class="actions">
        	<a href="#" class="button" id="edit-product" data-id="<?php echo $item->id; ?>"><?php echo lang('general:edit'); ?></a>
            <a href="#" class="button" id="delete-product" data-id="<?php echo $item->id; ?>"><?php echo lang('general:delete'); ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
</table>