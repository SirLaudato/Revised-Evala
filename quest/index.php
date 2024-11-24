<?php
// Include database connection
include 'db_connect_texteditor.php';

// Handle adding a new category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = $_POST['category_name'];
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle adding a new editor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_editor'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $stmt = $conn->prepare("INSERT INTO editors (first_name, last_name) VALUES (?, ?)");
    $stmt->bind_param("ss", $first_name, $last_name);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle saving an article
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_article'])) {
    $title = $_POST['title'];
    $category_id = $_POST['category'];
    $editor_id = $_POST['editor'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO articles (title, category_id, editor_id, content) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siis", $title, $category_id, $editor_id, $content);
    $stmt->execute();
    echo "<p>Article saved successfully!</p>";
}

// Handle article deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle article editing
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $result = $conn->query("SELECT * FROM articles WHERE id = $edit_id");
    $article = $result->fetch_assoc();
    $title = $article['title'];
    $category_id = $article['category_id'];
    $editor_id = $article['editor_id'];
    $content = $article['content'];
}

// Handle article duplication
if (isset($_GET['duplicate_id'])) {
    $duplicate_id = $_GET['duplicate_id'];
    $result = $conn->query("SELECT * FROM articles WHERE id = $duplicate_id");
    
    if ($result->num_rows > 0) {
        $article = $result->fetch_assoc();
        
        // Get article data
        $title = $article['title'];
        $category_id = $article['category_id'];
        $editor_id = $article['editor_id'];
        $content = $article['content'];

        // Insert the duplicated article into the database
        $stmt = $conn->prepare("INSERT INTO articles (title, category_id, editor_id, content) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siis", $title, $category_id, $editor_id, $content);
        $stmt->execute();
        
        // Redirect back to the page with the updated list of articles
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Fetch categories and editors
$categories = $conn->query("SELECT * FROM categories");
$editors = $conn->query("SELECT * FROM editors");

// Fetch articles
$articles = $conn->query("SELECT articles.id, articles.title, categories.name AS category_name, 
                            CONCAT(editors.first_name, ' ', editors.last_name) AS editor_name, 
                            articles.content, articles.created_at 
                            FROM articles 
                            JOIN categories ON articles.category_id = categories.id 
                            JOIN editors ON articles.editor_id = editors.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article</title>
</head>
<body>
    <h3>Create Article</h3>
    
    <!-- Article Form -->
    <form action="" method="post">
        <label for="title">Article Title:</label><br>
        <input type="text" name="title" id="title" value="<?= isset($title) ? htmlspecialchars($title) : '' ?>" required><br><br>

        <label for="category">Select Category:</label><br>
        <select name="category" id="category" required>
            <option value="" disabled selected>Choose a category</option>
            <?php while ($category = $categories->fetch_assoc()) { ?>
                <option value="<?= $category['id'] ?>" <?= isset($category_id) && $category_id == $category['id'] ? 'selected' : '' ?>>
                    <?= $category['name'] ?>
                </option>
            <?php } ?>
        </select>
        <button type="button" onclick="document.getElementById('addCategoryModal').style.display='block'">Add New Category</button><br><br>

        <label for="editor">Select Editor:</label><br>
        <select name="editor" id="editor" required>
            <option value="" disabled selected>Choose an editor</option>
            <?php while ($editor = $editors->fetch_assoc()) { ?>
                <option value="<?= $editor['id'] ?>" <?= isset($editor_id) && $editor_id == $editor['id'] ? 'selected' : '' ?>>
                    <?= $editor['first_name'] . ' ' . $editor['last_name'] ?>
                </option>
            <?php } ?>
        </select>
        <button type="button" onclick="document.getElementById('addEditorModal').style.display='block'">Add New Editor</button><br><br>

        <label for="content">Content:</label><br>
        <textarea name="content" id="editor_content"><?= isset($content) ? htmlspecialchars($content) : '' ?></textarea><br><br>

        <input type="submit" name="save_article" value="Post Article">
    </form>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" style="display:none;">
        <h3>Add New Category</h3>
        <form action="" method="post">
            <label for="category_name">Category Name:</label><br>
            <input type="text" name="category_name" id="category_name" required><br><br>
            <input type="submit" name="add_category" value="Add Category">
            <button type="button" onclick="document.getElementById('addCategoryModal').style.display='none'">Cancel</button>
        </form>
    </div>

    <!-- Add Editor Modal -->
    <div id="addEditorModal" style="display:none;">
        <h3>Add New Editor</h3>
        <form action="" method="post">
            <label for="first_name">First Name:</label><br>
            <input type="text" name="first_name" id="first_name" required><br><br>
            <label for="last_name">Last Name:</label><br>
            <input type="text" name="last_name" id="last_name" required><br><br>
            <input type="submit" name="add_editor" value="Add Editor">
            <button type="button" onclick="document.getElementById('addEditorModal').style.display='none'">Cancel</button>
        </form>
    </div>

    <!-- Article List -->
    <h3>List of Articles</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Editor</th>
                <th>Content</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($articles->num_rows > 0) { ?>
                <?php while ($article = $articles->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $article['id'] ?></td>
                        <td><?= htmlspecialchars($article['title']) ?></td>
                        <td><?= htmlspecialchars($article['category_name']) ?></td>
                        <td><?= htmlspecialchars($article['editor_name']) ?></td>
                        <td><?= htmlspecialchars(substr($article['content'], 0, 50)) ?>...</td>
                        <td><?= $article['created_at'] ?></td>
                        <td>
                            <a href="?edit_id=<?= $article['id'] ?>">Edit</a> | 
                            <a href="?delete_id=<?= $article['id'] ?>" onclick="return confirm('Are you sure you want to delete this article?')">Delete</a> |
                            <a href="?duplicate_id=<?= $article['id'] ?>">Duplicate</a> <!-- Duplicate Link -->
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="7">No articles found.</td></tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Include TinyMCE -->
    <script src="tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea#editor_content',
            height: 300,
            plugins: 'advlist autolink link image lists charmap preview anchor pagebreak table', // Add 'table' plugin here
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify |' +
                    'bullist numlist outdent indent | link image | table | print preview media', // Add 'table' to toolbar
            menubar: false,
            table_toolbar: 'tableprops | cellprops | merge | split', // Optional: For controlling table cells and rows
        });
    </script>

</body>
</html>
