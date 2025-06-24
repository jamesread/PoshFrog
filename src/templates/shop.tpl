{startBox("Welcome to the shop", BOX_YELLOW)}
	<p>Welcome to the shop. What can we get you?</p>

	<p>Types:
	{foreach from = $entityTypes item = $type name = entityTypes}
		<a href = "?mode={$type}">{$type}</a>{if not $smarty.foreach.entityTypes.last},{else}.{/if}
	{/foreach}
	</p>
{stopBox(BOX_YELLOW)}

{startBox({$entityType}, BOX_GREEN)}
	{if empty($items)}
        <p>Sorry, no {$entityType} for sale.</p>
	{else}
		<table class = "normal">
			<thead>
				<tr>
					<th>Name</th>
					<th>Cost</th>
				</tr>
			</thead>
			<tbody>
		{foreach from = $items item = $item}
			<tr>
				<td>{popup("{$item.name}", "shop_view_item.php?id={$item.id}&amp;type={$entityType}")}</td>
				<td>{$item.cost_gold|formatGold}</td>
			</tr>
		{/foreach}
			</tbody>

		</table>
	{/if}
{stopBox(BOX_GREEN)}
