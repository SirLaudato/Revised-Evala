<?php
require __DIR__ . '/../vendor/autoload.php';
?>
!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/contact-support.css" />
    <link rel="stylesheet" href="../components/all.css">
    <link rel="stylesheet" href="../components/modal.css">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;1,700&display=swap" />
    <link rel="icon" type="image/png" href="innovatio-icon.png" sizes="16x16">

    <title>Contact Support</title>
</head>

<body>
    <div class="customer-support">
        <div class="navigator">
            <?php include('../components/nav.php') ?>
        </div>

        <div class="frame-2">
            <div class="support-container">
                <div class="text-wrapper-3">Contact Support</div>
                <p class="p">View upcoming evaluations to stay organized and never miss a deadline.</p>
            </div>
            <div class="frame-3">
                <div class="title-hero">
                    <div class="text-wrapper-4">Send us a message</div>
                    <p class="text-wrapper-5">Have a question? Reach out, and we’ll get back to you soon.</p>
                </div>
                <div class="frame-4">
                    <form method="POST">
                        <input class="input-field" name="name" placeholder="Your Name" type="text" required />
                        <input class="input-field-2" name="email" placeholder="Your E-mail" type="email" required />
                        <input class="input-field-2" name="subject" placeholder="Subject" type="text" required />
                        <textarea class="input-field-3" name="message" placeholder="Message" required></textarea>

                        <div class="send-message">
                            <button class="button" type="submit">
                                <span class="text-wrapper-7">Send Message</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $modalTitle = "";
    $modalMessage = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        require __DIR__ . '/../vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Correct Gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'evala2406@gmail.com'; // Your Gmail email address
            $mail->Password = 'ojrc bcjp mmzl ujpr'; // Your App Password (if 2FA is enabled)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; // For TLS, 465 for SSL
    
            // Recipients
            $mail->setFrom('innovatio.evala@gmail.com', $_POST['name']); // Default from address
            $mail->addAddress('innovatio.evala@gmail.com', 'Innovatio');
            $mail->addReplyTo($_POST['email'], $_POST['name']); // Make sure 'email' and 'name' are sanitized
    
            // Content
            $mail->isHTML(true);
            $mail->Subject = htmlspecialchars($_POST['subject']); // Ensure special chars are escaped
            $mail->Body = nl2br(htmlspecialchars($_POST['message'])); // Escape message and preserve line breaks
    
            // Send the email
            $mail->send();
            $modalTitle = "Success";
            $modalMessage = "Email sent successfully!";
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // It's better to return a proper response instead of just exiting
        exit;
    }
    ?>




    <?php include('modal.php') ?>
    <?php include '../components/footer.php' ?>
    </div>
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