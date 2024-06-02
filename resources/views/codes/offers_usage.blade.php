@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-11">
                <h1>{{ $code->name }} Offers usages deatails</h1>
                <div class="mb-3">
                    <a href="{{ route('export.pdf', ['code' => $code->id]) }}" class="btn btn-dark btn-sm">Export as PDF</a>
                    <a href="{{ route('export.excel', ['code' => $code->id]) }}" class="btn btn-dark btn-sm">Export as
                        Excel</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th> Shop Name</th>
                            <th> Name</th>
                            <th> Amount</th>
                            <th> Max usage times</th>
                            <th> Used times</th>
                            <th> Time</th>
                            <th> Time Difference</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offersUsagesDetails as $offerDetails)
                            <tr>
                                <td class="offer-shop_id">{{ $offerDetails->offer->shop->name }}</td>
                                <td class="offer-name">{{ $offerDetails->offer->name }}</td>
                                <td class="offer-amount">{{ $offerDetails->offer->amount }}</td>
                                <td class="offer-max_usage_times">{{ $offerDetails->offer->max_usage_times }}</td>
                                <td class="offer-used_times">{{ $offerDetails->offer->used_times }}</td>
                                <td class="offer-created_at">
                                    {{ Carbon\Carbon::parse($offerDetails->created_at)->format('Y M d H:i:s') }}</td>
                                <td>
                                    {{ Carbon\Carbon::parse($offerDetails->created_at)->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $offersUsagesDetails->links() }}
            </div>
        </div>
    </div>
@endsection
