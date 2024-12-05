<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criteria List</title>
    <link rel="stylesheet" href="../admin-css/modal.css">
    <link rel="stylesheet" href="../admin-css/evaluation.css">
</head>
<style>
    @import url("https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css");
@import url("https://fonts.googleapis.com/css?family=Montserrat:400,500,700,600,italic");

:root {
  --text-color: #342928;
  --background-color: #f4f4f3;
  --gray-color: #ebebeb;
  --placeholder: #a6a6a6;
  --text-gray: #727271;
  --font-family: "Montserrat", sans-serif;
  --navigator-width: 200px;
  --section-gap: 20px;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: var(--font-family);
}

body {
  background-color: var(--background-color);
  color: var(--text-color);
  display: flex;
  font-family: var(--font-family);
}

.navigator {
  width: var(--navigator-width);
  margin-right: 60px; /* Add space between the sidebar and main content */
}

.parent-evaluation-container {
  display: flex;
  flex: 1;
  gap: var(--section-gap);
  padding: 20px;
  padding-left: 0; /* Avoid additional spacing here */
}

.evaluation-add {
  background-color: var(--gray-color); /* White background for a flat look */
  width: 30%; /* Set to 30% of the parent container */
  color: var(--text-color); /* Text in dark gray/black */
  padding: 20px;
  border: 1px solid var(--gray-color); /* Subtle border */
  height: auto; /* Automatically adjusts to content */
  box-shadow: none; /* Remove shadow */
  gap: 10px;
}
.evaluation-add label {
  font-size: 14px;
  margin-bottom: 6px; /* Space between label and the next element */
  display: block; /* Ensures the label behaves as a block element */
  font-family: var(--font-family);
}

.evaluation-list label {
  font-size: 14px;
  margin-bottom: 6px;
  display: block;
  font-family: var(--font-family);
}

.evaluation-list {
  background-color: var(--gray-color); /* White background for a flat look */
  width: 70%; /* Set to 70% of the parent container */
  color: var(--text-color); /* Text in dark gray/black */
  padding: 20px;
  border: 1px solid var(--gray-color); /* Subtle border */
  box-shadow: none; /* Remove shadow */
}

.evaluation-list table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

.evaluation-list table th,
.evaluation-list table td {
  border: 1px solid var(--gray-color);
  padding: 10px;
  text-align: left;
  font-size: 0.9em;
  color: var(--text-color);
}

.evaluation-list table th {
  background-color: var(--gray-color);
  font-weight: 400;
  padding-bottom: 2rem;
}

.evaluation-list table td {
  background-color: var(--gray-color);
}

.evaluation-list .buttons {
  /* Button alignment for the form */
  display: flex;
  width: 180px;
  text-align: center;
  margin-top: 10px;
  gap: 5px;
}

form {
  display: flex; /* Make it a flex container */
  flex-direction: column; /* Stack children vertically */
  gap: 14px; /* Add gap between child elements */
}

.evaluation-add h2,
.evaluation-list h2 {
  font-size: 1.4em;
  margin-bottom: 40px;
  color: #342928;
}

button {
  background-color: #342928; /* Dark button background */
  color: white;
  border: none;
  padding: 8px 16px;
  cursor: pointer;
  font-size: 0.9em;
  width: 100%;
}

button:hover {
  background-color: #4a3d3c; /* Slightly lighter shade on hover */
}

textarea {
  width: 100%; /* Make it full width */
  height: 150px; /* Fixed height */
  border: none;
  background-color: #ffffff;
  color: var(--text-color);
  margin-bottom: 10px;
  font-size: 0.9em;
  outline: none;
  padding: 10px;
  resize: none; /* Disable resizing */
}

/* Adjust form input styles */
input,
select {
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #ffffff;
  color: var(--text-color);
  margin-bottom: 10px;
  font-size: 0.9em;
  outline: none;
}

.custum-file-upload {
  height: 200px;
  width: auto;
  display: flex;
  flex-direction: column;
  align-items: space-between;
  gap: 20px;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  border: 2px dashed #cacaca;
  background-color: rgba(255, 255, 255, 1);
  padding: 3rem;
  box-shadow: 0px 48px 35px -48px rgba(0, 0, 0, 0.1);
}

.custum-file-upload .icon {
  display: flex;
  align-items: center;
  justify-content: center;
}

.custum-file-upload .icon svg {
  height: 80px;
  fill: var(--text-color);
}

.custum-file-upload .text {
  display: flex;
  align-items: center;
  justify-content: center;
}

.custum-file-upload .text span {
  font-weight: 400;
  color: rgba(75, 85, 99, 1);
}

.custum-file-upload input {
  display: none;
}

#criteria_name {
  height: 390px;
  margin-bottom: 24px;
}

</style>
<body>

    <div class="navigator">
        <?php include('../admin/index.php'); ?>
    </div>

    <div class="parent-evaluation-container">
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