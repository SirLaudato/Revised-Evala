<?php
require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;

// Initialize Dompdf
$dompdf = new Dompdf();

// Start output buffering to capture dynamic HTML
ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: blue;
        }

        p {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h1>Welcome to Dompdf!</h1>
    <p>This PDF was generated dynamically using PHP.</p>

    <!-- Dynamic PHP Content -->
    <p>Today's date: <?php echo date('Y-m-d'); ?></p>
    <p>User: <?php echo 'John Doe'; ?></p>
    <p>Random Number: <?php echo rand(1, 100); ?></p>
</body>

</html>

<?php
// Get the HTML output as a string
$html = ob_get_clean();

// Load the HTML content into Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the PDF
$dompdf->render();

// Output the PDF to the browser
$dompdf->stream("Results.pdf", ["Attachment" => false]);
