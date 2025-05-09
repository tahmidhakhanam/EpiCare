--
-- Creating table structure for table `epicare_community`
--

DROP TABLE IF EXISTS `epicare_community`;
CREATE TABLE IF NOT EXISTS `epicare_community` (
  `community_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `comm_date` datetime DEFAULT NULL,
  PRIMARY KEY (`community_id`),
  FOREIGN KEY (`user_id`) REFERENCES `epicare_users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Inserting data for table `epicare_community`
--


INSERT INTO epicare_community (user_id, message, comm_date)
VALUES (1, 'Welcome to EpiCare!', '2023-11-01');