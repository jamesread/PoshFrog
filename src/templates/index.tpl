<div>
	{if $isLoggedIn}
		{startBox('Hello again!', BOX_GREEN)}
		<p>Welcome back <strong>{$user->getUsername()}</strong>.</p>
		{stopBox(BOX_GREEN)}
	{else}
	pFrog is a free online role-playing game. The objectives of the game are as follows:

	<ul>
		<li>Try to become the richest player in the game.</li>
		<li>The richer you become, within the smallest time as possible will give you good rankings.</li>
		<li>You play as a 'tycoon'. Earn lots of money while you get one up on your fellow players.</li>
	</ul>
	{/if}
</div>
