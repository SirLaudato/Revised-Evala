<?php
require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;

// Initialize Dompdf
$dompdf = new Dompdf();

// Start output buffering to capture dynamic HTML
ob_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";
$con = new mysqli($servername, $username, $password, $database);

if ($con->connect_error) {
    die("Connection Failed: " . $con->connect_error);
}

// Query to fetch all criteria, evaluator types, questions, and their average ratings
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
    `c`.`evaluator_type` ASC, 
    `questionnaire`.`question` ASC
";

$result = $con->query($query);

// Organize results by criteria and evaluator type
$criteria_results = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $criteria_results[$row['criteria_name']][$row['evaluator_type']][] = $row;
    }
}

$response_text = isset($_GET['response']) ? htmlspecialchars($_GET['response']) : 'No additional feedback provided.'; // Capture the response text passed via GET
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1,
        h2,
        h3 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .container {
            margin: 0 auto;
            padding: 20px;
            max-width: 800px;
        }

        .response-text {
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Evaluation Results</h1>

        <?php if (!empty($criteria_results)): ?>
            <?php foreach ($criteria_results as $criteria_name => $evaluator_types): ?>
                <h2><?php echo htmlspecialchars($criteria_name); ?></h2>

                <?php foreach ($evaluator_types as $evaluator_type => $rows): ?>
                    <h3><?php echo htmlspecialchars($evaluator_type); ?></h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Average Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['question']); ?></td>
                                    <td><?php echo number_format($row['average_rating'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>

            <?php endforeach; ?>
        <?php else: ?>
            <p>No evaluation results found.</p>
        <?php endif; ?>

        <!-- Display the response text from the form -->
        <div class="response-text">
            <h3>Feedback:</h3>
            <p><?php echo $response_text; ?></p>
        </div>
    </div>
</body>

</html>

<?php
// Close the database connection
$con->close();

// Get the HTML output as a string
$html = ob_get_clean();

// Load the HTML content into Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

try {
    // Render the PDF
    $dompdf->render();

    // Output the PDF to the browser
    $dompdf->stream("Results.pdf", ["Attachment" => false]);
} catch (Exception $e) {
    die("Error generating PDF: " . $e->getMessage());
}
?>