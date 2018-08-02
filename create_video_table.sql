use wordpress;

CREATE TABLE `wp_uploaded_video` (
  `video_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `author` bigint(20) unsigned NOT NULL,
  `uploaded_time` datetime NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`video_id`),
  KEY `fk_uploaded_video_1_idx` (`author`),
  CONSTRAINT `fk_uploaded_video_1` FOREIGN KEY (`author`) REFERENCES `wp_users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

