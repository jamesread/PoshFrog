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
$title = "Modify Tileset";
require_once 'includes/widgets/mini_header.php';
require_once 'libAllure/util/shortcuts.php';

if (isset($submit)) {
    $tileset = str_replace(' [image]', '.jpg', $tileset);
    $tileset = str_replace(' ', '_', $tileset);
}

print_r($_REQUEST);

$row = san()->filterUint('row');
$col = san()->filterUint('column');
$quadrent = san()->filterString('quadrent');

function getCell($quadrant, $row, $col)
{
    global $db;

    // get info about cell
    $sql = 'SELECT * FROM `map` WHERE `quadrent` = :quadrant AND row = :row AND col = :col LIMIT 1';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':quadrant', $quadrant);
    $stmt->bindValue(':row', $row);
    $stmt->bindValue(':col', $col);
    $stmt->execute();

    $cell = $stmt->fetchRow();

    if (empty($cell)) {
        return array (
        'tileset' => null,
        'traversable' => false,
        'exit' => null,
        'exit_quadrent' => null,
        'newCell' => true,
        );
    } else {
        return $cell;
    }
}

$cell = getCell($quadrent, $row, $col);

$tileset = $cell['tileset'];
$exit = $cell['exit'];
$exit_to = $cell['exit_quadrent'];
$traversable = $cell['traversable'];

if (isset($_REQUEST['submit'])) {
    if (isset($cell['newCell'])) {
        $sql = "INSERT INTO `map` (row, col, `quadrent`, `tileset`, `exit`, `exit_quadrent` ) VALUES (:row, :col, '$quadrent', '$tileset', '$exit', '$exit_to' )";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':row', $row);
        $stmt->bindValue(':col', $col);
        $stmt->execute();
        die("done insert");
    } else {
        $sql = "UPDATE `map` SET `exit_quadrent` = '$exit_to', `exit` = '$exit', `tileset` = '" . $tileset . "', `traversable` = '" . $traversable . "' WHERE `quadrent` = '" . $quadrent . "' AND `row` = '" . $row . "' AND col = '" . $col . "' LIMIT 1";
        $result = $db->query($sql);
        die("done update");
    }
}

echo "<strong>Co-ordinates</strong>: " . $row . "." . $col . "<br />";

echo "<form>";
// tileset
echo "tileset <select name = tileset>\n\n";

$tiles = scandir('resources/images/tilesets/');
unset($tiles[0]);
unset($tiles[1]);
foreach ($tiles as $key => $name) {
    if ($name != "." && $name != "..") {
        $name = str_replace('_', ' ', $name);
        $name = str_replace('.jpg', ' [image]', $name);
    }

    $tiles[$key] = $name;
}

sort($tiles);

foreach ($tiles as $name) {
    if ($name == $cell['tileset']) {
        echo "\t<option selected style = 'background-color: #FF9900;'>" . $name . "</option>\n";
    } else {
        echo "\t<option>" . $name . "</option>\n";
    }
}

echo "</select> <br /><br />\n\n";

// traversable
echo "Traversable: <select name = traversable>\n";

foreach (array('yes', 'no', 'empty') as $traversable) {
    if ($traversable == $cell['traversable']) {
        echo "\t<option selected style = 'background-color: #FF9900;' >" . $traversable . "</option>\n";
    } else {
        echo "\t<option>" . $traversable  . "</option>\n";
    }
}
echo "</select><br /><br />\n";

// exit direction

echo "exit direction <select name = exit>\n";
foreach (array('none', 'top', 'bottom', 'left', 'right') as $exitDirection) {
    if ($exitDirection == $cell['exit']) {
        echo "\t<option selected style = 'background-color: #FF9900;' >" . $exitDirection . "</option>\n";
    } else {
        echo "\t<option>" . $exitDirection  . "</option>\n";
    }
}
echo "</select><br /><br />\n";

// exit quadrent
echo "exit to <select name = exit_to>\n\n";

$sql = "SELECT * FROM `quadrents`";
$result = $db->query($sql);

while ($exitQuadrent = $result->fetchRow()) {
    if ($exitQuadrent['name'] == $exitQuadrent['exitQuadrent']) {
        echo "\t<option selected style = 'background-color: #FF9900;'>" . $extQuadrent['name'] . "</option>\n";
    } else {
        echo "\t<option>" . $exitQuadrent['name'] . "</option>\n";
    }
}
echo "</select> \n\n";

popup("new", "admin_create_quadrent.php");

echo "<br /><br />";

// quadrent
echo "\n\n", '<input name = "quadrent" type = "hidden" value = "', $quadrent, '">', "\n\n";
// co ordinates
echo '<input type = "hidden" name = "row" value = "', $row, '">';
echo '<input type = "hidden" name = "column" value = "', $col, '">';
// submit
echo '<input type = "submit" name = "submit" value = "save">';
echo '</form>';

require_once "includes/widgets/footer.php";
