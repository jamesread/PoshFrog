{startBox('Activities', BOX_GREEN)}

<ul>
{foreach from = $activities item = activity}
	<li>{popup($activity.name, $activity.url)}</li>
{/foreach}
</ul>

{stopBox(BOX_GREEN)}
