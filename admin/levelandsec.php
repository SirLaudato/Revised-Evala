<?php
// Include the database connection
include('db_conn_records.php');  

// Handle Create and Update operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $course_id = $_POST['course_id'];  // New field to associate a course
    $evaluation_status = $_POST['evaluation_status'];

    // Validate input
    if (!empty($year) && !empty($semester) && !empty($course_id) && !empty($evaluation_status)) {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Edit existing record
            $id = $_POST['id'];
            $sql = "UPDATE levelandsec SET year = ?, semester = ?, course_id = ?, evaluation_status = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $year, $semester, $course_id, $evaluation_status, $id);

            if ($stmt->execute()) {
                header("Location: levelandsec.php");  // Redirect after successful update
                exit;
            } else {
                echo "Error updating level and section: " . $conn->error;
            }
        } else {
            // Create new record
            $sql = "INSERT INTO levelandsec (year, semester, course_id, evaluation_status) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $year, $semester, $course_id, $evaluation_status);

            if ($stmt->execute()) {
                header("Location: levelandsec.php");  // Redirect after successful insertion
                exit;
            } else {
                echo "Error creating level and section: " . $conn->error;
            }
        }
    } else {
        echo "All fields are required.";
    }
}

// Handle Delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete record
    $sql = "DELETE FROM levelandsec WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: levelandsec.php");  // Redirect after successful deletion
        exit;
    } else {
        echo "Error deleting level and section: " . $conn->error;
    }
}

// If there's an ID in the URL, fetch record data for editing
$levelandsec = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM levelandsec WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $levelandsec = $result->fetch_assoc();
    }
}

// Fetch all courses for the dropdown list
$courses_result = $conn->query("SELECT id, name FROM courses");  // Use the correct column name here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Level and Section Management</title>
    <link rel="stylesheet" href="../admin css/levelandsec.css">
    <link rel="stylesheet" href="../admin css/admin global.css">
</head>
<body>
    <div class="levelandsec-parent-div">

        <div class="levelandsec-add">
            <!-- Create or Edit Level and Section Form -->
            <form method="POST" action="levelandsec.php">
                <?php if ($levelandsec): ?>
                    <h2>Edit Level and Section</h2>
                    <input type="hidden" name="id" value="<?php echo $levelandsec['id']; ?>" />
                <?php else: ?>
                    <h2>Add New Level and Section</h2>
                <?php endif; ?>

                <!-- Year Input (Changed to Text) -->
                <label for="year">Year:</label>
                <input type="text" id="year" name="year" placeholder="2022-2023" value="<?php echo ($levelandsec ? $levelandsec['year'] : ''); ?>" required><br><br>

                <!-- Semester Input -->
                <label for="semester">Semester:</label>
                <select id="semester" name="semester" required>
                    <option value="">Select Semester</option>
                    <option value="1" <?php echo ($levelandsec && $levelandsec['semester'] == '1') ? 'selected' : ''; ?>>1</option>
                    <option value="2" <?php echo ($levelandsec && $levelandsec['semester'] == '2') ? 'selected' : ''; ?>>2</option>
                    <option value="3" <?php echo ($levelandsec && $levelandsec['semester'] == '3') ? 'selected' : ''; ?>>3</option>
                </select><br><br>

                <!-- Course Dropdown -->
                <label for="course_id">Course:</label>
                <select id="course_id" name="course_id" required>
                    <option value="">Select Course</option>
                    <?php while ($course = $courses_result->fetch_assoc()): ?>
                        <option value="<?php echo $course['id']; ?>" <?php echo ($levelandsec && $levelandsec['course_id'] == $course['id']) ? 'selected' : ''; ?>>
                            <?php echo $course['name']; ?>  <!-- Adjusted for correct column name -->
                        </option>
                    <?php endwhile; ?>
                </select><br><br>

                <!-- Evaluation Status Dropdown -->
                <label for="evaluation_status">Evaluation Status:</label>
                <select id="evaluation_status" name="evaluation_status" required>
                    <option value="">Select Evaluation Status</option>
                    <option value="Starting" <?php echo ($levelandsec && $levelandsec['evaluation_status'] == 'Starting') ? 'selected' : ''; ?>>Starting</option>
                    <option value="Not Yet Started" <?php echo ($levelandsec && $levelandsec['evaluation_status'] == 'Not Yet Started') ? 'selected' : ''; ?>>Not Yet Started</option>
                    <option value="Done" <?php echo ($levelandsec && $levelandsec['evaluation_status'] == 'Done') ? 'selected' : ''; ?>>Done</option>
                </select><br><br>

                <input type="submit" value="<?php echo $levelandsec ? 'Update Level and Section' : 'Create Level and Section'; ?>">
            </form>
        </div>
        <div class="levelandsec-list">
            <!-- Display List of Level and Section Records -->
            <h2>Level and Section List</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Year</th>
                        <th>Semester</th>
                        <th>Course</th>
                        <th>Evaluation Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch all level and section records
                    $sql = "SELECT l.id, l.year, l.semester, l.evaluation_status, c.name AS course_name
                            FROM levelandsec l 
                            JOIN courses c ON l.course_id = c.id";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                        <td><?php echo $row['semester']; ?></td>
                        <td><?php echo $row['course_name']; ?></td>
                        <td><?php echo $row['evaluation_status']; ?></td>
                        <td>
                            <a href="levelandsec.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="levelandsec.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
    </div>

</body>
</html>

<?php
$conn->close();  // Close the database connection at the end
?>
