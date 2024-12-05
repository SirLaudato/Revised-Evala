<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criteria List</title>
    <link rel="stylesheet" href="../admin-css/modal.css">
    <link rel="stylesheet" href="../admin-css/evaluation.css">
</head>
<body>

    <div class="navigator">
        <?php include('../admin/index.php'); ?>
    </div>

    <div class="parent-evaluation-container">
        <div class="evaluation-progress">
            
        </div>
        
        <div class="evaluation-analysis">
            <div class="evaluation-add">
                <h2>Evaluation Analysis</h2>
                <form id="uploadForm" method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="criteria_name">Upload a File:</label>
                        <label class="custum-file-upload" for="file">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24">
                                    <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text">
                                <span>Click to upload File</span>
                            </div>
                            <input type="file" name="file" id="file">
                        </label>
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
                </form>
                <div class="form-group">
                    <button type="submit" name="add_criteria">Export to PDF</button>
                </div>
            </div>
        </div>

        <div class="evaluation-feedback">
            <form id="uploadForm" method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="prompt">Prompt:</label>
                    <textarea name="prompt" id="prompt" rows="4" cols="50" required></textarea>
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
    </script>

</body>

</html>