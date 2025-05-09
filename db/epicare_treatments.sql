--
-- Creating table structure for table `epicare_treatments`
--

DROP TABLE IF EXISTS `epicare_treatments`;
CREATE TABLE IF NOT EXISTS `epicare_treatments` (
  `treatment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `dose` int(11) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `side_effects` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`treatment_id`),
  FOREIGN KEY (`user_id`) REFERENCES `epicare_users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Inserting data for table `epicare_treatments`
--

INSERT INTO epicare_treatments (user_id, name, dose, frequency, side_effects)
VALUES (1, 'carbamazepine', '200', 'daily', 'other');
