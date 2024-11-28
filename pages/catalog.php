<?php
session_start();
if (!isset($_SESSION['emailaddress'])) {
  header("Location: ../pages/login.php");
  exit();
}

$evaluation_status = "Pending"; // Example: "Completed", "Pending", etc.
$curriculum_name = "BS Computer Science"; // Example curriculum name
$evaluation_deadline = "2024-12-15"; // Example deadline

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";

$con = mysqli_connect($servername, $username, $password, $database);

if (!$con) {
  die("Connection Failed: " . mysqli_connect_error());
}

$modalTitle = "";
$modalMessage = "";
$count_evaluations = "SELECT 
                      COUNT(*) AS active_evaluations
                      FROM 
                      evaluations
                      LEFT JOIN 
                      user_evaluations ON user_evaluations.`evaluation_id` = evaluations.`evaluation_id`
                      LEFT JOIN 
                      users ON user_evaluations.`user_id` = users.`user_id`
                      WHERE 
                      evaluations.`active_flag` = 1
                      AND users.`user_id` = " . $_SESSION["user_id"] . ";";

$course = "SELECT DISTINCT `courses`.`course_id`
                      FROM `users` 
	                    LEFT JOIN `students` ON `students`.`user_id` = `users`.`user_id` 
	                    LEFT JOIN `courses` ON `students`.`course_id` = `courses`.`course_id` 
	                    LEFT JOIN `evaluations` ON `evaluations`.`course_id` = `courses`.`course_id`
                      WHERE users.user_id = " . $_SESSION["user_id"] . ";";



mysqli_close($con);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Catalog</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="../css/global.css" />
  <link rel="stylesheet" href="../css/catalog.css" />
  <link rel="stylesheet" href="../components/all.css">
  <link rel="icon" type="image/png" href="innovatio-icon.png" sizes="16x16">

</head>

<body>
  <div class="catalog">
    <div class="navigator">
      <?php include('../components/nav.php') ?>
    </div>
    <div class="frame-wrapper">
      <div class="frame-2">
        <div class="frame-3">
          <div class="text-wrapper-3">Curriculum Evaluation</div>
        </div>
        <div class="frame-4">
          <div class="frame-5">


            <div class="div-wrapper">
              <div class="text-wrapper-4">On-going Evaluations</div>
            </div>

            <div class="frame-6">

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


                    if ($active_evaluations === $total_evaluations) {
                      $status = "Active";
                      echo '
                <a href="catalog-selection.php?course_id=' . urlencode($course_row["course_id"]) . '">
                    <div class="curriculum-container">
                        <div class="frame-7"></div>
                        <div class="frame-8">
                            <div class="frame-9">
                                <div class="div-wrapper">
                                    <div class="text-wrapper-5">' . htmlspecialchars($status) . '</div>
                                </div>
                                <div class="frame-3">
                                    <div class="text-wrapper-4">' . htmlspecialchars($course_row["course_name"]) . '</div>
                                </div>
                            </div>
                            <div class="div-wrapper">
                                <span class="evaluation-label">Deadline:</span>
                                <div class="text-wrapper-6">' . htmlspecialchars($evaluation_deadline) . '</div>
                            </div>
                        </div>
                    </div>
                </a>
            ';
                    } elseif (empty($active_evaluations)) {
                      $status = "Inactive";
                    } else {
                      $status = "Pending";
                      echo '
                <a href="catalog-selection.php?course_id=' . urlencode($course_row["course_id"]) . '">
                    <div class="curriculum-container">
                        <div class="frame-7"></div>
                        <div class="frame-8">
                            <div class="frame-9">
                                <div class="div-wrapper">
                                    <div class="text-wrapper-5">' . htmlspecialchars($status) . '</div>
                                </div>
                                <div class="frame-3">
                                    <div class="text-wrapper-4">' . htmlspecialchars($course_row["course_name"]) . '</div>
                                </div>
                            </div>
                            <div class="div-wrapper">
                                <span class="evaluation-label">Deadline:</span>
                                <div class="text-wrapper-6">' . htmlspecialchars($evaluation_deadline) . '</div>
                            </div>
                        </div>
                    </div>
                </a>
            ';

                    }





                  }
                } else {
                  echo "No course details found.";
                }
              } else {
                echo "No courses found for the user.";
              }

              // Close the database connection
              mysqli_close($con);




              ?>
            </div>
          </div>


          <div class="frame-10">
            <div class="frame-5">
              <div class="div-wrapper">
                <div class="text-wrapper-4">Completed Evaluations</div>
              </div>
              <div class="frame-6">

                <?php if ($status === "Inactive") {
                  echo '
                <a href="catalog-selection.php?course_id=' . urlencode($_SESSION["course_id"]) . '">
                    <div class="curriculum-container">
                        <div class="frame-7"></div>
                        <div class="frame-8">
                            <div class="frame-9">
                                <div class="div-wrapper">
                                    <div class="text-wrapper-5">' . htmlspecialchars($status) . '</div>
                                </div>
                                <div class="frame-3">
                                    <div class="text-wrapper-4">' . htmlspecialchars($_SESSION["course_name"]) . '</div>
                                </div>
                            </div>
                            <div class="div-wrapper">
                                <span class="evaluation-label">Deadline:</span>
                                <div class="text-wrapper-6">' . htmlspecialchars($evaluation_deadline) . '</div>
                            </div>
                        </div>
                    </div>
                </a>
            ';
                }

                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include('../components/footer.php') ?>
  </div>
</body>
<script src="https://www.chatbase.co/embed.min.js" chatbotId="m2no5re7gKnDgnq30Logf" domain="www.chatbase.co" defer>
</script>

</html>