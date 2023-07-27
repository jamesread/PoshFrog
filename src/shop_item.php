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

?>

<head>
<link rel = stylesheet href = includes/widgets/style.css>
</head>

<body>

<?php

$item = $HTTP_GET_VARS['item'];
$result = db_query("SELECT * FROM tycoonism_shop WHERE name = '" . $item . "' LIMIT 1");

if (count_rows($result) == 0) {
    message(TYPE_ERROR, 'Cannot get item info.');
}

while ($row = mysql_fetch_array($result)) {
    echo "<strong>" . $row['name'] . "</strong><hr>";
    $temp = get_userdata($_SESSION['username']);
    $gold = $temp['gold'];

    $turns = get_turns($_SESSION['username']);

    if ($gold >= $row['gold']) {
        if ($turns['turns'] >= $row['turns']) {
            if (isset($HTTP_GET_VARS['submit'])) {
                db_query("INSERT INTO `tycoonism_inventory` ( `owner` , `item` , `type` ) VALUES ( '" . $_SESSION['username'] . "', '" . $row['name'] . "', '" . $row['type'] . "' )");
                db_query("UPDATE tycoonism_users SET `gold` = (`gold` - " . $row['gold'] . "), `usedturns` = (`usedturns` + " . $row['turns'] . " ) WHERE username = '" . $_SESSION['username'] . "'");
                die("done");
            } else {
                echo "<strong>Description:</strong> " . $row['description'];
                echo "<br /><br /><strong>Gold:</strong> ";
                echo $row['gold'];
                echo "<br /><br /><strong>Turns:</strong> ";
                echo $row['turns'];
            }
        } else {
            die("You dont have enough turns. You need <strong>" . $row['turns'] . "</strong>");
        }
    } else {
        die("You dont have enough gold. You need <strong>" . $row['gold'] . "</strong>");
    }
}

?>

<br /><div style = "float:right;"><form><input type = submit name = submit value = buy><input name = item type = hidden value = '<?php echo $item; ?>'></form></div>
</body>
