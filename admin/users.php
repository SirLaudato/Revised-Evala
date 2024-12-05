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

// Queries to count users by roles
$studentQuery = "SELECT COUNT(`user_id`) AS total_students FROM `users` WHERE `role` = 'Student'";
$facultyQuery = "SELECT COUNT(`user_id`) AS total_faculties FROM `users` WHERE `role` = 'Faculty'";
$alumniQuery = "SELECT COUNT(`user_id`) AS total_alumni FROM `users` WHERE `role` = 'Alumni'";
$IABQuery = "SELECT COUNT(`user_id`) AS total_IAB FROM `users` WHERE `role` = 'IAB'";

$studentResult = $conn->query($studentQuery);
$facultyResult = $conn->query($facultyQuery);
$alumniResult = $conn->query($alumniQuery);
$IABResult = $conn->query($IABQuery);

// Fetch counts, default to 0 if query fails
$total_students = $studentResult ? $studentResult->fetch_assoc()['total_students'] : 0;
$total_faculties = $facultyResult ? $facultyResult->fetch_assoc()['total_faculties'] : 0;
$total_alumni = $alumniResult ? $alumniResult->fetch_assoc()['total_alumni'] : 0;
$total_IAB = $IABResult ? $IABResult->fetch_assoc()['total_IAB'] : 0;

// Query to fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Handle password reset
if (isset($_POST['reset_password'])) {
    $user_id = $_POST['user_id'];
    // Default password reset to "1234"
    $newPassword = password_hash("1234", PASSWORD_DEFAULT);

    // Prepare the query with bound parameters
    $resetQuery = "UPDATE `users` SET `password` = ? WHERE `user_id` = ?";
    $stmt = $conn->prepare($resetQuery);
    $stmt->bind_param("si", $newPassword, $user_id); // 'si' means string and integer

    // Execute the query and check for success
    if ($stmt->execute()) {
        $modalTitle = "Success";
        $modalMessage = "Password reset successfully.";
    } else {
        $modalTitle = "Error";
        $modalMessage = "Failed to reset password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criteria List</title>
    <link rel="stylesheet" href="../components/modal.css">
    <link rel="stylesheet" href="../admin-css/modal.css">
    <link rel="stylesheet" href="../admin-css/criteria.css">
    <link rel="icon" type="image/png" href="../pages/innovatio-icon.png" sizes="16x16">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="navigator">
        <?php include('../admin/index.php');
        include('../pages/modal.php'); ?>
    </div>
    <div style="width: 20%; margin: auto;">
        <canvas id="roleDoughnutChart"></canvas>
    </div>

    <script>
        // Data from PHP
        const data = {
            labels: ['Students', 'Faculties', 'Alumni', 'IAB'],
            datasets: [{
                label: 'User Distribution by Role',
                data: [
                    <?php echo $total_students; ?>,
                    <?php echo $total_faculties; ?>,
                    <?php echo $total_alumni; ?>,
                    <?php echo $total_IAB; ?>
                ],
                backgroundColor: ['#42a5f5', '#66bb6a', '#ffa726', '#ffc107'], // Custom colors
                hoverBackgroundColor: ['#1e88e5', '#43a047', '#fb8c00', '#ffc107']
            }]
        };

        // Configuration for the doughnut chart
        const config = {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                }
            }
        };

        // Render the chart
        const ctx = document.getElementById('roleDoughnutChart').getContext('2d');
        new Chart(ctx, config);
    </script>

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
                                <td>{$row['role']}</td>
                                <td>$status</td>
                                <td>
                                    <form method='POST'>
                                        <input type='hidden' name='user_id' value='{$row['user_id']}'>
                                        <button type='submit' name='reset_password' class='edit'>Reset Password</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No users found.</td></tr>";
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
            </form>
        </div>
    </div>
</body>

</html>