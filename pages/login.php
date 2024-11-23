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
                if ($row["password"] == '1234') {
                    if ($row['password'] == $pw) {
                        // Set session variables
                        $_SESSION["user_id"] = $row["user_id"];
                        $_SESSION["password"] = $row["password"];
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
                } else {
                    if (password_verify($pw, $row['password'])) {
                        // Set session variables
                        $_SESSION["user_id"] = $row["user_id"];
                        $_SESSION["password"] = $row["password"];
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
    <link rel="stylesheet" href="../components/modal.css">
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/login.css" />
    <link rel="stylesheet" href="../css/nav.css" />
    <link rel="icon" type="image/png" href="innovatio-icon.png" sizes="16x16">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login">
        <!-- Include the navigation bar -->

            <?php include('../components/nav-login.php') ?>

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


<?php include('modal.php') ?>


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