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

    // Handle deletion (delete faculty record)
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];

        // Delete query
        $delete_sql = "DELETE FROM `users` WHERE `user_id` = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            echo "<script>alert('Faculty deleted successfully.');</script>";
        } else {
            echo "<script>alert('Error deleting faculty.');</script>";
        }

        $stmt->close();
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
                <label for="name">Course:</label>
                <input type="text" id="name" name="name" required>
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
                                        </button>
                                        <button class='delete-btn' data-id='{$row['user_id']}'>Delete</button>
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
            const deleteButtons = document.querySelectorAll('.delete-btn');
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

            // Delete faculty
            deleteButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (confirm("Are you sure you want to delete this faculty member?")) {
                        const userId = button.dataset.id;
                        window.location.href = `?delete_id=${userId}`;
                    }
                });
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