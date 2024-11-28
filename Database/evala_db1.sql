-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2024 at 08:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evala_db1`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `alumni_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `student_number` varchar(50) NOT NULL,
  `graduation_year` year(4) NOT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`alumni_id`, `user_id`, `student_number`, `graduation_year`, `course_id`) VALUES
(1, 5, '2015-2-02236', '2020', 5);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_description` text DEFAULT NULL,
  `course_cover` varchar(256) NOT NULL,
  `active_flag` tinyint(1) NOT NULL COMMENT '0 = inactive\r\n1 = active\r\n2 = pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_description`, `course_cover`, `active_flag`) VALUES
(1, 'Computer Science', 'Computer science is the study of computers and computational systems.', '../course_cover/computer_science.jpg', 1),
(2, 'Information Technology', 'Information technology (IT) is the use of computer systems to manage, process, protect, and exchange information. It\'s a vast field of expertise that includes a variety of subfields and specializations. The common goal between them is to use technology systems to solve problems and handle information.', '', 1),
(3, 'Computer Engineering', 'Computer engineering is a broad field that combines computer science and electrical engineering to design, build, and maintain computer hardware and software', '', 1),
(4, 'Electrical Engineering', 'Electrical engineering is the study of electricity, electronics, and electromagnetism, and the application of these principles to design, develop, and test electrical systems, devices, and technologies. Electrical engineers use physics and mathematics to create products that use electricity to do useful things.', '', 1),
(5, 'Architecture', 'Architecture is the art and science of designing and building structures and buildings. It\'s a process that involves sketching, planning, designing, and constructing. Architecture can also be defined as the product of these steps.', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `criteria_id` int(10) NOT NULL,
  `criteria_name` text NOT NULL,
  `evaluator_type` enum('Student','Faculty','Alumni') NOT NULL,
  `active_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`criteria_id`, `criteria_name`, `evaluator_type`, `active_flag`) VALUES
(1, 'Curriculum Objectives', 'Student', 1),
(2, 'Curriculum Objectives', 'Faculty', 1),
(3, 'Faculty Members', 'Student', 1),
(4, 'Instructions', 'Student', 1),
(5, 'Instructions', 'Faculty', 1),
(6, 'Evaluation Measures', 'Student', 1),
(7, 'Evaluation Measures', 'Faculty', 1),
(8, 'Enrichment', 'Student', 1),
(9, 'Enrichment', 'Faculty', 1),
(10, 'Other Resources', 'Student', 1),
(11, 'Other Resources', 'Faculty', 1),
(12, 'Over-all Evaluation of the Curriculum', 'Student', 1),
(13, 'Over-all Evaluation of the Curriculum', 'Faculty', 1),
(14, 'Relevance to Industry Needs', 'Alumni', 1),
(15, 'Technical Skills Development', 'Alumni', 1),
(16, 'Soft Skills Presentation', 'Alumni', 1),
(17, 'Innovation and Critical Thinking', 'Alumni', 1),
(18, 'Interdisciplinary Integration', 'Alumni', 1),
(19, 'Graduate Preparedness', 'Alumni', 1),
(20, 'Feedback Mechanism', 'Alumni', 1),
(21, 'Continuous Improvement', 'Alumni', 1),
(22, 'Global and Social Impact', 'Alumni', 1),
(23, 'Course Content', 'Student', 1),
(24, 'Course Content', 'Faculty', 1);

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
  `evaluation_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `evaluator_type` enum('student','faculty','alumni') DEFAULT NULL,
  `criteria_id` int(11) NOT NULL,
  `evaluation_start_date` date NOT NULL,
  `evaluation_end_date` date NOT NULL,
  `active_flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluations`
--

INSERT INTO `evaluations` (`evaluation_id`, `course_id`, `evaluator_type`, `criteria_id`, `evaluation_start_date`, `evaluation_end_date`, `active_flag`) VALUES
(3, 1, 'student', 1, '2024-11-23', '2024-12-10', 1),
(4, 1, 'student', 23, '2024-11-23', '2024-12-10', 1),
(5, 1, 'student', 3, '2024-11-23', '2024-12-10', 1),
(6, 1, 'student', 4, '2024-11-23', '2024-12-10', 1),
(7, 1, 'student', 6, '2024-11-23', '2024-12-10', 1),
(8, 1, 'student', 8, '2024-11-23', '2024-12-10', 1),
(9, 1, 'student', 10, '2024-11-23', '2024-12-10', 1),
(10, 1, 'student', 12, '2024-11-23', '2024-12-10', 1),
(12, 5, 'alumni', 14, '2024-11-28', '2024-12-11', 1),
(13, 5, 'alumni', 15, '2024-11-28', '2024-12-11', 1),
(14, 5, 'alumni', 16, '2024-11-28', '2024-12-11', 1),
(15, 5, 'alumni', 17, '2024-11-28', '2024-12-11', 1),
(16, 5, 'alumni', 18, '2024-11-28', '2024-12-11', 1),
(17, 5, 'alumni', 19, '2024-11-28', '2024-12-11', 1),
(18, 5, 'alumni', 20, '2024-11-28', '2024-12-11', 1),
(19, 5, 'alumni', 21, '2024-11-28', '2024-12-11', 1),
(20, 5, 'alumni', 22, '2024-11-28', '2024-12-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_results`
--

CREATE TABLE `evaluation_results` (
  `result_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `rate` int(11) DEFAULT NULL CHECK (`rate` between 1 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `hired_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `user_id`, `position`, `department`, `hired_date`) VALUES
(1, 2, 'Head of Computer Studies', 'COECSA', '2014-11-20');

-- --------------------------------------------------------

--
-- Table structure for table `iab`
--

CREATE TABLE `iab` (
  `iab_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `department` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `iab`
--

INSERT INTO `iab` (`iab_id`, `user_id`, `department`) VALUES
(1, 1, 'COECSA');

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire`
--

CREATE TABLE `questionnaire` (
  `question_id` int(1) NOT NULL,
  `question` text NOT NULL,
  `criteria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questionnaire`
--

INSERT INTO `questionnaire` (`question_id`, `question`, `criteria_id`) VALUES
(1, 'The objectives of the program are clearly defined and understood. ', 1),
(2, 'The objectives of the program are clearly defined and understood. ', 2),
(3, 'The objectives are within the framework of the University philosophy, \r\n\r\n“Veritas et Fortitudo” and “Pro Deo et Patria”. ', 1),
(4, 'The objectives are within the framework of the University philosophy, \r\n\r\n“Veritas et Fortitudo” and “Pro Deo et Patria”. ', 2),
(5, 'The objectives are realistic. ', 1),
(6, 'The objectives are realistic. ', 2),
(7, 'The objectives are relevant to the needs of the students. ', 1),
(8, 'The objectives are relevant to the needs of the students. ', 2),
(9, 'The objectives are relevant to the needs of the profession/discipline. ', 1),
(10, 'The objectives are relevant to the needs of the profession/discipline. ', 2),
(11, 'The course content is generally perceived as comprehensive. The \r\n\r\nrelatively high mean score indicates positive feedback, though there is \r\n\r\nsome variability. ', 23),
(12, 'The course content is generally perceived as comprehensive. The \r\n\r\nrelatively high mean score indicates positive feedback, though there is \r\n\r\nsome variability. ', 24),
(13, 'The syllabi\'s emphasis on connections within and across disciplines is \r\n\r\nseen positively but with some variability in responses. ', 23),
(14, 'The syllabi\'s emphasis on connections within and across disciplines is \r\n\r\nseen positively but with some variability in responses. ', 24),
(15, 'The syllabi\'s provision of items leading to conceptual understanding is well-regarded, though some responses vary. ', 23),
(16, 'The syllabi\'s provision of items leading to conceptual understanding is well-regarded, though some responses vary. ', 24),
(17, 'There is strong agreement that appropriate technology is incorporated into the syllabi. The low standard deviation indicates consistent feedback. ', 23),
(18, 'There is strong agreement that appropriate technology is incorporated into the syllabi. The low standard deviation indicates consistent feedback. ', 24),
(19, 'Experiences related to research are well-integrated in the syllabi, though responses vary slightly. ', 23),
(20, 'Experiences related to research are well-integrated in the syllabi, though responses vary slightly. ', 24),
(21, 'The integration of experiences related to social responsibility is seen positively with some variability. ', 23),
(22, 'The integration of experiences related to social responsibility is seen positively with some variability. ', 24),
(23, 'The incorporation of experiences for oral and written communication is viewed positively. The low standard deviation indicates consensus. ', 23),
(24, 'The incorporation of experiences for oral and written communication is viewed positively. The low standard deviation indicates consensus. ', 24),
(25, 'Experiences for developing desirable values and attitudes are included effectively, though with some variability in responses. ', 23),
(26, 'Experiences for developing desirable values and attitudes are included effectively, though with some variability in responses. ', 24),
(27, 'The development of specific professional skills is well-covered in the syllabi, with feedback showing consistency. ', 23),
(28, 'The development of specific professional skills is well-covered in the syllabi, with feedback showing consistency. ', 24),
(29, 'Faculty members are educationally highly qualified. ', 3),
(30, 'Faculty members handle subjects in their line of expertise. ', 3),
(31, 'Faculty members demonstrate mastery of the subject matter. ', 3),
(32, 'Students are given opportunities to apply theories and concepts to real \r\n\r\nlife situations ', 4),
(33, 'Students are given opportunities to apply theories and concepts to real \r\n\r\nlife situations ', 5),
(34, 'Ideas, topics, and contents existing in actual situations are used in \r\n\r\ninstructional materials. ', 4),
(35, 'Ideas, topics, and contents existing in actual situations are used in \r\n\r\ninstructional materials. ', 5),
(36, 'The subjects provide for the development of learning skills. ', 4),
(37, 'The subjects provide for the development of learning skills. ', 5),
(38, 'Teachers utilize appropriate and innovative teaching strategies and \r\n\r\ntechniques to motivate students. ', 4),
(39, 'Teachers utilize appropriate and innovative teaching strategies and \r\n\r\ntechniques to motivate students. ', 5),
(40, 'Teachers make use of appropriate technology in instructions. ', 4),
(41, 'Teachers make use of appropriate technology in instructions. ', 5),
(42, 'There is provision of opportunities for active student participation in \r\n\r\nclass. ', 4),
(43, 'There is provision of opportunities for active student participation in \r\n\r\nclass. ', 5),
(44, 'Teachers use varied evaluative techniques in the tests, quizzes, recitations, research group assignment and other innovative techniques ', 6),
(45, 'Teachers use varied evaluative techniques in the tests, quizzes, recitations, research group assignment and other innovative techniques ', 7),
(46, 'Regular periodic evaluation is conducted to assess student performance. ', 6),
(47, 'Regular periodic evaluation is conducted to assess student performance. ', 7),
(48, 'There are provisions for relevant co-curricular and extra-curricular \r\n\r\nActivities. ', 8),
(49, 'There are provisions for relevant co-curricular and extra-curricular \r\n\r\nActivities. ', 9),
(50, 'Outsourced expertise is utilized through lectures, demonstrations, simulations, etc. ', 8),
(51, 'Outsourced expertise is utilized through lectures, demonstrations, simulations, etc. ', 9),
(52, 'Library facilities and resources are adequate ', 10),
(53, 'Library facilities and resources are adequate ', 11),
(54, 'Laboratory facilities are complete, up-to-date and relevant to the course. ', 10),
(55, 'Laboratory facilities are complete, up-to-date and relevant to the course. ', 11),
(56, 'Classrooms are conducive to learning ', 10),
(57, 'Classrooms are conducive to learning ', 11),
(58, 'The curriculum fully equips students\' personality and professional skills according to expectations. ', 12),
(59, 'The curriculum fully equips students\' personality and professional skills according to expectations. ', 13),
(60, 'The curriculum reflected the latest advancements in the computer studies industry. ', 14),
(61, 'The curriculum incorporated current industry standards and practices. ', 14),
(62, 'Updates to the curriculum were made regularly to align with industry changes. ', 14),
(63, 'The curriculum provided comprehensive training in essential technical skills ', 15),
(64, 'The curriculum has laboratory sessions and practical projects that are sufficient to develop the student’s technical expertise. ', 15),
(65, 'The curriculum effectively covered advanced technical topics relevant to the industry. ', 15),
(66, 'The curriculum included courses or modules focused on developing communication skills ', 16),
(67, 'Teamwork and collaboration skills were adequately emphasized in the curriculum and are useful in professional life ', 16),
(68, 'The curriculum prepared well for ethical decision-making in professional settings ', 16),
(69, 'The curriculum encouraged students to think creatively and innovate in their current role ', 17),
(70, 'The curriculum provided opportunities for the students to engage in research and development projects ', 17),
(71, 'The curriculum included problem solving activities that required critical thinking ', 17),
(72, 'The curriculum integrated knowledge from multiple computer studies disciplines effectively, as needed in career ', 18),
(73, 'The curriculum has interdisciplinary projects that are useful in applying concepts from various fields in job ', 18),
(74, 'The curriculum incorporated elements from noncomputer studies disciplines (e.g., management, economics) relevant to work ', 18),
(75, 'The curriculum prepared the students well for immediate employment in the industry ', 19),
(76, 'Employers expressed satisfaction with technical and professional skills acquired from the curriculum ', 19),
(77, 'The student was able to meet the initial job requirements in their respective fields upon graduation ', 19),
(78, 'The curriculum incorporated feedback from students and industry partners effectively ', 20),
(79, 'The curriculum incorporated feedback from students and industry partners effectively ', 20),
(80, 'The curriculum has a regular and structured process for gathering feedback from industry ', 20),
(81, 'The curriculum adapted to industry trends based on feedback received from industry experts ', 20),
(82, 'The curriculum was reviewed and updated based on feedback from previous evaluations ', 21),
(83, 'Changes to the curriculum were communicated effectively to students and faculty ', 21),
(84, 'The curriculum adapted quickly to emerging technologies and methodologies ', 21),
(85, 'The curriculum addressed global challenges such as sustainability and climate change ', 22),
(86, 'Ethical and societal implications of computer studies practices were covered in the curriculum ', 22),
(87, 'The curriculum prepared students well to work in a globalized computer studies environment ', 22);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `student_number` varchar(255) NOT NULL,
  `student_year` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `student_number`, `student_year`, `course_id`) VALUES
(2, 3, '2022-2-02512', 3, 1),
(3, 4, '2022-2-13192', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('IAB','Student','Faculty','Alumni') NOT NULL,
  `active_flag` int(1) NOT NULL,
  `attempts` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`, `active_flag`, `attempts`) VALUES
(1, 'Arnel', 'Avelino', 'iab@gmail.com', '$2y$10$hGnWmN4kZv9QF62uEgRfCukPVbaiCs.oM44.vzErKN7fBEHQTRv5u', 'IAB', 1, 0),
(2, 'Jerian ', 'Peren', 'jerianperen@lpunetwork.edu.ph', '$2y$10$1B4ERWSkapMLhkjm4.rjIO.VFRvaMzEPgp4d6HOotgRbBrAzc./Wm', 'Faculty', 1, 0),
(3, 'Jaira Mae', 'Tafalla', 'jairamae@lpunetwork.edu.ph', '$2y$10$hhFkVMtFJM3HHCsUmFcccO8VbURq3MKxzLXivNZxXMsZIPtdP0oL2', 'Student', 1, 0),
(4, 'Lawrence', 'Laudato', 'lawrence@lpunetwork.edu.ph', '$2y$10$2Fc13A6D6zrPA7IOli0O1.j8CQQS5fCsNFbXCiBztK.pm5CuLXBK2', 'Student', 1, 0),
(5, 'John', 'Doe', 'johndoe@lpunetwork.edu.ph', '$2y$10$TEGoBUe6xS.5fG5zIyPXN.jvWAG/dklbKhDnRalqgEXOzQIdSBd7a', 'Alumni', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_evaluations`
--

CREATE TABLE `user_evaluations` (
  `user_eval_id` int(11) NOT NULL,
  `evaluation_id` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `has_answered` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_evaluations`
--

INSERT INTO `user_evaluations` (`user_eval_id`, `evaluation_id`, `user_id`, `has_answered`) VALUES
(1, 3, 3, 1),
(2, 4, 3, 1),
(3, 5, 3, 1),
(4, 6, 3, 1),
(5, 7, 3, 1),
(6, 8, 3, 1),
(7, 9, 3, 1),
(8, 10, 3, 1),
(9, 3, 4, 1),
(10, 4, 4, 1),
(11, 5, 4, 1),
(12, 6, 4, 1),
(13, 7, 4, 1),
(14, 8, 4, 1),
(15, 9, 4, 1),
(16, 10, 4, 1),
(17, 12, 5, 1),
(18, 13, 5, 1),
(19, 14, 5, 1),
(20, 15, 5, 1),
(21, 16, 5, 1),
(22, 17, 5, 1),
(23, 18, 5, 1),
(24, 19, 5, 1),
(25, 20, 5, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`alumni_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`criteria_id`);

--
-- Indexes for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`evaluation_id`),
  ADD KEY `evaluations_ibfk_1` (`course_id`),
  ADD KEY `criteria_id` (`criteria_id`),
  ADD KEY `evaluator_type` (`evaluator_type`);

--
-- Indexes for table `evaluation_results`
--
ALTER TABLE `evaluation_results`
  ADD PRIMARY KEY (`result_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`question_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `iab`
--
ALTER TABLE `iab`
  ADD PRIMARY KEY (`iab_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `questionnaire`
--
ALTER TABLE `questionnaire`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `criteria_id` (`criteria_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `user_evaluations`
--
ALTER TABLE `user_evaluations`
  ADD PRIMARY KEY (`user_eval_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `evaluation_id` (`evaluation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `alumni_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `criteria_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `evaluation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `evaluation_results`
--
ALTER TABLE `evaluation_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `iab`
--
ALTER TABLE `iab`
  MODIFY `iab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `question_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_evaluations`
--
ALTER TABLE `user_evaluations`
  MODIFY `user_eval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni`
--
ALTER TABLE `alumni`
  ADD CONSTRAINT `alumni_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alumni_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluations_ibfk_2` FOREIGN KEY (`criteria_id`) REFERENCES `criteria` (`criteria_id`);

--
-- Constraints for table `evaluation_results`
--
ALTER TABLE `evaluation_results`
  ADD CONSTRAINT `evaluation_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluation_results_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questionnaire` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `iab`
--
ALTER TABLE `iab`
  ADD CONSTRAINT `iab_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `questionnaire`
--
ALTER TABLE `questionnaire`
  ADD CONSTRAINT `questionnaire_ibfk_1` FOREIGN KEY (`criteria_id`) REFERENCES `criteria` (`criteria_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_evaluations`
--
ALTER TABLE `user_evaluations`
  ADD CONSTRAINT `user_evaluations_ibfk_2` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`evaluation_id`),
  ADD CONSTRAINT `user_evaluations_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
