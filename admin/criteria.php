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

    // Handle Add Criteria
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_criteria'])) {
        $criteria_name = $_POST['criteria_name'];
        $evaluator_type = $_POST['evaluator_type'];
        $status = $_POST['status'] == "active" ? 1 : 0;

        $insert_sql = "INSERT INTO `criteria` (`criteria_name`, `evaluator_type`, `active_flag`) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssi", $criteria_name, $evaluator_type, $status);

        if ($stmt->execute()) {
            echo "<script>alert('Criteria added successfully'); window.location.href = ''; </script>";
        } else {
            echo "<script>alert('Error adding criteria');</script>";
        }
        $stmt->close();
    }

    // Handle Delete
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $delete_sql = "DELETE FROM `criteria` WHERE `criteria_id` = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            echo "<script>alert('Criteria deleted successfully'); window.location.href = ''; </script>";
        } else {
            echo "<script>alert('Error deleting criteria');</script>";
        }
        $stmt->close();
    }

    // Handle Edit
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['criteria_id'])) {
        $criteria_id = $_POST['criteria_id'];
        $criteria_name = $_POST['criteria_name'];
        $evaluator_type = $_POST['evaluator_type'];
        $status = $_POST['status'];

        $update_sql = "UPDATE `criteria` SET `criteria_name` = ?, `evaluator_type` = ?, `active_flag` = ? WHERE `criteria_id` = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssii", $criteria_name, $evaluator_type, $status, $criteria_id);

        if ($stmt->execute()) {
            echo "<script>alert('Criteria updated successfully'); window.location.href = ''; </script>";
        } else {
            echo "<script>alert('Error updating criteria');</script>";
        }
        $stmt->close();
    }

    // Query to fetch all criteria
    $sql = "SELECT `criteria`.* FROM `criteria`";
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
    <div class="criteria-add">
        <h2>Add New Criteria</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="criteria_name">Criteria Name:</label>
                <input type="text" id="criteria_name" name="criteria_name" required>
            </div>
            <div class="form-group">
                <label for="evaluator_type">Evaluator:</label>
                <select id="evaluator_type" name="evaluator_type" required>
                    <option value="">Select Evaluator</option>
                    <option value="Student">Student</option>
                    <option value="Faculty">Faculty</option>
                    <option value="Alumni">Alumni</option>
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
                <button type="submit" name="add_criteria">Add Criteria</button>
            </div>
        </form>
    </div>

    <div class="criteria-list">
        <h2>Criteria List</h2>
        <!-- Criteria Table -->
        <table border="1">
            <thead>
                <tr>
                    <th>Criteria ID</th>
                    <th>Criteria Name</th>
                    <th>Evaluator</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $status = $row['active_flag'] == 1 ? 'Active' : 'Locked';
                        echo "<tr>
                                <td>{$row['criteria_id']}</td>
                                <td>{$row['criteria_name']}</td>
                                <td>{$row['evaluator_type']}</td>
                                <td>$status</td>
                                <td>
                                    <div class='buttons'>
                                        <button class='edit-btn' 
                                            data-id='{$row['criteria_id']}'
                                            data-name='{$row['criteria_name']}'
                                            data-type='{$row['evaluator_type']}'
                                            data-status='$status'>
                                            Edit
                                        </button>
                                        <button class='delete-btn' data-id='{$row['criteria_id']}'>Delete</button>
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

                <label for="name">Criteria Name</label>
                <input type="text" id="name" name="criteria_name">
                

                <label for="evaluator_type">Evaluator Type</label>
                <select id="evaluator_type" name="evaluator_type">
                    <option value="Student">Student</option>
                    <option value="Faculty">Faculty</option>
                    <option value="Alumni">Alumni</option>
                </select>
                

                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="1">Active</option>
                    <option value="0">Locked</option>
                </select>
                

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

            // Delete criteria
            deleteButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (confirm("Are you sure you want to delete this criteria?")) {
                        const criteriaId = button.dataset.id;
                        window.location.href = `?delete_id=${criteriaId}`;
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