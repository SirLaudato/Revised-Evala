<!DOCTYPE html>
<html>

<head>
    <title>Evaluation Status Pie Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div style="width: 100%; margin: auto;">
        <canvas id="evaluationPieChart"></canvas>
    </div>

    <script>
       // Fetch evaluation data and render the chart
        fetch('/get-evaluation-data')
            .then(response => response.json())
            .then(data => {
        // Data for the chart
        const chartData = {
            labels: ['Not Yet Completed', 'Completed'],
            datasets: [{
                label: 'Evaluation Status',
                data: [data.not_yet_completed, data.completed],
                backgroundColor: ['#bebebe', '#342928'],
                hoverBackgroundColor: ['#bebebe', '#342928']
            }]
        };

        // Chart configuration
        const config = {
            type: 'pie',
            data: chartData,
        };

        // Render the chart
        const ctx = document.getElementById('evaluationPieChart').getContext('2d');
        new Chart(ctx, config);
    })
    .catch(error => console.error('Error fetching evaluation data:', error));

    </script>
</body>

</html>