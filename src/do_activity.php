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

$title = 'Do activity';
require_once 'includes/widgets/header.minimal.php';

use libAllure\Session;
use libAllure\DatabaseFactory;
use function libAllure\util\san;
use function libAllure\util\stmt;

$stmt = stmt("SELECT * FROM activitys WHERE id = :activityId LIMIT 1");
$stmt->execute([
    ':activityId' => san()->filterUint('id'),
]);

$row = $stmt->fetchRow();

    echo "<strong>";
    echo $row['name'];
    echo "</strong><hr>";

    if (isset($_GET['action'])) {
        adjustUserGold($row['gold']);

        echo "Thanks for doing the " . $row['name'] . ".";
    } else {
        $turns = getTurns();
        $turns = $turns['total'];

        if ($turns >= $row['turns']) {
            echo "This will take " . $row['turns'] . " turns, you will earn " . $row['gold'] . " gold.";
            echo "<br /><br /><div align = right><form><input type = hidden name = id value = '" . $row['id'] . "'><input type = submit name = action value = 'do it'></form></div>";
        } else {
            echo "You dont have enough turns avalible to do this!";
        }
    }

$showClose = true;
require_once 'includes/widgets/footer.php';
