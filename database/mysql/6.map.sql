-- +migrate Up
ALTER TABLE `map` ADD (`row` int not null, `col` int not null);

-- +migrate Down
