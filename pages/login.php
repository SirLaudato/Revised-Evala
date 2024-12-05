<?php
session_start();
if (isset($_SESSION['emailaddress'])) {
    header("Location: ../pages/home.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";

$con = new mysqli($servername, $username, $password, $database);
if ($con->connect_error) {
    die("Connection Failed: " . $con->connect_error);
}

$modalTitle = $modalMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['e-mail'] ?? null;
    $pw = $_POST['password'] ?? null;

    if (empty($email) || empty($pw)) {
        $modalTitle = "Input Error";
        $modalMessage = "Please fill in all the fields.";
    } else {
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['active_flag'] == 0) {
                $modalTitle = "Account Locked";
                $modalMessage = "Your account has been locked. Contact support.";
            } elseif (password_verify($pw, $row['password'])) {
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["role"] = $row["role"];
                $_SESSION["first_name"] = $row["first_name"];
                $_SESSION["last_name"] = $row["last_name"];
                $_SESSION["emailaddress"] = $row["email"];

                $stmt = $con->prepare("UPDATE users SET attempts = 0 WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();

                switch ($row["role"]) {
                    case "Student":
                    case "Alumni":
                    case "Faculty":
                        header("Location: ../pages/home.php");
                        break;
                    case "IAB":
                        header("Location: ../admin/index.php");
                        break;
                    default:
                        $modalTitle = "Access Denied";
                        $modalMessage = "Invalid role.";
                }
                exit();
            } else {
                if ($row['attempts'] >= 4) {
                    $stmt = $con->prepare("UPDATE users SET active_flag = 0 WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();

                    $modalTitle = "Account Locked";
                    $modalMessage = "Your account is locked after multiple failed attempts.";
                } else {
                    $stmt = $con->prepare("UPDATE users SET attempts = attempts + 1 WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();

                    $modalTitle = "Login Error";
                    $modalMessage = "Incorrect password. Attempts left: " . (4 - $row['attempts']);
                }
            }
        } else {
            $modalTitle = "Account Error";
            $modalMessage = "No account found with this email.";
        }
        $stmt->close();
    }
}

$con->close();
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
    <link rel="stylesheet" href="../css/nav-login.css" />
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


    <?php include('../pages/modal.php') ?>


</body>
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