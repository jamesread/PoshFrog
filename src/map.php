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
$title = 'map';
require_once "includes/widgets/header.php";

use libAllure\Session;
use libAllure\DatabaseFactory;
use libAllure\Shortcuts as LA;

$san = libAllure\Sanitizer::getInstance();
$map = $san->filterString('quadrant', 'Alpha');
$selectedRow = $san->filterUint('row');
$selectedCol = $san->filterUint('col');

function getMaps()
{
    $sql = 'SELECT q.id, q.name FROM maps q ORDER BY q.name ASC';
    $stmt = DatabaseFactory::getInstance()->prepare($sql);
    $stmt->execute([
    ]);

    return $stmt->fetchAll();
}

function updatePlayerLocation() {
    if ($map != null && $row != null && $col != null) {
        $sql = 'UPDATE `users` SET `map_location` = :location WHERE id = :uid LIMIT 1';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->execute([
            ':location' => $row . '.' . $col,
            ':uid' => Session::getUser()->getId(),
        ]);
    }
}

function getAllCellsInQuad($map) {
    $sql = "SELECT m.tileset, m.traversable, m.entity, m.row, m.col FROM map_cells m LEFT JOIN entities e ON m.entity = e.id WHERE m.map = :quad";
    $stmt = DatabaseFactory::getInstance()->prepare($sql);
    $stmt->execute([
        ':quad' => $map,
    ]);

    return $stmt->fetchAll();
}

function getCell($row, $col)
{
    global $cells, $selectedRow, $selectedCol;

    // FIXME this is horrendously inefficient.
    foreach ($cells as $cell) {
        if ($cell['row'] == $row && $cell['col'] == $col) {
            $cell['selected'] = ($row == $selectedRow && $col == $selectedCol);

            return $cell;
        }
    }

    return array(
        'row' => $row,
        'col' => $col,
        'traversable' => true,
        'tileset' => 'tree.jpg',
        'entity' => null,
        'selected' => ($row == $selectedRow && $col == $selectedCol),
    );

    throw new Exception('Cell not found: ' . $row . ':' . $col . ' in ' . print_r($cells, true));
}

$cells = getAllCellsInQuad($map);

$tpl->assign('selectedCell', getCell($selectedRow, $selectedCol));
$tpl->assign('map', $map);
$tpl->assign('listMaps', getMaps());
$tpl->display('map.tpl');


require_once 'includes/widgets/footer.php';
