<?php
session_start();
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
    $evaluation_status = $_SESSION['status'];
} else {
    // Handle case when no evaluation is found
    $evaluation_id = null;
    $evaluation_name = "No evaluation found";
    $evaluation_status = "N/A";
    $evaluation_start_date = "N/A";
    $evaluation_end_date = "N/A";
}

// Prepare the SQL query
$sql_query = "
                SELECT 
                    `users`.`user_id`, 
                    `user_evaluations`.`user_eval_id`, 
                    `user_evaluations`.`has_answered`, 
                    `evaluations`.`evaluation_id`, 
                    `evaluations`.`active_flag` AS `evaluation_active_flag`, 
                    `criteria`.`criteria_id`, 
                    `criteria`.`active_flag` AS `criteria_active_flag`, 
                    `questionnaire`.*, 
                    `evaluation_results`.*
                FROM `users` 
                LEFT JOIN `user_evaluations` ON `user_evaluations`.`user_id` = `users`.`user_id` 
                LEFT JOIN `evaluations` ON `user_evaluations`.`evaluation_id` = `evaluations`.`evaluation_id` 
                LEFT JOIN `criteria` ON `evaluations`.`criteria_id` = `criteria`.`criteria_id` 
                LEFT JOIN `questionnaire` ON `questionnaire`.`criteria_id` = `criteria`.`criteria_id` 
                LEFT JOIN `evaluation_results` ON `evaluation_results`.`user_id` = `users`.`user_id`
                WHERE `users`.`user_id` = ?;";

// Prepare the statement
$stmt = $con->prepare($sql_query);

// Bind the parameter
$stmt->bind_param("i", $user_id);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $evaluation = $result->fetch_assoc();

    // Extract data from the query result
    $course_id = $evaluation['course_id'] ?? null;

}
// Free resources
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
    <link rel="stylesheet" href="../components/modal.css">
    <link rel="icon" type="image/png" href="../innovatio-icon.png" sizes="16x16">

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
                        <div class="text-wrapper-4">Status: <?php echo $_SESSION['status']; ?></div>
                        <div class="text-wrapper-4">Start Date: <?php echo $evaluation_start_date; ?></div>
                        <div class="text-wrapper-4">End Date: <?php echo $evaluation_end_date; ?></div>
                    </div>
                </div>
                <div class="buttons">
                    <?php
                    if ($evaluation_id !== null) {
                        // If evaluation_id is available, create the link to the evaluation page
                        if ($_SESSION['status'] === "Completed") {
                            echo '<a href="catalog-selection.php?course_id=' . urlencode($_SESSION["course_id"]) . '">
                                <button class="start-eval-button" name="start-evaluation" onclick="handleStartEvaluation(event);">
                                    <span class="text-wrapper-6">Start Evaluation</span>
                                </button>
                            </a>
                            <a href="catalog.php">
                                <button class="check-other-button">
                                    <span class="text-wrapper-7">Check Other Evaluation</span>
                                </button>
                            </a>
                            <a href = "result.php?course_id=' . $course_id . '&evaluation_id=' . $evaluation_id . ' &user_id=' . $_SESSION['user_id'] . '">View Results</a>'

                            ;




                        } else {
                            echo '<a href="evaluation.php?course_id=' . $course_id . '&evaluation_id=' . $evaluation_id . '&user_id=' . $_SESSION['user_id'] . '">
                                <button class="start-eval-button">
                                    <span class="text-wrapper-6">Start Evaluation</span>
                                </button>
                            </a><a href="catalog.php">
                                <button class="check-other-button">
                                    <span class="text-wrapper-7">Check Other Evaluation</span>
                                </button>
                            </a>';

                        }

                    } else {
                        echo "<p>No active evaluation available for this course.</p>";
                    }
                    ?>

                </div>
            </div>
        </div>
        <?php include('../pages/modal.php') ?>
        <?php include('../components/footer.php') ?>
    </div>
</body>
<script>
    function showModal(message) {
        const modal = document.getElementById("alertModal");
        const modalMessage = modal.querySelector(".modal-message");
        modalMessage.textContent = message;
        modal.style.display = "block";
    }

    function closeModal() {
        const modal = document.getElementById("alertModal");
        modal.style.display = "none";
    }

    <?php if ($modalTitle && $modalMessage): ?>
        showModal("<?= htmlspecialchars($modalMessage) ?>");
    <?php endif; ?>
</script>

</html>

<script>
    function showModal(type, message) {
        // Determine the correct modal ID based on type
        const modalId = type === 'success' ? 'successModal' : 'failModal';
        const modal = document.getElementById(modalId);

        if (modal) {
            const modalMessage = modal.querySelector('.modal-message');

            // Set the message and make the modal visible
            if (modalMessage) modalMessage.textContent = message;

            modal.style.display = 'block';
            const modalContent = modal.querySelector('.modal-content');

            if (modalContent) {
                modalContent.style.animation = 'slideDown 0.5s ease forwards';
            }
        } else {
            console.error(`Modal with ID "${modalId}" not found.`);
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);

        if (modal) {
            const modalContent = modal.querySelector('.modal-content');

            // Apply slide-up animation before hiding
            if (modalContent) {
                modalContent.style.animation = 'slideUp 0.5s ease forwards';
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 200); // Match the animation duration
            }
        } else {
            console.error(`Modal with ID "${modalId}" not found.`);
        }
    }
</script>


<?php if (!empty($modalTitle) && !empty($modalMessage)): ?>
    <script>
        showModal('<?php echo strtolower($modalTitle); ?>', '<?php echo $modalMessage; ?>');
    </script>
<?php endif; ?>

<script>
    window.addEventListener('click', function (event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (event.target === modal) {
                const modalContent = modal.querySelector('.modal-content');
                if (modalContent) {
                    // Apply slide-up animation
                    modalContent.style.animation = 'slideUp 0.5s ease forwards';

                    // Wait for the animation to complete before hiding the modal
                    setTimeout(() => {
                        modal.style.display = 'none';
                    }, 200); // Match the animation duration
                }
            }
        });
    });
</script>

<script>
    function handleStartEvaluation(event) {
        event.preventDefault();
        showModal('error', 'You have already completed the evaluation for this course.');
        return false; // Prevent the navigation
    }
</script>