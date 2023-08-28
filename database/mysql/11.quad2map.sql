-- +migrate Up
ALTER TABLE `map` RENAME TO map_cells;
ALTER TABLE `map_cells` RENAME COLUMN `quadrent` TO `map`;
ALTER TABLE quadrents RENAME TO maps;

-- +migrate Down
