{foreach from = $entities item = $category}
<div class = "box">
	<h2 class = "green-box">{$category.name}</h2>

	{if empty($category.items)}
	<p>None owned.</h2>
	{else}
	<ul>
		{foreach from = $category.items item = $entity}
		<li>{$entity.id}: {$entity.name}</li>
		{/foreach}

	</ul>
	{/if}
</div>
{/foreach}
