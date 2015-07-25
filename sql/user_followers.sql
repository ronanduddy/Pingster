CREATE TABLE `users_followers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL REFERENCES users(id),
  `follower_id` bigint(20) unsigned NOT NULL REFERENCES users(id),
  PRIMARY KEY (`id`)
);

ALTER TABLE users add column verified_email BOOLEAN NOT NULL DEFAULT TRUE;