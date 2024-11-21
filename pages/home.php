<?php
session_start();
if (!isset($_SESSION['emailaddress'])) {
    header("Location: ../pages/login.php");
    exit();

}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/home.css" />
    <link rel="stylesheet" href="../components/all.css">
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
                                        <div class="text-wrapper-7">0</div>
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
                                        <div class="text-wrapper-7">0</div>
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
                                        <div class="text-wrapper-7">0</div>
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

</html>