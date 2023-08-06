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
require_once 'includes/widgets/header.minimal.php';

$advisor = $_GET['advisor'];

echo "<strong>$advisor advisor</strong><hr>";
switch ($advisor) {
    case 'slaves':
        $result = $db->query("SELECT * FROM slaves WHERE user = '" . $_SESSION['username'] . "'");

        if ($result->numRows() == 0) {
            echo "You dont have any slaves, prehaps you should invest in some?";
        } else {
            echo "You have <strong>" . $result->numRows() . "</strong> slaves. Keep your number of slaves up.";
        }

        break;

    case 'business':
        $result = $db->query("SELECT * FROM inventory WHERE owner = '" . $_SESSION['username'] . "' AND type = 'BUSINESS'");

        if ($result->numRows() <= 0) {
            echo "You've no businesses! Go to the shop, and buy some to start making money!";
            echo "<br /><br /><strong>Overall</strong>: Bad";
        } else {
            echo "You have </strong>" . count_rows($result) . "</strong> businsesses, nice going.";
            echo "<br /><br /><strong>Overall</strong>: Good";
        }

        break;

    case 'financial':
        if (\libAllure\Session::getUser()->getData('gold') <= 0) {
            echo "We are in debt! Try raising some more cash.";
            echo "<br /><br /><strong>Overall</strong>: Bad";
        } else {
            echo "We are not in debt, but make more money!";
            echo "<br /><br /><strong>Overall</strong>: Good";
        }

        break;

    case 'rankings':
        $turns = getTurns();
        $rank = (intval(($turns['total_turns'] * $user->getData('gold')) / 10000));

        if ($rank <= 20) {
            echo "You're rank is only <strong>" . $rank . "</strong>, you aught to try and improve this... Try making more money.";
            echo "<br /><br /><strong>Overall</strong>: Bad";
        } else {
            echo "You've got a rank of <strong>" . $rank . "</strong>, keep going!";
            echo "<br /><br /><strong>Overall</strong>: Good";
        }

        break;

    default:
        echo "Your $advisor advisor is currently not avalible.";
        break;
}

?>

<br /><br />
<a href = "javascript:window.close()">Close window</a>
</body>
