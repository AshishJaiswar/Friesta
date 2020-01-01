-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2019 at 03:15 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialnetwork`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `posted_at` datetime NOT NULL,
  `post_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `user_id`, `posted_at`, `post_id`) VALUES
(1, 'hey buddy whats up?', 2, '2019-10-19 19:13:36', 12),
(2, 'My nigga', 2, '2019-10-19 19:19:30', 8),
(3, 'Nice post', 2, '2019-11-24 19:14:59', 34),
(4, 'Wow i like it', 2, '2019-11-24 19:16:29', 33),
(5, 'Yes im fine', 2, '2019-11-24 19:18:50', 32),
(6, 'Hey dude', 2, '2019-11-24 19:26:00', 8),
(7, 'Nice post dude and nigga', 2, '2019-11-24 19:34:38', 8);

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `follower_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `user_id`, `follower_id`) VALUES
(5, 2, 3),
(7, 3, 4),
(8, 4, 2),
(12, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `login_tokens`
--

CREATE TABLE `login_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `token` char(64) NOT NULL DEFAULT '',
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_tokens`
--

INSERT INTO `login_tokens` (`id`, `token`, `user_id`) VALUES
(38, '9d9f3ac376c9642388911685e2a0f56fe64b8318', 2),
(39, 'c5b5f189c4c4ef5d7f0efaf092fc4a73b341d578', 4),
(41, '8c1123a4154e623682085b6aec1b8534280e22eb', 2),
(48, '4e662ff0ac928cd3528549d20e810256359f8b8a', 2),
(49, 'a1defce5bcfab1653cafe39d934b6c17d664c130', 4),
(51, '228053b4e051adb35a6b305e06acdc5c935cf0d2', 4),
(56, '502c47b868fbbaf56d0bf814e0b374168f1b25e5', 3),
(59, '949d70e203cc5a19f36bd388bdd3d42337ba5d76', 3),
(60, '18b65af66aadd06bd679d5ed5f34767eaae78da1', 2),
(61, '0ee5f1a0edcbd11c436315a99eaf53c3626267ba', 2),
(62, '81363d127a3d458db1447bc757daddd450c1e6bb', 2),
(63, '1d6b5a8a8ecbf35a8f50f102b9f4b9e83144ad64', 2),
(64, '962f87aa43641c53db020765482e78018ff6468a', 2),
(65, '1d87e00f34400e94473c305e736bc9492ab7efff', 3),
(67, 'c2b2f9e1751705b981f97160a8339686b08aa08e', 2),
(71, '4b008ac19e02f86b94fdbe7d9ff007e69caa667a', 2),
(72, 'a9fa747dd4f2c3802eb79b526aadbb961bff0fbb', 2),
(73, '7d666f709edfa93233daeffe64c0cd9c59941c7f', 2),
(74, 'a719ac7cdd849f567ba3b3b0d817a2696f91b780', 2),
(75, 'e12d68230dabbafe32b0ee4ce7bc2f1ebe3f2f81', 2),
(76, 'ca9f9d6e9fb745a2a44f07f7642b6333cfd2f154', 2),
(79, '5d4ba2863304ccc6d68bc9fdaf3234aea8713d20', 2),
(80, '3af44d6b0f41bdb40e96006e82345ed5ca4d4e9c', 2),
(86, '25cef9e2dd8448f4bfcb78611278f30eadb50e29', 3),
(87, '5991246c9092ca70a26601a0eaa050fdc938661c', 3),
(88, '0c076760c4139a4839fd82f338aa3908d694c8c6', 2);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `sender` int(11) UNSIGNED NOT NULL,
  `receiver` int(11) UNSIGNED NOT NULL,
  `read` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `body`, `sender`, `receiver`, `read`) VALUES
(1, 'He buddy', 2, 3, 0),
(2, 'Ashish4 How are you', 2, 4, 1),
(3, 'Fine bro', 4, 2, 0),
(4, 'Whats up?', 3, 2, 0),
(5, 'Hey user 5', 2, 5, 0),
(6, 'Message to user 6', 2, 6, 0),
(7, 'Where are you ', 2, 4, 0),
(8, '?', 2, 4, 0),
(9, 'Meet u soon', 2, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` int(11) UNSIGNED NOT NULL,
  `receiver` int(10) UNSIGNED NOT NULL,
  `sender` int(11) UNSIGNED NOT NULL,
  `extra` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `receiver`, `sender`, `extra`) VALUES
