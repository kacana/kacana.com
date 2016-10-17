ALTER TABLE `kacana_users` ADD `user_type` INT NOT NULL AFTER `updated`;

CREATE TABLE IF NOT EXISTS `kacana_user_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kacana_user_type`
--
ALTER TABLE `kacana_user_type`
  ADD PRIMARY KEY (`id`);

  ALTER TABLE `kacana_users` CHANGE `status` `status` INT(11) NULL DEFAULT '1';