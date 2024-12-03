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
            font-family: "Arial", Helvetica, sans-serif;
        }

        h1, h2, h3, h4, h5 {
            text-align: center;
            margin: 0;
        }

        .header-section {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .header-section .college {
            font-size: 16px;
            font-weight: bold;
        }

        .header-section .department {
            font-style: italic;
            font-size: 14px;
            margin-top: 5px;
        }

        .header-section .title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
        }

        .header-section .year {
            font-size: 14px;
            margin-top: 20px;
        }

        .header-section .program {
            font-size: 14px;
            font-weight: bold;
            margin-top: 30px;
        }

        .header-section .program-details {
            font-size: 12px;
            margin-top: 5px;
        }


        h1 {
            color: blue;
            font-family: "Arial", Helvetica, sans-serif;
        }

        p {
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }

        td {
            font-size: 12px;
        }

        tr {
            font-weight: 400;
            text-align: center;
            font-size: 14px;
            
        }

        .table-title {
            font-weight: bold;
            margin-top: 20px;
            text-transform: uppercase;
        }

        .content {
            text-indent: 50px;
        }

    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="header-section">
        <div class="college">COLLEGE OF ENGINEERING, COMPUTER STUDIES, and ARCHITECTURE</div>
        <div class="department">Department of Computer Studies</div>
        <div class="title">CURRICULUM VALIDATION RESULTS</div>
        <div class="year">ACADEMIC YEAR 2023-2024</div>
        <div class="program">Bachelor of Science in Information Technology (BSIT)</div>
        <div class="program-details">with Specialization in Web and Mobile Technology<br>Curriculum Year 2022-2023</div>
    </div>

    <!-- Content Section -->
    <div class="content-section">

        <!-- The numbering of sections, in roman numerals should be incrementing -->
        <div class="table-title">I. Introduction</div>
        <div class="content">
            <p>
            Curriculum Validation/Evaluation is one way to determine the significance, usefulness and even
            the weak point of any program’s curricula. Last week of June the Department of Computer Studies
            conducted a curriculum review for the 2022-2023 BSIT Curriculum. This was done through feedback
            mechanism from the primary stakeholder - the students, industry academic board and faculty members
            using the online platform. The purpose of which is to serve as basis to continuously update and improve
            appropriate syllabi in response to the ever evolving and dynamic world of Information Technology.
            Changes to the curriculum will be incorporated in the syllabi content for each major IT subjects.
            </p>
        </div>
    </div>

    <!-- Table -->
    <div class="table-section">
        <div class="table-title">Table 1.B Course Content</div>
        <table>
            <thead>
                <tr>
                    <th>Course Content</th>
                    <th>Student Rating</th>
                    <th>Faculty Rating</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>The course content is generally perceived as comprehensive. The relatively high mean score indicates positive feedback, though there is some variability.</td>
                    <td>4.42</td>
                    <td>4.64</td>
                </tr>
                <tr>
                    <td>The syllabi's emphasis on connections within and across disciplines is seen positively but with some variability in responses.</td>
                    <td>4.42</td>
                    <td>4.64</td>
                </tr>
                <tr>
                    <td>The syllabi's provision of items leading to conceptual understanding is well-regarded, though some responses vary.</td>
                    <td>4.44</td>
                    <td>4.82</td>
                </tr>
                <tr>
                    <td>There is strong agreement that appropriate technology is incorporated into the syllabi. The low standard deviation indicates consistent feedback.</td>
                    <td>4.47</td>
                    <td>4.82</td>
                </tr>
            </tbody>
        </table>
    </div>

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
?>
