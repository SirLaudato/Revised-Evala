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
        return jsonify({"message": "No file or prompt provided"}), 400

    file = request.files["file"]

    if file and allowed_file(file.filename):
        filename = secure_filename(file.filename)
        file_path = os.path.join(app.config["UPLOAD_FOLDER"], filename)
        file.save(file_path)

        file_type = filename.rsplit(".", 1)[1].lower()
        extracted_text = extract_text(file_path, file_type)

        # Send the extracted text and prompt to GPT
    
        default_prompt = """Given the following table comparing ratings for different aspects of instruction, immediately provide a detailed analysis that includes the following elements: 
                        1.	A comparison of the users on the ratings on each aspect.
                        2.	Observations on any significant differences between user’s ratings.
                        3.	Insight into how these differences might reflect different perspectives on the effectiveness of the instruction.
                        4.	Evaluation of whether both groups agree on certain aspects such as the application of theoretical knowledge, inclusion of real-world content, innovative teaching strategies, use of technology, and opportunities for student participation.
                        5.	A final conclusion highlighting the overall trends in the ratings and any recommendations based on the analysis.
                        Focus on how perspectives align and diverge in each area, and provide any actionable insights. Do not include introductory or general phrases; go directly into the analysis.
                        """
        combined_prompt = f"{default_prompt}\n\n{extracted_text}"


        
        gpt_response = openai.ChatCompletion.create(
            model="gpt-3.5-turbo",
            messages=[
                {"role": "system", "content": "You are an assistant."},
                {"role": "user", "content": combined_prompt },
            ]
        )
        ai_response = gpt_response["choices"][0]["message"]["content"]

        # Clean up the uploaded file
        os.remove(file_path)

        # Format the AI response
        formatted_response = format_response(ai_response)

        return jsonify({"message": formatted_response})

    return jsonify({"message": "Invalid file type"}), 400

if __name__ == "__main__":
    app.run(debug=True)
