<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";

$con = mysqli_connect($servername, $username, $password, $database);

if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Query to get counts
$query = "
    SELECT 
    SUM(
        CASE 
            WHEN EXISTS (
                SELECT 1
                FROM `user_evaluations`
                WHERE `user_evaluations`.`user_id` = `users`.`user_id`
                AND `user_evaluations`.`has_answered` = 1
                LIMIT 1
            ) THEN 1
            ELSE 0
        END
    ) AS `not_yet_completed_count`,
    SUM(
        CASE 
            WHEN NOT EXISTS (
                SELECT 1
                FROM `user_evaluations`
                WHERE `user_evaluations`.`user_id` = `users`.`user_id`
                AND `user_evaluations`.`has_answered` = 1
                LIMIT 1
            ) THEN 1
            ELSE 0
        END
    ) AS `completed_count`
FROM `users`
LEFT JOIN `students` ON `users`.`user_id` = `students`.`user_id`
LEFT JOIN `faculty` ON `users`.`user_id` = `faculty`.`user_id`
LEFT JOIN `alumni` ON `users`.`user_id` = `alumni`.`user_id`
WHERE `students`.`user_id` IS NOT NULL
   OR `faculty`.`user_id` IS NOT NULL
   OR `alumni`.`user_id` IS NOT NULL;
";

$result = $con->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $notYetCompleted = $row['not_yet_completed_count'];
    $completed = $row['completed_count'];
} else {
    echo "Query failed: " . mysqli_error($con);
    exit();
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Evaluation Status Pie Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div style="width: 25%; margin: auto;">
        <canvas id="evaluationPieChart"></canvas>
    </div>

    <script>
        // Data from PHP
        const data = {
            labels: ['Not Yet Completed', 'Completed'],
            datasets: [{
                label: 'Evaluation Status',
                data: [<?php echo $notYetCompleted; ?>, <?php echo $completed; ?>],
                backgroundColor: ['#bebebe', '#342928'],
                hoverBackgroundColor: ['#bebebe', '#342928']
            }]
        };

        // Configuration for the chart
        const config = {
            type: 'pie',
            data: data,
        };

        // Render the chart
        const ctx = document.getElementById('evaluationPieChart').getContext('2d');
        new Chart(ctx, config);
    </script>
</body>

</html>