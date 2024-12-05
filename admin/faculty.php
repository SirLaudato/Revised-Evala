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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission (update faculty data)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    // Get updated values from the form
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $status = $_POST['status'];

    // Update query
    $update_sql = "UPDATE `users` SET `email` = ?, `active_flag` = ? WHERE `user_id` = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sii", $email, $status, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Faculty updated successfully.');</script>";
    } else {
        echo "<script>alert('Error updating faculty.');</script>";
    }

    $stmt->close();
}

// Handle Add Student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $student_number = $_POST['email'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $course_id = $_POST['course'];
    $status = ($_POST['status'] == 'active') ? 1 : 0;

    $insertUserSql = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `role`, `active_flag`) 
                      VALUES (?, ?, ?, ?, 'Student', ?)";
    $stmt = $conn->prepare($insertUserSql);
    $password = password_hash('1234', PASSWORD_DEFAULT); // Default password
    $stmt->bind_param("ssssi", $fname, $lname, $email, $password, $status);
    $stmt->execute();

    $user_id = $conn->insert_id;

    $insertFacultySql = "INSERT INTO `students` (`user_id`, `student_number`, `student_year`, `course_id`) 
                         VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertFacultySql);
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

    echo "<script>alert('Student added successfully.'); window.location.reload();</script>";
}
// Query to fetch user data
$sql = "SELECT `users`.`user_id`, `users`.`first_name`, `users`.`last_name`, `users`.`email`, `users`.`active_flag`, `faculty`.`position`, `faculty`.`department`, `faculty`.`hired_date`, `courses`.`course_name`
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
            <form>
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
                        <option value="coecsa">COECSA</option>
                        <option value="coecsa">CLAE</option>
                        <option value="coecsa">CAMS</option>
                        <option value="coecsa">CBA</option>
                        <option value="coecsa">CITHM</option>
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
                    <button type="submit">Create Faculty</button>
                </div>
            </form>
        </div>

        <div class="faculty-list">
            <h2>Faculty List</h2>
            <!-- Faculty Table -->
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
                                        <button class='edit-btn' data-id='{$row['user_id']}'
                                            data-name='{$row['first_name']} {$row['last_name']}'
                                            data-email='{$row['email']}'
                                            data-status='{$row['active_flag']}'>
                                            Edit
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
        <span class="close">&times;</span>
        <div class="modal-content">
            <form id="editForm" method="POST">
                <input type="hidden" name="user_id" id="user_id">

                <label for="name">Name</label>
                <input type="text" id="name" name="name" readonly>


                <label for="email">E-mail</label>
                <input type="email" id="email" name="email">


                <label for="status">Status</label>
                <div>
                    <button type="button" id="activeButton">Active</button>
                    <button type="button" id="lockButton">Lock</button>
                </div>

                <input type="hidden" id="status" name="status">


                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- JavaScript for handling modals and form submission -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('editModal');
            const closeModal = document.querySelector('.close');
            const editButtons = document.querySelectorAll('.edit-btn');
            const statusField = document.getElementById('status');
            const activeButton = document.getElementById('activeButton');
            const lockButton = document.getElementById('lockButton');

            // Open edit modal and populate fields
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    document.getElementById('user_id').value = button.dataset.id;
                    document.getElementById('name').value = button.dataset.name;
                    document.getElementById('email').value = button.dataset.email;
                    statusField.value = button.dataset.status;

                    modal.style.display = 'flex';
                });
            });

            // Close edit modal
            closeModal.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            // Update status
            activeButton.addEventListener('click', () => {
                statusField.value = 1;
                alert('Status set to Active');
            });

            lockButton.addEventListener('click', () => {
                statusField.value = 0;
                alert('Status set to Locked');
            });


            // Close modal on outside click
            window.addEventListener('click', event => {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>