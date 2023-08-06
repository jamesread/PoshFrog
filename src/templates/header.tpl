<!DOCTYPE html>
<html>
<head>
<title>pFrog / {$title} </title>
	<link rel = "stylesheet" type = "text/css" href = "resources/stylesheets/style.css" />

	<script language = "javascript" type = "text/javascript" src = "resources/javascript/menu.js"></script>
	<script language = "javascript" type = "text/javascript" src = "resources/javascript/popup.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<header>
	<h1 style = "grid-area: title">
		<a href = "index.php">pFrog</a>
	</h1>

{if $isLoggedIn}
    <div style = "grid-area: session; justify-self: right;">
		logged in as <strong><a href = "viewuser.php?user={$user->getID()}" \>{$user->getUsername()}</a></strong>.
	</div>
    
	<ul style = "grid-area: 'shop'">
			<li><h3>Main</h3></li>
			{if $isAdmin}
			<li>
			</li>
			{/if}
			<li><a href="leaderboard.php">leaderboard</a></li>
			<li><a href="quadrants.php">quadrents</a></li>
             <li><a href="contacts.php">contacts</a></li>
			<li><a href="activitys.php">activities</a></li>
	</ul>

	<ul style = "grid-area: finance">
			<li><h3>Financial</h3></li>
			<li><a href="bank.php">bank</a></li>
			<li><a href="shop.php">shop</a></li>
			<li><a href="slaves.php">slaves</a></li>
			<li><a href="business.php">business</a></li>
	</ul>
</header>

<p class = "status">
<span class = "metric"><strong><img src = "resources/images/gold.png" />{$gold}</strong></span>
<span class = "metric"><strong><img src = "resources/images/turn.png" />{$turns.remaining}</strong></span>
<span class = "metric"><strong><img src = "resources/images/time.png" />{$turns.time}</strong></span>
</p>
{else}
	<div class = "grid-area: 'session'">
		<a href = "login.php">login</a> |
		<a href = "register.php">register</a> 
	</div>
{/if}
</header>

<div class = "page">
