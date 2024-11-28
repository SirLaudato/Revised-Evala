<?php
// Include the database connection
include('db_conn_records.php');  

// Handle Create and Update operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department_id = $_POST['department']; 
    $name = $_POST['name']; 
    $description = $_POST['description']; 

    // Validate input
    if (!empty($department_id) && !empty($name) && !empty($description)) {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Edit existing course
            $id = $_POST['id'];
            $sql = "UPDATE courses SET department_id = ?, name = ?, description = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issi", $department_id, $name, $description, $id);

            if ($stmt->execute()) {
                header("Location: courses.php");  // Redirect after successful update
                exit;
            } else {
                echo "Error updating course: " . $conn->error;
            }
        } else {
            // Create new course
            $sql = "INSERT INTO courses (department_id, name, description) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $department_id, $name, $description);


            if ($stmt->execute()) {
                header("Location: courses.php");  // Redirect after successful insertion
                exit;
            } else {
                echo "Error creating course: " . $conn->error;
            }
        }
    } else {
        echo "All fields are required.";
    }
}

// Handle Delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete course
    $sql = "DELETE FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin/courses.php");  // Redirect after successful deletion
        exit;
    } else {
        echo "Error deleting course: " . $conn->error;
    }
}

// If there's an ID in the URL, fetch course data for editing
$course = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Management</title>
    <link rel="stylesheet" href="../admin css/courses.css">
    <link rel="stylesheet" href="../admin css/admin global.css">
    
</head>
<body>
<?php include("index.php") ?>
    <div class="parent-course-div">

        <div class="course-management">
            <h2><?php echo $course ? 'Edit Course' : 'Add New Course'; ?></h2>
            <form method="POST" action="courses.php">
                <?php if ($course): ?>
                    <input type="hidden" name="id" value="<?php echo $course['id']; ?>" />
                <?php endif; ?>

                <label for="department">Department:</label>
                <select id="department" name="department" required>
                    <option value="">Select Department</option>
                    <option value="1" <?php echo ($course && $course['department_id'] == 1) ? 'selected' : ''; ?>>CAMS</option>
                    <option value="2" <?php echo ($course && $course['department_id'] == 2) ? 'selected' : ''; ?>>CAS</option>
                    <option value="3" <?php echo ($course && $course['department_id'] == 3) ? 'selected' : ''; ?>>CBA</option>
                    <option value="4" <?php echo ($course && $course['department_id'] == 4) ? 'selected' : ''; ?>>COECSA</option>
                    <option value="5" <?php echo ($course && $course['department_id'] == 5) ? 'selected' : ''; ?>>CFAD</option>
                    <option value="6" <?php echo ($course && $course['department_id'] == 6) ? 'selected' : ''; ?>>CITHM</option>
                    <option value="7" <?php echo ($course && $course['department_id'] == 7) ? 'selected' : ''; ?>>BSN</option>
                </select>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="BSCS - CS301" value="<?php echo ($course ? $course['name'] : ''); ?>" required>

                <label for="description">Description:</label>
                <input type="text" id="description" name="description" placeholder="Bachelor of Computer Science" value="<?php echo ($course ? $course['description'] : ''); ?>" required>

                <input type="submit" value="<?php echo $course ? 'Update Course' : 'Create Course'; ?>">
            </form>
        </div>

        <div class="course-list">
            <h2>Courses List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Department</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM courses";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $department_name = '';
                        if ($row['department_id'] == 1) $department_name = 'CAMS';
                        if ($row['department_id'] == 2) $department_name = 'CAS';
                        if ($row['department_id'] == 3) $department_name = 'CBA';
                        if ($row['department_id'] == 4) $department_name = 'COECSA';
                        if ($row['department_id'] == 5) $department_name = 'CFAD';
                        if ($row['department_id'] == 6) $department_name = 'CITHM';
                        if ($row['department_id'] == 7) $department_name = 'BSN';
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $department_name; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>
                            <a href="courses.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="courses.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    
    </div>


</body>
</html>
<?php
$conn->close();  // Close the database connection at the end
?>
