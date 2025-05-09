--
-- Chane epicare_users storage engine to use forign keys
--
ALTER TABLE epicare_users ENGINE = InnoDB;

--
-- Creating table structure for table `epicare_events`
--

DROP TABLE IF EXISTS `epicare_events`;
CREATE TABLE IF NOT EXISTS `epicare_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  FOREIGN KEY (`user_id`) REFERENCES `epicare_users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Inserting data for table `epicare_events`
--

INSERT INTO epicare_events (user_id, event_type, event_date)
VALUES (1, 'Seizure', '2023-11-01');

--
-- Creating table structure for table `epicare_seizures`
--

DROP TABLE IF EXISTS `epicare_seizures`;
CREATE TABLE IF NOT EXISTS `epicare_seizures` (
  `seizure_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `seizure_type` varchar(255) DEFAULT NULL,
  `warnings` boolean,
  `sleep` boolean,
  `triggers` varchar(255) DEFAULT NULL,
  `psr` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  PRIMARY KEY (`seizure_id`),
  FOREIGN KEY (`user_id`) REFERENCES `epicare_users` (`user_id`),
  FOREIGN KEY (`event_id`) REFERENCES `epicare_events` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Inserting data for table `epicare_seizures`
--

INSERT INTO epicare_seizures (user_id, event_id, seizure_type, warnings, sleep, triggers, psr, location)
VALUES (1, 1, 'Generalized Tonic-Clonic', true, false, 'Stress', 'Confusion', 'Home');

--
-- Creating table structure for table `epicare_moods`
--

DROP TABLE IF EXISTS `epicare_moods`;
CREATE TABLE IF NOT EXISTS `epicare_moods` (
  `mood_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `mood_scale` int(11) DEFAULT NULL,
  PRIMARY KEY (`mood_id`),
  FOREIGN KEY (`user_id`) REFERENCES `epicare_users` (`user_id`),
  FOREIGN KEY (`event_id`) REFERENCES `epicare_events` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Inserting data for table `epicare_moods`
--

INSERT INTO epicare_moods (user_id, event_id, mood_scale)
VALUES (1, 1, 8);

--
-- Creating table structure for table `epicare_apps`
--

DROP TABLE IF EXISTS `epicare_apps`;
CREATE TABLE IF NOT EXISTS `epicare_apps` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `doctor_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`app_id`),
  FOREIGN KEY (`user_id`) REFERENCES `epicare_users` (`user_id`),
  FOREIGN KEY (`event_id`) REFERENCES `epicare_events` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Inserting data for table `epicare_apps`
--

INSERT INTO epicare_apps (user_id, event_id, doctor_name, location)
VALUES (1, 1, 'Doctor', 'RVI');