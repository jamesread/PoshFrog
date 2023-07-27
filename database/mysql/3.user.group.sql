-- +migrate Up
ALTER TABLE `users` ADD (`group` int not null default 1);
CREATE TABLE `group_memberships` (id int not null primary key auto_increment, `user` int not null, `group` int not null);
CREATE TABLE `permissions` (id int not null primary key, `key` varchar(128), description varchar(1024));

-- +migrate Down
