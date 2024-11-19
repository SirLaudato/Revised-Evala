<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";

$con = mysqli_connect($servername, $username, $password, $database);

if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['e-mail']) && isset($_POST['password'])) {
        $email = mysqli_real_escape_string($con, $_POST['e-mail']);
        $pw = mysqli_real_escape_string($con, $_POST['password']);

        $userQuery = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($con, $userQuery);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['password'] == $pw) {
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["first_name"] = $row["first_name"];
                $_SESSION["last_name"] = $row["last_name"];
                $_SESSION["emailaddress"] = $row["email"];
                $_SESSION["role"] = $row["role"];

                if (in_array($row["role"], ["student", "alumni", "faculty"])) {
                    header("Location: ../pages/home.php");
                    exit();
                }
            } else {
                $modalTitle = "Login Error";
                $modalMessage = "Incorrect password. Please try again.";
            }
        } else {
            $modalTitle = "Account Error";
            $modalMessage = "An account with this email doesn’t exist.";
        }
    } else {
        $modalTitle = "Input Error";
        $modalMessage = "Please fill in all the fields.";
    }
}

mysqli_close($con);

$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";

$con = mysqli_connect($servername, $username, $password, $database);

if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['e-mail']) && isset($_POST['password'])) {
        $email = mysqli_real_escape_string($con, $_POST['e-mail']);
        $pw = mysqli_real_escape_string($con, $_POST['password']);

        $userQuery = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($con, $userQuery);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['password'] == $pw) {
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["first_name"] = $row["first_name"];
                $_SESSION["last_name"] = $row["last_name"];
                $_SESSION["emailaddress"] = $row["email"];
                $_SESSION["role"] = $row["role"];

                if (in_array($row["role"], ["student", "alumni", "faculty"])) {
                    header("Location: ../pages/home.php");
                    exit();
                }
            } else {
                $modalTitle = "Login Error";
                $modalMessage = "Incorrect password. Please try again.";
            }
        } else {
            $modalTitle = "Account Error";
            $modalMessage = "An account with this email doesn’t exist.";
        }
    } else {
        $modalTitle = "Input Error";
        $modalMessage = "Please fill in all the fields.";
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../components/all.css">
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/login.css" />
    <link rel="stylesheet" href="../css/nav.css" />

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login">
        <!-- Include the navigation bar -->
        <div class="navigator">
            <?php include('../components/nav.php') ?>
        </div>

        <!-- Login Form -->
        <form action="" method="post" class="form-group">
            <div class="login-interface">
                <div class="div-2">
                    <div class="text-wrapper-3">Log In</div>
                    <p class="p">Use the school email provided by your school.</p>
                </div>

                <div class="div-2">
                    <div class="div-3">
                        <div class="text-wrapper-4">Email Address</div>
                        <input class="input-field" placeholder="Your E-mail" type="email" name="e-mail" />
                    </div>
                    <div class="div-3">
                        <div class="text-wrapper-6">Password</div>
                        <input class="input-field" placeholder="Your Password" type="password" name="password" />
                    </div>
                </div>

                <div class="login-button">
                    <button class="button">
                        <span class="text-wrapper-7">Log In</span>
                    </button>

                    <div class="text-wrapper-8">Forgot your password?</div>
                </div>
            </div>
        </form>
        <!-- Include the footer -->

        <?php include '../components/footer.php' ?>
    </div>

    <div id="alertModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle">Alert</h2>
            <p id="modalMessage">This is a message.</p>
            <button class="close-btn" onclick="closeModal()">Close</button>
        </div>
    </div>



    <!-- Scroll event for shadow -->
    <script>
        document.addEventListener('scroll', () => {
            if (window.scrollY > 0) {
                document.querySelector('.navigator').style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.1)';
            } else {
                document.querySelector('.navigator').style.boxShadow = 'none';
            }
        });
    </script>

    <script>
        const modal = document.getElementById("alertModal");
        const modalTitle = document.getElementById("modalTitle");
        const modalMessage = document.getElementById("modalMessage");

        // Function to show the modal
        function showModal(title, message) {
            modalTitle.innerText = title;
            modalMessage.innerText = message;
            modal.style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            modal.style.display = "none";
        }

        // Close the modal when clicking outside of it
        window.onclick = function (event) {
            if (event.target === modal) {
                closeModal();
            }
        };

        // Check for server-side modal trigger
        <?php if ($modalTitle && $modalMessage): ?>
            showModal("<?php echo $modalTitle; ?>", "<?php echo $modalMessage; ?>");
        <?php endif; ?>
    </script>
    </script>

    <script>
        const modal = document.getElementById("alertModal");
        const modalTitle = document.getElementById("modalTitle");
        const modalMessage = document.getElementById("modalMessage");

        // Function to show the modal
        function showModal(title, message) {
            modalTitle.innerText = title;
            modalMessage.innerText = message;
            modal.style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            modal.style.display = "none";
        }

        // Close the modal when clicking outside of it
        window.onclick = function (event) {
            if (event.target === modal) {
                closeModal();
            }
        };

        // Check for server-side modal trigger
        <?php if ($modalTitle && $modalMessage): ?>
            showModal("<?php echo $modalTitle; ?>", "<?php echo $modalMessage; ?>");
        <?php endif; ?>
    </script>
</body>

</html>