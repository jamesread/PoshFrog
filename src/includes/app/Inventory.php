<?php

namespace pfrog;

use libAllure\Session;
use libAllure\Shortcuts as LA;

class Inventory {
    function getOwned($type) 
    {
        $sql = 'SELECT i.* FROM inventory_' . $type. ' i WHERE i.owner = :owner';
        $stmt = LA::stmt($sql);
        $stmt->execute([
            'owner' => Session::getUser()->getId()
        ]);

        return $stmt->fetchAll();
    }

    function buy($type, $id) 
    {
        $sql = 'UPDATE inventory_' . $type . ' SET owner = :me WHERE id = :id';;
        $stmt = LA::stmt($sql);
        $stmt->execute([
            'me' => Session::getUser()->getId(),
            'id' => $id,
        ]);

//        adjustUserGold(-$this->item['cost_gold']);
    }

    function get($type, $id) 
    {
        $sql = 'SELECT i.* FROM inventory_' . $type . ' i WHERE i.id = :id';
        $stmt = LA::stmt($sql);
        $stmt->execute([
            ':id' => $id,
        ]);

        return $stmt->fetchRow();
    }

    function getUnowned($type) 
    {
        $sql = 'SELECT * FROM `inventory_' . $type . '` WHERE `owner` is null';
        $stmt = LA::stmt($sql);
        $stmt->execute([
        ]);

        return $stmt->fetchAll();
    }

}
