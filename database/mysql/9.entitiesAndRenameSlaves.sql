-- +migrate Up
DROP TABLE slaves;
DROP TABLE inventory;
ALTER TABLE shop RENAME TO entities;
ALTER TABLE entities CHANGE `type` `type` varchar(64);
ALTER TABLE entities ADD owner int DEFAULT null;

-- +migrate Down
