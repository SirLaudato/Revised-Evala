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
        <div class="wrapper">
            <?php
            // Database connection
            $servername = "localhost"; //database server
            $username = "root"; //database username
            $password = ""; //database password
            $database = "evala_db1"; //database name
            
            $conn = mysqli_connect($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM accounts
            JOIN employee ON accounts.AccountID = employee.AccountID 
            JOIN employee_details ON employee.EmployeeID = employee_details.EmployeeID
            JOIN accdata ON accounts.AccountID = accdata.AccountID;";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="frame-6" data-aos="flip-right" data-aos-duration="500">';
                    echo '<img src = "' . $row['EmployeePicture'] . '" alt = ""></img>';
                    echo '<h4> Name: Dr. ' . $row['AccountName'] . '</h4>';
                    echo '<p>Specialty: ' . $row['EmployeeSpecialty'] . '</p>';
                    echo '<p>Room Number: ' . $row['RoomNumber'] . '</p>';

                    // Ensure AccountEmail is echoed inside the anchor tag
                    echo '<a href="mailto:' . $row['AccountEmail'] . '"> Request Appointment </a>';

                    // Add other fields as needed
                    echo '</div>';
                }
            } else {
                echo "No Available Employee.";
            }

            $conn->close();
            ?>

        </div>
        <?php include('../components/footer.php') ?>
    </div>
</body>

</html>