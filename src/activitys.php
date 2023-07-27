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
$title = "slaves";
require_once "includes/widgets/header.php";

$sql = "SELECT * FROM activitys";
$result = $db->query($sql);

startBox("Activities", BOX_GREEN);

echo "<ul>";
while ($activity = $result->fetchRow()) {
    popup("<li>" . $activity['name'] . "</li>", "do_activity.php?activity=" . $activity['name']);
}
echo "</ul>";
stopBox(BOX_GREEN);

require_once "includes/widgets/footer.php";
