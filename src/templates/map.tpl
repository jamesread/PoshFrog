<div class = "box">
	<h2>Current Map: {$map->getName()}</h2>
	<p>
		{$selectedCell = $map->getSelectedCell()}
		Selected Cell: <strong class = "selected">{$selectedCell.row}.{$selectedCell.col}</strong>

		{if $selectedCell.building_id}
		<strong>Building: {$selectedCell.building_id}</strong>
		{else}
		<strong>Empty!! {popup('Build!', "map_build.php?row={$selectedCell.row}&col={$selectedCell.col}")}
		{/if}

		{if $isAdmin}
		{/if}
	</p>


	<table class = "map">
	{for $row = 1 to 4}
		<tr>
		{for $col = 1 to 4}
			{$currentCell = $map->getCell($row, $col)}

			<td class = "map_box {if $currentCell.selected}selected{/if}">
				<a href = "map.php?row={$row}&col={$col}&map={$map->getName()}">
				<img class = null src = "resources/images/tilesets/{$currentCell['tileset']}" />
				</a>
			</td>
		{/for}
		</tr>
	{/for}

	</table>
</div>

<div class = "box">
	<h2>Maps</h2>

	<div class = "boxContent">
	<ul>
	{foreach from = $listMaps item = quadrant} 
		<li><a href = "map.php?id={$quadrant.id}">{$quadrant.name}</a></li>
	{/foreach}
	</ul>
	</div>
</div>

{if $isAdmin}
<div class = "box">
	<h3>Admin...</h3>
	<ul>
		<li>{popup("create map", "admin_create_map.php?")}</li>
		<li>{popup("Modify selected cell", "admin_modify_tileset.php?map={$map->getName()}&row={$selectedCell.row}&col={$selectedCell.col}")}</li>
	</ul>
</div>
{/if}


