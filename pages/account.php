<?php
session_start();
if (!isset($_SESSION['emailaddress'])) {
    header("Location: ../pages/login.php");
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
    $cp = isset($_POST['current_password']) ? mysqli_real_escape_string($con, $_POST['current_password']) : null;
    $np = isset($_POST['new_password']) ? mysqli_real_escape_string($con, $_POST['new_password']) : null;
    $cnp = isset($_POST['confirm_password']) ? mysqli_real_escape_string($con, $_POST['confirm_password']) : null;
    if ($cp == $_SESSION['password']) {
        if ($np == $cnp) {
            $hashed = password_hash($np, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = '$hashed' WHERE email = '" . $_SESSION['emailaddress'] . "'";
            if (mysqli_query($con, $sql)) {
                $modalTitle = "Success";
                $modalMessage = "Password changed successfully.";
            }
        }

    } else {
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/account.css">
    <link rel="stylesheet" href="../components/all.css">
    <link rel="icon" type="image/png" href="innovatio-icon.png" sizes="16x16">
</head>
<div>

    <div class="navigator">
        <?php include('../components/nav.php') ?>
    </div>
    <div class="containerism">
        <div class="account">
            <div class="tab-content" id="tab-content">
                <div id="tab-account" class="tab active">
                    <form action="" method="POST">
                        <div class="input-field">
                            <h4>Personal Information</h4>
                            <h>Full Name</h>
                            <div class="form-row">
                                <div>
                                    <input type="text" id="first_name" name="first_name" readonly placeholder=<?php echo $_SESSION['first_name']; ?>>
                                </div>
                                <div>
                                    <input type="text" id="last_name" name="last_name" readonly placeholder=<?php echo $_SESSION['last_name']; ?>>
                                </div>
                            </div>
                        </div>
                        <div class="input-field">
                            <h>Contact Information</h>
                            <div class="form-row">
                                <div>
                                    <input type="text" id="student_number" name="student_number" required readonly
                                        placeholder=<?php echo $_SESSION['student_number']; ?>>
                                </div>
                                <div>
                                    <input type="text" id="email_address" name="email_address" required readonly
                                        placeholder=<?php echo $_SESSION['emailaddress']; ?>>
                                </div>
                            </div>
                        </div>
                        <div class="input-field">
                            <h>Password</h>
                            <div class="widefield">
                                <input type="password" id="current_password" name="current_password" required
                                    placeholder="Current Password">
                            </div>
                            <div class="form-row">
                                <div>
                                    <input type="password" id="new_password" name="new_password" required
                                        placeholder="New Password">
                                </div>
                                <div>
                                    <input type="password" id="confirm_password" name="confirm_password" required
                                        placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>
                        <button type="submit">Save</button>
                    </form>
                    <form>
                        <div class="input-field">
                            <h4>Privacy Settings</h4>
                            <div class="form-row">
                                <p>We care about your integrity, and continuosly work toward making your
                                    Innovatio experience as safe and secure as possible. Read the Innovatio Privacy
                                    Policy
                                    to learn more about how we use and store personal data.
                                </p>
                            </div>

                            <div class="form-row">
                                <p>This page is where you will be able to manage your privacy settings.
                                    Return to review this page, as it will be continuosly updated.
                                </p>
                            </div>
                        </div>
                    </form>
                    <button class="con-shopping">Privacy Settings</button>

                    <form>
                        <div class="input-field">
                            <h4>Closing Your Account</h4>
                            <div class="form-row">
                                <p> If you choose to close your account you will no longer be able to access our
                                    services including,
                                    for example, viewing your order history, or viewing your registered products. For
                                    the time being
                                    this is a manual process and needs to be initiated via an e-mail sent to us. Click
                                    the button below
                                    to start the process.
                                </p>


                            </div>
                        </div>
                    </form>
                    <button class="con-shopping">Close Account</button>
                </div>




            </div>
        </div>

        <div class="user-info">
            <div class="user">
                <div class="username">
                    <h>Welcome, <?php echo $_SESSION['first_name']; ?></h>
                </div>
                <div class="Logout">
                    <a href="session-destroy.php">Logout</a>
                </div>
            </div>

            <div class="guide">
                <div class="guide-info">
                    <p>In your account pages you can register your products, as well as view your order history.</p>
                    <p>You can also contact the Innovatio customer support team. For the fastest help however, we
                        recommend looking through appropriate product manuals, FAQ sections, or checking the
                        Innovatioauts user forum for answers.</p>
                </div>



            </div>
        </div>
    </div>


    <?php include '../components/footer.php' ?>

    </body>

</html>