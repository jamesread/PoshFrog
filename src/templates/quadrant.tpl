
<div style = "float: right">
	<h2>Quadrents</h2>

	{foreach from = $listQuadrents item = quadrant} 
		<li><a href = "quadrants.php?id={$quadrant.id}">{$quadrant.name}</a></li>
	{/foreach}
</div>
