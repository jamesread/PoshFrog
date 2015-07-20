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

if (isset($_GET['transfur'])) {
	$sql = "UPDATE `users` SET `gold` = (`gold` + '" . $_GET['transfur'] . "' ) WHERE `username` = '" . $_GET['user'] . "' ";
	$result = db_query($sql);

	$sql = "UPDATE `users` SET `gold` = (`gold` - '" . $_GET['transfur'] . "' ) WHERE `username` = '" . $_SESSION['username'] . "' ";
	$result = db_query($sql);

	echo mysql_error();

	redirect("Money transfured", "viewuser.php?user=" . $_GET['user']);
}

$title = "index";
require_once "includes/widgets/header.php";

$sql = 'SELECT * FROM `users` WHERE `id` = "' . $_REQUEST['user']. '" LIMIT 1';
$result = $db->query($sql);

if ($result->numRows() == 0) {
	$tpl->error("User not found.");
}

while ($row = $result->fetchRow()) {

startBox($row['username'], BOX_GREEN);
echo "<strong>Gold:</strong> " . $row['gold'] . "<br />";
$temp = get_turns( $row['username'] );
$total_turns = intval($temp['total_turns']);
echo "<strong>Total Turns</strong>: $total_turns <br/>";
echo "<strong>Slaves owned</strong>";
$result2 = $db->query("SELECT * FROM slaves WHERE user = '" . $row['username'] . "'");

echo "<ul>";
if ($result2->numRows() == 0) {
	echo "<li>No slaves owned.</li>";
} else {
	while ($row2 = mysql_fetch_array ($result2)) {
		popup ( "<li>" . $row2['name'] . "</li>", "view_slave.php?slave= " . $row2['name'] );
	}
}
echo "</ul>";

$ranking = (intval(($total_turns * $row['gold']) / 10000));
popup ("<strong>Player Ranking</strong>: ", "help.php?topic=rankings"); echo $ranking;

}

stopBox(BOX_GREEN);

if ($_SESSION['username'] != $_GET['user']) {
?>
<form action = "viewuser.php">
<input type = "hidden" name = "user" value = "<?php echo $_GET['user']; ?>" />
<table class = "normal">
<th>Money transfur</th>
<th>Amount</th>
<tr>
<td>Transfur some money from you account to this player.</td>
<td><input name = "transfur" /></td>
</tr>
<tr>
<td colspan = "2"><input type = "submit" value = "Transfur" /></td>
</tr>
</table>
</form>
<?php
}

require_once ("includes/widgets/footer.php");

?>
