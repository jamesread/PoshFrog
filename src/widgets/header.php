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
	$core->error("Title not set for this page.");
}

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>pFrog / <?php echo $title; ?> </title>
	<link rel = "stylesheet" type = "text/css" href = "resources/stylesheets/style.css" />
	<link rel = "stylesheet" type = "text/css" href = "resources/stylehseets/menu.css" />

	<script language = "javascript" type = "text/javascript" src = "resources/javascript/menu.js"></script>
	<script language = "javascript" type = "text/javascript" src = "resources/javascript/popup.js"></script>
</head>

<body>

<div id = "header">
	<h1>pFrog</h1>
		<?php

		if (Session::isLoggedIn()) {
			echo "<div style = 'float: right;'> logged in as <strong><a href = \"viewuser.php?user=" . Session::getUser()->getId() . "\">" . Session::getUser()->getUsername() . "</a></strong>.</div>";

			if (Session::hasPriv('ADMIN')) {
				echo " | <a href = admin.php>admin</a> | ";
			}

		?>
	<div>
		<h2>Menu</h2>

		<ul>
			<li><a href="index.php">index</a></li>
			<li><a href="leaderboard.php">leaderbord</a></li>
			<li><a href="map.php">map</a></li>
			<li><a href="activitys.php">activitys</a></li>
			<li><h3>Financial</h3></li>
			<li><a href="bank.php">bank</a></li>
			<li><a href="shop.php">shop</a></li>
			<li><a href="slaves.php">slaves</a></li>
			<li><a href="business.php">business</a></li>
			<li><h3>Account</h3></li>
			<li><a href="contacts.php">contacts</a></li>
			<li><a href="clans.php">clans</a></li>
			<li><a href="logout.php">logout</a></li>
		</ul>
	</div>
<?php

	echo "<div style = 'float:left;'>";
	echo "<strong><img src = \"resources/images/coins.jpg\" />" . number_format(Session::getUser()->getData('gold')) . "</strong> Gold. ";

	$turns = Session::getUser()->getData('turns');

	echo "<strong>" . $turns['remaining'] . "</strong> turns avalible, <strong>" . $turns['time'] . "</strong> seconds before next turn.";
	echo "</div>";
} else {
	echo "<a href = \"register.php\">register</a> | ";
	echo "<a href = \"login.php\">login</a>";
}

?>

</div>

<div class = "page">
