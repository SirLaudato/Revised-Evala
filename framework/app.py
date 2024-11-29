from flask import Flask, jsonify, request
import pandas as pd
from sklearn.cluster import KMeans
from transformers import pipeline

app = Flask(__name__)

# Dummy data for demonstration purposes
data = [
    {"user_id": 1, "rate": 5},
    {"user_id": 2, "rate": 3},
    {"user_id": 3, "rate": 4},
    {"user_id": 4, "rate": 2},
]

# Example: Sentiment Analysis setup (Optional: if you have textual feedback)
sentiment_analyzer = pipeline("sentiment-analysis")

@app.route('/analyze_ratings', methods=['GET'])
def analyze_ratings():
    # Simulating analysis of ratings
    df = pd.DataFrame(data)
    avg_rating = df['rate'].mean()
    return jsonify({"average_rating": avg_rating})

@app.route('/predict_rating_trends', methods=['GET'])
def predict_rating_trends():
    # Simulating KMeans clustering analysis on ratings
    df = pd.DataFrame(data)
    kmeans = KMeans(n_clusters=2)
    df['cluster'] = kmeans.fit_predict(df[['rate']])
    return jsonify({"clusters": df['cluster'].tolist(), "centroids": kmeans.cluster_centers_.tolist()})

@app.route('/sentiment_analysis', methods=['POST'])
def sentiment_analysis():
    feedback = request.json.get('feedback')
    results = sentiment_analyzer(feedback)
    return jsonify(results)

if __name__ == '__main__':
    app.run(debug=True)
