-- +migrate Up
ALTER TABLE users ADD location varchar(128);

-- +migrate Down
