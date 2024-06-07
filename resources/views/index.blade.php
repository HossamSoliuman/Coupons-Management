@extends('layouts.admin')

<style>
        #myChart {
            margin: 25px auto;
        }
        .main-title {
            font-weight: bold;
            text-align: justify;
        }
        .pagination {
            justify-content: end;
        }

        .pagination .page-item.active .page-link {
            background-color: #04512D !important;
            color: white;
        }
</style>

@section('content')
    <canvas id="myChart" width="350" height="100" ></canvas>

    <div class="table-container" >
        <!-- <h2>{{ __('messages.offer_usage_details') }}</h2> -->
        <h2 class="main-title">تفاصيل استخدام العروض</h2>
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
                        backgroundColor: 'rgba(155, 175, 163, .6)',
                        borderColor: 'rgba(7, 56, 27, 1)',
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
