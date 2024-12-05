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
// Handle Edit Course
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_course'])) {
    $course_id = $_POST['course_id'];
    $course_name = $_POST['edit_course_name'];
    $course_desc = $_POST['edit_course_desc'];
    $course_department = $_POST['edit_department'];
    $status = $_POST['edit_status']; // Ensure this is either 1 or 0

    $conn->begin_transaction();
    try {
        // Update the course in the database
        $stmt = $conn->prepare("UPDATE `courses` SET `course_name` = ?, `course_description` = ?, `department` = ?, `active_flag` = ? WHERE `course_id` = ?");
        $stmt->bind_param("sssii", $course_name, $course_desc, $course_department, $status, $course_id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();
        $_SESSION['message'] = 'Course updated successfully.';
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['message'] = 'Failed to update course: ' . $e->getMessage();
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}



// Handle Add Course
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_course'])) {
    // Collect form inputs
    $course_name = $_POST['course_name'];
    $course_desc = $_POST['course_desc'];
    $department = $_POST['department'];
    $evaluation_start_date = $_POST['evaluation_start_date'];
    $evaluation_end_date = $_POST['evaluation_end_date'];
    $status = ($_POST['status'] == "active") ? 1 : 0;


    // Insert course into the `courses` table
    $insert_course_sql = "INSERT INTO `courses` (`course_name`, `course_description`, `department`, `active_flag`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_course_sql);
    $stmt->bind_param("sssi", $course_name, $course_desc, $department, $status);

    if ($stmt->execute()) {
        // Get the last inserted course ID
        $course_id = $conn->insert_id;

        // Define evaluator types
        $evaluator_types = ['student', 'faculty', 'alumni'];

        // Insert evaluations for each evaluator type and criteria
        foreach ($evaluator_types as $evaluator_type) {
            // Fetch criteria for the current evaluator type
            $criteria_query = "SELECT criteria_id FROM criteria WHERE evaluator_type = ?";
            $criteria_stmt = $conn->prepare($criteria_query);
            $criteria_stmt->bind_param('s', $evaluator_type);
            $criteria_stmt->execute();
            $result = $criteria_stmt->get_result();

            // Insert evaluations for each criteria
            while ($row = $result->fetch_assoc()) {
                $criteria_id = $row['criteria_id'];

                $insert_eval_query = "
                    INSERT INTO evaluations (course_id, evaluator_type, criteria_id, evaluation_start_date, evaluation_end_date, active_flag)
                    VALUES (?, ?, ?, ?, ?, 1)";
                $insert_eval_stmt = $conn->prepare($insert_eval_query);
                $insert_eval_stmt->bind_param('issss', $course_id, $evaluator_type, $criteria_id, $evaluation_start_date, $evaluation_end_date);
                $insert_eval_stmt->execute();
            }

            $criteria_stmt->close();
        }

        echo "<script>alert('Course and evaluations added successfully.'); window.location.href = ''; </script>";
    } else {
        echo "<script>alert('Error adding course. Please try again.');</script>";
    }

    $stmt->close();
}

// Query to fetch all courses
$sql = "SELECT `courses`.* FROM `courses`";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List</title>
    <link rel="stylesheet" href="../admin-css/modal.css">
    <link rel="stylesheet" href="../admin-css/courses.css">
    <link rel="icon" type="image/png" href="../pages/innovatio-icon.png" sizes="16x16">
</head>

<body>
    
    <div class="navigator">
        <?php include('../admin/index.php'); ?>
    </div>

    <div class="parent-courses-container">
        <div class="courses-add">
            <h2>Add New Course</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="course_name">Course Name:</label>
                    <input type="text" id="course_name" name="course_name" required>
                </div>
                <div class="form-group">
                    <label for="course_desc">Course Description:</label>
                    <input type="text" id="course_desc" name="course_desc" required>
                </div>
                <div class="form-group">
                    <label for="department">Department:</label>
                    <input type="text" id="department" name="department" required>
                </div>
                <div class="form-group">
                    <label for="evaluation_start_date">Evaluation Start Date:</label>
                    <input type="date" id="evaluation_start_date" name="evaluation_start_date" required>
                </div>
                <div class="form-group">
                    <label for="evaluation_end_date">Evaluation End Date:</label>
                    <input type="date" id="evaluation_end_date" name="evaluation_end_date" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name="add_course">Add Course</button>
                </div>
            </form>
        </div>

        <div class="courses-list">
            <h2>Course List</h2>
            <!-- courses Table -->
            <table border="1">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Course Description</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $status = $row['active_flag'] == 1 ? 'Active' : 'Inactive';
                            echo "<tr>
                                <td>{$row['course_id']}</td>
                                <td>{$row['course_name']}</td>
                                <td>{$row['course_description']}</td>
                                <td>{$row['department']}</td>
                                <td>$status</td>
                                <td>
                                    <div class='buttons'>
                                        <button class='edit-btn' 
                                            data-id='{$row['course_id']}'
                                            data-name='{$row['course_name']}'
                                            data-desc='{$row['course_description']}'
                                            data-dept='{$row['department']}'
                                            data-status='$status'>
                                            Edit
                                    </div>    
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No course found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>






    <!-- Edit courses Modal -->
    <div id="editModal" class="modal" style="display:none;">

        <span class="close">&times;</span>
        <div class="modal-content">

            <form id="editForm" method="POST">
                <input type="hidden" name="course_id" id="course_id">

                <label for="name">Course Name</label>
                <input type="text" id="edit_course_name" name="edit_course_name">


                <label for="course_desc">Course Description</label>
                <input type="text" id="edit_course_desc" name="edit_course_desc">

                <label for="department">Department</label>
                <input type="text" id="edit_department" name="edit_department">

                <label for="status">Status</label>
                <select id="edit_status" name="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>

                <button type="submit" id="edit_course" name="edit_course">Save Changes</button>
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
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const desc = this.getAttribute('data-desc');
            const dept = this.getAttribute('data-dept'); // Corrected key
            const status = this.getAttribute('data-status') === 'Active' ? 1 : 0; // Handle active status as 1 or 0

            // Populate modal form with existing values
            document.getElementById('course_id').value = id; // Hidden input for course ID
            document.getElementById('edit_course_name').value = name;
            document.getElementById('edit_course_desc').value = desc;
            document.getElementById('edit_department').value = dept;
            document.getElementById('edit_status').value = status; // Set correct value (1 or 0)

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

    // Close modal when clicking the close button
    document.querySelector('.close').addEventListener('click', function () {
        modal.style.display = 'none';
    });
});

</script>