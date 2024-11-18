<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="globals.css" />
        <link rel="stylesheet" href="styleguide.css" />
        <link rel="stylesheet" href="catalog-selection.css" />
    </head>
    <body>
        <div class="questionnaire">
            <div class="navigator">
                <?php include('nav.php') ?>
            </div>
            <div class="catalog-container">
                <div class="evaluation-pics-desc">
                    <div class="evaluation-img"></div>
                    <div class="eval-overview">
                        <div class="eva-name">Evaluation Name</div>
                        <p class="eval-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
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
            <?php include('footer.php') ?>
        </div>
    </body>
</html>
