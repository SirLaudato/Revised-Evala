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

// Check if course_id is set
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    // Query to fetch course_name and course_description
    $course_query = "SELECT course_name, course_description FROM courses WHERE course_id = ?";
    $stmt = $con->prepare($course_query);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($course_name, $course_description);
    $stmt->fetch();

    // Check if course was found
    if (!$course_name) {
        die("Error: Course not found.");
    }
} else {
    session_start();
    session_destroy();

    header("Location: ../pages/login.php");
    exit();
}
?>



<?php
// Fetch the course name using course_id
$course_query = "SELECT course_name FROM courses WHERE course_id = ?";
$course_stmt = $con->prepare($course_query);
$course_stmt->bind_param("i", $course_id); // Bind the course_id parameter
$course_stmt->execute();
$course_result = $course_stmt->get_result();

// Check if the course is found
if ($course_result->num_rows > 0) {
    $course_row = $course_result->fetch_assoc();
    $course_name = $course_row['course_name']; // Get the course name
} else {
    die("Error: Course not found.");
}
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/evaluation.css" />
    <link rel="stylesheet" href="../components/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="questionnaire">
        <div class="navigator">
            <?php include('../components/nav.php') ?>
        </div>

        <div class="frame-2">
            <div class="frame-wrapper">
                <div class="frame-3">
                    <!-- The Course name (ex. Computer Science) -->
                    <div class="text-wrapper-3">
                        <?php
                        // Output the course name
                        echo htmlspecialchars($course_name);
                        ?>
                    </div>
                    <p class="p">
                        <?php
                        // Output the course description
                        echo htmlspecialchars($course_description);
                        ?>
                    </p>
                </div>
                <div class="frame-3">
                    <ol>
                        <li><strong>1 - Strongly Disagree</strong></li>
                        <li><strong>2 - Disagree</strong></li>
                        <li><strong>3 - Neutral</strong></li>
                        <li><strong>4 - Agree</strong></li>
                        <li><strong>5 - Strongly Agree</strong></li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="questionnaire-evaluation">
            <form action="/submit-evaluation" method="POST">
                <?php
                // Ensure the course_id and evaluation_id are passed
                if (!isset($_GET['course_id']) || !isset($_GET['evaluation_id'])) {
                    die("Error: course_id or evaluation_id is not set.");
                }

                $course_id = $_GET['course_id'];
                $evaluation_id = $_GET['evaluation_id'];

                // Fetch the evaluation based on evaluation_id and course_id
                $evaluation_query = "SELECT * FROM evaluations WHERE evaluation_id = ? AND course_id = ?";
                $stmt = $con->prepare($evaluation_query);
                $stmt->bind_param("ii", $evaluation_id, $course_id);
                $stmt->execute();
                $evaluation_result = $stmt->get_result();

                if ($evaluation_result->num_rows > 0) {
                    $evaluation_row = $evaluation_result->fetch_assoc();
                    $evaluator_type = $evaluation_row['evaluator_type'];
                } else {
                    die("Error: Evaluation not found.");
                }

                // Fetch criteria based on evaluation_id
                $criteria_query = "SELECT * FROM criteria WHERE evaluator_type = ? AND active_flag = 1";
                $criteria_stmt = $con->prepare($criteria_query);
                $criteria_stmt->bind_param("s", $evaluator_type);
                $criteria_stmt->execute();
                $criteria_result = $criteria_stmt->get_result();

                // Check if we have criteria for this evaluation
                if ($criteria_result->num_rows > 0) {
                    while ($criteria_row = $criteria_result->fetch_assoc()) {
                        $criteria_id = $criteria_row['criteria_id'];
                        $criteria_name = $criteria_row['criteria_name'];
                        ?>

                        <!-- Per Section -->
                        <div class="per-section">
                            <div class="frame-3">
                                <!-- Section name -->
                                <div class="text-wrapper-3"><?php echo htmlspecialchars($criteria_name); ?></div>

                                <p class="p">
                                    Answer the following questions based on your experience. Good luck!
                                </p>
                                <div id="progress-modal">
                                    <div class="progress-text"><span id="progress-percentage">0%</span></div>
                                    <div id="progress-bar">
                                        <div style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fetch and display questions for this criteria -->
                            <div class="questionnaire-per-section">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>1<br></th>
                                            <th>2<br></th>
                                            <th>3<br></th>
                                            <th>4<br></th>
                                            <th>5<br></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch questions for the current criteria
                                        $questions_query = "SELECT * FROM questionnaire WHERE criteria_id = ?";
                                        $questions_stmt = $con->prepare($questions_query);
                                        $questions_stmt->bind_param("i", $criteria_id);
                                        $questions_stmt->execute();
                                        $questions_result = $questions_stmt->get_result();

                                        if ($questions_result->num_rows > 0) {
                                            // Loop through questions and display them
                                            $question_number = 1;
                                            while ($question_row = $questions_result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td class="question"><?php echo htmlspecialchars($question_row['question']); ?></td>
                                                    <td><input type="radio"
                                                            name="q<?php echo $criteria_id; ?>_<?php echo $question_number; ?>"
                                                            value="1" required></td>
                                                    <td><input type="radio"
                                                            name="q<?php echo $criteria_id; ?>_<?php echo $question_number; ?>"
                                                            value="2"></td>
                                                    <td><input type="radio"
                                                            name="q<?php echo $criteria_id; ?>_<?php echo $question_number; ?>"
                                                            value="3"></td>
                                                    <td><input type="radio"
                                                            name="q<?php echo $criteria_id; ?>_<?php echo $question_number; ?>"
                                                            value="4"></td>
                                                    <td><input type="radio"
                                                            name="q<?php echo $criteria_id; ?>_<?php echo $question_number; ?>"
                                                            value="5"></td>

                                                </tr>
                                                <?php
                                                $question_number++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No questions available for this section.</td></tr>";
                                        }
                                        ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    echo "No criteria found for this evaluation.";
                }
                ?>

                <button type="submit" class="submit-btn" disabled>Submit Evaluation</button>
                <button type="button" class="cancel-btn"
                    onclick="window.location.href='course_list.php'">Cancel</button>
            </form>
        </div>

        <script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
        const totalQuestions = document.querySelectorAll('input[type="radio"][required]').length;
        const progressBar = document.querySelector('#progress-bar > div');
                const progressPercentage = document.getElementById('progress-percentage');
                const submitButton = document.querySelector('.submit-btn');

                // Check if the progress bar elements exist
                if (!progressBar || !progressPercentage) {
                    console.error("Progress bar elements not found.");
                return;
        }

                // Function to update the progress
                function updateProgress() {
            const answeredQuestions = Array.from(
                document.querySelectorAll('input[type="radio"]:checked')
            ).filter(input => input.name.startsWith('q')).length;

                const progress = Math.round((answeredQuestions / totalQuestions) * 100);

                console.log(`Answered questions: ${answeredQuestions}`);
                console.log(`Total questions: ${totalQuestions}`);
                console.log(`Progress: ${progress}%`);

                progressBar.style.width = `${progress}%`;
                progressPercentage.textContent = `${progress}%`;

                submitButton.disabled = answeredQuestions < totalQuestions;
        }

                // Attach event listeners to radio buttons
                const radios = document.querySelectorAll('input[type="radio"]');
        radios.forEach(radio => {
                    radio.addEventListener('change', updateProgress);
        });

                // Initialize progress
                updateProgress();
    });
        </script>
        </script>

        <?php include '../components/footer.php' ?>
    </div>
</body>

</html>