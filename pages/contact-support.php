<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/contact-support.css" />
    <link rel="stylesheet" href="../components/all.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;1,700&display=swap" />
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
                    <input class="input-field" placeholder="Your Name" type="text" />
                    <input class="input-field-2" placeholder="Your E-mail" type="text">
                    <input class="input-field" placeholder="Phone Number" type="tel" />
                    <input class="input-field-2" placeholder="Subject" type="text">
                    <textarea class="input-field-3" placeholder="Message" type="text"></textarea>

                    <div class="send-message">
                        <button class="button">
                            <span class="text-wrapper-7">Send Message</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../components/footer.php' ?>
    </div>
</body>

</html>