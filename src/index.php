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
$title = "index";
require_once ("includes/widgets/header.php");

use \libAllure\Session;


if (Session::isLoggedIn()) {
	startBox("Hello again!", BOX_GREEN);
	echo "Welcome back, " . Session::getUser()->getUsername() .".";
	stopBox(BOX_GREEN);


	$sql = "SELECT * FROM `hints` ORDER BY rand() LIMIT 1 ";
	$result = $db->query($sql);
	$hint = $result->fetchRow();

	startBox("Random Game Hint #" . ($hint['id']), BOX_YELLOW);

	echo $hint['content'];

	stopBox(BOX_YELLOW);
} else {
	echo "tycoonism is a free online role playing game, ( rpg for short ). The objectives of the game are as follows: ";
	echo "<ul>";
	echo "<li>Try to become the richest player in the game.</li>";
	echo "<li>The richer you become, within the smallest time as possible will give you good rankings.</li>";
	echo "<li>You play as a 'tycoon'. Earn lots of money while you get one up on your fellow players.</li>";
	echo "</ul>";
}

require_once ("includes/widgets/footer.php");

?>
