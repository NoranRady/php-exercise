@extends('layouts.app')

@section('content')
    <h1>Historical Stock Data</h1>
    <table class="table">
        <thead>
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

    <script>
        const symbol = '{{ $symbol }}'; // assuming the $symbol variable is passed from the controller
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
            })
            .catch(error => console.error(error));
    </script>
@endsection
