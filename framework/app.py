from flask import Flask, request, jsonify
from transformers import pipeline

# Initialize Flask app
app = Flask(__name__)

# Load a pre-trained model (e.g., GPT-Neo or GPT-J)
model = pipeline("text-generation", model="EleutherAI/gpt-neo-1.3B")

@app.route('/interpret', methods=['POST'])
def interpret_data():
    # Get questionnaire data from request
    data = request.json
    questionnaire_results = data.get('results', [])

    # Generate an interpretation
    input_text = f"Here are the questionnaire results: {questionnaire_results}. Provide suggested actions."
    response = model(input_text, max_length=200, num_return_sequences=1)

    # Return response as JSON
    return jsonify({"suggestion": response[0]['generated_text']})

if __name__ == '__main__':
    app.run(debug=True)
