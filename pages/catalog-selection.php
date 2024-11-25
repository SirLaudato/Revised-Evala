<?php 
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    // You can now use $course_id to fetch specific evaluation data related to this course
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Catalog Selection</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/catalog-selection.css" />
    <link rel="stylesheet" href="../components/all.css">
    <link rel="icon" type="image/png" href="innovatio-icon.png" sizes="16x16">

</head>

<body>
    <div class="questionnaire">
        <div class="navigator">
            <?php include('../components/nav.php') ?>
        </div>
        <div class="catalog-container">
            <div class="evaluation-pics-desc">
                <div class="evaluation-img"></div>
                <div class="eval-overview">
                    <div class="eva-name">Evaluation Name</div>
                    <p class="eval-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nost
                    </p>
                </div>
            </div>
            <div class="evaluation-navigator">
                <div class="evaluation-title">
                    <div class="text-wrapper-3">Evaluation Name</div>
                    <div class="evaluation-status">
                        <div class="text-wrapper-4">Status:</div>
                        <div class="text-wrapper-4">Deadline:</div>
                    </div>
                </div>
                <div class="buttons">
                    <button class="start-eval-button">
                        <span class="text-wrapper-6">Start Evaluation</span>
                    </button>

                    <a href="catalog.php">
                        <button class="check-other-button">
                            <span class="text-wrapper-7">Check Other Evaluation</span>
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <?php include('../components/footer.php') ?>
    </div>
</body>

</html>