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

if (!isset($_REQUEST['submit'])) {
    $_GET['submit'] = "null";
}

use libAllure\DatabaseFactory;
use libAllure\Session;

switch ($_GET['submit']) {
    case 'loan':
        adjustUserGold(100);

        redirect('bank.php', 'Loan application approved!');
        break;

    case "deposit":
        $amount = intval($_REQUEST['amount']);

        adjustUserGold(-$amount, $amount);

        redirect('bank.php', "Gold deposited. Thank you.");

        break;

    case "withdraw":
        $amount = intval($_REQUEST['amount']);

        adjustUserGold($amount, -$amount);

        redirect('bank.php', "Gold withdrawn, with " . $game->getSetting('bankIntrestRate') . "% interest. Thank you.");

        break;

    default:
        break;
}

$title = "slaves";
require_once 'includes/widgets/header.php';

$user = \libAllure\Session::getUser();

startBox("Bank", BOX_YELLOW);
echo "You currently have <strong>" . $user->getData('gold') . "</strong> gold and <strong>";
echo $user->getData('bankgold') . "</strong> gold in the bank. <br /><br />";

//echo "The bank currently has an interest rate of <strong>" . $game->getSetting('bankInterestRate') . "%</strong>. ";
echo "With interest, you have <strong>";

$bankgold_original = $user->getData('bankgold');
$bankgold = $bankgold_original / 100;
$percent = $bankgold * 10;
$bankgold = $bankgold_original + $percent;
echo $bankgold;
echo "</strong> gold in the bank";
stopBox(BOX_YELLOW);

?>
<table class = "normal">
<tr>
        <th>deposit</th>
        <th>withdraw</th>
</tr>
<tr>
        <td>
        How much would you like to deposit?
        <form><input name = "amount">&nbsp;<input type = "submit" name = "submit" value = "deposit"></form>
        </td>

        <td>
        How much would you like to withdraw?
        <form><input name = "amount" />&nbsp;<input type = "submit" name = "submit" value = "withdraw"></form>
        </td>
</tr>
</table>
<?php

if ($user->getData('gold') <= 0) {
    startBox('Uh oh...', BOX_RED);
    echo 'You are a bankrupt tycoon. The bank offers you an <a href = "bank.php?submit=loan">emergency loan</a>. ';
    stopBox(BOX_RED);
}

require_once "includes/widgets/footer.php";

?>
