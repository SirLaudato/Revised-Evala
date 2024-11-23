<!DOCTYPE html>
<html>

<head>
  <title>Catalog</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="../css/global.css" />
  <link rel="stylesheet" href="../css/catalog.css" />
  <link rel="stylesheet" href="../components/all.css">
  <link rel="icon" type="image/png" href="innovatio-icon.png" sizes="16x16">

</head>

<body>
  <div class="catalog">
    <div class="navigator">
      <?php include('../components/nav.php') ?>
    </div>
    <div class="frame-wrapper">
      <div class="frame-2">
        <div class="frame-3">
          <div class="text-wrapper-3">Curriculum Evaluation</div>
        </div>
        <div class="frame-4">
          <div class="frame-5">


            <div class="div-wrapper">
              <div class="text-wrapper-4">On-going Evaluations</div>
            </div>

            <div class="frame-6">

            <?php
            // Dynamic values
            $evaluation_status = "Pending"; // Example: "Completed", "Pending", etc.
            $curriculum_name = "BS Computer Science"; // Example curriculum name
            $evaluation_deadline = "2024-12-15"; // Example deadline

            // Echo the HTML structure
            echo '
            <div class="curriculum-container">
                <div class="frame-7"></div>
                <div class="frame-8">
                    <div class="frame-9">
                        <div class="div-wrapper">
                            <div class="text-wrapper-5">' . htmlspecialchars($evaluation_status) . '</div>
                        </div>
                        <div class="frame-3">
                            <div class="text-wrapper-4">' . htmlspecialchars($curriculum_name) . '</div>
                        </div>
                    </div>
                    <div class="div-wrapper">
                        <div class="text-wrapper-6">' . htmlspecialchars($evaluation_deadline) . '</div>
                    </div>
                </div>
            </div>';
            ?>

              <div class="curriculum-container">
                <div class="frame-7"></div>
                <div class="frame-8">
                  <div class="frame-9">
                    <div class="div-wrapper">
                      <div class="text-wrapper-5">Evaluation Status</div>
                    </div>
                    <div class="frame-3">
                      <div class="text-wrapper-4">Curriculum Name</div>
                    </div>
                  </div>
                  <div class="div-wrapper">
                    <div class="text-wrapper-6">Evaluation Deadline</div>
                  </div>
                </div>
              </div>


              <div class="curriculum-container">
                <div class="frame-7"></div>
                <div class="frame-8">
                  <div class="frame-9">
                    <div class="div-wrapper">
                      <div class="text-wrapper-5">Evaluation Status</div>
                    </div>
                    <div class="frame-3">
                      <div class="text-wrapper-4">Curriculum Name</div>
                    </div>
                  </div>
                  <div class="div-wrapper">
                    <div class="text-wrapper-6">Evaluation Deadline</div>
                  </div>
                </div>
              </div>


            </div>
          </div>


          <div class="frame-10">
            <div class="frame-5">
              <div class="div-wrapper">
                <div class="text-wrapper-4">Completed Evaluations</div>
              </div>
              <div class="frame-6">


                <div class="curriculum-container">
                  <div class="frame-7"></div>
                  <div class="frame-8">
                    <div class="frame-9">
                      <div class="div-wrapper">
                        <div class="text-wrapper-5">Evaluation Status</div>
                      </div>
                      <div class="frame-3">
                        <div class="text-wrapper-4">Curriculum Name</div>
                      </div>
                    </div>
                    <div class="div-wrapper">
                      <div class="text-wrapper-6">Evaluation Deadline</div>
                    </div>
                  </div>
                </div>


                <div class="curriculum-container">
                  <div class="frame-7"></div>
                  <div class="frame-8">
                    <div class="frame-9">
                      <div class="div-wrapper">
                        <div class="text-wrapper-5">Evaluation Status</div>
                      </div>
                      <div class="frame-3">
                        <di class="text-wrapper-4">Curriculum Name</di v>
                      </div>
                    </div>
                    <div class="div-wrapper">
                      <div class="text-wrapper-6">Evaluation Deadline</div>
                    </div>
                  </div>
                </div>

                


                <div class="curriculum-container">
                  <div class="frame-7"></div>
                  <div class="frame-8">
                    <div class="frame-9">
                      <div class="div-wrapper">
                        <div class="text-wrapper-5">Evaluation Status</div>
                      </div>
                      <div class="frame-3">
                        <div class="text-wrapper-4">Curriculum Name</div>
                      </div>
                    </div>
                    <div class="div-wrapper">
                      <div class="text-wrapper-6">Evaluation Deadline</div>
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include('../components/footer.php') ?>
  </div>
</body>

</html>