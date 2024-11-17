<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="global.css" />
    <link rel="stylesheet" href="login.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login">
        <!-- Include the navigation bar -->
        <div class="navigator">
            <?php include('nav.php'); ?>
        </div>

        <!-- Login Form -->
        <div class="login-interface">
            <div class="div-2">
                <div class="text-wrapper-3">Log In</div>
                <p class="p">Use the school email provided by your school.</p>
            </div>

            <div class="div-2">
                <div class="div-3">
                    <div class="text-wrapper-4">Email Address</div>
                    <input class="input-field" placeholder="Your E-mail" type="email" />
                </div>
                <div class="div-3">
                    <div class="text-wrapper-6">Password</div>
                    <input class="input-field" placeholder="Your Password" type="password" />
                </div>
            </div>

            <div class="login-button">
                <button class="button"><div class="text-wrapper-7">Log In</div></button>
                <div class="text-wrapper-8">Forgot your password?</div>
            </div>
        </div>

        <!-- Include the footer -->
        <?php include('footer.php'); ?>
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
</body>
</html>
