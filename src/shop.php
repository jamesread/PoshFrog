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

require_once "includes/common.php";
$title = "shop";
require_once "includes/widgets/header.php";

startBox("Welcome to the shop", BOX_YELLOW);
echo "Welcome to the shop. What can we get you?<br />";
echo "<a href = \"?mode=business\">business</a> | ";
echo "<a href = \"?mode=slaves\">slaves</a> | ";
echo "<a href = \"?mode=accessories\">accessories</a>";
stopBox(BOX_YELLOW);

use libAllure\DatabaseFactory;

$display = [
    'business' => false,
    'slaves' => false,
    'accessories' => false,
];

if (isset($_GET['mode'])) {
    if (isset($display[$_GET['mode']])) {
        $display[$_GET['mode']] = true;
    }
}

if ($display['business']) {
    startBox("Business", BOX_GREEN);

    $sql = 'SELECT * FROM `shop` WHERE `type` = "BUSINESS"';
    $stmt = DatabaseFactory::getInstance()->prepare($sql);
    $stmt->execute();

    echo "<ul>\n";
    if ($stmt->numRows() == 0) {
        echo "\t<li>Sorry, no bussinesses are available on the market.</li>\n";
    } else {
        while ($row = mysql_fetch_array($result)) {
            popup("\t<li>" . $row['name'] . "</li>\n", "shop_item.php?item=" . $row['name']);
        }
    }
    echo "</ul>\n";
    stopBox(BOX_RED);
}

if ($display['slaves']) {
    startBox("Slaves", BOX_GREEN);

    echo "Slaves are useful, for, erm, something. <br /><br />";

    $sql = "SELECT * FROM `slaves` WHERE `owner` = '' ORDER BY `gold` DESC";
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
            popup($row['name'], "view_slave.php?slave=" . $row['id']);
            echo "</td><td>";
            echo $row['gold'];
            echo "</td>";
            echo "</tr>";
        }
    }
    echo "</table>\n";
    stopBox(BOX_GREEN);
}

if ($display['accessories']) {
    $sql = "SELECT * FROM shop WHERE type = 'ACCESSORY'";
    $result = $db->query($sql);

    if ($result->numRows() == 0) {
        startBox("Accessories", BOX_RED);
        echo "<ul>\n";
        echo "\t<li>Sorry, no accessories for someone such as yourself are available.</li>\n";
    } else {
        startBox("Accessories", BOX_GREEN);
        echo "<ul>\n";
        while ($row = mysql_fetch_array($result)) {
            popup("\t<li>" . $row['name'] . "</li>\n", "shop_item.php?item=" . $row['name']);
        }
    }
    echo "</ul>\n";
    stopBox(BOX_GREEN);
}

require_once "includes/widgets/footer.php";
