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

require_once ("includes/common.php");

if (isset($_GET['clan'])) {
	$sql = "SELECT * FROM `clans` WHERE `name` = '" . $_GET['clan'] . "' LIMIT 1";
	$result = db_query($sql);

	$clan = mysql_fetch_array($result);

	if ($clan['password'] == md5($_GET['password'])) {
		$sql = "UPDATE `tycoonism_users` SET `clan` = '" . $clan['name'] . "' WHERE `username` = '" . $_SESSION['username'] . "'";
		$result = db_query($sql);
		redirect("Clan Joined.", "clans.php");
	} else {
		redirect("Password incorrect.", "clans.php");
	}

}

$title = "clans";
require_once ("includes/widgets/header.php");

startBox("About Clans", BOX_YELLOW);
echo "Clans are groups of players that play the game together. It makes
for strong forces. Most clans have certain requirements that you must
meet before you can join. You can only be in one clan at a time.";

stopBox(BOX_YELLOW);

startBox("Join a clan", BOX_GREEN);

$sql = "SELECT * FROM `clans`";
$result = $db->query($sql);

if (mysql_error() || $result->numRows() == 0) {
	echo "No clans found.";
} else {
	echo "<form action = \"clans.php\">";
	echo "<label>Clan <select name = \"clan\">";
	while ($clan = mysql_fetch_array($result)) {
		echo "\t<option>" . $clan['name'] . "</option>\n";
	}
	echo "</select></label><br /><br />";
	echo "<label>password <input name = \"password\" type = \"password\"/></label><br /><br />";
	echo "<input type = \"submit\" value = \"join\" />";
	echo "</form>";
}

stopBox(BOX_GREEN);

require_once ("includes/widgets/footer.php");

?>
