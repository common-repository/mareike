SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


CREATE TABLE `%tablename%` (
                                 `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
                                 `pagetext_slug` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `pagetext_content` varchar(8192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                 PRIMARY KEY  (id)
) %charset%;

ALTER TABLE `%tablename%`
    ADD PRIMARY KEY (`id`);


ALTER TABLE `%tablename%`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

COMMIT;