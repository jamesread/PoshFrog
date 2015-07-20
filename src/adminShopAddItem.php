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

require_once("includes/common.php");

use \libAllure\DatabaseFactory;

if (isset($_GET['submit'])) {
	if (!is_numeric($_GET['gold'])) {
		$title = "Add shop item";
		require_once("includes/widgets/header.php");
		message(TYPE_ERROR, "Invalid gold field.");
	}

	if (!is_numeric($_GET['turns'])) {
		$title = "Add shop item";
		require_once("includes/widgets/header.php");
		message(TYPE_ERROR, "Invalid turns field.");
	}

	if ($_GET['type'] == "SLAVE") {
		$sql = "INSERT INTO `slaves` (`name`, `gold` ) VALUES ('" . $_GET['name'] . "', '" . $_GET['gold'] . "')";
	} else {
		$sql = "INSERT INTO `shop` (`type`, `name`, `gold`, `turns`, `description`) VALUES ('" . $_GET['type'] . "', '" . $_GET['name'] . "', '" . $_GET['gold'] . "', '" . $_GET['turns'] . "', '" . $_GET['type'] . "' )"; 	
	} 

	$stmt = DatabaseFactory::getInstance()->prepare($sql);
	$stmt->execute();

	$core->redirect('admin.php', "Item added successfully.");
}

$title = "Add shop item";
require_once("includes/widgets/header.php");

startBox($title, BOX_GREEN);
?>

<form action = "adminShopAddItem.php">
<label>Type <select name = "type">
	<option>BUSINESS</option>
	<option>SLAVE</option>
	<option>ACCESSORY</option>
</select></label><br /><br />
<label>Name <input name = "name" /></label><br /><br />
<label>Gold <input name = "gold" /></label><br /><br />
<label>Turns <input name = "turns" /></label><br /><br />
<label>Description<br /><textarea name = "description"></textarea></label><br /><br />
<input type = "submit" name = "submit" value = "add" />
</form>

<?php
stopBox(BOX_GREEN);

require_once("includes/widgets/footer.php");

?>
