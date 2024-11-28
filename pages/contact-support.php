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
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;1,700&display=swap" />
    <link rel="icon" type="image/png" href="innovatio-icon.png" sizes="16x16">

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
        $mail->setFrom('innovatio.evala@gmail.com', $_POST['name']);
        $mail->addAddress('innovatio.evala@gmail.com', 'Innovatio');
        $mail->addReplyTo($_POST['email'], $_POST['name']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $_POST['subject'];
        $mail->Body = $_POST['message'];
        $mail->send();
        echo "Message has been sent successfully!";
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
    ?>




    <?php include '../components/footer.php' ?>
    </div>
</body>

</html>