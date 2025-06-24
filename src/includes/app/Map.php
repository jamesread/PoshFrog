<?php

namespace pfrog;

use libAllure\DatabaseFactory;

class Map {
    private int $mapId = 1;
    private array $cells = [];

    public function __construct() 
    {
        $this->getAllCells();
    }

    function getAllCells() {
        if ($this->cells == null) {
            $map = 1;
            $sql = "SELECT m.id, m.tileset, m.traversable, m.building_id, m.row, m.col FROM map_cells m LEFT JOIN inventory_buildings b ON m.building_id = b.id WHERE m.map = :map";
            $stmt = DatabaseFactory::getInstance()->prepare($sql);
            $stmt->execute([
                ':map' => $map,
            ]);

            $this->cells = [];

            foreach ($stmt->fetchAll() as $row) {
                $this->cells[$this->pos2key($row['row'], $row['col'])] = $row;
            }
        }

        return $this->cells;
    }

    private function pos2key($row, $col): string
    {
        return $row . '.' . $col;
    }

    public function getName(): string
    {
        return 'Alpha';
    }

    function getCell($row, $col) {
        $key = $this->pos2key($row, $col);

        if (!isset($this->cells[$key])) {
            $this->cells[$key] = $this->createCell($row, $col);
        }

        $cell = $this->cells[$key];

        $cell['selected'] = ($row == $_SESSION['selectedRow'] && $col == $_SESSION['selectedCol']);

        if ($cell['building_id'] != null) {
            $cell['tileset'] = 'shop_bussiness.jpg';
        }

        if ($cell['tileset'] == null) {
            $cell['tileset'] = 'tree.jpg';
        }

        return $cell;
    }

    private function createCell($row, $col) {
        $sql = 'INSERT INTO map_cells (row, col, map) VALUES (:row, :col, :map) ON DUPLICATE KEY UPDATE id = id';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->execute([
            ':row' => $row,
            ':col' => $col,
            ':map' => $this->mapId,
        ]);

        return $this->getNewCellFromDatabase($row, $col);
    }

    public function getSelectedCell() {
        return $this->getCell($_SESSION['selectedRow'], $_SESSION['selectedCol']);
    }

    public function setSelectedCell($row, $col) {
        if ($row == null || $col == null) {
            if (!isset($_SESSION['selectedRow']) || !isset($_SESSION['selectedCol'])) {
                $row = 1;
                $col = 1;
            } else {
                return;
            }
        }

        $_SESSION['selectedRow'] = $row;
        $_SESSION['selectedCol'] = $col;
    }

    private function getNewCellFromDatabase($row, $col) {
        $sql = "SELECT m.id, m.tileset, m.traversable, m.building_id, m.row, m.col FROM map_cells m LEFT JOIN inventory_buildings b ON m.building_id = b.id WHERE m.map = :map AND m.row = :row AND m.col = :col";
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->execute([
            ':row' => $row,
            ':col' => $col,
            ':map' => $this->mapId,
        ]);

        return $stmt->fetchRow();
    }
}
