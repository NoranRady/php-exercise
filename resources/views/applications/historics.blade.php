@extends('layouts.app')

@section('content')
    <h1>Historical Stock Data</h1>
    <p style="color: blue;"><a href="#chart">Click here to view chart at the end of the page</a></p>

    <div id="loading-spinner" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    
    <table class="table table-striped table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Date</th>
                <th>Open</th>
                <th>High</th>
                <th>Low</th>
                <th>Close</th>
                <th>Volume</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <canvas id="chart" style="max-height: 400px;"></canvas>

    <style>
        body {
            background-color: #f8f9fa;
        }
    
        h1 {
            margin-top: 50px;
            margin-bottom: 30px;
            font-size: 36px;
            text-align: center;
        }
    
        table {
            margin-bottom: 50px;
        }
    
        canvas {
            margin-top: 50px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const symbol = '{{ $symbol }}'; // assuming the $symbol variable is passed from the controller
        const spinner = document.getElementById('loading-spinner');
        spinner.style.display = 'block'; // Show the spinner
    
        fetch(`https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol=${symbol}`, {
                headers: {
                    'X-RapidAPI-Key': '3635bd2bc9mshdb45b5dbbc89d81p158584jsn8b2f5b986b52',
                    'X-RapidAPI-Host': 'yh-finance.p.rapidapi.com',
                },
            })
            .then(response => response.json())
            .then(data => {
                const historicalData = data.prices;
                console.log(historicalData);
    
                // Create arrays of dates, opens, and closes
                const dates = historicalData.map(data => data.date);
                const opens = historicalData.map(data => data.open);
                const closes =historicalData.map(data => data.close);
    
                // Create chart data
                const chartData = {
                    labels: dates,
                    datasets: [{
                            label: 'Open',
                            data: opens,
                            borderColor: 'rgb(255, 99, 132)',
                            fill: false,
                        },
                        {
                            label: 'Close',
                            data: closes,
                            borderColor: 'rgb(54, 162, 235)',
                            fill: false,
                        },
                    ]
                };
    
                // Create chart options
                const chartOptions = {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Open and Close Prices',
                        },
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date',
                            },
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Price',
                            },
                            suggestedMin: Math.min(...opens, ...closes),
                            suggestedMax: Math.max(...opens, ...closes),
                        },
                    },
                };
    
                // Get tabledata and render it to the page
                const tableBody = document.querySelector('tbody');
                tableBody.innerHTML = '';
                historicalData.forEach(data => {
                    const row = document.createElement('tr');
                    const dateCell = document.createElement('td');
                    const openCell = document.createElement('td');
                    const highCell = document.createElement('td');
                    const lowCell = document.createElement('td');
                    const closeCell = document.createElement('td');
                    const volumeCell = document.createElement('td');
    
                    dateCell.innerText = data.date;
                    openCell.innerText = data.open;
                    highCell.innerText = data.high;
                    lowCell.innerText = data.low;
                    closeCell.innerText = data.close;
                    volumeCell.innerText = data.volume;
    
                    row.appendChild(dateCell);
                    row.appendChild(openCell);
                    row.appendChild(highCell);
                    row.appendChild(lowCell);
                    row.appendChild(closeCell);
                    row.appendChild(volumeCell);
    
                    tableBody.appendChild(row);
                });
    
                // Create chart
                const ctx = document.getElementById('chart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: chartOptions,
                });
    
                spinner.style.display = 'none'; // Hide the spinner after the data is fetched
            })
            .catch(error => console.error(error));
    </script>
    
@endsection
