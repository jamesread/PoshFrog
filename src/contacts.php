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
$title = "index";
require_once ("includes/widgets/header.php");

startBox("Advisors", BOX_GREEN);

echo "<ul>";
popup ("<li>Financial</li>", "advisors.php?advisor=financial");
popup ("<li>Business</li>", "advisors.php?advisor=business");
popup ("<li>Rankings</li>", "advisors.php?advisor=rankings");
popup ("<li>Slaves</li>", "advisors.php?advisor=slaves");
echo "</ul>";

stopBox(BOX_GREEN);
startBox("Staff", BOX_GREEN);

echo "<ul>";
popup ("<li>Chauffeur</li>", "staff.php?staff=chauffer");
popup ("<li>Golf Coach</li>", "staff.php?staff=Golf Coach");
echo "</ul>";

stopBox(BOX_GREEN);
startBox("Other Players...", BOX_GREEN);

$sql = "SELECT * FROM users LIMIT 10";
$result = $db->query($sql);

echo "<ul>";
while ($row = $result->fetchRow()) {
	echo "<li><a href = viewuser.php?user=" . $row['username'] . ">" . $row['username'] . "</a></li>";
}
echo "</ul>";

stopBox(BOX_GREEN);

//echo "Checkout the <a href = leaderboard.php>leaderboard</a>?";

require_once ("includes/widgets/footer.php");

?>