(1, 1, 3, 2, ''),
(2, 1, 3, 2, ' { \"postbody\": \"@Ashish2 how are you\" } '),
(3, 1, 3, 2, ' { \"postbody\": \"@Ashish2 My nigga its Awesome\" } '),
(4, 2, 3, 3, ''),
(5, 2, 4, 4, ''),
(6, 1, 3, 2, ' { \"postbody\": \"Hey @Ashish2 how are you\" } ');

-- --------------------------------------------------------

--
-- Table structure for table `password_tokens`
--

CREATE TABLE `password_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `token` char(64) NOT NULL DEFAULT '',
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password_tokens`
--

INSERT INTO `password_tokens` (`id`, `token`, `user_id`) VALUES
(1, '0fe808f91dbc389f75a8f06b767565bc3140b727', 1),
(2, '8636b33dd8495209f6a50a9e53fd82764d082857', 1),
(3, 'b067e12bab5072ba739375bce0d06df5c3165124', 1),
(4, '5cc097c63bfdd363e072efe050c1bee9d2160573', 1),
(5, 'ea9c720bf89c0506cc9111b82f5fbe4502996da0', 1),
(6, '5c17d12337dea29ac87a8e8e9c1993b055299655', 1),
(7, '11679fe791c366db157210f2773e240246a2ac3d', 1),
(8, '7f67443b9bbc5ed114267468652170d2f87a591f', 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `body` varchar(160) NOT NULL DEFAULT '',
  `posted_at` datetime NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `likes` int(11) UNSIGNED NOT NULL,
  `postimg` varchar(255) DEFAULT NULL,
  `topics` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `posted_at`, `user_id`, `likes`, `postimg`, `topics`) VALUES
