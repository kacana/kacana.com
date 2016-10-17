
CREATE TABLE IF NOT EXISTS `kacana_product_gallery` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: gallery; 2:description',
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kacana_product_gallery`
--
ALTER TABLE `kacana_product_gallery`
  ADD PRIMARY KEY (`id`);