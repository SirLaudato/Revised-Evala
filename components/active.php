<?php
// Dynamic values
$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";

// Establish connection
$con = mysqli_connect($servername, $username, $password, $database);
if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Check if user_id is set in the session
if (!isset($_SESSION["user_id"])) {
    die("Error: User not logged in.");
}

// Query to get the course for the logged-in user
$course_query = "
    SELECT DISTINCT `courses`.`course_id`
    FROM `users` 
    LEFT JOIN `students` ON `students`.`user_id` = `users`.`user_id`
    LEFT JOIN `alumni` ON `alumni`.`user_id` = `users`.`user_id`
    LEFT JOIN `courses` ON `courses`.`course_id` = IFNULL(`students`.`course_id`, `alumni`.`course_id`)
    LEFT JOIN `evaluations` ON `evaluations`.`course_id` = `courses`.`course_id`
    WHERE `users`.`user_id` = " . intval($_SESSION["user_id"]) . ";
";


$result = $con->query($course_query);

// Check if the query returned any results
if ($result && $result->num_rows > 0) {
    // Fetch the first course_id and store it in the session
    $row = $result->fetch_assoc();
    $_SESSION["course_id"] = $row["course_id"];

    // Query to get course details using the fetched course_id
    $select_course = "
        SELECT * 
        FROM `courses` 
        WHERE `course_id` = '" . mysqli_real_escape_string($con, $_SESSION["course_id"]) . "';";

    $course_result = $con->query($select_course);

    if ($course_result && $course_result->num_rows > 0) {
        while ($course_row = $course_result->fetch_assoc()) {
            $active_evaluation_query = "SELECT 
                                                COUNT(*) AS `active_evaluations`
                                                FROM 
                                                `evaluations`
                                                LEFT JOIN 
                                                `user_evaluations` ON `user_evaluations`.`evaluation_id` = `evaluations`.`evaluation_id`
                                                LEFT JOIN 
                                                `users` ON `user_evaluations`.`user_id` = `users`.`user_id`
                                                WHERE 
                                                `user_evaluations`.`has_answered` = 1
                                                AND `users`.`user_id` = " . intval($_SESSION["user_id"]) . ";";

            $total_evaluation_query = "SELECT 
                                                COUNT(*) AS `total_evaluations`
                                                FROM 
                                                `evaluations`
                                                LEFT JOIN 
                                                `user_evaluations` ON `user_evaluations`.`evaluation_id` = `evaluations`.`evaluation_id`
                                                LEFT JOIN 
                                                `users` ON `user_evaluations`.`user_id` = `users`.`user_id`
                                                WHERE 
                                                `evaluations`.`course_id` = " . intval($course_row["course_id"]) . "
                                                AND `users`.`user_id`= " . intval($_SESSION["user_id"]) . ";";

            $total_result = mysqli_query($con, $total_evaluation_query);
            if ($total_result) {
                $row = mysqli_fetch_assoc($total_result);
                $total_evaluations = $row['total_evaluations'];
            } else {
                echo "Query failed: " . mysqli_error($con);
                continue; // Skip to next iteration
            }

            // Execute active evaluations query
            $active_result = mysqli_query($con, $active_evaluation_query);
            if ($active_result) {
                $row = mysqli_fetch_assoc($active_result);
                $active_evaluations = $row['active_evaluations'];
            } else {
                echo "Query failed: " . mysqli_error($con);
                continue; // Skip to next iteration
            }

            $_SESSION["course_id"] = $course_id = $course_row["course_id"];
            $_SESSION["course_name"] = $course_name = $course_row["course_name"];
            $_SESSION["course_cover"] = $course_cover = $course_row["course_cover"];

            if ($active_evaluations === $total_evaluations) {
                $_SESSION["status"] = "Not yet completed";
            } elseif (empty($active_evaluations)) {
                $_SESSION["status"] = "Completed";
            } else {
                $_SESSION["status"] = "Pending";
            }
        }
    }
}