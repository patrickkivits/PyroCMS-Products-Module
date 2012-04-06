<div class="products-container">

	{{ if items_exist == false }}
		<p>{{ helper:lang line="specials:no_items" }}</p>
	{{ else }}
		<div class="products-data">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th width="25%">{{ helper:lang line="specials:name" }}</th>
					<th width="25%">{{ helper:lang line="specials:start" }}</th>
                    <th width="25%">{{ helper:lang line="specials:end" }}</th>
                    <th width="25%">{{ helper:lang line="specials:description" }}</th>
				</tr>
				{{ items }}
				<tr>
					<td width="25%">{{ name }}</td>
					<td width="25%">{{ start }}</td>
                    <td width="25%">{{ end }}</td>
                    <td width="25%">{{ description }}</td>
				</tr>
				{{ /items }}
			</table>
		</div>
	
		{{ pagination:links }}
	
	{{ endif }}
	
</div>