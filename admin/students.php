<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if ($_SESSION['role'] != 'IAB') {
    session_destroy();
    header('Location: /Revised-Evala/pages/login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evala_db1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Add Student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $student_number = $_POST['student_number'];
    $student_year = $_POST['student_year'];
    $course_id = $_POST['course'];
    $status = ($_POST['status'] == 'active') ? 1 : 0;

    // Check if the email already exists
    $checkEmailSql = "SELECT COUNT(*) FROM `users` WHERE `email` = ?";
    $stmt = $conn->prepare($checkEmailSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($emailCount);
    $stmt->fetch();
    $stmt->close();

    if ($emailCount > 0) {
        // If email already exists, show an error message
        echo "<script>alert('Email already exists. Please use a different email.');</script>";
    } else {
        // Insert the new student if email doesn't exist
        $insertUserSql = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `role`, `active_flag`) 
                          VALUES (?, ?, ?, ?, 'Student', ?)";
        $stmt = $conn->prepare($insertUserSql);
        $password = password_hash('1234', PASSWORD_DEFAULT); // Default password
        $stmt->bind_param("ssssi", $fname, $lname, $email, $password, $status);
        $stmt->execute();

        $user_id = $conn->insert_id;

        $insertStudentSql = "INSERT INTO `students` (`user_id`, `student_number`, `student_year`, `course_id`) 
                             VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertStudentSql);
        $stmt->bind_param("isis", $user_id, $student_number, $student_year, $course_id);
        $stmt->execute();
        $evaluationIds = [];
        $evaluationSql = "SELECT `evaluation_id` FROM `evaluations` WHERE `evaluator_type` = 'Student'";
        $evaluationResult = $conn->query($evaluationSql);

        if ($evaluationResult->num_rows > 0) {
            while ($row = $evaluationResult->fetch_assoc()) {
                $evaluationIds[] = $row['evaluation_id'];
            }
        }

        foreach ($evaluationIds as $evaluationId) {
            $insertUserEvaluationsSql = "
                INSERT INTO `user_evaluations` (`evaluation_id`, `user_id`, `has_answered`)
                VALUES (?, ?, 1)";

            $stmt = $conn->prepare($insertUserEvaluationsSql);
            $stmt->bind_param("ii", $evaluationId, $user_id);

            if (!$stmt->execute()) {
                echo "Error inserting evaluation ID {$evaluationId} for user ID {$user_id}: " . $stmt->error;
            }
        }

        // Debugging: Confirmation message (optional)
        echo "User evaluations inserted successfully for user ID: {$user_id}";

        echo "<script>alert('Student added successfully.'); window.location.reload();</script>";
    }
}

// Handle Edit User
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user'])) {
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $status = $_POST['status'];

    $updateSql = "UPDATE `users` SET `email` = ?, `active_flag` = ? WHERE `user_id` = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("sii", $email, $status, $user_id);
    $stmt->execute();

    // Set session message for success
    $_SESSION['message'] = 'User updated successfully.';

    // Redirect to avoid the alert from looping
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$sql = "SELECT `users`.`user_id`, `users`.`first_name`, `users`.`last_name`, `users`.`email`, 
               `users`.`active_flag`, `students`.`student_number`, `students`.`student_year`, 
               `courses`.`course_name`
        FROM `users`
        LEFT JOIN `students` ON `students`.`user_id` = `users`.`user_id`
        LEFT JOIN `courses` ON `students`.`course_id` = `courses`.`course_id`
        WHERE `users`.`role` = 'Student';";

$result = $conn->query($sql);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
</head>

<body>
    <?php
    if (isset($_SESSION['message'])) {
        echo "<script>alert('" . $_SESSION['message'] . "');</script>";
        unset($_SESSION['message']);
    }
    ?>

    <div class="parent-alumni-container">
        <div class="alumni-add">
            <h2>Add New Student</h2>
            <form method="post" id="addStudentForm">
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" id="fname" name="fname" required
                        value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" id="lname" name="lname" required
                        value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required
                        value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="student_number">Student Number:</label>
                    <input type="text" id="student_number" name="student_number" required
                        value="<?php echo isset($_POST['student_number']) ? $_POST['student_number'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="student_year">Student Year:</label>
                    <input type="number" id="student_year" name="student_year" min="1" max="4" required
                        value="<?php echo isset($_POST['student_year']) ? $_POST['student_year'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="course">Course:</label>
                    <select id="course" name="course" required>
                        <option value="">Select a course</option>
                        <?php
                        $coursesSql = "SELECT course_id, course_name FROM courses";
                        $coursesResult = $conn->query($coursesSql);

                        if ($coursesResult->num_rows > 0) {
                            while ($course = $coursesResult->fetch_assoc()) {
                                echo "<option value=\"{$course['course_id']}\" " . (isset($_POST['course']) && $_POST['course'] == $course['course_id'] ? 'selected' : '') . ">{$course['course_name']}</option>";
                            }
                        } else {
                            echo "<option value=\"\">No courses available</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="active" <?php echo isset($_POST['status']) && $_POST['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="locked" <?php echo isset($_POST['status']) && $_POST['status'] == 'locked' ? 'selected' : ''; ?>>Locked</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name="add_student">Add Student</button>
                </div>
            </form>
        </div>

        <div class="student-list">
            <h2>Student List</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Student Number</th>
                        <th>Year</th>
                        <th>Course</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $status = $row['active_flag'] == 1 ? 'Active' : 'Locked';
                            echo "<tr>
                                    <td>{$row['user_id']}</td>
                                    <td>{$row['first_name']} {$row['last_name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$status}</td>
                                    <td>{$row['student_number']}</td>
                                    <td>{$row['student_year']}</td>
                                    <td>{$row['course_name']}</td>
                                    <td><button class='edit-btn' data-id='{$row['user_id']}' data-email='{$row['email']}' data-status='{$row['active_flag']}'>Edit</button></td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No students found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" style="display:none;">
        <form method="post" id="editUserForm">
            <h2>Edit Student</h2>
            <input type="hidden" id="edit_user_id" name="user_id">
            <div class="form-group">
                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" name="email" required>
            </div>
            <div class="form-group">
                <label for="edit_status">Status:</label>
                <select id="edit_status" name="status" required>
                    <option value="1">Active</option>
                    <option value="0">Locked</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" name="edit_user">Save Changes</button>
                <button type="button" onclick="closeModal()">Close</button>
            </div>
        </form>
    </div>

    <script>
        // Open Edit Modal
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.dataset.id;
                const email = this.dataset.email;
                const status = this.dataset.status;

                document.getElementById('edit_user_id').value = userId;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_status').value = status;

                document.getElementById('editModal').style.display = 'block';
            });
        });

        // Close Modal
        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Close Modal when clicked outside
        window.onclick = function (event) {
            if (event.target == document.getElementById('editModal')) {
                closeModal();
            }
        };
    </script>
</body>

</html>