(8, 'Tuesday', '2019-10-19 16:46:43', 4, 5, '', ''),
(10, 'Ibrahim', '2019-10-19 16:49:26', 3, 0, '', ''),
(11, 'Shivam', '2019-10-19 16:49:32', 3, 1, '', ''),
(12, 'Abhi', '2019-10-19 16:49:37', 3, 3, '', ''),
(13, 'Prjwalddsljfs', '2019-10-19 17:06:15', 2, 1, '', ''),
(14, 'Vikas Nibba', '2019-10-19 17:09:29', 2, 0, '', ''),
(15, 'Hey bro', '2019-10-21 12:25:37', 2, 0, '', ''),
(18, 'Its working fine', '2019-10-21 12:31:35', 2, 0, 'https://i.imgur.com/a29hEzM.jpg', ''),
(32, 'He my buddy how are you I think you are fine ', '2019-10-29 10:05:17', 3, 0, '', ''),
(33, '@Vikas how are you', '2019-11-03 10:13:43', 3, 0, '', ''),
(34, '#php', '2019-11-03 10:14:46', 3, 0, '', 'php,'),
(35, ' Post done sucessfully', '2019-11-25 16:28:32', 2, 0, '', ''),
(36, ' Post testing 1', '2019-11-25 16:29:21', 2, 0, '', ''),
(37, ' Posting testing 2', '2019-11-25 16:30:27', 2, 0, '', ''),
(38, ' Posting testing 3', '2019-11-25 16:31:11', 2, 0, '', ''),
(39, '  Posting Testing 3', '2019-11-25 16:33:26', 2, 0, '', ''),
(43, ' Hey', '2019-11-25 16:45:02', 2, 0, '', ''),
(45, 'Posting test 4', '2019-11-25 16:49:38', 2, 0, '', ''),
(46, 'Hey Shivam meet me tommrow', '2019-11-25 20:33:28', 2, 0, '', ''),
(47, 'ttttt', '2019-12-06 12:17:30', 2, 0, '', ''),
(48, 'Posting with image', '2019-12-08 11:21:59', 2, 0, '', ''),
(49, 'Posting with Image ', '2019-12-08 11:23:00', 2, 0, 'https://i.imgur.com/Kal5eZm.png', ''),
(50, 'Posting done test 1', '2019-12-08 11:28:40', 2, 0, '', ''),
(51, 'Posting done test2', '2019-12-08 11:29:04', 2, 1, 'https://i.imgur.com/0H14xWu.jpg', ''),
(52, 'New Post is Here', '2019-12-11 15:02:27', 2, 0, '', ''),
(53, 'Ashish Jaiswar', '2019-12-11 15:05:36', 2, 0, 'https://i.imgur.com/mriGj4W.jpg', ''),
(54, 'Shivam Sukla', '2019-12-11 15:06:58', 2, 0, '', ''),
(55, 'Harry Potter', '2019-12-11 15:08:15', 2, 0, 'https://i.imgur.com/Uy497tx.jpg', ''),
(56, 'Hey @Ashish2 how are you', '2019-12-14 11:18:13', 2, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(11) UNSIGNED NOT NULL,
  `post_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`id`, `post_id`, `user_id`) VALUES
(14, 6, 3),
(15, 6, 2),
(16, 8, 4),
(17, 12, 3),
(18, 11, 3),
(21, 13, 2),
(30, 24, 2),
(33, 27, 2),
(67, 0, 2),
(124, 8, 3),
(127, 9, 3),
(130, 9, 2),
(133, 12, 2),
(135, 8, 2),
(136, 51, 2);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50),
  `lives_in` varchar(50) DEFAULT NULL,
  `relationship` varchar(20) DEFAULT NULL,
  `joined_by` datetime DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `fullname`, `lives_in`, `relationship`, `joined_by`, `bio`, `username`) VALUES
(1, 'Ashish Jaiswar', 'Airoli', 'single', '2019-10-10 00:00:00', 'A student of computer science', 'Ashish1'),
(2, '', '', '', '2019-10-10 00:00:00', '', 'Ashish2'),
(3, '', '', '', '2019-12-12 12:32:11', '', 'Shivam');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `profileimg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`, `profileimg`) VALUES
(1, 'Ashish', '$2y$10$Sosym142RIxVqWrPMZla6OH7vbdx4ge7bjujI6Ei/IIFnWU41/6uG', 'AshishJaiswar777@gmail.com', 0, 'https://i.imgur.com/owS76PV.png'),
(2, 'Ashish1', '$2y$10$9FEMgTAezBHwYkn4RLUKj.TSPgfBhP7TKfclfZb2I1z/WQkJprF.O', 'admin@admin.com', 1, 'https://i.imgur.com/QtqqYxx.jpg'),
(3, 'Ashish2', '$2y$10$RLMpJU7zLGQrpeAL0BxpmewaspHUh3gfY7ojqKKVimt2AUixWEJPW', 'Ashish2@gmail.com', 0, 'https://i.imgur.com/owS76PV.png'),
(4, 'Ashish4', '$2y$10$NlRWetJ1lsZiTYhuyIM5oet0uMNruKjYU4W0cPV9rgxwAmZJ4oWcO', 'Ashish$@gmail.com', 0, 'https://i.imgur.com/owS76PV.png'),
(5, 'as ', '$2y$10$OQTez6c8lm8Y1Z.LVXLe7.Qf2CmNtcsjJVfAeT871Ek4RgqLccHV2', 'fhfgh#@gmail.com', 0, 'https://i.imgur.com/owS76PV.png'),
(6, 'asd', '$2y$10$gudgzdOjG436CNGSXE7lCem3qvuYT3/esKHDby/gNBn2BNo7j9tUC', 'dsfdg@dfg.com', 0, 'https://i.imgur.com/owS76PV.png'),
(7, 'Ashish/   ', '$2y$10$KBqig8ll.ik8NO1P9rJrwOdzoWQP/KGgUvus7ddChhYDg.O8gb4a6', 'dsfg@dfg.com', 0, 'https://i.imgur.com/owS76PV.png'),
(8, 'as4dgfgd=-', '$2y$10$/LYIyOknifwoPd9vZPpzneYcnsY/GJKTU/OrEvUe565hkR/w574lq', 'gdsdbgjdf@gamil.com', 0, 'https://i.imgur.com/owS76PV.png'),
(9, 'ashish5', '$2y$10$Cv6.1gkuuiyT5cNiKMHQjenEfepDoKyAuH4qmSGOrNUJNlKXu27.K', 'Ashish5@gmail.com', 0, 'https://i.imgur.com/owS76PV.png'),
(10, 'ashish6', '$2y$10$TMTpy4OOel1OyahgXA8jG.P2RsOBI0XxG0L3yTGwRa0YbBtf6efEK', 'Ashish6@gmail.com', 0, 'https://i.imgur.com/owS76PV.png'),
(11, 'ashish7', '$2y$10$BN6ZVXAdFnJiRz0LyLyNouJbAkmTNac4ChJWi9rT9FS8TJwAu5N3S', 'Ashish7@gmail.com', 0, NULL),
(12, 'Ashish8', '$2y$10$a.MpYfwzFNw0GB0qM6otr.mv.xIfhufXAAMNwMutSTJnAzATt1KOi', 'Ashish8@gmail.com', 0, NULL),
(13, 'ashish9', '$2y$10$65pmYwF04GvIaEFNzwsER.VGRuzZpbyuoI6LR/bkkwi3D2aom6Sj6', 'Ashish9@gamil.com', 0, NULL),
(14, 'ashish10', '$2y$10$qSVYR0ofmIyZE4XXIbI.ZeOVs08lCKoS8w.2J7lKqK5kcaMBC5yPm', 'shfihf@hsjhf.com', 0, NULL),
(15, 'ashish11', '$2y$10$ynpdl2SnLbA5F83uZJDCk.U0J4xffqXAPtzI3DHOwkxBdoxb3EZXe', 'Ashish11@hsd.cim', 0, NULL),
(16, 'ashish12', '$2y$10$YdYuuBZ8mqSYOK7aZE4r7u/Uo.VieVmhP56CzS/sisvtdFLusnsCG', 'Ashish12@gmail.com', 0, NULL),
(17, 'ashish12', '$2y$10$G84A7Q4jI44ZWkZOZaF.L.KudpMJrxMVCEKVXKEKEquAUZQHKtxfS', 'Ashish12@gmail.com', 0, NULL),
(18, 'Verified', '$2y$10$oYKWBx1WfmHJmU8wt05KcOQTyro69E/axoO8FLs4SZbu3JY0oQJIS', 'Verifiedaccount@gmail.com', 0, NULL),
(19, 'Abhishek ', '$2y$10$buRtZWuLcXlP7tE.1m7j2.w5fB4ak4397JQXU1NlsYtrFcIfSQ23O', 'Abhishekrai@gmail.com', 0, ''),
(29, 'Vikas1', '$2y$10$RhEEF.v8vuktX/SE9v3x.OVlWyGLHPB4X50rMrfY5X8RLnH1c9UJ6', 'friesta.socailnetwork@gmail.com', 0, ''),
(30, 'Abhishek2', '$2y$10$xDCvcpGrBQw0tqWPAmgkKuUuOe0KfSJFZOvlbvwj1vv97A6ZXkWoS', 'Abhishek2@gmail.com', 0, ''),
(31, 'Abhishek3', '$2y$10$xuSfJ8iKdjFRx/UrSMwtie06Bl4.GGTzTNp.PE/vkk72wkQbcPpEG', 'Abhishek3@gmail.com', 0, ''),
(32, 'Abhishek4', '$2y$10$qPB28L7ntFnIeSTbrgEQP.RVwf.s2dPGot.EUJ6B5ZK7yxFq8rHIq', 'Abhishek4@gmail.com', 0, ''),
(33, 'Shivam', '$2y$10$n1VJN.Mnk5TCeieO0fsUiu1DKGM26DgA8WnuU3szqcOLmvgmNZmsm', 'ShivamShukla@gmail.com', 0, 'https://i.imgur.com/owS76PV.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_tokens`
--
ALTER TABLE `password_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `password_tokens`
--
ALTER TABLE `password_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD CONSTRAINT `login_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
