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

require_once ("includes/common.php");

?>

<head>
<link rel = stylesheet href = includes/widgets/style.css>
	<title>Viewing slave.</title>
</head>

<body class = "noBgImage">

<?php

$slave = $HTTP_GET_VARS['slave'];
$result = db_query ("SELECT * FROM tycoonism_slaves WHERE name = '" . $slave . "' LIMIT 1");

if (count_rows($result) == 0) {
	message ( TYPE_ERROR, 'Cannot get slave info.');
}

while ($row = mysql_fetch_array($result)) {
	if ($userdata['gold'] < $row['gold']) {
		die ("This slave costs " . $row['gold'] . " gold, and you only have " . $userdata['gold'] . " gold. Come back another day. </body>");
	}

	switch($submit) {

	case 'buy slave':
		echo "<strong>Slave: </strong>" . $row['name'] . "<hr>";
		$result = db_query("UPDATE tycoonism_slaves SET `owner` = '" . $_SESSION['username'] . "' WHERE `id` = '" . $row['id'] . "'");
		$result = db_query("UPDATE tycoonism_users SET `gold` = (`gold` - " . $row['gold'] . ") WHERE `username` = '" . $_SESSION['username'] . "' LIMIT 1");
		die ("Thanks for buying " . $row['name'] . ".");
		break;

	case 'sell slave':
		echo "<strong>Slave: </strong>" . $row['name'] . "<hr>";
		$result = db_query("UPDATE tycoonism_slaves SET `owner` = '' WHERE `id` = '" . $row['id'] . "'");
		$amount = ($row['gold'] / 100) * 80;
		$result = db_query("UPDATE tycoonism_users SET `gold` = (`gold` + '" . $amount . "') WHERE `username` = '" . $_SESSION['username'] . "' LIMIT 1");
		die ("Your slave, <strong>" . $row['name'] . "</strong>, has been sold back to the shop for <strong>" . $amount . " </strong>gold");
		break;

	default:
		echo "<strong>Slave: </strong>" . $row['name'] . "<hr>";
		echo "<strong>Value: </strong>" . $row['gold'] . " gold. <br />";
		if ($row['owner'] == "") {
			echo "For sale! <br /><br />";
			echo "<form><div style = 'float:right;'><input type = submit name = submit value = 'buy slave'><input type = hidden name = slave value = " . $row['name'] . "></form></div>";
		} else {
			echo "<strong>Owner:</strong> " . $row['owner'];
			if ($row['owner'] == $_SESSION['username']) {
				echo "<br /><br /><form>You could sell this slave for 80% of its value...<br /><br /><div style = 'float:right'><input type = submit name = submit value = 'sell slave'><input type = hidden name = slave value = " . $row['name'] . "></div></form>";
			}
		}
		echo "<br /><br /><hr /><strong>Note:</strong> More expensive slaves dont actually preform any better, but genrally have cooler names.";

		break;

	}
}

?>

</body>
