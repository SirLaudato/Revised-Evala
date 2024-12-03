<?php
session_start();

if (!isset($_SESSION['emailaddress'])) {
    header("Location: ../pages/login.php");
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";

$con = mysqli_connect($servername, $username, $password, $database);

if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}
$email = $_SESSION['emailaddress'];
if ($_SESSION['role'] == 'Alumni') {
    $userQuery = "SELECT * FROM users INNER JOIN alumni ON users.user_id = alumni.user_id WHERE email = '$email';";
    $result = mysqli_query($con, $userQuery);
    $modalTitle = "";
    $modalMessage = "";


    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['password'] = $row['password'];
        $_SESSION['student_number'] = $row['student_number'];

        if (password_verify('1234', $row['password'])) {
            $modalTitle = "Change Password";
            $modalMessage = "Please change your password immediately.";
        }

    }
} elseif ($_SESSION['role'] == 'Faculty') {
    $userQuery = "SELECT * FROM users INNER JOIN faculty ON users.user_id = faculty.user_id WHERE email = '$email';";
    $result = mysqli_query($con, $userQuery);
    $modalTitle = "";
    $modalMessage = "";


    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['password'] = $row['password'];
        $_SESSION['faculty_id'] = $row['faculty_id'];
        $_SESSION['Department'] = $row['department'];
        $_SESSION['course_id'] = $row['course_id'];
        if (password_verify('1234', $row['password'])) {
            $modalTitle = "Change Password";
            $modalMessage = "Please change your password immediately.";
        }

    }
} elseif ($_SESSION['role'] == 'Student') {
    $userQuery = "SELECT * FROM users INNER JOIN students ON users.user_id = students.user_id WHERE email = '$email';";
    $result = mysqli_query($con, $userQuery);
    $modalTitle = "";
    $modalMessage = "";


    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['password'] = $row['password'];
        $_SESSION['student_number'] = $row['student_number'];
        if (password_verify('1234', $row['password'])) {
            $modalTitle = "Change Password";
            $modalMessage = "Please change your password immediately.";
        }

    }
} else {
    session_destroy();
    header('Location: /Revised-Evala/pages/login.php');
}

$result = mysqli_query($con, $userQuery);
$modalTitle = "";
$modalMessage = "";


if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['password'] = $row['password'];
    if (password_verify('1234', $row['password'])) {
        $modalTitle = "Change Password";
        $modalMessage = "Please change your password immediately.";
    }

}
// Check if user_id is set in the session
if (!isset($_SESSION["user_id"])) {
    die("Error: User not logged in.");
}

// Query to get the course for the logged-in user

$course_query = "
                  SELECT DISTINCT `courses`.`course_id`
                  FROM `users`
                  LEFT JOIN `students` ON `students`.`user_id` = `users`.`user_id`
                  LEFT JOIN `alumni` ON `alumni`.`user_id` = `users`.`user_id`
                  LEFT JOIN `faculty` ON `faculty`.`user_id` = `users`.`user_id`
                  LEFT JOIN `courses` ON `courses`.`course_id` = COALESCE(`students`.`course_id`, `alumni`.`course_id`, `faculty`.`course_id`)
                  WHERE `users`.`user_id` = " . intval($_SESSION["user_id"]) . ";
              ";



$result = $con->query($course_query);

