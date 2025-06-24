<?php

require_once 'includes/widgets/header.php';

use libAllure\Session;

$inv = new pfrog\Inventory(); 

$entitiesByType = [];

foreach ($game->getItemTypes() as $type) {
    $entitiesByType[] = [
        'name' => $type,
        'items' => $inv->getOwned($type),
    ];
}

$tpl->assign('entities', $entitiesByType);
$tpl->display('status.tpl');

require_once 'includes/widgets/footer.php';
