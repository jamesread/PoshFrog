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

use \libAllure\DatabaseFactory;

$san = new libAllure\Sanitizer();

$row = $san->filterUint('row');
$col = $san->filterUint('col');
$quadrent = $san->filterString('quadrent');

function getCell($quadrent, $row, $col)
{
    $sql = 'SELECT * FROM `map` WHERE `quadrent` = :quadrent AND row = :row AND col = :col LIMIT 1';
    $stmt = DatabaseFactory::getInstance()->prepare($sql);
    $stmt->execute([
        ':row' => $row,
        ':col' => $col,
        ':quadrent' => $quadrent,
    ]);

    $cell = $stmt->fetchRow();

    if (empty($cell)) {
        $sql = 'INSERT INTO `map` (quadrent, row, col) VALUES (:quadrent, :row, :col)';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->execute([
            ':row' => $row,
            ':col' => $col,
            ':quadrent' => $quadrent,
        ]);

        return getCell($quadrent, $row, $col);
    }

    return $cell;
}

$cell = getCell($quadrent, $row, $col);

if (isset($_REQUEST['submit'])) {
    $sql = 'UPDATE `map` SET `tileset` = :tileset, `exit` = :exit, `exit_quadrent` = :exit_to WHERE quadrent = :quadrent AND row = :row AND col = :col';
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':row' => $row,
        ':col' => $col,
        ':quadrent' => $quadrent,
        ':tileset' => $san->filterString('tileset'),
        ':exit' => $san->filterString('exit'),
        ':exit_to' => $san->filterString('exit_to'),
    ]);
}

echo "<strong>Co-ordinates</strong>: " . $row . "." . $col . "<br />";

echo "<form>";
echo "tileset <select name = tileset>\n\n";

function getTiles(): array
{
    $tiles = [];
    $files = scandir('resources/images/tilesets/');

    foreach ($files as $name) {
        if ($name == "." || $name == "..") {
            continue;
        }

        $caption = str_replace('_', ' ', $name);
        $caption = str_replace('.jpg', ' [image]', $caption);

        $tiles[$name] = $caption;
    }

    ksort($tiles);

    return $tiles;
}

foreach (getTiles() as $key => $name) {
    if ($name == $cell['tileset']) {
        echo "\t<option selected style = 'background-color: #FF9900;'>" . $name . "</option>\n";
    } else {
        echo "\t<option value = \"$key\">" . $name . "</option>\n";
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
    //    if ($exitQuadrent['name'] == $exitQuadrent['exit_quadrent']) {
    //        echo "\t<option selected style = 'background-color: #FF9900;'>" . $extQuadrent['name'] . "</option>\n";
    //    } else {
    echo "\t<option>" . $exitQuadrent['name'] . "</option>\n";
    //    }
}
echo "</select> \n\n";

popup("new", "admin_create_quadrent.php");

echo "<br /><br />";

// quadrent
echo "\n\n", '<input name = "quadrent" type = "hidden" value = "', $quadrent, '">', "\n\n";
// co ordinates
echo '<input type = "hidden" name = "row" value = "', $row, '">';
echo '<input type = "hidden" name = "col" value = "', $col, '">';
// submit
echo '<input type = "submit" name = "submit" value = "save">';
echo '</form>';

require_once "includes/widgets/footer.php";
