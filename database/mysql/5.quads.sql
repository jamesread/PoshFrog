-- +migrate Up
ALTER TABLE quadrents ADD (owner int not null);

-- +migrate Down
