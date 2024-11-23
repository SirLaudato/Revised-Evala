-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 08:10 PM
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
(1, 5, '0', '2020', 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_description`) VALUES
(1, 'Computer Science', 'Computer science is the study of computers and computational systems.'),
(2, 'Information Technology', 'Information technology (IT) is the use of computer systems to manage, process, protect, and exchange information. It\'s a vast field of expertise that includes a variety of subfields and specializations. The common goal between them is to use technology systems to solve problems and handle information.'),
(3, 'Computer Engineering', 'Computer engineering is a broad field that combines computer science and electrical engineering to design, build, and maintain computer hardware and software'),
(4, 'Electrical Engineering', 'Electrical engineering is the study of electricity, electronics, and electromagnetism, and the application of these principles to design, develop, and test electrical systems, devices, and technologies. Electrical engineers use physics and mathematics to create products that use electricity to do useful things.'),
(5, 'Architecture', 'Architecture is the art and science of designing and building structures and buildings. It\'s a process that involves sketching, planning, designing, and constructing. Architecture can also be defined as the product of these steps.');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `criteria_id` int(10) NOT NULL,
  `criteria_name` text NOT NULL,
  `evaluator_type` enum('Student','Faculty','Alumni') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`criteria_id`, `criteria_name`, `evaluator_type`) VALUES
(1, 'Curriculum Objectives', 'Student'),
(2, 'Curriculum Objectives', 'Faculty'),
(3, 'Faculty Members', 'Student'),
(4, 'Instructions', 'Student'),
(5, 'Instructions', 'Faculty'),
(6, 'Evaluation Measures', 'Student'),
(7, 'Evaluation Measures', 'Faculty'),
(8, 'Enrichment', 'Student'),
(9, 'Enrichment', 'Faculty'),
(10, 'Other Resources', 'Student'),
(11, 'Other Resources', 'Faculty'),
(12, 'Over-all Evaluation of the Curriculum', 'Student'),
(13, 'Over-all Evaluation of the Curriculum', 'Faculty'),
(14, 'Other Resources', 'Student'),
(15, 'Other Resources', 'Faculty'),
(16, 'Relevance to Industry Needs', 'Alumni'),
(17, 'Technical Skills Development', 'Alumni'),
(18, 'Soft Skills Presentation', 'Alumni'),
(19, 'Innovation and Critical Thinking', 'Alumni'),
(20, 'Interdisciplinary Integration', 'Alumni'),
(21, 'Graduate Preparedness', 'Alumni'),
(22, 'Feedback Mechanism', 'Alumni'),
(23, 'Continuous Improvement', 'Alumni'),
(24, 'Global and Social Impact', 'Alumni'),
(25, 'Course Content', 'Student'),
(26, 'Course Content', 'Faculty');

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

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_results`
--

CREATE TABLE `evaluation_results` (
  `result_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `question_id` int(10) NOT NULL
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
(25, 'The objectives of the program are clearly defined and understood. ', 1),
(26, 'The objectives of the program are clearly defined and understood. ', 2),
(27, 'The objectives are within the framework of the University philosophy, \r\n\r\n“Veritas et Fortitudo” and “Pro Deo et Patria”. ', 1),
(28, 'The objectives are within the framework of the University philosophy, \r\n\r\n“Veritas et Fortitudo” and “Pro Deo et Patria”. ', 2),
(29, 'The objectives are realistic. ', 1),
(30, 'The objectives are realistic. ', 2),
(31, 'The objectives are relevant to the needs of the students. ', 1),
(32, 'The objectives are relevant to the needs of the students. ', 2),
(33, 'The objectives are relevant to the needs of the profession/discipline. ', 1),
(34, 'The objectives are relevant to the needs of the profession/discipline. ', 2),
(35, 'The course content is generally perceived as comprehensive. The \r\n\r\nrelatively high mean score indicates positive feedback, though there is \r\n\r\nsome variability. ', 25),
(36, 'The course content is generally perceived as comprehensive. The \r\n\r\nrelatively high mean score indicates positive feedback, though there is \r\n\r\nsome variability. ', 26),
(37, 'The syllabi\'s emphasis on connections within and across disciplines is \r\n\r\nseen positively but with some variability in responses. ', 25),
(38, 'The syllabi\'s emphasis on connections within and across disciplines is \r\n\r\nseen positively but with some variability in responses. ', 26),
(39, 'The syllabi\'s provision of items leading to conceptual understanding is well-regarded, though some responses vary. ', 25),
(40, 'The syllabi\'s provision of items leading to conceptual understanding is well-regarded, though some responses vary. ', 26),
(41, 'There is strong agreement that appropriate technology is incorporated into the syllabi. The low standard deviation indicates consistent feedback. ', 25),
(42, 'There is strong agreement that appropriate technology is incorporated into the syllabi. The low standard deviation indicates consistent feedback. ', 26),
(43, 'Experiences related to research are well-integrated in the syllabi, though responses vary slightly. ', 25),
(44, 'Experiences related to research are well-integrated in the syllabi, though responses vary slightly. ', 26),
(45, 'The integration of experiences related to social responsibility is seen positively with some variability. ', 25),
(46, 'The integration of experiences related to social responsibility is seen positively with some variability. ', 26),
(47, 'The incorporation of experiences for oral and written communication is viewed positively. The low standard deviation indicates consensus. ', 25),
(48, 'The incorporation of experiences for oral and written communication is viewed positively. The low standard deviation indicates consensus. ', 26),
(49, 'Experiences for developing desirable values and attitudes are included effectively, though with some variability in responses. ', 25),
(50, 'Experiences for developing desirable values and attitudes are included effectively, though with some variability in responses. ', 26),
(51, 'The development of specific professional skills is well-covered in the syllabi, with feedback showing consistency. ', 25),
(52, 'The development of specific professional skills is well-covered in the syllabi, with feedback showing consistency. ', 26),
(53, 'Faculty members are educationally highly qualified. ', 3),
(54, 'Faculty members handle subjects in their line of expertise. ', 3),
(55, 'Faculty members demonstrate mastery of the subject matter. ', 3),
(56, 'Students are given opportunities to apply theories and concepts to real \r\n\r\nlife situations ', 4),
(57, 'Students are given opportunities to apply theories and concepts to real \r\n\r\nlife situations ', 5),
(58, 'Ideas, topics, and contents existing in actual situations are used in \r\n\r\ninstructional materials. ', 4),
(59, 'Ideas, topics, and contents existing in actual situations are used in \r\n\r\ninstructional materials. ', 5),
(60, 'The subjects provide for the development of learning skills. ', 4),
(61, 'The subjects provide for the development of learning skills. ', 5),
(62, 'Teachers utilize appropriate and innovative teaching strategies and \r\n\r\ntechniques to motivate students. ', 4),
(63, 'Teachers utilize appropriate and innovative teaching strategies and \r\n\r\ntechniques to motivate students. ', 5),
(64, 'Teachers make use of appropriate technology in instructions. ', 4),
(65, 'Teachers make use of appropriate technology in instructions. ', 5),
(66, 'There is provision of opportunities for active student participation in \r\n\r\nclass. ', 4),
(67, 'There is provision of opportunities for active student participation in \r\n\r\nclass. ', 5),
(68, 'Teachers use varied evaluative techniques in the tests, quizzes, recitations, research group assignment and other innovative techniques ', 6),
(69, 'Teachers use varied evaluative techniques in the tests, quizzes, recitations, research group assignment and other innovative techniques ', 7),
(70, 'Regular periodic evaluation is conducted to assess student performance. ', 6),
(71, 'Regular periodic evaluation is conducted to assess student performance. ', 7),
(72, 'There are provisions for relevant co-curricular and extra-curricular \r\n\r\nActivities. ', 8),
(73, 'There are provisions for relevant co-curricular and extra-curricular \r\n\r\nActivities. ', 9),
(74, 'Outsourced expertise is utilized through lectures, demonstrations, simulations, etc. ', 8),
(75, 'Outsourced expertise is utilized through lectures, demonstrations, simulations, etc. ', 9),
(76, 'Library facilities and resources are adequate ', 10),
(77, 'Library facilities and resources are adequate ', 11),
(78, 'Laboratory facilities are complete, up-to-date and relevant to the course. ', 10),
(79, 'Laboratory facilities are complete, up-to-date and relevant to the course. ', 11),
(80, 'Classrooms are conducive to learning ', 10),
(81, 'Classrooms are conducive to learning ', 11),
(82, 'The curriculum fully equips students\' personality and professional skills according to expectations. ', 12),
(83, 'The curriculum fully equips students\' personality and professional skills according to expectations. ', 13),
(84, 'The curriculum reflected the latest advancements in the computer studies industry. ', 16),
(85, 'The curriculum incorporated current industry standards and practices. ', 16),
(86, 'Updates to the curriculum were made regularly to align with industry changes. ', 16),
(87, 'The curriculum provided comprehensive training in essential technical skills ', 17),
(88, 'The curriculum has laboratory sessions and practical projects that are sufficient to develop the student’s technical expertise. ', 17),
(89, 'The curriculum effectively covered advanced technical topics relevant to the industry. ', 17),
(90, 'The curriculum included courses or modules focused on developing communication skills ', 18),
(91, 'Teamwork and collaboration skills were adequately emphasized in the curriculum and are useful in professional life ', 18),
(92, 'The curriculum prepared well for ethical decision-making in professional settings ', 18),
(93, 'The curriculum encouraged students to think creatively and innovate in their current role ', 19),
(94, 'The curriculum provided opportunities for the students to engage in research and development projects ', 19),
(95, 'The curriculum included problem solving activities that required critical thinking ', 19),
(96, 'The curriculum integrated knowledge from multiple computer studies disciplines effectively, as needed in career ', 20),
(97, 'The curriculum has interdisciplinary projects that are useful in applying concepts from various fields in job ', 20),
(98, 'The curriculum incorporated elements from noncomputer studies disciplines (e.g., management, economics) relevant to work ', 20),
(99, 'The curriculum prepared the students well for immediate employment in the industry ', 21),
(100, 'Employers expressed satisfaction with technical and professional skills acquired from the curriculum ', 21),
(101, 'The student was able to meet the initial job requirements in their respective fields upon graduation ', 21),
(102, 'The curriculum incorporated feedback from students and industry partners effectively ', 22),
(103, 'The curriculum has a regular and structured process for gathering feedback from industry ', 22),
(104, 'The curriculum adapted to industry trends based on feedback received from industry experts ', 22),
(105, 'The curriculum was reviewed and updated based on feedback from previous evaluations ', 23),
(106, 'Changes to the curriculum were communicated effectively to students and faculty ', 23),
(107, 'The curriculum adapted quickly to emerging technologies and methodologies ', 23),
(108, 'The curriculum addressed global challenges such as sustainability and climate change ', 24),
(109, 'Ethical and societal implications of computer studies practices were covered in the curriculum ', 24),
(110, 'The curriculum prepared students well to work in a globalized computer studies environment ', 24);

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
  `active_flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`, `active_flag`) VALUES
(1, 'Arnel', 'Avelino', 'iab@gmail.com', 'admin123', 'IAB', 1),
(2, 'Jerian ', 'Peren', 'jerianperen@lpunetwork.edu.ph', 'jerian123', 'Faculty', 1),
(3, 'Jaira Mae', 'Tafalla', 'jairamae@lpunetwork.edu.ph', 'jaira123', 'Student', 1),
(4, 'Lawrence', 'Laudato', 'lawrence@lpunetwork.edu.ph', 'lawrence123', 'Student', 1),
(5, 'John', 'Doe', 'johndoe@gmail.com', 'johndoe123', 'Alumni', 1);

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
  ADD KEY `criteria_id` (`criteria_id`);

--
-- Indexes for table `evaluation_results`
--
ALTER TABLE `evaluation_results`
  ADD PRIMARY KEY (`result_id`),
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
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `criteria_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `evaluation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `question_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

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
  MODIFY `user_eval_id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `evaluation_results_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questionnaire` (`question_id`);

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
  ADD CONSTRAINT `user_evaluations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_evaluations_ibfk_2` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`evaluation_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
