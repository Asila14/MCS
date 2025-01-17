<!DOCTYPE html>
<html>
<head>
    <title>Hi-Lo Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 80%;">
        <canvas id="hiLoChart"></canvas>
    </div>

    <script>
        // Sample data for high, average, low, and labels
        const data = [
            { x: 'Day 1', y: { high: 75, average: 73, low: 60 } },
            { x: 'Day 2', y: { high: 80, average: 78, low: 70 } },
            { x: 'Day 3', y: { high: 65, average: 64, low: 55 } },
            { x: 'Day 4', y: { high: 90, average: 87, low: 80 } },
            { x: 'Day 5', y: { high: 85, average: 82, low: 75 } },
        ];

        const ctx = document.getElementById('hiLoChart').getContext('2d');

        new Chart(ctx, {
            type: 'scatter', // Use scatter chart for Hi-Lo data
            data: {
                datasets: [
                    {
                        label: 'High',
                        data: data.map(item => ({ x: item.x, y: item.y.high })),
                        borderColor: 'rgba(0, 123, 255, 1)',
                        backgroundColor: 'rgba(0, 123, 255, 1)',
                        pointRadius: 6, // Adjust the size of the high points
                        pointStyle: 'rect', // Change the shape to a rectangle
                    },
                    {
                        label: 'Average',
                        data: data.map(item => ({ x: item.x, y: item.y.average })),
                        borderColor: 'rgba(255, 123, 27, 1)',
                        backgroundColor: 'rgba(255, 123, 27, 1)',
                        pointRadius: 6, // Adjust the size of the average points
                        pointStyle: 'triangle', // Change the shape to a triangle
                    },
                    {
                        label: 'Low',
                        data: data.map(item => ({ x: item.x, y: item.y.low })),
                        borderColor: 'rgba(255, 99, 71, 1)',
                        backgroundColor: 'rgba(255, 99, 71, 1)',
                        pointRadius: 6, // Adjust the size of the low points
                        pointStyle: 'rect', // Change the shape to a rectangle
                    },
                ]
            },
            options: {
                scales: {
                    x: {
                        position: 'bottom',
                        beginAtZero: true,
                        type: 'category', // Use category scale for x-axis
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
