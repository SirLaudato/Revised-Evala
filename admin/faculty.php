<?php
// Include the database connection
include('db_conn_people.php');

// Initialize message variable for success/error feedback
$message = "";

// Handle form submission (Create or Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form input data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $status = $_POST['status'];
    $id = isset($_POST['id']) ? $_POST['id'] : null; // ID for editing an existing record

    // Handle file upload (image)
    $target_dir = "uploads/";  // Directory to store uploaded images
    $image_path = "default.jpg"; // Default image path

    // If an image is uploaded, move it to the target directory
    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;
        
        // Move uploaded file to the server
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;  // Update image path with the new file
        }
    }

    // Check if we are updating an existing record or creating a new one
    if ($id) {
        // Update existing record
        $sql = "UPDATE faculty SET name='$name', email='$email', phone='$phone', department='$department', status='$status', image='$image_path' WHERE id=$id";
    } else {
        // Create a new record
        $sql = "INSERT INTO faculty (name, email, phone, department, status, image) VALUES ('$name', '$email', '$phone', '$department', '$status', '$image_path')";
    }

    // Execute the query and handle the result
    if ($conn->query($sql) === TRUE) {
        $message = $id ? "Record updated successfully." : "New record created successfully.";
    } else {
        $message = "Error: " . $conn->error;  // Display error message if query fails
    }
}

// Handle record deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM faculty WHERE id=$id";  // Query to delete the record

    // Execute the delete query and handle the result
    if ($conn->query($sql) === TRUE) {
        $message = "Record deleted successfully.";
    } else {
        $message = "Error: " . $conn->error;  // Display error message if deletion fails
    }
}

// Fetch all faculty records for displaying in a table
$sql = "SELECT * FROM faculty";
$result = $conn->query($sql);

// Fetch a specific record for editing
$edit_record = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $edit_sql = "SELECT * FROM faculty WHERE id=$id";  // Query to fetch the specific record

    $edit_result = $conn->query($edit_sql);
    if ($edit_result->num_rows > 0) {
        $edit_record = $edit_result->fetch_assoc();  // Fetch the record for editing
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty Management</title>

    <link rel="stylesheet" href="../admin css/faculty.css">
    <link rel="stylesheet" href="../admin css/admin global.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>

<div class="faculty-parent-div">
    <div class="faculty-add">

        <!-- Display success/error message -->

        <!-- Create or Edit Faculty Form -->
        <form method="POST" action="faculty.php" enctype="multipart/form-data">
            <h2><?php echo $edit_record ? "Edit Faculty" : "Add New Faculty"; ?></h2>
            
            <!-- Hidden input to store the faculty ID for editing -->
            <input type="hidden" name="id" value="<?php echo $edit_record['id'] ?? ''; ?>">

            <!-- Form fields -->
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $edit_record['name'] ?? ''; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $edit_record['email'] ?? ''; ?>" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $edit_record['phone'] ?? ''; ?>" required>

            <!-- Image upload with drag and drop -->
            <label for="image">Image:</label>
            <div id="image-drop-zone" class="upload-container" ondrop="drop(event)" ondragover="allowDrop(event)">
                <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                <p>Drag & Drop an image here or click to select</p>
                <img id="preview" src="<?php echo $edit_record['image'] ?? 'default.jpg'; ?>" width="150" height="150" alt="Preview">
            </div>

            <!-- Department selection -->
            <label for="department">Department:</label>
            <select id="department" name="department" required>
                <option value="">Select Department</option>
                <option value="CAMS" <?php echo isset($edit_record['department']) && $edit_record['department'] === 'CAMS' ? 'selected' : ''; ?>>CAMS</option>
                <option value="CAS" <?php echo isset($edit_record['department']) && $edit_record['department'] === 'CAS' ? 'selected' : ''; ?>>CAS</option>
                <option value="CBA" <?php echo isset($edit_record['department']) && $edit_record['department'] === 'CBA' ? 'selected' : ''; ?>>CBA</option>
                <option value="COECSA" <?php echo isset($edit_record['department']) && $edit_record['department'] === 'COECSA' ? 'selected' : ''; ?>>COECSA</option>
                <option value="CFAD" <?php echo isset($edit_record['department']) && $edit_record['department'] === 'CFAD' ? 'selected' : ''; ?>>CFAD</option>
                <option value="CITHM" <?php echo isset($edit_record['department']) && $edit_record['department'] === 'CITHM' ? 'selected' : ''; ?>>CITHM</option>
                <option value="BSN" <?php echo isset($edit_record['department']) && $edit_record['department'] === 'BSN' ? 'selected' : ''; ?>>BSN</option>
            </select>

            <!-- Status selection -->
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="active" <?php echo isset($edit_record['status']) && $edit_record['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="onleave" <?php echo isset($edit_record['status']) && $edit_record['status'] === 'onleave' ? 'selected' : ''; ?>>On Leave</option>
                <option value="onsabbatical" <?php echo isset($edit_record['status']) && $edit_record['status'] === 'onsabbatical' ? 'selected' : ''; ?>>On Sabbatical</option>
            </select>

            <!-- Submit button -->
            <input type="submit" value="<?php echo $edit_record ? 'Update Faculty' : 'Create Faculty'; ?>">
        </form>
    </div>

    <div class="faculty-records">
        <!-- Faculty Records Table -->
        <h2>Faculty List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through each faculty record and display in table -->
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['department']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <img src="<?php echo $row['image']; ?>" alt="Profile Picture" width="50" height="50" onerror="this.src='default.jpg';">
                            </td>
                            <td>
                                <a href="faculty.php?id=<?php echo $row['id']; ?>">Edit</a> |
                                <a href="faculty.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No faculty found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>



    <script>
        // Allow file to be dropped
        function allowDrop(event) {
            event.preventDefault();
        }
        // Handle file drop event
        function drop(event) {
            event.preventDefault();
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                const input = document.getElementById('image');
                input.files = event.dataTransfer.files;
                previewImage({ target: input });
            } else {
                alert('Please drop a valid image file (e.g., JPG, PNG, GIF).');
            }
        }

        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) { // Display the selected image
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "default.jpg";
            }
        }
    </script>
</body>
</html>
