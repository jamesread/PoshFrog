<?php

require_once 'includes/widgets/header.php';

use libAllure\Session;

$entities = getOwnedEntities();
$entitiesByType = [];

foreach (getOwnedEntities() as $entity) {
    if (!isset($entitiesByType[$entity['type']])) {
        $entitiesByType[$entity['type']] = [
            'name' => $entity['type'],
            'items' => [],   
        ];
    }

    $entitiesByType[$entity['type']]['items'][] = $entity;
}

$tpl->assign('entities', $entitiesByType);
$tpl->display('status.tpl');

require_once 'includes/widgets/footer.php';
