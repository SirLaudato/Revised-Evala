<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation</title>
    <link rel="stylesheet" href="{{ url_for('static', filename='modal.css') }}">
    <link rel="stylesheet" href="{{ url_for('static', filename='evaluation.css') }}">
</head>

<body>

    <div class="navigator">
        {% include 'index.php' %}>
        {% include 'chart.php' %}
        <div style="width: 100%; margin: auto;">
            <canvas id="evaluationPieChart" width="800" height="400"></canvas>
        </div>

    </div>

    <div class="parent-evaluation-container">
        <div class="evaluation-add">
            <h2>Evaluation Analysis</h2>
            <form id="uploadForm" method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="criteria_name">Criteria Name:</label>
                    <label class="custum-file-upload" for="file">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24">
                                <!-- SVG Content -->
                            </svg>
                        </div>
                        <div class="text">
                            <span>Click to upload File</span>
                        </div>
                        <input type="file" name="file" id="file">
                    </label>
                     <div class="file-name" id="file-name"></div>
                </div>
                <div class="form-group">
                    <label for="prompt">Prompt:</label>
                    <textarea name="prompt" id="prompt" rows="4" cols="50" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" name="add_criteria">Analyze</button>
                </div>
            </form>
        </div>

        <div class="evaluation-list">
            <h2>Analyzation with Ai Feedback</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="criteria_name">Results:</label>
                    <textarea id="response" name="response" required></textarea>
                </div>
                <div class="form-group">
                    <!-- Send data to pdf-generator.php with the content of textarea -->
                    <a id="export-pdf" href="#" target="_blank">
                        <button type="button">Export to PDF</button>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Handle the form submission and send the file and prompt to the server
        document.getElementById("uploadForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData();
            formData.append('file', document.getElementById('file').files[0]);
            formData.append('prompt', document.getElementById('prompt').value);

            // Send the data to Flask for analysis
            fetch('/analyze', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    // Insert the AI response, using innerHTML to render HTML tags (e.g., <strong> for bold)
                    document.getElementById('response').innerHTML = data.message;
                })
                .catch(error => console.error('Error:', error));
        });

        // Add an event listener for the export link click
        document.getElementById('export-pdf').addEventListener('click', function (e) {
            // Get the response content from the textarea
            var responseText = encodeURIComponent(document.getElementById('response').value);

            // Update the href to include the response text
            this.href = "https://localhost/Revised-Evala/pdf-generator.php?response=" + responseText;
        });
    </script>

    <script>
    document.getElementById('file').addEventListener('change', function(event) {
        var fileName = event.target.files[0] ? event.target.files[0].name : '';
        var fileNameDisplay = document.getElementById('file-name');
        
        if (fileName) {
            fileNameDisplay.textContent = 'Selected file: ' + fileName;
        } else {
            fileNameDisplay.textContent = '';
        }
    });
</script>
</body>

</html>