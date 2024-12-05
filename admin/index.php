<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Professional Sidebar Design</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../pages/innovatio-icon.png" sizes="16x16">
    <style>
        :root {
            --text-color: #342928;
            --background-color: #f4f4f3;
            --gray-color: #ebebeb;
            --placeholder: #a6a6a6;
            --text-gray: #727271;
            --font-family: "Montserrat", sans-serif;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
            padding: 20px;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--text-color);
            /* Black background */
            color: #f0f0f0;
            /* Light grey text */
            padding-top: 20px;
            padding-left: 15px;
            transition: all 0.3s ease;
        }

        .sidebar h4 {
            margin-bottom: 15px;
            font-weight: 700;
            color: #fff;
            /* White heading */
            font-size: 30px;
            font-style: italic;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .dropdown-btn {
            background: none;
            border: none;
            color: #f0f0f0;
            /* Light grey */
            text-align: left;
            width: 100%;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: inherit;
        }

        .dropdown-btn:hover {
            color: var(--text-gray);
            /* White text */
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
        }

        .nav-link:hover {
            color: var(--text-gray);
            /* White text */
        }

        .nav-link i {
            margin-right: 8px;
        }

        .active {
            color: #fff;
            /* White when active */
        }

        .content h2 {
            color: #1c1c1c;
            /* Blackish grey */
        }

        .content p {
            color: #4a4a4a;
            /* Medium grey for readability */
        }

        .sidebar img {
            width: 50%;
            padding: 20px 20px 32px 14px;
        }
    </style>
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
            <a href="evaluation.php" class="nav-link"><i class="fas fa-chart-line"></i> Evaluation</a>
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