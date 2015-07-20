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
$title = "shop";
require_once ("includes/widgets/header.php");

startBox("Welcome to the shop", BOX_YELLOW);
echo "Welcome to the shop. What can we get you?<br />";
echo "<a href = \"?mode=business\">business</a> | ";
echo "<a href = \"?mode=slaves\">slaves</a> | ";
echo "<a href = \"?mode=accessorys\">accessorys</a>";
stopBox(BOX_YELLOW);

$display = array ();
if (isset($HTTP_GET_VARS['mode'])) { $mode = $HTTP_GET_VARS['mode']; }

$display['business'] = FALSE;
$display['slaves'] = FALSE;
$display['accessorys'] = FALSE;

if (isset($mode)) {
	$display[$mode] = TRUE;
}

if ($display['business']) {
	startBox("Business", BOX_GREEN);

	$sql = 'SELECT * FROM `shop` WHERE `type` = "BUSINESS"';
	$stmt = DatabaseFactory::getInstance()->prepare($sql);
	$stmt->execute();

	echo "<ul>\n";
	if ($stmt->numRows() == 0) { 
		echo "\t<li>Sorry, no bussinesses are avalible on the market.</li>\n";
	} else {
		while ($row = mysql_fetch_array($result)) {
			popup ( "\t<li>" . $row['name'] . "</li>\n", "shop_item.php?item=" . $row['name'] );
		}
	}
	echo "</ul>\n";
	stopBox(BOX_RED);
}

if ($display['slaves']) {
	startBox("Slaves", BOX_GREEN);

	echo "Slaves are usefull, for, erm, something. <br /><br />";

	$sql = "SELECT * FROM `pfrog_slaves` WHERE `owner` = '' ORDER BY `gold` DESC";							
	$result = $db->query($sql);

	if ($result->numRows() == 0) { 
		echo "\tSorry, no slaves in stock at the moment.\n";
	} else {
		echo "<table class = \"normal\">";
		echo "<th>Name</th>";
		echo "<th>Gold</th>";
		while ($row = $result->fetchRow()) {
			echo "<tr>";
			echo "<td>";
			popup($row['name'], "view_slave.php?slave=" . $row['name'] );
			echo "</td><td>";
			echo $row['gold'];
			echo "</td>";
			echo "</tr>";
		}
	}
	echo "</table>\n";
	stopBox(BOX_GREEN);
}

if ($display['accessorys']) {
	$sql = "SELECT * FROM pfrog_shop WHERE type = 'ACCESSORY'";
	$result = $db->query($sql);

	if ($result->numRows() == 0) { 
		startBox("Accessorys", BOX_RED);
		echo "<ul>\n";
		echo "\t<li>Sorry, no accessorys for someone such as yourself are avalible.</li>\n";
	} else {
		startBox("Accessorys", BOX_GREEN);
		echo "<ul>\n";
		while ($row = mysql_fetch_array($result)) {
			popup ( "\t<li>" . $row['name'] . "</li>\n", "shop_item.php?item=" . $row['name'] );
		}
	}
	echo "</ul>\n";
	stopBox(BOX_GREEN);
}

require_once ("includes/widgets/footer.php");

?>
