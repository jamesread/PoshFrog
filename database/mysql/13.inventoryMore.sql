-- +migrate Up
CREATE TABLE inventory_businessess LIKE inventory_buildings;
CREATE TABLE inventory_machines LIKE inventory_buildings;

-- +migrate Down
