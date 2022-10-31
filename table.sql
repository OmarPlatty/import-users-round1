create table if not exists user_export
(
    userId     bigint auto_increment primary key,
    username   varchar(100)         null,
    email      varchar(100)         null,
    firstName  varchar(100)         null,
    registered datetime             null,
    city       varchar(100)         null,
    country    varchar(100)         null,
    language   varchar(100)         null,
    phone      varchar(100)         null,
    imported   tinyint(1) default 0 not null,
    emailed    tinyint(1) default 0 not null,
    user_id    bigint default 0 not null
);
ALTER TABLE `user_export` ADD INDEX `email_index` (`email`);
ALTER TABLE `user_export` ADD INDEX `username_index` (`username`);
ALTER TABLE `user_export` ADD INDEX `imported_index` (`imported`);
ALTER TABLE `user_export` ADD INDEX `user_id_index` (`user_id`);


INSERT INTO wp_usermeta (umeta_id, user_id, meta_key, meta_value) VALUES (1202662, 37606, 'nickname', 'OmarTest');
INSERT INTO wp_usermeta (umeta_id, user_id, meta_key, meta_value) VALUES (1202663, 37606, 'first_name', 'Omar Corrales');
INSERT INTO wp_usermeta (umeta_id, user_id, meta_key, meta_value) VALUES (1202664, 37606, 'last_name', '');
INSERT INTO wp_usermeta (umeta_id, user_id, meta_key, meta_value) VALUES (1202665, 37606, 'description', '');
INSERT INTO wp_usermeta (umeta_id, user_id, meta_key, meta_value) VALUES (1202666, 37606, 'rich_editing', 'true');
INSERT INTO wp_usermeta (umeta_id, user_id, meta_key, meta_value) VALUES (1202667, 37606, 'syntax_highlighting', 'true');
INSERT INTO wp_usermeta (umeta_id, user_id, meta_key, meta_value) VALUES (1202668, 37606, 'comment_shortcuts', 'false');
INSERT INTO wp_usermeta (umeta_id, user_id, meta_key, meta_value) VALUES (1202669, 37606, 'admin_color', 'fresh');
INSERT INTO wp_usermeta (umeta_id, user_id, meta_key, meta_value) VALUES (1202670, 37606, 'use_ssl', '0');
INSERT INTO wp_usermeta (umeta_id, user_id, meta_key, meta_value) VALUES (1202671, 37606, 'show_admin_bar_front', 'true');