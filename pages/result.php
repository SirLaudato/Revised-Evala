<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/evaluation.css" />
    <title>Document</title>
</head>

<body>
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
            <button type="button" class="cancel-btn" onclick="window.location.href='course_list.php'">Cancel</button>
        </form>





    </div>
</body>

</html>