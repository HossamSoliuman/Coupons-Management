@extends('layouts.admin')


@section('styles')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header h1 {
        font-weight: 500;
        letter-spacing: 1px;
        font-size: 32px;
    }

    .create-btn {
        border-radius: 24px;
        background-color: #D2E5BB;
        border: none;
        padding: 7px 15px;
        color: black;
        font-size: 18px;
        font-weight: bold;
        transition: .2s;
        letter-spacing: 1px;
    }

    .create-btn:hover {
        background-color: #BBCCA6;
        transform: scale(1.05);
    }

    .card-body {
        text-align: right;
    }
    th {
        font-weight: 500 !important;
    }

    th,
    td {
        text-align: center;
    }

</style>

@endsection


@section('content')
<div class="container mt-5">
    <div class="row justify-content-center mt-5">
        <div class="col-md-11">
            <div class="page-header">
                <h1> تفاصيل استخدام عروض : {{ $code->name }}</h1>
                <div class="mb-3">
                    <a href="{{ route('export.pdf', ['code' => $code->id]) }}" class="btn create-btn">تحميل بصيغة PDF</a>
                    <a href="{{ route('export.excel', ['code' => $code->id]) }}" class="btn create-btn">تحميل بصيغة EXCEL</a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th> اسم المتجر</th>
                        <th> الاسم</th>
                        <th> القيمة</th>
                        <th> أقصي حد للاستخدام	</th>
                        <th> عدد مرات الاستخدام	</th>
                        <th> تم انشاؤه في	</th>
                        <th> اخر مره تم استخدامه في</th>
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
                            {{ Carbon\Carbon::parse($offerDetails->created_at)->format('Y M d H:i:s') }}
                        </td>
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
