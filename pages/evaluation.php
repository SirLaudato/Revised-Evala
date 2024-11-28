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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="innovatio-icon.png" sizes="16x16">

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
            <?php
            // Ensure the course_id and evaluation_id are passed
            if (!isset($_GET['course_id']) || !isset($_GET['evaluation_id'])) {
                die("Error: course_id or evaluation_id is not set.");
            }

            $course_id = $_GET['course_id'];
            $evaluation_id = $_GET['evaluation_id'];
            $user_id = $_SESSION['user_id'];  // Assuming session contains user_id
            
            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get the submitted answers (question_id => rate pairs)
                $answers = $_POST['answers'];

                // Save the answers in evaluation_results table
                $insert_query = "INSERT INTO evaluation_results (user_id, question_id, rate) VALUES (?, ?, ?)";
                $stmt = $con->prepare($insert_query);

                foreach ($answers as $question_id => $rate) {
                    $stmt->bind_param("iii", $user_id, $question_id, $rate); // Include user_id
                    $stmt->execute();
                }

                // Now check if all questions in the criteria have been answered for this user
                $criteria_query = "SELECT DISTINCT criteria_id FROM questionnaire WHERE question_id IN (" . implode(',', array_keys($answers)) . ")";
                $criteria_stmt = $con->prepare($criteria_query);
                $criteria_stmt->execute();
                $criteria_result = $criteria_stmt->get_result();

                while ($criteria_row = $criteria_result->fetch_assoc()) {
                    $criteria_id = $criteria_row['criteria_id'];

                    // Count total questions in this criteria
                    $total_questions_query = "SELECT COUNT(*) AS total_questions FROM questionnaire WHERE criteria_id = ?";
                    $total_questions_stmt = $con->prepare($total_questions_query);
                    $total_questions_stmt->bind_param("i", $criteria_id);
                    $total_questions_stmt->execute();
                    $total_questions_result = $total_questions_stmt->get_result();
                    $total_questions = $total_questions_result->fetch_assoc()['total_questions'];

                    // Count how many questions the user has answered in this criteria
                    $answered_questions_query = "SELECT COUNT(*) AS answered_questions FROM evaluation_results 
                                      WHERE user_id = ? AND question_id IN (SELECT question_id FROM questionnaire WHERE criteria_id = ?)";
                    $answered_questions_stmt = $con->prepare($answered_questions_query);
                    $answered_questions_stmt->bind_param("ii", $user_id, $criteria_id);
                    $answered_questions_stmt->execute();
                    $answered_questions_result = $answered_questions_stmt->get_result();
                    $answered_questions = $answered_questions_result->fetch_assoc()['answered_questions'];

                    // If all questions are answered, update active_flag in user_evaluations table
                    if ($answered_questions == $total_questions) {
                        $update_flag_query = "UPDATE user_evaluations SET has_answered = 0 WHERE user_id = ?";
                        $update_flag_stmt = $con->prepare($update_flag_query);
                        $update_flag_stmt->bind_param("i", $user_id);
                        $update_flag_stmt->execute();
                    }
                }



                echo "<div class='success-message'>Responses saved successfully and statuses updated!</div>";
            }

            // Fetch evaluation and criteria to render the form
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

            // Fetch active criteria for this evaluation
            $criteria_query = "SELECT * FROM criteria WHERE evaluator_type = ? AND active_flag = 1";
            $criteria_stmt = $con->prepare($criteria_query);
            $criteria_stmt->bind_param("s", $evaluator_type);
            $criteria_stmt->execute();
            $criteria_result = $criteria_stmt->get_result();
            ?>

            <form method="POST">
                <?php
                if ($criteria_result->num_rows > 0) {
                    while ($criteria_row = $criteria_result->fetch_assoc()) {
                        $criteria_id = $criteria_row['criteria_id'];
                        $criteria_name = $criteria_row['criteria_name'];
                        ?>

                        <div class="per-section">
                            <div class="frame-3">
                                <div class="text-wrapper-3"><?php echo htmlspecialchars($criteria_name); ?></div>
                                <p>Answer the following questions based on your experience.</p>
                            </div>
                            <div class="questionnaire-per-section">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $questions_query = "SELECT * FROM questionnaire WHERE criteria_id = ?";
                                        $questions_stmt = $con->prepare($questions_query);
                                        $questions_stmt->bind_param("i", $criteria_id);
                                        $questions_stmt->execute();
                                        $questions_result = $questions_stmt->get_result();

                                        if ($questions_result->num_rows > 0) {
                                            while ($question_row = $questions_result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td class="question"><?php echo htmlspecialchars($question_row['question']); ?></td>
                                                    <td><input type="radio" name="answers[<?php echo $question_row['question_id']; ?>]"
                                                            value="1" required></td>
                                                    <td><input type="radio" name="answers[<?php echo $question_row['question_id']; ?>]"
                                                            value="2"></td>
                                                    <td><input type="radio" name="answers[<?php echo $question_row['question_id']; ?>]"
                                                            value="3"></td>
                                                    <td><input type="radio" name="answers[<?php echo $question_row['question_id']; ?>]"
                                                            value="4"></td>
                                                    <td><input type="radio" name="answers[<?php echo $question_row['question_id']; ?>]"
                                                            value="5"></td>
                                                </tr>
                                                <?php
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
                    echo "No active criteria found for this evaluation.";
                }
                ?>
                <button type="submit" class="submit-btn">Submit Evaluation</button>
                <button type="button" class="cancel-btn"
                    onclick="window.location.href='course_list.php'">Cancel</button>
            </form>





        </div>


        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const totalQuestions = document.querySelectorAll('input[type="radio"][required]').length; // Get required radio buttons
                console.log(`Total questions: ${totalQuestions}`);

                const progressBar = document.querySelector('#progress-bar > div');  // Select the progress bar element
                const progressPercentage = document.getElementById('progress-percentage');  // Select the progress percentage element
                const submitButton = document.querySelector('.submit-btn');  // Select the submit button

                // Ensure the progress bar and percentage elements are found
                if (!progressBar || !progressPercentage) {
                    console.error('Progress bar elements not found.');
                    return;
                }

                // Add event listeners to radio buttons after DOM is ready
                const radios = document.querySelectorAll('input[type="radio"]');
                radios.forEach(radio => {
                    radio.addEventListener('change', updateProgress);
                });

                // Function to update the progress bar
                function updateProgress() {
                    const answeredQuestions = Array.from(
                        document.querySelectorAll('input[type="radio"]:checked')
                    ).filter(input => input.name.startsWith('q')).length;

                    const progress = Math.round((answeredQuestions / totalQuestions) * 100);

                    console.log('Updating progress...');
                    console.log(`Answered questions: ${answeredQuestions}`);
                    console.log(`Total questions: ${totalQuestions}`);
                    console.log(`Progress: ${progress}%`);

                    // Update progress bar width and percentage text
                    progressBar.style.width = `${progress}%`;
                    progressPercentage.textContent = `${progress}%`;

                    // Enable or disable the submit button
                    submitButton.disabled = answeredQuestions < totalQuestions;
                }

                // Initialize progress
                updateProgress();  // Initialize progress on page load
            });
        </script>

        <?php include '../components/footer.php' ?>
    </div>
</body>

</html>