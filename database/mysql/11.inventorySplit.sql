-- +migrate Up
CREATE TABLE inventory_buildings LIKE entities;
ALTER TABLE inventory_buildings DROP COLUMN `type`;
ALTER TABLE inventory_buildings RENAME COLUMN `gold` TO `cost_gold`;
CREATE TABLE inventory_workers LIKE entities;
ALTER TABLE inventory_workers DROP COLUMN `type`;
ALTER TABLE inventory_workers RENAME COLUMN `gold` TO `cost_gold`;

-- +migrate Down
