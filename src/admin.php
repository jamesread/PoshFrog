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

$title = "index";
require_once ("includes/widgets/header.php");

if (Session::hasPriv('VIEW_ADMIN')) {
	redirect('index.php', 'You do not have the privileges to see this.');
}

if (isset($_GET['toggle'])) {
	if ($_GET['toggle'] == 'off') {
			$_SESSION['admin_mode'] = 'off';
		} else {
			$_SESSION['admin_mode'] = 'on';
	}
}

startBox("Toggle admin mode", BOX_RED);
echo "If you are an admin, and want to play the game via this account, admin mode might get in the way. You can turn it off to make playing the game
easier. <br /><br />";

echo "<form action = \"admin.php\">";
if ($user->inAdminMode()) {
	echo "<input type = \"hidden\" name = \"toggle\" value = \"on\" />";
	echo "<input type = \"submit\" value = \"Turn admin mode on\" />";
} else {
	echo "<input type = \"hidden\" name = \"toggle\" value = \"off\" />";
	echo "<input type = \"submit\" value = \"Turn admin mode off\" />";
}
echo "</form>";
stopBox(BOX_GREEN);

if ($user->inAdminMode()) {
	startBox("Shop Admin", BOX_BLUE);
	echo "<ul>";
	echo "<li><a href = \"adminShopAddItem.php\">Add item</a>";
	echo "</ul>";
	stopBox(BOX_BLUE);
}

require_once ("includes/widgets/footer.php");

?>
