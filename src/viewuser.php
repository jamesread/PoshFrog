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

use libAllure\Session;
use libAllure\Sanitizer;
use libAllure\DatabaseFactory;

$san = Sanitizer::getInstance();

function transferGoldToPlayer($recipient, $amount) {
    $sql = "UPDATE `users` SET `gold` = (`gold` + :adjust) WHERE `username` = :username ";
    $stmt = DatabaseFactory::getInstance()->prepare($sql);
    $stmt->execute([
        ':adjust' => $amount,
        ':username' => $recipient,
    ]);


    $sql = "UPDATE `users` SET `gold` = (`gold` - :amount) WHERE `uid` = :uid ";
    $stmt = DatabaseFactory::getInstance()->prepare($sql);
    $stmt->execute([
        ':adjust' => $amount,
        ':uid' => Session::getUser()->getId(),
    ]);

    redirect("Money transfered", "viewuser.php?user=" . $recipient);

}

if ($san->hasInput('transfer')) {
    transferGoldToPlayer($san->filterString('recipient'), $san->filterUint('amount'));
}

$title = "index";
require_once "includes/widgets/header.php";

function getUser($id) {
    $sql = 'SELECT * FROM `users` WHERE `id` = :id LIMIT 1';
    $stmt = DatabaseFactory::getInstance()->prepare($sql);
    $stmt->execute([
        'id' => $id,
    ]);

    if ($stmt->numRows() == 0) {
        $tpl->error("User not found.");
    }

    return $stmt->fetchRow();
}

$row = getUser(Sanitizer::getInstance()->filterUint('user'));

    startBox($row['username'], BOX_GREEN);
    echo "<strong>Gold:</strong> " . $row['gold'] . "<br />";
    echo "<strong>Entities owned</strong>";

    $entities = getOwnedEntities();

    if (empty($entities)) {
        echo "<li>No slaves owned.</li>";
    } else {
        echo "<ul>";
        foreach($entities as $entity) {
            popup("<li>" . $entity['name'] . "</li>", "view_worker.php?slave= " . $entity['name']);
        }
        echo "</ul>";
    }

    popup("<strong>Player Ranking</strong>: ?", "help.php?topic=rankings");

stopBox(BOX_GREEN);

if (Session::getUser()->getUsername() != $_GET['user']) {
    ?>
<form action = "viewuser.php">
<input type = "hidden" name = "user" value = "<?php echo $_GET['user']; ?>" />
<table class = "normal">
<th>Money transfer</th>
<th>Amount</th>
<tr>
<td>Transfer some money from you account to this player.</td>
<td><input name = "transfer" /></td>
</tr>
<tr>
<td colspan = "2"><input type = "submit" value = "Transfer" /></td>
</tr>
</table>
</form>
    <?php
}

$tpl->assign('viewUser', $_GET['user']);
$tpl->display('viewUser.tpl');

require_once "includes/widgets/footer.php";

?>
