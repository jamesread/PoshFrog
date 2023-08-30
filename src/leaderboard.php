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

$title = "leaderboard";
require_once "includes/widgets/header.php";

$sql = "SELECT `id`, `username`, `registered`, `gold` FROM `users`";
$result = $db->query($sql);

while ($currentUser = $result->fetchRow()) {
    $ranking = (0); // Used to calc getTurns for every user, but that sucks.

    $currentUser['ranking'] = $ranking;

    $leader_array[] = $currentUser;
}

$ranking = array();
foreach ($leader_array as $key => $row) {
    $ranking[$key] = $row['ranking'];
}

array_multisort($ranking, SORT_DESC, $leader_array);

startBox("About the leaderboard", BOX_YELLOW);
echo "This is a list of the current 30 best players, ordered by ";
popup("ranking", "help.php?topic=rankings");
echo ". There are proberbly lots of other players, but they dont qualify for the leaderboard, yet.";
echo "<br /><br />";
stopBox(BOX_YELLOW);

?>

<table class = "normal">
<tr>
    <th style = 'width: 10%;'>ranking</th>
    <th>username</th>
    <th style = 'width: 20%;'>gold</th>
    <th style = 'width: 20%;'>registerd</th>
</tr>



<?php
$i = 0;
while ($i < sizeof($leader_array)) {
    echo "<tr>";
    echo "<td>" . number_format($leader_array[$i]['ranking']) . "</td>";
    echo "<td><a href = \"viewuser.php?user=" . $leader_array[$i]['id'] . "\">" . $leader_array[$i]['username'] . "</a></td>";
    echo "<td>" . number_format($leader_array[$i]['gold']) . "</td>";
    echo "<td>" . $leader_array[$i]['registered'] . "</td>";
    echo "</tr>";
    $i++;
}
echo "</table>";

require_once "includes/widgets/footer.php";

?>
