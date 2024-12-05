<?php
// Include the database connection
include('db_conn_people.php');

// Initialize message variable
$message = "";

// Handle form submission for Create and Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    // Handle image upload (if any)
    $target_dir = "uploads/";
    $image_path = "default.jpg"; // Default image

    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;

        // Move the uploaded image to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file; // Set the new image path
        }
    }

    // Update or create new record in the database
    if ($id) {
        // Update existing record
        $sql = "UPDATE users SET name='$name', email='$email', phone='$phone', role='$role', image='$image_path' WHERE id=$id";
    } else {
        // Create a new record
        $sql = "INSERT INTO users (name, email, phone, role, image) VALUES ('$name', '$email', '$phone', '$role', '$image_path')";
    }

    // Execute SQL query and set success message
    if ($conn->query($sql) === TRUE) {
        $message = $id ? "Record updated successfully." : "New record created successfully.";
    } else {
        $message = "Error: " . $conn->error; // Error message if query fails
    }
}

// Handle record deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";

    // Execute delete query and set success/error message
    if ($conn->query($sql) === TRUE) {
        $message = "Record deleted successfully.";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch all user records from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Fetch a single record for editing (if 'id' is passed in the URL)
$edit_record = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $edit_sql = "SELECT * FROM users WHERE id=$id";
    $edit_result = $conn->query($edit_sql);

    // If record exists, store it in $edit_record
    if ($edit_result->num_rows > 0) {
        $edit_record = $edit_result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Basic table and form styling */
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

        #preview {
            margin-top: 10px;
            max-width: 100%;
            max-height: 150px;
        }
    </style>
</head>
<body>
    <h1>User Management</h1>

    <!-- Display any messages (success or error) -->
    <p><?php echo $message; ?></p>

    <!-- Form for adding or editing a user -->
    <form method="POST" action="users.php" enctype="multipart/form-data">
        <h2><?php echo $edit_record ? "Edit User" : "Add New User"; ?></h2>
        
        <!-- Hidden input for user ID (if editing) -->
        <input type="hidden" name="id" value="<?php echo $edit_record['id'] ?? ''; ?>">

        <!-- Name input -->
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $edit_record['name'] ?? ''; ?>" required><br><br>

        <!-- Email input -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $edit_record['email'] ?? ''; ?>" required><br><br>

        <!-- Phone input -->
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $edit_record['phone'] ?? ''; ?>" required><br><br>

        <!-- Image upload (with drag and drop functionality) -->
        <label for="image">Image:</label>
        <div id="image-drop-zone" class="upload-container" ondrop="drop(event)" ondragover="allowDrop(event)">
            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
            <p>Drag & Drop an image here or click to select</p>
            <img id="preview" src="<?php echo $edit_record['image'] ?? 'default.jpg'; ?>" width="150" height="150" alt="Preview">
        </div><br><br>

        <!-- Role input -->
        <label for="role">Role:</label>
        <input type="text" id="role" name="role" placeholder="Chair, Secretary, etc." value="<?php echo $edit_record['role'] ?? ''; ?>" required><br><br>

        <!-- Status dropdown -->
        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="active" <?php echo isset($edit_record['status']) && $edit_record['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="inactive" <?php echo isset($edit_record['status']) && $edit_record['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
        </select><br><br>

        <!-- Submit button -->
        <input type="submit" value="<?php echo $edit_record ? 'Update User' : 'Create User'; ?>">
    </form>

    <!-- Displaying all user records in a table -->
    <h2>User List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <img src="<?php echo $row['image']; ?>" alt="Profile Picture" width="50" height="50" onerror="this.src='default.jpg';">
                        </td>
                        <td>
                            <a href="users.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="users.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No records found.</td>
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
