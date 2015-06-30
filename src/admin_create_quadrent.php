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

$title = "Create Quadrent";
require_once 'includes/widgets/mini_header.php';

if (isset($_REQUEST['submit'])) {
	$sql = 'INSERT INTO `quadrents` (`name`) VALUES ("' . $_REQUEST['name'] . '")';
	$result = $db->query($sql);

	echo 'done', '<a href = "javascript:window.close()">Close</a>';
	exit;
} else {
	echo "<form>";
	echo '<input name = "name">';
	echo '<input name = "submit" value = "add" type = "submit">';
	echo "</form>";

	$sql = "SELECT * FROM `quadrents` ORDER BY `id`";
	$result = $db->query($sql);

	echo "<ol>";
	while ($quadrents = $result->fetchRow()) {
		echo "<li>" . $quadrents['name'] . "</li>";
	}
	echo "</ol>";
}
?>

</body>
</html>
