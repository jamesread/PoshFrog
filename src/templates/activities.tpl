{startBox('Activities', BOX_GREEN)}

{foreach from = $activities item = activity}
	{popup($activity.name, $activity.url)}
{/foreach}

{stopBox(BOX_GREEN)}
