-- +migrate Up
ALTER TABLE shop CHANGE `type` `type` enum('BUSINESS', 'ACCESSORY') DEFAULT 'BUSINESS';

-- +migrate Down
