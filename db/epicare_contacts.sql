--
-- Creating table structure for table `epicare_contacts`
--

DROP TABLE IF EXISTS `epicare_contacts`;
CREATE TABLE IF NOT EXISTS `epicare_contacts` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone`int(11) NOT NULL,
  PRIMARY KEY (`contact_id`),
  FOREIGN KEY (`user_id`) REFERENCES `epicare_users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Inserting data for table `epicare_contacts`
--

INSERT INTO epicare_contacts (user_id, name, email, phone)
VALUES (1, 'Dr Jones', 'jones@northumbria.ac.uk', '12345678901');