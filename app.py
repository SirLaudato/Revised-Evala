import os
from flask import Flask, request, render_template, jsonify
from werkzeug.utils import secure_filename
import openai
from PyPDF2 import PdfReader
from docx import Document
import pandas as pd
from dotenv import load_dotenv
import re
import pymysql

load_dotenv()
app = Flask(__name__)

# Database configuration
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'evala_db1'
}

def get_db_connection():
    """Establishes a connection to the MySQL database."""
    return pymysql.connect(**DB_CONFIG)

#aaa
@app.route('/get-evaluation-data', methods=['GET'])
def get_evaluation_data():
    try:
        conn = get_db_connection()
        cursor = conn.cursor()
        
        # SQL Query to calculate counts
        query = """
                        SELECT 
                SUM(
                    CASE 
                        WHEN EXISTS (
                            SELECT 1
                            FROM `user_evaluations`
                            WHERE `user_evaluations`.`user_id` = `users`.`user_id`
                            AND `user_evaluations`.`has_answered` = 1
                            LIMIT 1
                        ) THEN 1
                        ELSE 0
                    END
                ) AS `not_yet_completed_count`,
                SUM(
                    CASE 
                        WHEN NOT EXISTS (
                            SELECT 1
                            FROM `user_evaluations`
                            WHERE `user_evaluations`.`user_id` = `users`.`user_id`
                            AND `user_evaluations`.`has_answered` = 1
                            LIMIT 1
                        ) THEN 1
                        ELSE 0
                    END
                ) AS `completed_count`
            FROM `users`
            LEFT JOIN `students` ON `users`.`user_id` = `students`.`user_id`
            LEFT JOIN `faculty` ON `users`.`user_id` = `faculty`.`user_id`
            LEFT JOIN `alumni` ON `users`.`user_id` = `alumni`.`user_id`
            WHERE `students`.`user_id` IS NOT NULL
                OR `faculty`.`user_id` IS NOT NULL
                OR `alumni`.`user_id` IS NOT NULL;

        """
        
        cursor.execute(query)
        result = cursor.fetchone()
        
        # Close connection
        cursor.close()
        conn.close()
        
        # Return JSON response
        return jsonify({
            'not_yet_completed': result[0] if result else 0,
            'completed': result[1] if result else 0
        })
    except Exception as e:
        return jsonify({'error': str(e)}), 500

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

# Helper: Format response to make text between ** bold
def format_response(response):
    """
    Replace text enclosed in ** with bold HTML tags (<strong>).
    """
    return re.sub(r"\*\*(.*?)\*\*", r"<strong>\1</strong>", response)

# Route: Serve the HTML file
@app.route("/")
def index():
    return render_template("evaluation.php")

# Chart Data
@app.route('/chart-data')
def chart_data():
    # Fetch data from the database
    not_yet_completed = 10  # Example value
    completed = 20  # Example value
    return jsonify({
        'labels': ['Not Yet Completed', 'Completed'],
        'data': [not_yet_completed, completed]
    })

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

        # Format the AI response
        formatted_response = format_response(ai_response)

        return jsonify({"message": formatted_response})

    return jsonify({"message": "Invalid file type"}), 400

if __name__ == "__main__":
    app.run(debug=True)