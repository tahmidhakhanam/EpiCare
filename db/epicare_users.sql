--
-- Creating table structure for table `epicare_users`
--

DROP TABLE IF EXISTS `epicare_users`;
CREATE TABLE IF NOT EXISTS `epicare_users` (
`user_id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Inserting data for table `epicare_users`
--

INSERT INTO `epicare_users` (`user_id`, `firstname`, `surname`, `username`, `password_hash`) VALUES
(1, 'John', 'Smith', 'user1234', '$2y$10$241VguAQ6fD12z38.FQ/bul3NU8yYoIXPQSbeN6lU5nSlyJsLVjgG'),
(2, 'Jane', 'Smith', 'user1235', '$2y$12$.qCR0Q/n9Q6694mmqyV8O.A8.oI4JjaUIWIZkGaPRm9Gn3NwZnh8K');

--
-- Indexes for table `epicare_users`
--
ALTER TABLE `epicare_users`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for table `epicare_users`
--
ALTER TABLE `epicare_users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;