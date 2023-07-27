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

use libAllure\DatabaseFactory;

?>

<head>
<link rel = stylesheet href = includes/widgets/style.css>
    <title>Do activity.</title>
</head>

<body class = "noBgImage">
<?php

$activity = $_GET['activity'];

$stmt = DatabaseFactory::getInstance()->prepare("SELECT * FROM activitys WHERE name = '" . $activity . "' LIMIT 1");
$stmt->execute();

foreach ($stmt->fetchAll() as $row) {
    echo "<strong>";
    echo $row['name'];
    echo "</strong><hr>";

    if (isset($_GET['action'])) {
        $sql = "UPDATE `users` SET `gold` = (`gold` + " . $row['gold'] . "), `usedturns` = (`usedturns` + " . $row['turns'] . ") WHERE `username` = '" . $userdata['username'] . "' LIMIT 1";
        $result2 = DatabaseFactory::getInstance()->prepare($sql);

        if ($result2) {
            echo "Thanks for doing the " . $row['name'] . ".";
        } else {
            message(TYPE_ERROR_SQL, "Cannot update user table.");
        }
    } else {
        $turns =  get_turns($_SESSION['username']);
        $turns = $turns['turns'];

        if ($turns >= $row['turns']) {
            echo "This will take " . $row['turns'] . " turns, you will earn " . $row['gold'] . " gold.";
            echo "<br /><br /><div align = right><form><input type = hidden name = activity value = '" . $activity . "'><input type = submit name = action value = 'do it'></form></div>";
        } else {
            echo "You dont have enough turns avalible to do this!";
        }
    }
}


?>
</body>
