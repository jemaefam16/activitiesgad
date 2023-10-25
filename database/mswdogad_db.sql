-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2023 at 08:16 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mswdogad_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(30) NOT NULL,
  `title` text DEFAULT NULL,
  `event_location` text DEFAULT NULL,
  `label` text DEFAULT NULL,
  `attendance_status` text DEFAULT NULL,
  `evaluation_status` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `upload_path` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 =active ,2 = Inactive',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `title`, `event_location`, `label`, `attendance_status`, `evaluation_status`, `description`, `upload_path`, `status`, `date_created`) VALUES
(1, 'GAD Awareness Seminar', 'Poblacion Covered Court, Brgy. Poblacion, Corcuera, Romblon', 'Open', 'Open', 'Open', '&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify;&quot;&gt;&lt;font color=&quot;#000000&quot; face=&quot;Open Sans, Arial, sans-serif&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;This activity seeks to promote understanding and open-mindedness among the participants and for them to examine their personal attitudes, beliefs, and behavior, and to instill empathy into the views about themselves and the other sex.&lt;/span&gt;&lt;/font&gt;&lt;br&gt;&lt;/p&gt;', 'uploads/activity_1', 0, '2023-06-18 10:31:03'),
(2, 'ERPAT General Assembly & Seminar', 'Brgy. Alegria, Corcuera, Romblon', 'Open', 'Open', 'Open', '&lt;p style=&quot;text-align: justify; &quot;&gt;&lt;font color=&quot;#000000&quot; face=&quot;Open Sans, Arial, sans-serif&quot;&gt;&lt;b&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;ERPAT &lt;/span&gt;&lt;/b&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;or &lt;/span&gt;&lt;b&gt;Empowerment and Reaffirmation Paternal Abilities&lt;/b&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt; aims to engage fathers to. become effective and responsive. It gives. importance and emphasis on fathers paternal.&lt;/span&gt;&lt;/font&gt;&lt;br&gt;&lt;/p&gt;', 'uploads/activity_2', 1, '2023-06-18 11:17:11'),
(3, '45th National Disability Prevention and Rehabilitation Week', 'Brgy. Poblacion, Corcuera, Romblon', 'Open', 'Open', 'Open', '&lt;p style=&quot;text-align: justify; &quot;&gt;&lt;font color=&quot;#000000&quot; face=&quot;Open Sans, Arial, sans-serif&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;In pursuance of Presidential Proclamation No. 1870, s. 1979, as amended by Presidential Proclamation No. 361, s. 2000, the Municipal Social Welfare Development (MSWD) joins the whole nation in the celebration of the&lt;b&gt; 45th National Disability Prevention and Rehabilitation (NDPR) Week&lt;/b&gt;. Person with Disabilities Accessibility and Rights: Towards a Sustainable Future where No One is Left Behind aims to create a more inclusive society where differently abled people are free to fully participate in all aspects of life. It also aims to improve the quality of life for differently abled people by ensuring that they have access to the necessary resources and support. Honoring the differently abled community can help create a more inclusive society, as celebrating their achievements sends a message that everyone belongs. This, in turn, can contribute to fostering a more welcoming and accessible environment for everyone.&lt;/span&gt;&lt;/font&gt;&lt;br&gt;&lt;/p&gt;', 'uploads/activity_3', 0, '2023-06-18 13:34:08');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(30) NOT NULL,
  `about` text DEFAULT NULL,
  `announcements` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 =done ,2 = upcoming',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `about`, `announcements`, `status`, `date_created`) VALUES
(1, 'ERPAT', 'We will be having an assembly about ERPAT in Alegria.', 1, '2023-10-03 08:24:36'),
(12, 'ERPAT Assembly Meeting', '&lt;p&gt;We will be having an assembly meeting about ERPAT. &lt;/p&gt;', 2, '2023-10-09 09:53:52');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_list`
--

CREATE TABLE `attendance_list` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `activity_id` int(30) NOT NULL,
  `registration_id` int(30) DEFAULT NULL,
  `status` enum('unchecked','Present') DEFAULT NULL,
  `attendance_date` date DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance_list`
--

INSERT INTO `attendance_list` (`id`, `user_id`, `activity_id`, `registration_id`, `status`, `attendance_date`, `date_created`) VALUES
(13, 11, 3, 11, 'Present', '2023-10-07', '2023-10-16 17:17:53'),
(14, 15, 1, 15, 'Present', '2023-10-07', '2023-10-18 13:52:40'),
(15, 13, 1, 13, 'Present', '2023-10-07', '2023-10-18 13:57:00'),
(16, 12, 3, 12, 'Present', '2023-10-10', '2023-10-18 14:00:59'),
(17, 14, 1, 14, 'Present', '2023-10-07', '2023-10-18 14:03:35');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(30) NOT NULL,
  `docu_title` text DEFAULT NULL,
  `docu_description` text DEFAULT NULL,
  `upload_path` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 =Uploaded ,2 = Updated',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `docu_title`, `docu_description`, `upload_path`, `status`, `date_created`) VALUES
