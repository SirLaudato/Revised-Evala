<?php
session_start();
// Redirect if already logged in
if (isset($_SESSION['emailaddress'])) {
    header("Location: ../pages/home.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";

$con = mysqli_connect($servername, $username, $password, $database);

if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}

$modalTitle = "";
$modalMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['e-mail']) ? mysqli_real_escape_string($con, $_POST['e-mail']) : null;
    $pw = isset($_POST['password']) ? mysqli_real_escape_string($con, $_POST['password']) : null;

    // Missing fields
    if (empty($email) || empty($pw)) {
        $modalTitle = "Input Error";
        $modalMessage = "Please fill in all the fields.";
    } else {
        // Fetch user from database
        $userQuery = "SELECT * FROM users INNER JOIN students ON users.user_id = students.user_id WHERE email = '$email';";
        $result = mysqli_query($con, $userQuery);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Check if the account is locked
            if ($row["active_flag"] == 0) {
                $modalTitle = "Account Error";
                $modalMessage = "Your account has been locked. Please contact support for assistance.";
            } else {
                // Check if the password matches
                if ($row['password'] == $pw) {
                    // Set session variables
                    $_SESSION["user_id"] = $row["user_id"];
                    $_SESSION["first_name"] = $row["first_name"];
                    $_SESSION["last_name"] = $row["last_name"];
                    $_SESSION["emailaddress"] = $row["email"];
                    $_SESSION["role"] = $row["role"];
                    $_SESSION["student_number"] = $row["student_number"];
                    $_SESSION["active_flag"] = $row["active_flag"];
                    $_SESSION["attempts"] = $row["attempts"];

                    // Reset attempts on successful login
                    $sql_reset = "UPDATE users SET attempts = 0 WHERE email = '$email';";
                    mysqli_query($con, $sql_reset);

                    // Redirect based on role
                    if (in_array($row["role"], ["Student", "Alumni", "Faculty"])) {
                        header("Location: ../pages/home.php");
                        exit();
                    } else {
                        $modalTitle = "Access Denied";
                        $modalMessage = "Your role does not have access to this page.";
                    }
                } else {
                    // Incorrect password
                    if ($row["attempts"] >= 4) { // Lock the account on the 5th failed attempt
                        $sql_lock = "UPDATE users SET active_flag = 0 WHERE email = '$email';";
                        mysqli_query($con, $sql_lock);
                        $modalTitle = "Account Locked!";
                        $modalMessage = "Your account has been locked due to multiple failed login attempts. Please contact support.";
                        session_destroy(); // Destroy session to log out any logged-in user
                    } else {
                        $modalTitle = "Login Error";
                        $modalMessage = "Incorrect password. Please try again.";
                        $sql_update = "UPDATE users SET attempts = attempts + 1 WHERE email = '$email';";
                        mysqli_query($con, $sql_update);
                    }
                }
            }
        } else {
            // Account not found
            $modalTitle = "Account Error";
            $modalMessage = "An account with this email doesn’t exist.";
        }
    }
}

mysqli_close($con);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Log In</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../components/all.css">
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/login.css" />
    <link rel="stylesheet" href="../css/nav.css" />
    <link rel="icon" type="image/png" href="innovatio-icon.png" sizes="16x16">

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
            <!-- Alert Icon -->
            <div class="modal-icon">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M11.25 16.25H13.75V18.75H11.25V16.25ZM11.25 6.25H13.75V13.75H11.25V6.25ZM12.5 0C5.5875 0 0 5.625 0 12.5C0 15.8152 1.31696 18.9946 3.66117 21.3388C4.8219 22.4996 6.19989 23.4203 7.71646 24.0485C9.23303 24.6767 10.8585 25 12.5 25C15.8152 25 18.9946 23.683 21.3388 21.3388C23.683 18.9946 25 15.8152 25 12.5C25 10.8585 24.6767 9.23303 24.0485 7.71646C23.4203 6.19989 22.4996 4.8219 21.3388 3.66117C20.1781 2.50043 18.8001 1.57969 17.2835 0.951506C15.767 0.323322 14.1415 0 12.5 0ZM12.5 22.5C9.84783 22.5 7.3043 21.4464 5.42893 19.5711C3.55357 17.6957 2.5 15.1522 2.5 12.5C2.5 9.84783 3.55357 7.3043 5.42893 5.42893C7.3043 3.55357 9.84783 2.5 12.5 2.5C15.1522 2.5 17.6957 3.55357 19.5711 5.42893C21.4464 7.3043 22.5 9.84783 22.5 12.5C22.5 15.1522 21.4464 17.6957 19.5711 19.5711C17.6957 21.4464 15.1522 22.5 12.5 22.5Z"
                        fill="#727271" />
                </svg>
            </div>

            <!-- Alert Message -->
            <div class="modal-message">
                Invalid username or password. Try Again.
            </div>

            <!-- Close Button -->
            <button class="close-btn" onclick="closeModal()">
                <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.83429 4.5L8 7.66572V8.5H7.16571L4 5.33429L0.834286 8.5H0V7.66572L3.16571 4.5L0 1.33429V0.5H0.834286L4 3.66571L7.16571 0.5H8V1.33429L4.83429 4.5Z"
                        fill="#727271" />
                </svg>
            </button>
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
        function showModal(message) {
            const modal = document.getElementById("alertModal");
            const modalMessage = modal.querySelector(".modal-message");
            modalMessage.textContent = message;
            modal.style.display = "block";
        }

        function closeModal() {
            const modal = document.getElementById("alertModal");
            modal.style.display = "none";
        }

        <?php if ($modalTitle && $modalMessage): ?>
            showModal("<?= htmlspecialchars($modalMessage) ?>");
        <?php endif; ?>
    </script>
</body>

</html>