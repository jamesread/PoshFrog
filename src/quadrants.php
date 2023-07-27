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
require_once "includes/widgets/header.php";

use libAllure\Session;

function getQuadrents()
{
    global $db;

    $sql = 'SELECT q.id, q.name FROM quadrents q WHERE owner = :userId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', Session::getUser()->getId());
    $stmt->execute();

    return $stmt->fetchAll();
}

$tpl->assign('listQuadrents', getQuadrents());
$tpl->display('quadrant.tpl');

if (!isset($_GET['quadrent'])) {
    $_GET['quadrent'] = null;
}
if (!isset($_GET['row'])) {
    $_GET['row'] = null;
}
if (!isset($_GET['column'])) {
    $_GET['column'] = null;
}

if ($_GET['quadrent'] != null && $_GET['row'] != null && $_GET['column'] != null) {
    $result = db_query("UPDATE `users` SET `map_location` = '" . $_GET['row'] . "." . $_GET['column'] . "' WHERE `username` = '" . $_SESSION['username'] . "' LIMIT 1");
}

if (!isset($_GET['quadrent'])) {
    $quadrent = "Alpha";
} else {
    $quadrent = $_GET['quadrent'];
}

$sql = "SELECT `tileset`, `traversable`, row, col FROM `map` WHERE `quadrent` = '" . $quadrent . "' LIMIT 1";
$result = $db->query($sql);

if ($result->numRows() == 0) {
    throw new Exception('No cells found for quadrent:' . $quadrent);
}

function getCell($row, $column)
{
    global $cells;

    foreach ($cells as $cell) {
        if ($cell['row'] == $row && $cell['col'] == $column) {
            return $cell;
        }
    }

    return array(
        'traversable' => true,
        'tileset' => 'tree.jpg',
    );

    throw new Exception('Cell not found: ' . $row . ':' . $column . ' in ' . print_r($cells, true));
}

$cells = $result->fetchAll();

echo "<div style = 'float:left;'><fieldset><legend>";
echo $quadrent . " quadrent";
echo "</legend><table class = \"map\">\n";

$location = gud('location');

if ($location == null) {
    $location = [1, 1];
} else {
    $location = explode(".", $location);
}

$row_loop = 1;
$column_loop = 1;

while ($row_loop <= 4 && $column_loop <= 4) {
    if ($column_loop == 1) {
        echo "<tr>\n";
    }

    $row_result = getCell($row_loop, $column_loop);

    // get cell contents

    // output cell
    if ($location[0] == $row_loop && $location[1] == $column_loop) {
        echo "\t<td class = map_box_here>\n";
    } else {
        if ($row_result['traversable'] == 'yes') {
            echo "\t<td class = 'map_box_traversable'>\n";
        } else {
            echo "\t<td class = 'map_box'>\n";
        }
    }

    if ($result->numRows() == 0) {
        if (inAdminMode()) {
            popup("no map data", "admin_modify_tileset.php?quadrent=$quadrent&row=$row_loop&column=$column_loop");
        } else {
            popup("no map data", "help.php?topic=no_map_data");
        }
    } else {
        if ($row_result['traversable'] == 'yes' && \libAllure\Session::hasPriv('something')) {
            echo "<a href = quadrants.php?quadrent=$quadrent&row=$row_loop&column=$column_loop>";
        }

        if (substr($row_result['tileset'], -3, 3) == "jpg") {
            echo "<img class = null src = 'resources/images/tilesets/" . $row_result['tileset'] . "' / >";
        } else {
            echo $row_result['tileset'];
        }

        if ($row_result['traversable'] == 'yes') {
            echo "</a>";
        }
    }

    echo "</td>\n";

    //
    // end cell
    //
    if ($column_loop == 4) {
        echo "</tr>\n";
    }

    if ($column_loop == 4) {
        $column_loop = 1;
        $row_loop++;
    } else {
        $column_loop++;
    }
}

echo "</table></fieldset></div>";

$quadrent = $_GET['quadrent'];
$row = $_GET['row'];
$column = $_GET['column'];

if (inAdminMode()) {
    echo "<div style = 'float:top;'><fieldset>";
    echo "<legend>admin mode</legend>";
    popup("modify", "admin_modify_tileset.php?quadrent=$quadrent&row=$row&column=$column");
    echo " | ";
    popup("create quadrent", "admin_create_quadrent.php");
    echo "</fieldset></div>";
}


echo "<div style = 'float:top;'><fieldset>";

echo "<legend>" . $quadrent . " Quadrent </legend>";
echo "<strong>Coordinates:</strong> " . $row . "." . $column . "<br />";

$sql = "SELECT * FROM `map` WHERE `row` = '" . $row . "' AND col = '" . $column . "' AND `quadrent` = '" . $quadrent . "' LIMIT 1";
$result = $db->query($sql);
$row_result = $result->fetchRow();

if ($row_result) {

    if ($row_result['exit_quadrent'] != 'none') {
        echo "<strong>Leads to:</strong> " . $row_result['exit_quadrent'] . " quadrent<br />";
        echo "<strong>Direction: </strong>";

        switch ($row_result['exit']) {
        case 'left':
            echo "<a href = map.php?quadrent=" . $row_result['exit_quadrent'] . "&row=$row&column=4>left</a>";
            break;

        case 'right':
            echo "<a href = map.php?quadrent=" . $row_result['exit_quadrent'] . "&row=$row&column=1>right</a>";
            break;

        case 'top':
            echo "<a href = map.php?quadrent=" . $row_result['exit_quadrent'] . "&row=4&column=$column>top</a>";
            break;

        case 'bottom':
            echo "<a href = map.php?quadrent=" . $row_result['exit_quadrent'] . "&row=1&column=$column>bottom</a>";
            break;

        default:
            echo "no direction specified..!";
            break;
        }
    }
}

?>
</fieldset></div>
<br clear = all / >
<?

require_once ("includes/widgets/footer.php");

?>
