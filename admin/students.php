<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    if ($_SESSION['role'] != 'IAB') {
        session_destroy();
        header('Location: /Revised-Evala/pages/login.php');
        exit();
    }

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "evala_db1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch user data
    $sql = "SELECT `users`.`user_id`, `users`.`first_name`, `users`.`last_name`, `users`.`email`, 
                `users`.`active_flag`, `students`.`student_number`, `students`.`student_year`, 
                `students`.`course_id`, `courses`.`course_name`
            FROM `users`
            LEFT JOIN `students` ON `students`.`user_id` = `users`.`user_id`
            LEFT JOIN `courses` ON `students`.`course_id` = `courses`.`course_id`
            WHERE `users`.`role` = 'Student';";

    $result = $conn->query($sql);

    // Handle form submission (update user data)
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
            echo "<script>alert('User updated successfully.');</script>";
        } else {
            echo "<script>alert('Error updating user.');</script>";
        }

        $stmt->close();
    }

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin-css/modal.css">
    <link rel="stylesheet" href="../admin-css/students.css">
    <title>Students</title>
</head>

<body>
    <div class="navigator">
        <?php include('../admin/index.php'); ?>
    </div>
    
    <div class="parent-student-container">
        <div class="student-add">
            <h2>Add New Student </h2>
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
                    <label for="student_number">Student Number:</label>
                    <input type="text" id="student_number" name="student_number" required>
                </div>
                <div class="form-group">
                    <label for="student_year">Student Year:</label>
                    <input type="text" id="student_year" name="student_year" required>
                </div>
                <div class="form-group">
                    <label for="course">Course:</label>
                    <input type="text" id="course" name="course" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit">Create Alumni</button>
                </div>
            </form>
        </div>
        <div class="student-list">
            <h2>Student List</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Student Number</th>
                        <th>Student Year</th>
                        <th>Course</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $yearMapping = [
                                1 => '1st',
                                2 => '2nd',
                                3 => '3rd',
                                4 => '4th'
                            ];
                            $studentYear = $yearMapping[$row['student_year']] ?? 'Unknown';
                            $status = $row['active_flag'] == 1 ? 'Active' : 'Locked';

                            echo "<tr>
                                    <td>{$row['user_id']}</td>
                                    <td>{$row['first_name']}</td>
                                    <td>{$row['last_name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>$status</td>
                                    <td>{$row['student_number']}</td>
                                    <td>$studentYear</td>
                                    <td>{$row['course_name']}</td>
                                    <td>
                                        <button class='edit-btn' data-id='{$row['user_id']}'
                                            data-name='{$row['first_name']} {$row['last_name']}'
                                            data-email='{$row['email']}'
                                            data-status='{$row['active_flag']}'>
                                            Edit
                                        </button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No students found.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>            




    
    <!-- Edit User Modal -->
    <div id="editModal" class="modal" style="display:none;">
        <span class="close">&times;</span>
        <div class="modal-content">
            <form id="editForm" method="post">
                <input type="hidden" name="user_id" id="user_id">

                <label for="name">Name</label>
                <input type="text" id="name" name="name" readonly>
                

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email">
                

                <label for="password">Password</label>
                <button type="button" id="resetPassword">Reset</button>
                

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

    <!-- Reset Password Confirmation Modal -->
    <div id="resetModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close-reset">&times;</span>
            <p>Are you sure you want to reset the password?</p>
            <form id="resetForm" method="post" action="reset_password.php">
                <input type="hidden" name="user_id" id="reset_user_id">
                <input type="hidden" name="new_password"
                    value="$2y$10$hGnWmN4kZv9QF62uEgRfCukPVbaiCs.oM44.vzErKN7fBEHQTRv5u">
                <button type="submit">Yes, Reset</button>
                <button type="button" class="cancel-reset">Cancel</button>
            </form>
        </div>
    </div>

    <!-- JavaScript for handling modals and form submission -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('editModal');
            const resetModal = document.getElementById('resetModal');
            const closeModal = document.querySelector('.close');
            const closeResetModal = document.querySelector('.close-reset');
            const editButtons = document.querySelectorAll('.edit-btn');
            const resetPasswordButton = document.getElementById('resetPassword');
            const statusField = document.getElementById('status');
            const activeButton = document.getElementById('activeButton');
            const lockButton = document.getElementById('lockButton');
            const resetUserId = document.getElementById('reset_user_id');
            const cancelResetButton = document.querySelector('.cancel-reset');

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

            // Open reset modal
            resetPasswordButton.addEventListener('click', () => {
                resetUserId.value = document.getElementById('user_id').value;
                modal.style.display = 'none';
                resetModal.style.display = 'flex';
            });

            // Close reset modal
            closeResetModal.addEventListener('click', () => {
                resetModal.style.display = 'none';
            });

            cancelResetButton.addEventListener('click', () => {
                resetModal.style.display = 'none';
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
                } else if (event.target == resetModal) {
                    resetModal.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>