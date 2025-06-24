<?php

$title = 'Build!';
require_once 'includes/widgets/header.minimal.php';

use \libAllure\Form;
use \libAllure\FormHandler;
use \libAllure\DatabaseFactory;
use \libAllure\Session;
use \libAllure\ElementSelect;
use pfrog\Inventory;
use pfrog\Map;

class FormBuild extends Form {
    public function __construct() {
        $san = \libAllure\Sanitizer::getInstance();
        $inv = new Inventory();

        $el = new ElementSelect('building', 'Building');

        foreach ($inv->getOwned('buildings') as $ent) {
            $el->addOption($ent['name'], $ent['id']);
        }

        $this->addElement($el);

        $map = new Map();
        $row = $san->filterUint('row');
        $col = $san->filterUint('col');

        $cell = $map->getCell($row, $col);

        var_dump($row, $col, $cell);

        $this->addElementReadOnly('Map Cell', $cell['id'], 'mapCellId');

        $this->addDefaultButtons('Buiild');
    }

    public function process() 
    {
        var_dump($this->getElementValue('building'));
        $sql = 'UPDATE inventory_buildings b SET b.map_cell = :mapCellId WHERE b.id = :buildingId LIMIT 1 ';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->execute([
            ':buildingId' => $this->getElementValue('building'),
            ':mapCellId' => $this->getElementValue('mapCellId'),
        ]);

         $sql = 'UPDATE map_cells c SET c.building_id = :buildingId WHERE c.id = :mapCellId LIMIT 1 ';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->execute([
            ':buildingId' => $this->getElementValue('building'),
            ':mapCellId' => $this->getElementValue('mapCellId'),
        ]);
    }
}

$fh = new FormHandler(new FormBuild());
$fh->handle();

require_once 'includes/widgets/footer.php';
