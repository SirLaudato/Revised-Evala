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
// Handle Edit
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['criteria_id'])) {
//     $criteria_id = $_POST['criteria_id'];
//     $criteria_name = $_POST['criteria_name'];
//     $evaluator_type = $_POST['evaluator_type'];
//     $status = $_POST['status'];

//     $update_sql = "UPDATE `criteria` SET `criteria_name` = ?, `evaluator_type` = ?, `active_flag` = ? WHERE `criteria_id` = ?";
//     $stmt = $conn->prepare($update_sql);
//     $stmt->bind_param("ssii", $criteria_name, $evaluator_type, $status, $criteria_id);

//     if ($stmt->execute()) {
//         echo "<script>alert('Criteria updated successfully'); window.location.href = ''; </script>";
//     } else {
//         echo "<script>alert('Error updating criteria');</script>";
//     }
//     $stmt->close();
// }

// Query to fetch all criteria
$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criteria List</title>
    <link rel="stylesheet" href="../admin-css/modal.css">
    <link rel="stylesheet" href="../admin-css/criteria.css">
    <link rel="icon" type="image/png" href="../pages/innovatio-icon.png" sizes="16x16">
</head>

<body>

    <div class="navigator">
        <?php include('../admin/index.php'); ?>
    </div>

    <div class="parent-criteria-container">
        <div class="criteria-list">
            <h2>Users</h2>
            <!-- Criteria Table -->
            <table border="1">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>E-mail</th>
                        <th>Role</th>
                        <th>Status</th>
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
                                <td>{$row['role']}</td>
                                <td>$status</td>
                                <td>
                                    <div class='buttons'>
                                        <button class='edit-btn' 
                                            data-id='{$row['user_id']}'
                                            data-name='{$row['first_name']} {$row['last_name']}'
                                            data-type='{$row['email']}'
                                            data-status='$status'>
                                            Edit
                                    </div>    
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No criteria found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>






    <!-- Edit Criteria Modal -->
    <div id="editModal" class="modal" style="display:none;">

        <span class="close">&times;</span>
        <div class="modal-content">

            <form id="editForm" method="POST">
                <input type="hidden" name="criteria_id" id="criteria_id">

                <label for="name">Full Name</label>
                <input type="text" id="name" name="criteria_name">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="1">Active</option>
                    <option value="0">Locked</option>
                </select>


                <button type="submit" name="edit_user">Save Changes</button>
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

            // Open edit modal and populate fields
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Populate the modal with data
                    const status = button.dataset.status == 'Active' ? '1' : '0';  // Set '1' for Active and '0' for Locked
                    document.getElementById('criteria_id').value = button.dataset.id;
                    document.getElementById('name').value = button.dataset.name;
                    document.getElementById('evaluator_type').value = button.dataset.type;
                    document.getElementById('status').value = status; // Set the correct default status

                    // Open the modal
                    modal.style.display = 'flex';
                });
            });

            // Close edit modal
            closeModal.addEventListener('click', () => {
                modal.style.display = 'none';
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