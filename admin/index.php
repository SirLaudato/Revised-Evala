<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Professional Sidebar Design</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../admin-css/index.css">
    <link rel="icon" type="image/png" href="../pages/innovatio-icon.png" sizes="16x16">
</head>

<body>
    <div class="sidebar">
        <img src="../creator_profile/icon.png" alt="Icon">

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
            </div>
        </div>
        <button class="dropdown-btn">Progress <i class="fa fa-caret-down"></i></button>
        <div class="dropdown-container">
            <a href="http://127.0.0.1:5000" class="nav-link"><i class="fas fa-chart-line"></i> Evaluation</a>
        </div>

        <div class="logout-div">
            <a href="session-destroy.php">
                <button class="logout-btn">Logout</button>
            </a>
        </div>
    </div>

    <script>
        var dropdown = document.getElementsByClassName("dropdown-btn");
        for (var i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
            });
        }
    </script>


</body>

</html>