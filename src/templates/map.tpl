<div class = "box">
	<h2>Current Map: {$map}</h2>
	<p>
		Selected Cell: <strong class = "selected">{$selectedCell.row}.{$selectedCell.col}</strong>

		{if $selectedCell.entity}
		<strong>Building: {$selectedCell.building}</strong>
		{else}
		<strong>Empty! {popup('Build!', 'map_build.php?map=$map&row={selectedCell.row}&col={$selectedCell.col}')}
		{/if}

		{if $isAdmin}
		{popup("modify", "admin_modify_tileset.php?map=$map&row={$selectedCell.row}&col={$selectedCell.col}")}
		{/if}
	</p>


	<table class = "map">
	{for $row = 1 to 4}
		<tr>
		{for $col = 1 to 4}
			{$currentCell = getCell($row, $col)}

			<td class = "map_box {if $currentCell.selected}selected{/if}">
				<a href = "map.php?row={$row}&col={$col}&map={$map}">
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
	{popup("create map", "admin_create_map.php?")}
</div>
{/if}


