<div class="products-container">

	{{ if items_exist == false }}
		<p>{{ helper:lang line="products:no_items" }}</p>
	{{ else }}
		<div class="products-data">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th>{{ helper:lang line="categories:name" }}</th>
                    <th>{{ helper:lang line="categories:description" }}</th>
				</tr>
				{{ items }}
				<tr>
					<td><a href="<? echo base_url() . $this->module?>/category/{{ id }}">{{ name }}</a></td>
                    <td>{{ description }}</td>
				</tr>
				{{ /items }}
			</table>
		</div>
	
		{{ pagination:links }}
	
	{{ endif }}
	
</div>