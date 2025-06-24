-- +migrate Up
ALTER TABLE map_cells rename column entity to building_id;

-- +migrate Down
