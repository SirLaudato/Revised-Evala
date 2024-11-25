<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";
$con = new mysqli($servername, $username, $password, $database);

if ($con->connect_error) {
    die("Connection Failed: " . $con->connect_error);
}

// Check if course_id is passed via GET
if (!isset($_GET['course_id'])) {
    die("Error: course_id is not set.");
}

$course_id = $_GET['course_id'];

// Fetch course details (course_name) from the courses table
$course_query = "SELECT course_name, course_description FROM courses WHERE course_id = ?";
$stmt = $con->prepare($course_query);
if (!$stmt) {
    die("Query preparation failed: " . $con->error);
}

$stmt->bind_param("i", $course_id);
$stmt->execute();
$course_result = $stmt->get_result();

// Fetch the course data
if ($course_result->num_rows > 0) {
    $course_row = $course_result->fetch_assoc();
    $course_name = htmlspecialchars($course_row["course_name"]);
    $course_description = htmlspecialchars($course_row["course_description"]);
} else {
    // Handle case when no course is found
    $course_name = "Course not found";
    $course_description = "No description available.";
}

// Now fetch the evaluation details for the course
$evaluation_query = "
    SELECT evaluation_id, evaluator_type, evaluation_start_date, evaluation_end_date 
    FROM evaluations 
    WHERE course_id = ? AND active_flag = 1";

$stmt = $con->prepare($evaluation_query);
if (!$stmt) {
    die("Query preparation failed: " . $con->error);
}

$stmt->bind_param("i", $course_id);
$stmt->execute();
$evaluation_result = $stmt->get_result();

// Fetch the evaluation data
if ($evaluation_result->num_rows > 0) {
    $evaluation = $evaluation_result->fetch_assoc();
    $evaluation_id = $evaluation['evaluation_id']; // Set evaluation_id
    $evaluation_name = "Evaluation for " . htmlspecialchars($evaluation['evaluator_type']); // Custom name using evaluator_type
    $evaluation_start_date = htmlspecialchars($evaluation['evaluation_start_date']);
    $evaluation_end_date = htmlspecialchars($evaluation['evaluation_end_date']);
    $evaluation_status = "Active"; // Assuming the evaluation is active if it's in the database
} else {
    // Handle case when no evaluation is found
    $evaluation_id = null;
    $evaluation_name = "No evaluation found";
    $evaluation_status = "N/A";
    $evaluation_start_date = "N/A";
    $evaluation_end_date = "N/A";
}

$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Catalog Selection</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/catalog-selection.css" />
    <link rel="stylesheet" href="../components/all.css">
    <link rel="icon" type="image/png" href="innovatio-icon.png" sizes="16x16">

</head>

<body>
    <div class="questionnaire">
        <div class="navigator">
            <?php include('../components/nav.php') ?>
        </div>
<div class="catalog-container">
    <div class="evaluation-pics-desc">
        <div class="evaluation-img"></div>
        <div class="eval-overview">
            <!-- Display course name dynamically -->
            <div class="eva-name"><?php echo $course_name; ?></div>
            <p class="eval-desc">
                <?php echo $course_description; ?>
            </p>
        </div>
    </div>
    <div class="evaluation-navigator">
        <div class="evaluation-title">
            <div class="text-wrapper-3"><?php echo $course_name; ?></div> <!-- Display course name here -->
            <div class="evaluation-status">
                <div class="text-wrapper-4">Status: <?php echo $evaluation_status; ?></div>
                <div class="text-wrapper-4">Start Date: <?php echo $evaluation_start_date; ?></div>
                <div class="text-wrapper-4">End Date: <?php echo $evaluation_end_date; ?></div>
            </div>
        </div>
        <div class="buttons">
<?php
if ($evaluation_id !== null) {
    // If evaluation_id is available, create the link to the evaluation page
    echo '<a href="evaluation.php?course_id=' . $course_id . '&evaluation_id=' . $evaluation_id . '">
            <button class="start-eval-button">
                <span class="text-wrapper-6">Start Evaluation</span>
            </button>
          </a>';
} else {
    echo "<p>No active evaluation available for this course.</p>";
}
?>
            <a href="catalog.php">
                <button class="check-other-button">
                    <span class="text-wrapper-7">Check Other Evaluation</span>
                </button>
            </a>
        </div>
    </div>
</div>
        <?php include('../components/footer.php') ?>
    </div>
</body>

</html>