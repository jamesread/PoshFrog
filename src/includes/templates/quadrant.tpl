
<div style = "float: right">
	<h2>Quadrants</h2>

	{foreach from = $listQuadrants item = quadrant} 
		<li><a href = "quadrants.php?id={$quadrant.id}">{$quadrant.name}</a></li>
	{/foreach}
</div>
