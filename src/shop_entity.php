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

require_once 'includes/widgets/header.minimal.php';

use libAllure\Session;
use libAllure\Form;

use function libAllure\util\stmt;
use function libAllure\util\san;

class FormBuy extends Form {
    private $id;
    private $gold;
    private $item;

    public function __construct() {
        parent::__construct('formBuy', 'Buy');

        $this->id = san()->filterUint('id');

        $this->addElementReadOnly('ID', $this->id, 'id');
        $this->addDefaultButtons('Buy');
    }

    public function getShopItem() {
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
        } else {
            $id = $this->getElementValue('id');
        }

        $stmt = stmt('SELECT * FROM entities WHERE id = :id LIMIT 1');
        $stmt->execute([
            'id' => $id,
        ]);

        return $stmt->fetchRow();
    }

    public function validateExtended() {
        $this->item = $this->getShopItem();
        $this->gold = getGold();
        //$this->turns = getTurns();

        if ($this->gold < $this->item['gold']) {
            $this->setValidatationError("You dont have enough gold. You need <strong>" . ($item['gold'] - $gold) . "</strong> more.");
            return;
        }

        if (false) { // check turns

        }
    }

    public function process() {
        $sql = 'UPDATE entities SET owner = :me WHERE id = :id';;
        $stmt = stmt($sql);
        $stmt->execute([
            'me' => Session::getUser()->getId(),
            'id' => $this->item['id'],
        ]);

        adjustUserGold($this->item['gold']);

        echo 'Purchased!';
    }
}

$f = new FormBuy();

if ($f->validate()) {
    $f->process();
} else {
    $item = $f->getShopItem();

    echo '<div class = "box">';
    echo '<h2 class = "green-box">' . $item['name'] . "</h2>";
    echo "<br /><br /><strong>Gold:</strong> ";
    echo $item['gold'];
    echo "<br /><br /><strong>Turns:</strong> ";
    echo $item['turns'];
    echo '</div><br/><br/>';

    $tpl->displayForm($f);
}

$showClose = true;
require_once 'includes/widgets/footer.php';
