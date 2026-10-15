-- =====================================================================
-- Migration: Add session concurrency control columns to users table
--
-- Supports single-active-session concurrency for admin accounts:
-- - current_session_id: stores the active PHP session ID for the admin
-- - last_activity: timestamp of the last admin request / heartbeat
-- - last_login_ip: records IP address of the login for security audit
-- =====================================================================

ALTER TABLE `users`
    ADD COLUMN IF NOT EXISTS `current_session_id` VARCHAR(128) NULL DEFAULT NULL AFTER `role`,
    ADD COLUMN IF NOT EXISTS `last_activity` DATETIME NULL DEFAULT NULL AFTER `current_session_id`,
    ADD COLUMN IF NOT EXISTS `last_login_ip` VARCHAR(45) NULL DEFAULT NULL AFTER `last_activity`;

CREATE INDEX IF NOT EXISTS `idx_users_admin_session` ON `users` (`id`, `current_session_id`);
