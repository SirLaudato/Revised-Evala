// Fetch the average rating
function fetchAverageRating() {
    fetch('http://localhost:5000/analyze_ratings')
        .then(response => response.json())
        .then(data => {
            document.getElementById('average-rating').innerText = data.average_rating;
        })
        .catch(error => console.error('Error fetching average rating:', error));
}

// Fetch rating clusters
function fetchRatingClusters() {
    fetch('http://localhost:5000/predict_rating_trends')
        .then(response => response.json())
        .then(data => {
            document.getElementById('rating-clusters').innerText = JSON.stringify(data.clusters);
        })
        .catch(error => console.error('Error fetching clusters:', error));
}

// Analyze sentiment on user feedback
function analyzeSentiment() {
    const feedback = document.getElementById('user-feedback').value;

    fetch('http://localhost:5000/sentiment_analysis', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ feedback: feedback })
    })
        .then(response => response.json())
        .then(data => {
            document.getElementById('sentiment-result').innerText = `Sentiment: ${data[0].label}, Confidence: ${data[0].score}`;
        })
        .catch(error => console.error('Error analyzing sentiment:', error));
}

// Call these functions when the page loads
window.onload = function () {
    fetchAverageRating();
    fetchRatingClusters();
};
