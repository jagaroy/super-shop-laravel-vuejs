ALTER TABLE `net_users` CHANGE `net_user_expiration` `net_user_expiration` DATE NULL; 

22-03-2024
ALTER TABLE `users` ADD `authored_by` INT NOT NULL AFTER `status`;
UPDATE `users` SET `authored_by` = '1' WHERE `users`.`id` = 1;
UPDATE `users` SET `authored_by` = '1' WHERE `users`.`id` != 1;

22-03-2024
ALTER TABLE `incomes` CHANGE `remarks` `remarks` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL; 