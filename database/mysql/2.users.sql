-- +migrate Up
CREATE TABLE `groups` (id int not null primary key auto_increment, title varchar(255));
CREATE TABLE `privileges_g` (permission int not null, `group` int not null);
CREATE TABLE `privileges_u` (permission int not null, `user` int not null);

-- +migrate Down
