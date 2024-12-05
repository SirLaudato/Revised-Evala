<?php
session_start();
if (!isset($_SESSION['emailaddress'])) {
  header("Location: ../pages/login.php");
  exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";

$con = mysqli_connect($servername, $username, $password, $database);

if (!$con) {
  die("Connection Failed: " . mysqli_connect_error());
}

// Check if user_id is set in the session
if (!isset($_SESSION["user_id"])) {
  die("Error: User not logged in.");
}

$course_query = "
  SELECT DISTINCT `courses`.`course_id`, `courses`.`course_name`, `courses`.`course_cover`
  FROM `users`
  LEFT JOIN `students` ON `students`.`user_id` = `users`.`user_id`
  LEFT JOIN `alumni` ON `alumni`.`user_id` = `users`.`user_id`
  LEFT JOIN `faculty` ON `faculty`.`user_id` = `users`.`user_id`
  LEFT JOIN `courses` ON `courses`.`course_id` = COALESCE(`students`.`course_id`, `alumni`.`course_id`, `faculty`.`course_id`)
  WHERE `users`.`user_id` = " . intval($_SESSION["user_id"]) . ";
";

$result = $con->query($course_query);

// Check if the query returned any results
if ($result && $result->num_rows > 0) {
  // Fetch the first course_id and store it in the session
  $row = $result->fetch_assoc();
  $_SESSION["course_id"] = $row["course_id"];
  $_SESSION["course_name"] = $row["course_name"];
  $_SESSION["course_cover"] = $row["course_cover"];

  // Query to get evaluation status
  $active_evaluation_query = "
        SELECT COUNT(*) AS `active_evaluations`
        FROM `evaluations`
        LEFT JOIN `user_evaluations` ON `user_evaluations`.`evaluation_id` = `evaluations`.`evaluation_id`
        LEFT JOIN `users` ON `user_evaluations`.`user_id` = `users`.`user_id`
        WHERE `user_evaluations`.`has_answered` = 1
        AND `users`.`user_id` = " . intval($_SESSION["user_id"]) . ";
    ";

  $total_evaluation_query = "
        SELECT COUNT(*) AS `total_evaluations`
        FROM `evaluations`
        LEFT JOIN `user_evaluations` ON `user_evaluations`.`evaluation_id` = `evaluations`.`evaluation_id`
        LEFT JOIN `users` ON `user_evaluations`.`user_id` = `users`.`user_id`
        WHERE `evaluations`.`course_id` = " . intval($_SESSION["course_id"]) . "
        AND `users`.`user_id`= " . intval($_SESSION["user_id"]) . ";
    ";

  $total_result = $con->query($total_evaluation_query);
  $active_result = $con->query($active_evaluation_query);

  if ($total_result && $active_result) {
    $total_row = $total_result->fetch_assoc();
    $active_row = $active_result->fetch_assoc();

    $_SESSION['total_evaluations'] = $total_row['total_evaluations'];
    $_SESSION['active_evaluations'] = $active_row['active_evaluations'];

    if ($_SESSION['active_evaluations'] === $_SESSION['total_evaluations']) {
      $_SESSION["status"] = "Not yet completed";
    } elseif ($_SESSION['active_evaluations'] == 0) {
      $_SESSION["status"] = "Completed";
    } else {
      $_SESSION["status"] = "Pending";
    }
  } else {
    echo "Query failed: " . mysqli_error($con);
  }
}
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
              <?php if ($_SESSION['status'] === "Not yet completed" || $_SESSION['status'] === "Pending") { ?>
                <a href="catalog-selection.php?course_id=<?php echo urlencode($_SESSION['course_id']); ?>">
                  <div class="curriculum-container">
                    <div class="frame-7">
                      <img class="frame-7" src="<?php echo htmlspecialchars($_SESSION['course_cover']); ?>" alt="">
                    </div>
                    <div class="frame-8">
                      <div class="frame-9">
                        <div class="div-wrapper">
                          <div class="text-wrapper-5">
                            <?php echo htmlspecialchars($_SESSION['status']); ?>
                          </div>
                        </div>
                        <div class="frame-3">
                          <div class="text-wrapper-4">
                            <?php echo htmlspecialchars($_SESSION['course_name']); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              <?php } else { ?>
                <p>No pending evaluations.</p>
              <?php } ?>
            </div>
          </div>

          <!-- Completed Evaluations Section -->
          <div class="frame-10">
            <div class="frame-5">
              <div class="div-wrapper">
                <div class="text-wrapper-4">Completed Evaluations</div>
              </div>
              <div class="frame-6">
                <?php if ($_SESSION['status'] === "Completed") { ?>
                  <a href="catalog-selection.php?course_id=<?php echo urlencode($_SESSION['course_id']); ?>">
                    <div class="curriculum-container">
                      <div class="frame-7">
                        <img class="frame-7" src="<?php echo htmlspecialchars($_SESSION['course_cover']); ?>" alt="">
                      </div>
                      <div class="frame-8">
                        <div class="frame-9">
                          <div class="div-wrapper">
                            <div class="text-wrapper-5">
                              <?php echo htmlspecialchars($_SESSION['status']); ?>
                            </div>
                          </div>
                          <div class="frame-3">
                            <div class="text-wrapper-4">
                              <?php echo htmlspecialchars($_SESSION['course_name']); ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                <?php } else { ?>
                  <p>No completed evaluations yet.</p>
                <?php } ?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <?php include('../components/footer.php') ?>
  </div>
</body>
<script src="https://www.chatbase.co/embed.min.js" chatbotId="m2no5re7gKnDgnq30Logf" domain="www.chatbase.co"
  defer></script>

</html>