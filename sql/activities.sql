CREATE TABLE `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `entity_id` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

ALTER TABLE projects add COLUMN loves VARCHAR(3000);
ALTER TABLE communities add column description varchar(1000);