<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Professional Sidebar Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #eaeaea; /* Light grey for contrast */
            color: #333; /* Dark grey for text */
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #1c1c1c; /* Black background */
            color: #f0f0f0; /* Light grey text */
            padding-top: 20px;
            padding-left: 15px;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            transition: all 0.3s ease;
        }
        .sidebar h4 {
            margin-bottom: 15px;
            font-weight: 600;
            color: #fff; /* White heading */
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        .dropdown-btn {
            background: none;
            border: none;
            color: #f0f0f0; /* Light grey */
            text-align: left;
            width: 100%;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.3s ease, color 0.3s ease;
        }
        .dropdown-btn:hover {
            background-color: #333; /* Darker grey on hover */
            color: #fff; /* White text */
        }
        .dropdown-container {
            display: none;
            padding-left: 10px;
        }
        .nav-link {
            color: #f0f0f0;
            text-decoration: none;
            padding: 8px 15px;
            display: flex;
            align-items: center;
            transition: background 0.3s ease, color 0.3s ease;
        }
        .nav-link:hover {
            background-color: #333; /* Darker grey */
            color: #fff;
        }
        .nav-link i {
            margin-right: 8px;
        }
        .active {
            color: #fff; /* White when active */
        }
        .content h2 {
            color: #1c1c1c; /* Blackish grey */
        }
        .content p {
            color: #4a4a4a; /* Medium grey for readability */
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h4>IAB</h4>
    <button class="dropdown-btn">Home <i class="fa fa-caret-down"></i></button>
    <div class="dropdown-container">
        <a href="criteria.php" class="nav-link"><i class="fas fa-star"></i> Criteria</a>
    </div>
    
    <button class="dropdown-btn">Catalog <i class="fa fa-caret-down"></i></button>
    <div class="dropdown-container">
        <button class="dropdown-btn">People <i class="fa fa-caret-down"></i></button>
        <div class="dropdown-container">
            <a href="faculty.php" class="nav-link"><i class="fas fa-user-tie"></i> Faculty</a>
            <a href="students.php" class="nav-link"><i class="fas fa-user-graduate"></i> Students</a>
            <a href="alumni.php" class="nav-link"><i class="fas fa-user"></i> Alumni</a>
            <a href="users.php" class="nav-link"><i class="fas fa-users"></i> Users</a>
        </div>
        <button class="dropdown-btn">Records <i class="fa fa-caret-down"></i></button>
        <div class="dropdown-container">
            <a href="subjects.php" class="nav-link"><i class="fas fa-book"></i> Subjects</a>
            <a href="courses.php" class="nav-link"><i class="fas fa-file-alt"></i> Courses</a>
            <a href="levelandsec.php" class="nav-link"><i class="fas fa-layer-group"></i> Level & Section</a>
        </div>
    </div>
    <button class="dropdown-btn">Progress <i class="fa fa-caret-down"></i></button>
    <div class="dropdown-container">
        <a href="evaluation.php" class="nav-link"><i class="fas fa-chart-line"></i> Evaluation</a>
    </div>
</div>
<div class="content">
    <h2>Sidebar Dropdown</h2>
    <p>Click on the dropdown button to open the dropdown menu inside the side navigation.</p>
    <p>This sidebar is of full height (100%) and always shown.</p>
    <p>Some random text..</p>
</div>
<script>
    var dropdown = document.getElementsByClassName("dropdown-btn");
    for (var i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
        });
    }
</script>
</body>
</html>