// Check if the query returned any results
if ($result && $result->num_rows > 0) {
    // Fetch the first course_id and store it in the session
    $row = $result->fetch_assoc();
    $_SESSION["course_id"] = $row["course_id"];

    // Query to get course details using the fetched course_id
    $select_course = "
        SELECT * 
        FROM `courses` 
        WHERE `course_id` = '" . mysqli_real_escape_string($con, $_SESSION["course_id"]) . "';";

    $course_result = $con->query($select_course);

    if ($course_result && $course_result->num_rows > 0) {
        while ($course_row = $course_result->fetch_assoc()) {
            $active_evaluation_query = "SELECT 
                                                COUNT(*) AS `active_evaluations`
                                                FROM 
                                                `evaluations`
                                                LEFT JOIN 
                                                `user_evaluations` ON `user_evaluations`.`evaluation_id` = `evaluations`.`evaluation_id`
                                                LEFT JOIN 
                                                `users` ON `user_evaluations`.`user_id` = `users`.`user_id`
                                                WHERE 
                                                `user_evaluations`.`has_answered` = 1
                                                AND `users`.`user_id` = " . intval($_SESSION["user_id"]) . ";";

            $total_evaluation_query = "SELECT 
                                                COUNT(*) AS `total_evaluations`
                                                FROM 
                                                `evaluations`
                                                LEFT JOIN 
                                                `user_evaluations` ON `user_evaluations`.`evaluation_id` = `evaluations`.`evaluation_id`
                                                LEFT JOIN 
                                                `users` ON `user_evaluations`.`user_id` = `users`.`user_id`
                                                WHERE 
                                                `evaluations`.`course_id` = " . intval($course_row["course_id"]) . "
                                                AND `users`.`user_id`= " . intval($_SESSION["user_id"]) . ";";

            $_SESSION['total_result'] = mysqli_query($con, $total_evaluation_query);
            if ($_SESSION['total_result']) {
                $row = mysqli_fetch_assoc($_SESSION['total_result']);
                $_SESSION['total_result'] = $row['total_evaluations'];
            } else {
                echo "Query failed: " . mysqli_error($con);
                continue; // Skip to next iteration
            }

            // Execute active evaluations query
            $_SESSION['active_result'] = mysqli_query($con, $active_evaluation_query);
            if ($_SESSION['active_result']) {
                $row = mysqli_fetch_assoc($_SESSION['active_result']);
                $_SESSION['active_result'] = $row['active_evaluations'];
            } else {
                echo "Query failed: " . mysqli_error($con);
                continue; // Skip to next iteration
            }

            $_SESSION["course_id"] = $course_id = $course_row["course_id"];
            $_SESSION["course_name"] = $course_name = $course_row["course_name"];
            $_SESSION["course_cover"] = $course_cover = $course_row["course_cover"];
            if ($_SESSION['active_result'] === $_SESSION['total_result']) {
                $_SESSION["status"] = "Not yet completed";
            } elseif (empty($active_evaluations)) {
                $_SESSION["status"] = "Completed";
            } else {
                $_SESSION["status"] = "Pending";
            }
        }
    }
}
?>
<?php include('../components/active.php') ?>

<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/home.css" />
    <link rel="stylesheet" href="../components/all.css">
    <link rel="stylesheet" href="../components/modal.css">

    <link rel="icon" type="image/png" href="innovatio-icon.png" sizes="16x16">
</head>


<body>
    <div class="home-revised">
        <div class="navigator">
            <?php include('../components/nav.php') ?>
        </div>
        <div class="frame-2">
            <div class="support-container-wrapper">
                <div class="support-container">
                    <div class="frame-3">
                        <div class="text-wrapper-3">Welcome, <?php echo $_SESSION['first_name']; ?></div>
                    </div>
                    <div class="frame-3">
                        <div class="text-wrapper-4"><?php echo $_SESSION['role']; ?></div>
                    </div>
                </div>
            </div>
            <div class="frame-4">
                <div class="title-hero-wrapper">
                    <div class="title-hero">
                        <div class="text-wrapper-5">Evaluation Progress</div>
                        <p class="p">Here is your overview of the Evaluations.</p>
                    </div>
                </div>
                <div class="frame-wrapper">
                    <div class="frame-5">
                        <div class="total-evaluation">
                            <div class="frame-6">
                                <div class="frame-7">
                                    <div class="frame-8">
                                        <div class="text-wrapper-6">Total Evaluations</div>
                                    </div>
                                    <div class="frame-9">
                                        <div class="text-wrapper-7">1</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="total-evaluation">
                            <div class="frame-6">
                                <div class="frame-7">
                                    <div class="frame-8">
                                        <div class="text-wrapper-6">Total Pending</div>
                                    </div>
                                    <div class="frame-9">
                                        <div class="text-wrapper-7"><?php if ($_SESSION['status'] == 'Completed') {
                                            $_SESSION['total'] = 0;
                                            echo $_SESSION['total'];
                                        } else {
                                            $_SESSION['total'] = 1;
                                            echo $_SESSION['total'];
                                        } ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="total-evaluation">
                            <div class="frame-6">
                                <div class="frame-7">
                                    <div class="frame-8">
                                        <div class="text-wrapper-6">Total Completed</div>
                                    </div>
                                    <div class="frame-9">
                                        <div class="text-wrapper-7"><?php if ($_SESSION['status'] == 'Completed') {
                                            $_SESSION['total'] = 1;
                                            echo $_SESSION['total'];
                                        } else {
                                            $_SESSION['total'] = 0;
                                            echo $_SESSION['total'];
                                        } ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../components/footer.php' ?>
    </div>
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

<script>
    window.embeddedChatbotConfig = {
        chatbotId: "m2no5re7gKnDgnq30Logf",
        domain: "www.chatbase.co"
    }
</script>
<script src="https://www.chatbase.co/embed.min.js" chatbotId="m2no5re7gKnDgnq30Logf" domain="www.chatbase.co" defer>
</script>