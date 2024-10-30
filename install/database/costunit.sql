SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


CREATE TABLE `%tablename%` (
                                 `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
                                 `treasurer_user_id` bigint DEFAULT NULL,
                                 `cost_unit_type` bigint UNSIGNED NOT NULL,
                                 `cost_unit_name` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `billing_deadline` date DEFAULT NULL,
                                 `distance_allowance` decimal(8,2) NOT NULL DEFAULT 0.25,
                                 `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `mail_on_new` tinyint(1) NOT NULL DEFAULT '0',
                                 `allow_new` tinyint(1) NOT NULL DEFAULT '1',
                                 `archived` tinyint(1) NOT NULL DEFAULT '0',
                                 `created_at` timestamp NULL DEFAULT NULL,
                                 `updated_at` timestamp NULL DEFAULT NULL,
                                 PRIMARY KEY  (id)

) %charset%;

ALTER TABLE `%tablename%`
    ADD PRIMARY KEY (`id`);


ALTER TABLE `%tablename%`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;


COMMIT;