(9, 'GENDER_AND_DEVELOPMENT_GAD_AUDIT_IN_STATE_UNIVERSI.pdf', '&lt;p&gt;GAD Report Seminar&lt;/p&gt;', 'uploads/document_9', 0, '2023-10-05 11:53:59'),
(10, 'PROMOTE GENDER EQUALITY AND EMPOWER WOMEN_ THE BIG PICTURE.pdf', '&lt;p&gt;GAD&lt;/p&gt;', 'uploads/document_10', 1, '2023-10-06 11:35:20');

-- --------------------------------------------------------

--
-- Table structure for table `rate_review`
--

CREATE TABLE `rate_review` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `activity_id` int(30) NOT NULL,
  `rate` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rate_review`
--

INSERT INTO `rate_review` (`id`, `user_id`, `activity_id`, `rate`, `review`, `date_created`) VALUES
(21, 11, 3, 4, 'Informative.', '2023-10-16 18:27:07'),
(22, 15, 1, 4, 'Informative and I learned a lot.', '2023-10-18 13:53:28'),
(23, 12, 3, 3, 'Good event.', '2023-10-18 14:01:17'),
(24, 14, 1, 5, 'I learned a lot about gender and development.', '2023-10-18 14:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `registration_list`
--

CREATE TABLE `registration_list` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `activity_id` int(30) NOT NULL,
  `status` enum('unchecked','done') DEFAULT NULL,
  `schedule` date DEFAULT NULL,
  `gender` enum('Male','Female','LGBTQA') DEFAULT NULL,
  `category` enum('Solo Parent','PWD','ERPAT','Women','Children','None') DEFAULT NULL,
  `address` varchar(1000) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration_list`
--

INSERT INTO `registration_list` (`id`, `user_id`, `activity_id`, `status`, `schedule`, `gender`, `category`, `address`, `contact`, `date_created`) VALUES
(11, 11, 3, 'done', '2023-10-10', 'Male', 'PWD', 'Gobon', '09302034576', '2023-10-16 17:17:33'),
(12, 15, 1, 'done', '2023-10-07', 'Male', 'Solo Parent', 'Labnig', '09456872341', '2023-10-18 13:52:23'),
(13, 13, 1, 'done', '2023-10-07', 'Female', 'Women', 'Alegria', '09096847365', '2023-10-18 13:56:48'),
(14, 12, 3, 'done', '2023-10-10', 'Male', 'PWD', 'Mahaba', '09084573624', '2023-10-18 13:59:17'),
(15, 14, 1, 'done', '2023-10-07', 'Female', 'Women', 'San Vicente', '09074562998', '2023-10-18 14:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_info` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `contact_info`, `address`, `photo`) VALUES
(1, 'Mercy F. Familara', '09194212412', 'Poblacion, Corcuera, Romblon', 'mswdhead.jpg'),
(5, 'Jessa Mae F. Famorcan', '09202447123', 'Gobon, Corcuera, Romblon', 'jessa.jpg'),
(9, 'Charina Lae F. Minon', '09092345678', 'Mangansag, Corcuera, Romblon', 'cha finall.png');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'MSWDO Corcuera Romblon'),
(6, 'short_name', 'MSWDO CORCUERA ROMBLON'),
(11, 'logo', 'uploads/1695816840_logo.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/1696312800_MSWDO.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL COMMENT '0=Registered,1=Pending',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`) VALUES
(1, 'MSWDO', 'Admin', 'mswdoadmin', '44ecd1d85cf14414c56148135f524944', 'uploads/1695617640_mswdhead.jpg', NULL, 1, 0, '2023-01-20 14:02:37', '2023-10-16 14:25:08'),
(11, 'Alex', 'Santos', 'alexsantos', '5624917c91e650495fb1c5575e50054b', NULL, NULL, 0, 0, '2023-10-16 17:16:47', NULL),
(12, 'Willie', 'Falceso', 'williefalceso', '86598fd42bf8bfd50a1c7eec0dacc9ee', NULL, NULL, 0, 0, '2023-10-18 13:43:59', NULL),
(13, 'Rachel', 'Mores', 'rachelmores', '5e05cdf19acd0c658de002d3135759f1', NULL, NULL, 0, 0, '2023-10-18 13:45:27', NULL),
(14, 'Nora', 'Fronda', 'norafronda', 'b5ab111b86a1b1b4c1dabd7023b4e2e6', NULL, NULL, 0, 0, '2023-10-18 13:46:47', NULL),
(15, 'Jay ', 'Fonte', 'jayfonte', '76428b97499a72a966df5774ea790237', NULL, NULL, 0, 0, '2023-10-18 13:47:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`id`, `name`) VALUES
(1, 'Womens Month.mp4'),
(2, 'Womens Month in Poblacion.mp4'),
(3, 'Womens Month in Corcuera.mp4'),
(4, 'Womens Month Part 2.mp4'),
(5, 'Womens Month in Poblacion Part 2.mp4'),
(7, 'Womens Month Celebration.mp4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_list`
--
ALTER TABLE `attendance_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rate_review`
--
ALTER TABLE `rate_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration_list`
--
ALTER TABLE `registration_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `attendance_list`
--
ALTER TABLE `attendance_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rate_review`
--
ALTER TABLE `rate_review`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `registration_list`
--
ALTER TABLE `registration_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
