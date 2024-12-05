import os
from flask import Flask, request, render_template, jsonify
from werkzeug.utils import secure_filename
import openai
from PyPDF2 import PdfReader
from docx import Document
import pandas as pd
from dotenv import load_dotenv
import re

load_dotenv()
app = Flask(__name__)

# Configuration
UPLOAD_FOLDER = "uploads"
ALLOWED_EXTENSIONS = {"pdf", "docx", "csv", "txt"}
app.config["UPLOAD_FOLDER"] = UPLOAD_FOLDER
os.makedirs(UPLOAD_FOLDER, exist_ok=True)  # Create the uploads folder if it doesn't exist

openai.api_key = os.getenv("OPENAI_API_KEY")  # Replace with your actual OpenAI API key

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

# Helper: Format response to make text between ** bold and add line breaks
def format_response(response):

    # Format: Bold the section titles inside ** and add line breaks before and after them
    response = re.sub(r"\*\*([^\*]+)\*\*", r"<strong>\1</strong>", response)

    # Format: Add line breaks before and after each section title
    response = re.sub(r"(\d+\.\s)(<strong>.*?</strong>)", r"<br>\1\2<br>", response)

    # Ensure line breaks between each bullet point (convert \n to <br>)
    response = response.replace("\n", "<br>")

    return response

# Route: Serve the HTML file
@app.route("/")
def index():
    return render_template("index.html")

# Route: Handle file upload and AI analysis
@app.route("/analyze", methods=["POST"])
def analyze_file():
    if "file" not in request.files:
        return jsonify({"message": "No file provided"}), 400

    file = request.files["file"]

    if file and allowed_file(file.filename):
        filename = secure_filename(file.filename)
        file_path = os.path.join(app.config["UPLOAD_FOLDER"], filename)
        file.save(file_path)
        logging.debug(f"File saved at: {file_path}")

        file_type = filename.rsplit(".", 1)[1].lower()
        extracted_text = extract_text(file_path, file_type)

        if not extracted_text:
            return jsonify({"message": "Failed to extract text from the file."}), 500

        logging.debug(f"Extracted text: {extracted_text[:500]}")  # Log first 500 chars

        # Default prompt to provide structure for analysis
        default_prompt = """
        Given the following content from the uploaded file, perform a detailed analysis. 
        Include insights, observations, and actionable recommendations based on the provided data.
        Additionally, highlight key patterns or discrepancies found in the file.
        """

        # Combine default prompt with the extracted file content
        combined_prompt = f"{default_prompt}\n\n{extracted_text}"

        try:
            gpt_response = openai.ChatCompletion.create(
                model="gpt-3.5-turbo",
                messages=[
                    {"role": "system", "content": "You are an assistant."},
                    {"role": "user", "content": combined_prompt}
                ]
            )
            ai_response = gpt_response["choices"][0]["message"]["content"]
            logging.debug(f"AI Response: {ai_response[:500]}")
        except openai.error.OpenAIError as e:
            logging.error(f"OpenAI API error: {e}")
            return jsonify({"message": "Error processing the file with AI."}), 500

        # Clean up uploaded file
        os.remove(file_path)

        # Format AI response
        formatted_response = format_response(ai_response)
        return jsonify({"message": formatted_response})

    return jsonify({"message": "Invalid file type"}), 400