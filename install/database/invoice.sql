SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


CREATE TABLE `%tablename%` (
                                 `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
                                 `costunit_id` bigint UNSIGNED NOT NULL,
                                 `lfd_nummer` int NOT NULL,
                                 `status` ENUM('APPROVED','DENIED','EXPORTED','NOPAYOUT','NEW') NOT NULL DEFAULT 'NEW',
                                 `user_id` bigint UNSIGNED DEFAULT NULL,
                                 `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `contact_bank_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `contact_bank_iban` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `amount` decimal(8,2) NOT NULL,
                                 `distance` int DEFAULT NULL,
                                 `type` ENUM('Travelling','Program','Other','Accommodation','Catering') NOT NULL,
                                 `comment` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `changes` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `travel_direction` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `people_in_car` int DEFAULT NULL,
                                 `transport` tinyint(1) NOT NULL DEFAULT '0',
                                 `document_filename` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `approved_by` int DEFAULT NULL,
                                 `approved_on` datetime DEFAULT NULL,
                                 `denied_by` int DEFAULT NULL,
                                 `denied_reason` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 `created_at` timestamp NULL DEFAULT NULL,
                                 `updated_at` timestamp NULL DEFAULT NULL,
                                 PRIMARY KEY  (id)
) %charset%;

ALTER TABLE `%tablename%`
    ADD PRIMARY KEY (`id`);


ALTER TABLE `%tablename%`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

COMMIT;