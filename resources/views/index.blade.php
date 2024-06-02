@extends('layouts.admin')

@section('content')
    <canvas id="myChart" width="400" height="200"></canvas>

    <div class="table-container">
        <h2>{{ __('messages.offer_usage_details') }}</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('messages.phone_number') }}</th>
                    <th>{{ __('messages.code_name') }}</th>
                    <th>{{ __('messages.shop_name') }}</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.amount') }}</th>
                    <th>{{ __('messages.time') }}</th>
                    <th>{{ __('messages.time_difference') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offersUsagesDetails as $offerDetails)
                    <tr>
                        <td>{{ $offerDetails->phone_number }}</td>
                        <td>{{ $offerDetails->offer->code->name }}</td>
                        <td>{{ $offerDetails->offer->shop->name }}</td>
                        <td>{{ $offerDetails->offer->name }}</td>
                        <td>{{ $offerDetails->offer->amount }}</td>
                        <td>{{ $offerDetails->created_at->format('Y M d H:i:s') }}</td>
                        <td>{{ $offerDetails->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Links -->
        {{ $offersUsagesDetails->links() }}
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script>
        fetch('index-data')
            .then(response => response.json())
            .then(data => {
                updateChart(data);
            })
            .catch(error => console.error('Error fetching data:', error));

        function updateChart(data) {
            const intervals = data.map(item => item.interval_start);
            const counts = data.map(item => item.count);
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: intervals,
                    datasets: [{
                        label: '{{ __('messages.offer_usage') }}',
                        data: counts,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    </script>
@endsection
