-- +migrate Up
ALTER TABLE `map` ADD (`entity` int null);

-- +migrate Down
