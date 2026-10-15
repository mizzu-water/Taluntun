-- =====================================================================
-- Talunton RIASEC System - Admin Module migration
-- Run once against riasec_db (phpMyAdmin > SQL tab, or the mysql CLI):
--   C:\xampp\mysql\bin\mysql.exe -u root riasec_db < database/migrations/2026_10_15_admin_module.sql
-- Safe to re-run: columns/indexes use IF NOT EXISTS and the seed uses INSERT IGNORE.
-- =====================================================================

-- 1. Role + username on the existing users table.
--    Regular users keep role = 'user'; existing logins (by email) are unaffected.
ALTER TABLE `users`
    ADD COLUMN IF NOT EXISTS `role` ENUM('user','admin') NOT NULL DEFAULT 'user' AFTER `user_type`,
    ADD COLUMN IF NOT EXISTS `username` VARCHAR(50) NULL DEFAULT NULL AFTER `full_name`;

-- Usernames are optional (NULL allowed many times) but must be unique when set.
CREATE UNIQUE INDEX IF NOT EXISTS `uniq_users_username` ON `users` (`username`);
CREATE INDEX IF NOT EXISTS `idx_users_role` ON `users` (`role`);

-- Optional official website for each school (managed in Admin > Schools).
ALTER TABLE `colleges`
    ADD COLUMN IF NOT EXISTS `website` VARCHAR(255) NULL DEFAULT NULL AFTER `profile_url`;

-- 2. Seed the default administrator.
--    Username: admin
--    Password: admin 123   (stored ONLY as a bcrypt hash produced by password_hash())
--    CHANGE THIS PASSWORD before the site goes live (Admin > Accounts > Edit).
--    To generate a fresh hash instead, run:  php database/seed_admin.php
INSERT IGNORE INTO `users`
    (`full_name`, `username`, `email`, `password_hash`, `user_type`, `role`, `is_verified`)
VALUES
    ('System Administrator', 'admin', 'admin@talunton.local',
     '$2y$10$5XO9Bh71TKlv3BPQMVMOB.AgzwTubfkAIHOktqWuxdEewXil7P3w.',
     'professional', 'admin', 1);
