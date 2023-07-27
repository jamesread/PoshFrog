-- +migrate Up
ALTER TABLE users ADD lastLogin datetime;

-- +migrate Down
