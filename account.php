<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="account.css"> <!-- Include your CSS file -->
    <link rel="stylesheet" href="all.css">
</head>
<div>

<?php include 'nav.php' ?>
<div class="containerism">
    <div class="account">
        <div class="tab-content" id="tab-content">
            <div id="tab-account" class="tab active">
                <form action="save_account.php" method="POST">
                    <div class="input-field">
                    <h4>Personal Information</h4>
                        <h>Full Name</h>
                        <div class="form-row">
                            <div>
                                <input type="text" id="first_name" name="first_name" required placeholder="First Name">
                            </div>
                            <div>
                                <input type="text" id="last_name" name="last_name" required placeholder="Last Name">
                            </div>
                        </div>                    </div>
                    <div class="input-field">
                        <h>Contact Information</h>
                        <div class="form-row">
                            <div>
                                <input type="text" id="first_name" name="first_name" required placeholder="Student Number">
                            </div>
                            <div>
                                <input type="text" id="last_name" name="last_name" required placeholder="School Email">
                            </div>
                        </div>
                    </div>
                    <div class="input-field">
                        <h>Password</h>
                        <div class="widefield">
                            <input type="text" id="first_name" name="first_name" required placeholder="Current Password">
                        </div>
                        <div class="form-row">
                            <div>
                                <input type="password" id="first_name" name="first_name" required placeholder="New Password">
                            </div>
                            <div>
                                <input type="password" id="last_name" name="last_name" required placeholder="New Password">
                            </div>
                        </div>
                    </div>
                    <button type="submit">Save</button>
                </form>




                <form>
                </form>

                <form>
                <div class="input-field">
                    <h4>Privacy Settings</h4>
                    <div class="form-row">
                        <p>We care about your integrity, and continuosly work toward making your
                            Innovatio experience as safe and secure as possible. Read the Innovatio Privacy Policy
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
                        <p> If you choose to close your account you will no longer be able to access our services including,
                         for example, viewing your order history, or viewing your registered products. For the time being
                         this is a manual process and needs to be initiated via an e-mail sent to us. Click the button below
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
                <h>Welcome, Lawrence</h>
            </div>
            <div class="Logout">
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <div class="guide">
            <div class="guide-info">
                <p>In your account pages you can register your products, as well as view your order history.</p>
                <p>You can also contact the Innovatio customer support team. For the fastest help however, we recommend looking through appropriate product manuals, FAQ sections, or checking the Innovatioauts user forum for answers.</p>
            </div>



        </div>
</div>
</div>


<?php include 'footer.php' ?>

</body>
</html>
