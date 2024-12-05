<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AI File Analysis</title>
</head>

<body>
  <h1>Upload Your File and Get AI Analysis</h1>

  <!-- Form to upload file and prompt -->
  <form id="uploadForm" enctype="multipart/form-data">
    <label for="file">Choose a file:</label>
    <input type="file" name="file" id="file" required><br><br>

    <label for="prompt">Enter your prompt:</label><br>
    <textarea name="prompt" id="prompt" rows="4" cols="50" required></textarea><br><br>

    <button type="submit">Analyze</button>
  </form>

  <h2>AI Response:</h2>
  <div id="response"></div>
  <!-- This is where the AI's response will be displayed -->

  <script>
    // Handle the form submission and send the file and prompt to the server
    document
      .getElementById("uploadForm")
      .addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData();
        formData.append('file', document.getElementById('file').files[0]);
        formData.append('prompt', document.getElementById('prompt').value);

        // Send the data to the server
        fetch('/analyze', {
          method: 'POST',
          body: formData,
        })
          .then(response => response.json())
          .then(data => {
            // Insert the AI response, using innerHTML to render the HTML tags (e.g., <strong> for bold and <br> for line breaks)
            document.getElementById('response').innerHTML = data.message;
          })
          .catch(error => console.error('Error:', error));
      });
  </script>
</body>

</html>