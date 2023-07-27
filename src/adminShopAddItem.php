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

use libAllure\DatabaseFactory;
use libAllure\ElementInput;
use libAllure\ElementNumeric;
use libAllure\ElementSelect;
use libAllure\FormHandler;

class FormShopAdd extends \libAllure\Form
{
    public function __construct()
    {
        parent::__construct('addItem', 'Add Item');

        $this->addElement(new ElementInput('name', 'Name'));
        $this->addElement(new ElementInput('description', 'Description'));
        $this->addElement($this->getTypeElement());
        $this->addElement(new ElementNumeric('gold', 'Gold', 0));
        $this->addElement(new ElementNumeric('turns', 'Turns', 0));
        $this->addDefaultButtons('add');
    }

    private function getTypeElement() 
    {
        $el = new ElementSelect('type', 'Type');
        $el->addOption('SLAVE');
        $el->addOption('BUSINESS');
        $el->addOption('ACCESSORY');

        return $el;
    }

    public function process()
    {
        if ($this->getElementValue('type') == 'SLAVE') {
            $sql = 'INSERT INTO `slaves` (`name`, `gold` ) VALUES (:name, :gold)';
            $stmt = DatabaseFactory::getInstance()->prepare($sql);
        } else {
            $sql = 'INSERT INTO `shop` (`type`, `name`, `gold`, `turns`, `description`) VALUES (:type, :name, :gold, :turns, :description)';
            $stmt = DatabaseFactory::getInstance()->prepare($sql);
            $this->bindStatementValues($stmt, ['type', 'turns', 'description']);
        }

        $this->bindStatementValues($stmt, ['name', 'gold']);

        $stmt->execute();

        redirect('admin.php', "Item added successfully.");
    }
}

$fh = new FormHandler('formShopAdd', $tpl);

$title = "Add shop item";

require_once "includes/widgets/header.php";

$fh->handle();

require_once "includes/widgets/footer.php";
