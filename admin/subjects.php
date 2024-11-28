<?php
// Include the database connection
include('db_conn_records.php');  

// Handle Create and Update operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST['subject_code'];
    $description = $_POST['description'];

    // Validate input
    if (!empty($subject_name) && !empty($subject_code) && !empty($description)) {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Edit existing subject
            $id = $_POST['id'];
            $sql = "UPDATE subjects SET subject_name = ?, subject_code = ?, description = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $subject_name, $subject_code, $description, $id);

            if ($stmt->execute()) {
                header("Location: subjects.php");  // Redirect after successful update
                exit;
            } else {
                echo "Error updating subject: " . $conn->error;
            }
        } else {
            // Create new subject
            $sql = "INSERT INTO subjects (subject_name, subject_code, description) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $subject_name, $subject_code, $description);

            if ($stmt->execute()) {
                header("Location: subjects.php");  // Redirect after successful insertion
                exit;
            } else {
                echo "Error creating subject: " . $conn->error;
            }
        }
    } else {
        echo "All fields are required.";
    }
}

// Handle Delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete subject
    $sql = "DELETE FROM subjects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: subjects.php");  // Redirect after successful deletion
        exit;
    } else {
        echo "Error deleting subject: " . $conn->error;
    }
}

// If there's an ID in the URL, fetch subject data for editing
$subject = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM subjects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $subject = $result->fetch_assoc();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subject Management</title>
    <link rel="stylesheet" href="../admin css/subject.css">
    <link rel="stylesheet" href="../admin css/admin global.css">
</head>
<body>
<?php include("index.php") ?>
<div class="subject-parent-div">

    <div class="subject-add">
        <!-- Create or Edit Subject Form -->
        <form method="POST" action="subjects.php">
            <?php if ($subject): ?>
                <h2>Edit Subject</h2>
                <input type="hidden" name="id" value="<?php echo $subject['id']; ?>" />
            <?php else: ?>
                <h2>Add New Subject</h2>
            <?php endif; ?>

            <!-- Subject Name Input -->
            <label for="subject_name">Subject Name:</label>
            <input type="text" id="subject_name" name="subject_name" placeholder="Algebra" value="<?php echo ($subject ? $subject['subject_name'] : ''); ?>" required>

            <!-- Subject Code Input -->
            <label for="subject_code">Subject Code:</label>
            <input type="text" id="subject_code" name="subject_code" placeholder="MATH101" value="<?php echo ($subject ? $subject['subject_code'] : ''); ?>" required>

            <!-- Description Input -->
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" placeholder="Studies certain abstract systems" value="<?php echo ($subject ? $subject['description'] : ''); ?>" required>

            <input type="submit" value="<?php echo $subject ? 'Update Subject' : 'Create Subject'; ?>">
        </form>
    </div>

    <div class="subject-list">
        <!-- Display List of Subjects -->
        <h2>Subjects List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>


                <?php
                // Fetch all subjects
                $sql = "SELECT * FROM subjects";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['subject_name']; ?></td>
                    <td><?php echo $row['subject_code']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                        <a href="subjects.php?id=<?php echo $row['id']; ?>">Edit</a> |
                        <a href="subjects.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this subject?')">Delete</a>
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
