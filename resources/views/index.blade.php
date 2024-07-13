@extends('layouts.admin')

<style>
    #myChart {
        margin: 35px auto 25px;
    }

    .main-title {
        font-weight: bold;
        text-align: justify;
    }

    .pagination {
        justify-content: end;
    }

    .pagination .page-item.active .page-link {
        background-color: #d2e5bb !important;
        color: black !important;
    }

    th {
        font-size: 16px !important;
        font-weight: 500 !important;
    }
</style>

@section('content')
    <canvas id="myChart" width="350" height="100" ></canvas>

    <div class="table-container">
        <h2 class="main-title">تفاصيل استخدام العروض</h2>
        <table class="table" id="offersUsageTable">
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
        {{ $offersUsagesDetails->links() }}
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script>
        function fetchData() {
            fetch('index/chart-data')
                .then(response => response.json())
                .then(data => {
                    updateChart(data);
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function updateChart(data) {
            const hours = Array.from({
                length: 24
            }, (_, i) => i);
            const counts = new Array(24).fill(0);

            data.forEach(item => {
                counts[item.hour] = item.count;
            });

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: hours,
                    datasets: [{
                        label: '{{ __('messages.offer_usage') }}',
                        data: counts,
                        backgroundColor: 'rgba(210, 229, 187, .6)',
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

        document.addEventListener('DOMContentLoaded', function() {
            fetchData();
            setInterval(fetchData, 60000);
        });
    </script>
@endsection
