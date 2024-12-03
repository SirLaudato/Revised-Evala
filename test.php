<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";
$con = new mysqli($servername, $username, $password, $database);

if ($con->connect_error) {
    die("Connection Failed: " . $con->connect_error);
}

// Query to fetch all criteria and their respective results
$query = "
SELECT 
    `c`.`criteria_id`, 
    `c`.`criteria_name`, 
    `c`.`evaluator_type`, 
    `questionnaire`.`question`, 
    AVG(`evaluation_results`.`rate`) AS average_rating
FROM 
    `criteria` AS `c`
LEFT JOIN `questionnaire` ON `questionnaire`.`criteria_id` = `c`.`criteria_id`
LEFT JOIN `evaluation_results` ON `evaluation_results`.`question_id` = `questionnaire`.`question_id`
GROUP BY 
    `c`.`criteria_id`, 
    `c`.`criteria_name`, 
    `c`.`evaluator_type`, 
    `questionnaire`.`question`
ORDER BY 
    `c`.`criteria_name` ASC, 
    `questionnaire`.`question` ASC
";

$result = $con->query($query);

// Organize results by criteria
$criteria_results = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $criteria_results[$row['criteria_name']][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Evaluation Results</h1>

        <?php if (!empty($criteria_results)): ?>
            <?php foreach ($criteria_results as $criteria_name => $rows): ?>
                <h2><?php echo htmlspecialchars($criteria_name); ?></h2>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Evaluator Type</th>
                            <th>Question</th>
                            <th>Average Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['evaluator_type']); ?></td>
                                <td><?php echo htmlspecialchars($row['question']); ?></td>
                                <td><?php echo number_format($row['average_rating'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No evaluation results found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close the database connection
$con->close();
?>
