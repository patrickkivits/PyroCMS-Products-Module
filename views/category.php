<div class="products-container">

	{{ if items_exist == false }}
    	<h1><a href="<? echo base_url() . $this->module?>/categories">{{ helper:lang line="categories:label" }}</a> &raquo; {{ helper:lang line="products:no_items" }}</h1>
		<p>{{ helper:lang line="products:no_items" }}</p>
	{{ else }}
		<div class="products-data">
        	{{ items }}<h1><a href="<? echo base_url() . $this->module?>/categories">{{ helper:lang line="categories:label" }}</a> &raquo; {{ category_name }}</h1>{{ /items }}
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th width="25%">{{ helper:lang line="products:name" }}</th>
                    <th width="25%">{{ helper:lang line="products:description" }}</th>
                    <th width="25%">{{ helper:lang line="products:image" }}</th>
				</tr>
				{{ items }}
				<tr>
					<td width="25%">{{ name }}</td>
                    <td width="25%">{{ description }}</td>
                    <td width="25%">{{ if thumbnail }}<img src="<?php echo base_url().'uploads/default/products/'?>{{ thumbnail }}" alt="{{ name }}" />{{ endif }}</td>
				</tr>
				{{ /items }}
			</table>
		</div>
	
		{{ pagination:links }}
	
	{{ endif }}
	
</div>