import os
from flask import Flask, request, render_template, jsonify
from werkzeug.utils import secure_filename
import openai
from PyPDF2 import PdfReader
from docx import Document
import pandas as pd

app = Flask(__name__)

# Configuration
UPLOAD_FOLDER = "uploads"
ALLOWED_EXTENSIONS = {"pdf", "docx", "csv", "txt"}
app.config["UPLOAD_FOLDER"] = UPLOAD_FOLDER
os.makedirs(UPLOAD_FOLDER, exist_ok=True)  # Create the uploads folder if it doesn't exist

openai.api_key = "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  "  # Replace with your actual OpenAI API key

# Helper: Check allowed file types
def allowed_file(filename):
    return "." in filename and filename.rsplit(".", 1)[1].lower() in ALLOWED_EXTENSIONS

# Helper: Extract text based on file type
def extract_text(file_path, file_type):
    if file_type == "pdf":
        reader = PdfReader(file_path)
        return " ".join([page.extract_text() for page in reader.pages])
    elif file_type == "docx":
        doc = Document(file_path)
        return " ".join([paragraph.text for paragraph in doc.paragraphs])
    elif file_type == "csv":
        df = pd.read_csv(file_path)
        return df.to_string()
    elif file_type == "txt":
        with open(file_path, "r", encoding="utf-8") as file:
            return file.read()

# Route: Serve the HTML file
@app.route("/")
def index():
    return render_template("index.html")

# Route: Handle file upload and AI analysis
@app.route("/analyze", methods=["POST"])
def analyze_file():
    if "file" not in request.files or "prompt" not in request.form:
        return jsonify({"message": "No file or prompt provided"}), 400

    file = request.files["file"]
    prompt = request.form["prompt"]

    if file and allowed_file(file.filename):
        filename = secure_filename(file.filename)
        file_path = os.path.join(app.config["UPLOAD_FOLDER"], filename)
        file.save(file_path)

        file_type = filename.rsplit(".", 1)[1].lower()
        extracted_text = extract_text(file_path, file_type)

        # Send the extracted text and prompt to GPT
        gpt_response = openai.ChatCompletion.create(
            model="gpt-3.5-turbo",
            messages=[
                {"role": "system", "content": "You are an assistant."},
                {"role": "user", "content": f"{prompt}\n\nHere is the file content:\n{extracted_text}"},
            ],
        )
        ai_response = gpt_response["choices"][0]["message"]["content"]

        # Clean up the uploaded file
        os.remove(file_path)

        return jsonify({"message": ai_response})

    return jsonify({"message": "Invalid file type"}), 400

if __name__ == "__main__":
    app.run(debug=True)
