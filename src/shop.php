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

use pfrog\ContentGenerator;
use pfrog\Inventory;
use libAllure\DatabaseFactory;

$generator = new ContentGenerator();
$generator->generate();

$san = libAllure\Sanitizer::getInstance();

$entityTypes = $game->getItemTypes();
$entityType = $san->filterInputEnum('mode', $entityTypes, 'workers');

$inv = new Inventory();

$tpl->assign('entityTypes', $entityTypes);
$tpl->assign('entityType', $entityType);
$tpl->assign('items', $inv->getUnowned($entityType));
$tpl->display('shop.tpl');


/*
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
            popup("\t<li>" . $row['name'] . "</li>\n", "shop_entity.php?item=" . $row['name']);
        }
    }
    echo "</ul>\n";
    stopBox(BOX_GREEN);
}
 */

$showClose = true;
require_once "includes/widgets/footer.php";
