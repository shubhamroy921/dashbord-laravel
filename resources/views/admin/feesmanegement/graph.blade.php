@extends('layouts.user_type.auth')

@section('content')
<div>
    <h5 class="mb-0">Fee Graph for {{ $student->name }}</h5>
    <canvas id="feeChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('feeChart').getContext('2d');
    var feeData = @json($monthlyFees); // Laravel to pass data to JavaScript

    var chart = new Chart(ctx, {
        type: 'line', // Line chart
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Months
            datasets: [{
                label: 'Fees Paid',
                data: feeData, // This comes from the controller
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: function(context) {
                    var index = context.dataIndex;
                    var value = context.dataset.data[index];
                    return value !== null ? 'rgba(75, 192, 192, 0.2)' : 'rgba(255, 99, 132, 0)'; // Filled for paid, unfilled for unpaid
                },
                borderWidth: 2,
                fill: true, // Fill below the line
                spanGaps: false, // Don't connect gaps (unpaid months)
                tension: 0.4 // Curved lines
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw !== null ? 'Paid: $' + tooltipItem.raw : 'Unpaid';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
