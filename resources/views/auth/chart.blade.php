<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
    <canvas id="myChart" width="400" height="200"></canvas> 
</div>
</body>
<script>
//     var ctx = document.getElementById('myChart').getContext('2d');
//     var salesData = @json($salesData);

//     var months = salesData.map(data => data.month);
//     var sales = salesData.map(data => data.sales);

//     var myChart = new Chart(ctx, {
//         type: 'pie', // Set the chart type to 'pie'
//         data: {
//             labels: months,
//             datasets: [{
//                 label: 'Sales',
//                 data: sales,
//                 backgroundColor: [
//                     'rgba(255, 99, 132, 0.2)',
//                     'rgba(54, 162, 235, 0.2)',
//                     'rgba(255, 206, 86, 0.2)',
//                     'rgba(75, 192, 192, 0.2)',
//                     'rgba(153, 102, 255, 0.2)',
//                     'rgba(255, 159, 64, 0.2)',
//                     'rgba(255, 99, 132, 0.2)',
//                 ],
//                 borderColor: [
//                     'rgba(255, 99, 132, 1)',
//                     'rgba(54, 162, 235, 1)',
//                     'rgba(255, 206, 86, 1)',
//                     'rgba(75, 192, 192, 1)',
//                     'rgba(153, 102, 255, 1)',
//                     'rgba(255, 159, 64, 1)',
//                     'rgba(255, 99, 132, 1)',
//                 ],
//                 borderWidth: 1
//             }]
//         },
//         options: {
//             // You can customize options for the pie chart here
//         }
//     });
// </script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var salesData = @json($salesData);

    var months = salesData.map(data => data.month);
    var sales = salesData.map(data => data.sales);

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Sales',
                data: sales,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</html>