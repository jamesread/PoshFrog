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

$title = 'help: ' . $_REQUEST['topic'];
require_once 'includes/widgets/header.minimal.php';

switch ($_REQUEST['topic']) {
    case 'rankings':
        echo "Ratings are calculated like this: ( turns / gold ), where turns is the total amount of turns the user has, effectivly, how long the user has been registerd, and gold, is the current amount of gold for that user. turns is devised by gold.";
        break;

    case 'pFrog':
        echo "pfrog is the script that powers this game. Programmed by xconspirisist, it is an anagram of 'Free Online RPG'.";
        break;

    case 'no_map_data':
        echo "This part of the quadrent has no data, it proberbly just hasnt been written yet, the admin should fix this by at least turning the cell into 'empty'.";
        break;

    default:
        echo "Could not find that topic, sorry, cant help. <br /><br />This shouldent happen, please send an email to <a href = 'mailto:xconspirisist@gmail.com'>xconspirisist</a>, or use the request form on the main technowax <a href = /help.php target = _blank>help page</a>.";
        break;
}

?>

<br /><br /><a href = "javascript:window.close()">Close</a>
</body>
