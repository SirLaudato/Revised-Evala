<?php
// Include the database connection file
include('db_conn_people.php');

// Initialize message variable for feedback
$message = "";

// Handle form submission (for Create and Update operations)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $graduate_career_field = $_POST['graduate_career_field'];
    $status = $_POST['status'];
    $old_school_id = $_POST['old_school_id'];
    $id = isset($_POST['id']) ? $_POST['id'] : null;  // Check if there's an ID for update

    // Handle file upload for image
    $target_dir = "uploads/";  // Directory to store uploaded images
    $image_path = "default.jpg"; // Default image if no file is uploaded

    // Check if a file is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;  // Update image path with the uploaded file
        }
    }

    // Check if we are updating or creating a new record
    if ($id) {
        // Update existing record in the database
        $sql = "UPDATE alumni 
                SET name='$name', email='$email', phone_number='$phone', 
                    graduate_career_field='$graduate_career_field', 
                    status='$status', old_school_id='$old_school_id', 
                    image='$image_path' 
                WHERE id=$id";
    } else {
        // Insert a new record into the database
        $sql = "INSERT INTO alumni (name, email, phone_number, graduate_career_field, 
                                     status, old_school_id, image) 
                VALUES ('$name', '$email', '$phone', '$graduate_career_field', 
                        '$status', '$old_school_id', '$image_path')";
    }

    // Execute the SQL query and check for success
    if ($conn->query($sql) === TRUE) {
        $message = $id ? "Record updated successfully." : "New record created successfully.";
    } else {
        $message = "Error: " . $conn->error;  // Display error message if query fails
    }
}

// Handle record deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];  // Get the ID of the record to delete
    $sql = "DELETE FROM alumni WHERE id=$id";  // SQL query to delete the record

    // Execute the delete query and check for success
    if ($conn->query($sql) === TRUE) {
        $message = "Record deleted successfully.";
    } else {
        $message = "Error: " . $conn->error;  // Display error message if query fails
    }
}

// Fetch all alumni records for displaying in the table
$sql = "SELECT * FROM alumni";
$result = $conn->query($sql);

// Fetch a single record for editing (if an ID is passed)
$edit_record = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $edit_sql = "SELECT * FROM alumni WHERE id=$id";
    $edit_result = $conn->query($edit_sql);

    // Fetch record data for editing
    if ($edit_result->num_rows > 0) {
        $edit_record = $edit_result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alumni Management</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* General styles for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Styling for image upload container */
        #image-drop-zone {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background-color: #f7f7f7;
        }
        #image-drop-zone:hover {
            background-color: #f0f0f0;
        }

        /* Preview of the uploaded image */
        #preview {
            margin-top: 10px;
            max-width: 100%;
            max-height: 150px;
        }

        /* Styling for upload instructions */
        .upload-container p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>Alumni Management</h1>

    <p><?php echo $message; ?></p> <!-- Display success or error messages -->

    <!-- Create or Edit Alumni Form -->
    <form method="POST" action="alumni.php" enctype="multipart/form-data">
        <h2><?php echo $edit_record ? "Edit Alumni" : "Add New Alumni"; ?></h2>
        
        <!-- Hidden field for storing alumni ID when editing -->
        <input type="hidden" name="id" value="<?php echo $edit_record['id'] ?? ''; ?>">

        <label for="old_school_id">Old School ID:</label>
        <input type="text" id="old_school_id" name="old_school_id" value="<?php echo $edit_record['old_school_id'] ?? ''; ?>" required><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $edit_record['name'] ?? ''; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $edit_record['email'] ?? ''; ?>" required><br><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $edit_record['phone_number'] ?? ''; ?>" required><br><br>

        <label for="image">Image:</label>
        <!-- Image upload with drag & drop or click to select -->
        <div id="image-drop-zone" class="upload-container" ondrop="drop(event)" ondragover="allowDrop(event)">
            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
            <p>Drag & Drop an image here or click to select</p>
            <img id="preview" src="<?php echo $edit_record['image'] ?? 'default.jpg'; ?>" width="150" height="150" alt="Preview">
        </div><br><br>

        <label for="graduate_career_field">Graduate Career Field:</label>
        <!-- Dropdown for career fields -->
        <select id="graduate_career_field" name="graduate_career_field" required>
            <option value="Business Management" <?php echo isset($edit_record['graduate_career_field']) && $edit_record['graduate_career_field'] === 'Business Management' ? 'selected' : ''; ?>>Business Management</option>
            <option value="Engineering" <?php echo isset($edit_record['graduate_career_field']) && $edit_record['graduate_career_field'] === 'Engineering' ? 'selected' : ''; ?>>Engineering</option>
            <option value="Health and Medical Fields" <?php echo isset($edit_record['graduate_career_field']) && $edit_record['graduate_career_field'] === 'Health and Medical Fields' ? 'selected' : ''; ?>>Health and Medical Fields</option>
            <option value="Education" <?php echo isset($edit_record['graduate_career_field']) && $edit_record['graduate_career_field'] === 'Education' ? 'selected' : ''; ?>>Education</option>
            <option value="Social Sciences" <?php echo isset($edit_record['graduate_career_field']) && $edit_record['graduate_career_field'] === 'Social Sciences' ? 'selected' : ''; ?>>Social Sciences</option>
            <!-- Add more career fields as needed -->
        </select><br><br>

        <label for="status">Status:</label>
        <!-- Dropdown for active/inactive status -->
        <select id="status" name="status" required>
            <option value="active" <?php echo isset($edit_record['status']) && $edit_record['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="inactive" <?php echo isset($edit_record['status']) && $edit_record['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
        </select><br><br>

        <!-- Submit button -->
        <input type="submit" value="<?php echo $edit_record ? 'Update Alumni' : 'Create Alumni'; ?>">
    </form>

    <!-- Alumni Records Table -->
    <h2>Alumni List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Old School ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Career Field</th>
                <th>Status</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['old_school_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone_number']; ?></td>
                        <td><?php echo $row['graduate_career_field']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><img src="<?php echo $row['image']; ?>" width="50" height="50" alt="Image"></td>
                        <td>
                            <a href="alumni.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="alumni.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No alumni found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

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

