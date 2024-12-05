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
$dbname = "evala_db1"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the transaction
$conn->begin_transaction();

// Handle Add Faculty
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_faculty'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $department = $_POST['department'];
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
        echo "<script>alert('Email already exists. Please use a different email.');</script>";
    } else {
        $conn->begin_transaction();
        try {
            $insertUserSql = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `role`, `active_flag`) 
                              VALUES (?, ?, ?, ?, 'Faculty', ?)";
            $stmt = $conn->prepare($insertUserSql);
            $password = password_hash('1234', PASSWORD_DEFAULT);
            $stmt->bind_param("ssssi", $fname, $lname, $email, $password, $status);
            $stmt->execute();

            $user_id = $conn->insert_id;

            $insertFacultySql = "INSERT INTO `faculty` (`user_id`, `position`, `department`, `course_id`, `hired_date`) 
                                 VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertFacultySql);
            $stmt->bind_param("sssis", $user_id, $position, $department, $course_id, date('Y-m-d'));
            $stmt->execute();

            $evaluationSql = "SELECT `evaluation_id` FROM `evaluations` WHERE `evaluator_type` = 'Faculty'";
            $evaluationResult = $conn->query($evaluationSql);

            if ($evaluationResult->num_rows > 0) {
                $insertUserEvaluationsSql = "
                    INSERT INTO `user_evaluations` (`evaluation_id`, `user_id`, `has_answered`)
                    VALUES (?, ?, 1)";
                $stmt = $conn->prepare($insertUserEvaluationsSql);
                while ($row = $evaluationResult->fetch_assoc()) {
                    $evaluationId = $row['evaluation_id'];
                    $stmt->bind_param("ii", $evaluationId, $user_id);
                    $stmt->execute();
                }
            }

            $conn->commit();

            $_SESSION['message'] = 'Faculty added successfully.';
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>alert('An error occurred while adding the faculty.');</script>";
        }
    }
}

// Handle Edit Faculty
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user'])) {
    $user_id = $_POST['edit_user_id'];
    $email = $_POST['edit_email'];
    $position = $_POST['edit_position'];
    $department = $_POST['edit_department'];
    $status = $_POST['edit_status'];

    $conn->begin_transaction();
    try {
        // Update user table
        $stmt = $conn->prepare("UPDATE `users` SET `email` = ?, `active_flag` = ? WHERE `user_id` = ?");
        $stmt->bind_param("sii", $email, $status, $user_id);
        $stmt->execute();

        // Update faculty table
        $stmt = $conn->prepare("UPDATE `faculty` SET `position` = ?, `department` = ? WHERE `user_id` = ?");
        $stmt->bind_param("ssi", $position, $department, $user_id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
    }
        $_SESSION['message'] = 'User updated successfully.';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

// Query to fetch user data
$sql = "SELECT `users`.`user_id`, `users`.`first_name`, `users`.`last_name`, `users`.`email`, `users`.`active_flag`, 
        `faculty`.`position`, `faculty`.`department`, `faculty`.`hired_date`, `courses`.`course_name`
        FROM `users` 
        LEFT JOIN `faculty` ON `faculty`.`user_id` = `users`.`user_id` 
        LEFT JOIN `courses` ON `faculty`.`course_id` = `courses`.`course_id`
        WHERE `users`.`role` = 'Faculty';";

$result = $conn->query($sql);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty List</title>
    <link rel="stylesheet" href="../admin-css/modal.css">
    <link rel="stylesheet" href="../admin-css/faculty.css">
    <link rel="icon" type="image/png" href="../pages/innovatio-icon.png" sizes="16x16">
</head>

<body>
    <div class="navigator">
        <?php include('../admin/index.php') ?>
    </div>

    <div class="parent-faculty-container">
        <div class="faculty-add">
            <h2>Add New Faculty</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">First Name:</label>
                    <input type="text" id="fname" name="fname" required>
                </div>
                <div class="form-group">
                    <label for="name">Last Name:</label>
                    <input type="text" id="lname" name="lname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Position:</label>
                    <input type="text" id="position" name="position" required>
                </div>
                <div class="form-group">
                    <label for="department">Department:</label>
                    <select id="department" name="department" required>
                        <option value="">Select Department</option>
                        <option value="COECSA">COECSA</option>
                        <option value="CLAE">CLAE</option>
                        <option value="CAMS">CAMS</option>
                        <option value="CBA">CBA</option>
                        <option value="CITHM">CITHM</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="course">Course:</label>
                    <select id="course" name="course" required>
                        <option value="">Select a course</option>
                        <?php
                        // Fetch available courses from the database
                        $coursesSql = "SELECT course_id, course_name FROM courses";
                        $coursesResult = $conn->query($coursesSql);

                        if ($coursesResult->num_rows > 0) {
                            while ($course = $coursesResult->fetch_assoc()) {
                                echo "<option value=\"{$course['course_id']}\">{$course['course_name']}</option>";
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
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name="add_faculty">Create Faculty</button>
                </div>
            </form>
        </div>

        <div class="faculty-list">
            <h2>Faculty List</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Hired Date</th>
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
                                <td>{$row['first_name']}</td>
                                <td>{$row['last_name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$status}</td>
                                <td>{$row['position']}</td>
                                <td>{$row['department']}</td>
                                <td>{$row['hired_date']}</td>
                                <td>{$row['course_name']}</td>
                                <td>
                                    <div class='buttons'>
                                        <button class='edit-btn' 
                                        data-id='{$row['user_id']}'
                                        data-name='{$row['first_name']} {$row['last_name']}'
                                        data-email='{$row['email']}'
                                        data-position='{$row['position']}' 
                                        data-department='{$row['department']}' 
                                        data-status='{$row['active_flag']}'>
                                        Edit
                                        </button>
                                    </div>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No faculty found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Faculty Modal -->
    <div id="editModal" class="modal" style="display:none;">
        <div class="modal-content">
            <form id="editForm" method="POST">
                <input type="hidden" name="edit_user_id" id="edit_user_id">
                <label for="edit_name">Name:</label>
                <input type="text" id="edit_name" name="edit_name" readonly> <!-- Display only -->
                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" name="edit_email" required>
                <label for="edit_position">Position:</label>
                <input type="text" id="edit_position" name="edit_position" required>
                <label for="edit_department">Department:</label>
                <input type="text" id="edit_department" name="edit_department" required>
                <label for="edit_status">Status:</label>
                <select id="edit_status" name="edit_status" required>
                    <option value="1">Active</option>
                    <option value="0">Locked</option>
                </select>
                <button type="submit" name="edit_user">Save Changes</button>
            </form>
        </div>
    </div>

</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get all edit buttons
        const editButtons = document.querySelectorAll('.edit-btn');

        // Add click event to each button
        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-id');
                const email = this.getAttribute('data-email');
                const position = this.getAttribute('data-position');
                const department = this.getAttribute('data-department');
                const status = this.getAttribute('data-status');
                const name = this.getAttribute('data-name');

                // Populate modal form with existing values
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_user_id').value = userId;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_position').value = position;
                document.getElementById('edit_department').value = department;
                document.getElementById('edit_status').value = status;

                // Display modal
                document.getElementById('editModal').style.display = 'flex';
            });
        });

        // Close modal when clicking outside of it
        const modal = document.getElementById('editModal');
        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });

</script>
