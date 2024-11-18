<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/components/all.css">
    <link rel="stylesheet" href="/css/global.css" />
    <link rel="stylesheet" href="/css/login.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login">
        <!-- Include the navigation bar -->
            <div class="navigator">
                <?php include('C:\Users\Lawrence\Documents\Revised Evala\components\nav.php') ?>
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

        <!-- Include the footer -->
        
        <?php include 'C:\Users\Lawrence\Documents\Revised Evala\components\footer.php' ?>
    </div>


    <?php
    $servername = "localhost"; //database server
    $username = "root"; //database username
    $password = ""; //database password
    $database = "evala_db1"; //database name
    
    $con = mysqli_connect($servername, $username, $password, $database);

    if (!$con) {
        die("Connection Failed: " . mysqli_connect_error());
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check if fields are filled
            if (isset($_POST['e-mail']) && isset($_POST['password'])) {
                // Initialize variables for queries and POST method
                $email = mysqli_real_escape_string($con, $_POST['username']); // Clean email text
                $pw = mysqli_real_escape_string($con, $_POST['password']); // Clean password text
    
                // Check if the email exists in the database
                $userQuery = "SELECT * FROM users
                          WHERE email = '$email'";
                $result = mysqli_query($con, $userQuery);

                // Check if the query has a result
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION["user_id"] = $row["user_id"];
                    $_SESSION["first_name"] = $row["first_name"];
                    $_SESSION["last_name"] = $row["last_name"];
                    $_SESSION["emailaddress"] = $row["email"];
                    $_SESSION["password"] = $row["password"];
                    $_SESSION["role"] = $row["role"];
                    if ($row['password'] == $pw) {
                        // Password is correct
                        if (($row["role"] == "student") || ($row["role"] == "alumni") || ($row["role"] == "faculty")) {
                            header("Location: /Revised-Evala/home.php");
                        }
                    } else {
                        // Password is incorrect
                        echo "<script>alert('Incorrect password');</script>";
                    }
                } else {
                    // Email not present in the database
                    echo "<script>alert('An account with this username doesn\'t exist');</script>";
                }
            } else {
                // Fields are not filled
                echo "<script>alert('Please fill in all the fields.');</script>";
            }
        }
    }

    // Close the connection
    mysqli_close($con);
    ?>
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