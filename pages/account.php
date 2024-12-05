<?php
session_start();
if (!isset($_SESSION['emailaddress'])) {
    header("Location: ../pages/login.php");
    session_destroy();
    exit();
}
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";

// Establishing a database connection
$con = mysqli_connect($servername, $username, $password, $database);

if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Fetching the logged-in user's email
$email = $_SESSION['emailaddress'];

// Query to fetch user information
if ($_SESSION['role'] == 'Alumni') {
    $userQuery = "SELECT * FROM users INNER JOIN alumni ON users.user_id = alumni.user_id WHERE email = '$email'";
} elseif ($_SESSION['role'] == 'Faculty') {
    $userQuery = "SELECT * FROM users INNER JOIN faculty ON users.user_id = faculty.user_id WHERE email = '$email'";
} elseif ($_SESSION['role'] == 'Student') {
    $userQuery = "SELECT * FROM users INNER JOIN students ON users.user_id = students.user_id WHERE email = '$email'";
}
$result = mysqli_query($con, $userQuery);

$modalTitle = "";
$modalMessage = "";

// Checking if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input
    $cp = isset($_POST['current_password']) ? mysqli_real_escape_string($con, $_POST['current_password']) : null;
    $np = isset($_POST['new_password']) ? mysqli_real_escape_string($con, $_POST['new_password']) : null;
    $cnp = isset($_POST['confirm_password']) ? mysqli_real_escape_string($con, $_POST['confirm_password']) : null;

    // Ensure data is fetched from the database
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $storedPasswordHash = $row['password']; // Assume the password is hashed in the database

        // Verify the current password
        if (password_verify($cp, $storedPasswordHash)) {
            // Check if the new password matches the confirmation password
            if ($np === $cnp) {
                $hashed = password_hash($np, PASSWORD_DEFAULT); // Hash the new password

                // Update the password in the database
                $sql = "UPDATE users SET password = '$hashed' WHERE email = '$email'";
                if (mysqli_query($con, $sql)) {
                    $modalTitle = "Success";
                    $modalMessage = "Password changed successfully.";
                    $_SESSION['password'] = $hashed; // Update session password if needed
                } else {
                    $modalTitle = "Error";
                    $modalMessage = "Failed to update password. Please try again.";
                }
            } else {
                $modalTitle = "Error";
                $modalMessage = "New password and confirm password do not match.";
            }
        } else {
            $modalTitle = "Error";
            $modalMessage = "Current password is incorrect.";
        }
    } else {
        $modalTitle = "Error";
        $modalMessage = "User not found.";
    }
}



mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Account</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../components/modal.css">
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
                                    <?php if ($_SESSION['role'] == 'Faculty') {
                                        echo '<input type="text" id="department" name="department" readonly placeholder=' . $_SESSION['Department'] . '>';
                                    } elseif ($_SESSION['role'] == 'Alumni') {
                                        echo '<input type="text" id="course_name" name="course_name" readonly placeholder=' . $_SESSION['student_number'] . '>';
                                    } else {
                                        echo '<input type="text" id="student_number" name="student_number" readonly placeholder=' . $_SESSION['student_number'] . '>';
                                    }
                                    ?>


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
                    <a href="terms&conditions.php">
                        <button class="con-shopping">Privacy Settings</button>
                    </a>
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

    <?php include('modal.php') ?>
    <?php include '../components/footer.php' ?>

    </body>
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

</html>

<script>
    function showModal(type, message) {
        // Determine the correct modal ID based on type
        const modalId = type === 'success' ? 'successModal' : 'failModal';
        const modal = document.getElementById(modalId);

        if (modal) {
            const modalMessage = modal.querySelector('.modal-message');

            // Set the message and make the modal visible
            if (modalMessage) modalMessage.textContent = message;

            modal.style.display = 'block';
            const modalContent = modal.querySelector('.modal-content');

            if (modalContent) {
                modalContent.style.animation = 'slideDown 0.5s ease forwards';
            }
        } else {
            console.error(`Modal with ID "${modalId}" not found.`);
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);

        if (modal) {
            const modalContent = modal.querySelector('.modal-content');

            // Apply slide-up animation before hiding
            if (modalContent) {
                modalContent.style.animation = 'slideUp 0.5s ease forwards';
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 200); // Match the animation duration
            }
        } else {
            console.error(`Modal with ID "${modalId}" not found.`);
        }
    }
</script>


<?php if (!empty($modalTitle) && !empty($modalMessage)): ?>
    <script>
        showModal('<?php echo strtolower($modalTitle); ?>', '<?php echo $modalMessage; ?>');
    </script>
<?php endif; ?>

<script>
    window.addEventListener('click', function (event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (event.target === modal) {
                const modalContent = modal.querySelector('.modal-content');
                if (modalContent) {
                    // Apply slide-up animation
                    modalContent.style.animation = 'slideUp 0.5s ease forwards';

                    // Wait for the animation to complete before hiding the modal
                    setTimeout(() => {
                        modal.style.display = 'none';
                    }, 200); // Match the animation duration
                }
            }
        });
    });
</script>