<?php
/*******************************************************************************

  Copyright (C) 2004-2006 xconspirisist (xconspirisist@gmail.com)

  This file is part of pFrog.

  pFrog is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  pFrog is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with pFrog; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*******************************************************************************/

require_once 'includes/common.php';

use \libAllure\Session;

if (!isset($title)) {
	$title = 'Untitled page';
}

global $tpl;
$tpl->assign('title', $title);
$tpl->display('header.tpl');

?>

<div id = "header">
	<h1><a href = "index.php">pFrog</a></h1>
		<?php

		if (Session::isLoggedIn()) {
			echo "<div style = 'float: right;'> logged in as <strong><a href = \"viewuser.php?user=" . Session::getUser()->getId() . "\">" . Session::getUser()->getUsername() . "</a></strong>.</div>";

			if (Session::hasPriv('ADMIN')) {
				echo "<a href = admin.php>admin</a>";
			}

		?>
	<div>
		<ul class = "mainmenu">
			<li><h3>Main</h3></li>
			<li><a href="index.php">index</a></li>
			<li><a href="leaderboard.php">leaderbord</a></li>
			<li><a href="map.php">map</a></li>
			<li><a href="activitys.php">activities</a></li>
		</ul>
		<ul class = "mainmenu">
			<li><h3>Financial</h3></li>
			<li><a href="bank.php">bank</a></li>
			<li><a href="shop.php">shop</a></li>
			<li><a href="slaves.php">slaves</a></li>
			<li><a href="business.php">business</a></li>
		</ul>
		<ul class = "mainmenu">
			<li><h3>Account</h3></li>
			<li><a href="contacts.php">contacts</a></li>
			<li><a href="clans.php">clans</a></li>
			<li><a href="logout.php">logout</a></li>
		</ul>
	</div>
<?php
	$turns = getTurns(Session::getUser()->getUsername());
	$gold = number_format(Session::getUser()->getData('gold'));

	echo '<p class = "status">';
	echo '<span class = "metric"><strong><img src = "resources/images/gold.png" /> ' . $gold . '</strong></span> ';
	echo '<span class = "metric"><strong><img src = "resources/images/turn.png" /> ' . $turns['remaining'] . '</strong></span> ';
	echo '<span class = "metric"><strong><img src = "resources/images/time.png" /> ' . $turns['time'] . '</strong></span>';
	echo "</p>";
} else {
	echo "<a href = \"register.php\">register</a> | ";
	echo "<a href = \"login.php\">login</a>";
}

?>

</div>

<div class = "page">
<?php 

