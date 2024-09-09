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

    .first-row-links,
    .second-row-links {
        margin: 10px 0;
    }

    .first-row-links a {
        color: black;
        margin-left: 8px;
        padding: 4px 8px;
        border-radius: 10px;
        background-color: #F8F8F8;
        box-shadow: #C4C4C4 1px 3px 9px;
        transition: .3s;
    }

    .first-row-links a:hover {
        background-color: #E0E0E0;
        box-shadow: #bebebe 1px 3px 9px;
    }

    .second-row-links {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 25px;
        margin-top: 30px;
    }

    .edit-btn {
        background-color: #3D8BFD;
        border-radius: 10px;
        border: none;
        padding: 4px 18px;
        border-radius: 10px;
        letter-spacing: 1px;
        color: white;
        transition: .3s;
        font-weight: 600;
    }

    .edit-btn:hover {
        background-color: #0d6efd;
    }

    .delete-btn {
        background-color: #ff4d4f;
        border-radius: 10px;
        border: none;
        padding: 4px 18px;
        border-radius: 10px;
        letter-spacing: 1px;
        color: white;
        transition: .3s;
        font-weight: 600;
    }

    .delete-btn:hover {
        background-color: #CC3D3F;
    }

    .modal-title {
        letter-spacing: 1px;
        font-weight: bold;
    }

    .modal-header {
        text-align: right;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header .close {
        padding: 0;
        margin: 0;
    }

    .btn-save-modal,
    .btn-close-modal {
        border-radius: 10px;
        font-size: 16px !important;
        letter-spacing: 1px;
        padding: 5px 10px !important;
    }

    .btn-save-modal {
        background-color: #3d8bfd;
        color: white;
    }

    .btn-close-modal {
        background-color: #ff4d4f;
        color: white;
        padding: 5px 20px !important;
    }

    .btn-close-modal:hover,
    .btn-save-modal:hover {
        color: white
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
                <h1> تفاصيل استخدام عروض : {{ $shop->name }}</h1>
                <div class="mb-3">
                    {{-- <a href="{{ route('shop.export.pdf', ['shop' => $shop->id]) }}" class="btn create-btn">تحميل بصيغة PDF</a> --}}
                    <a href="{{ route('shop.export.excel', ['shop' => $shop->id]) }}" class="btn create-btn"> تحميل بصيغة Excel</a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <!-- <th> Phone number</th>
                        <th> Code Name</th>
                        <th> Name</th>
                        <th> Amount</th>
                        <th> Max usage times</th>
                        <th> Used times</th>
                        <th> Time</th>
                        <th> Time Difference</th> -->
                        <th>رقم الهاتف</th>
                        <th>اسم كود الخصم</th>
                        <th> الاسم</th>
                        <th> القيمة</th>
                        <th> أقصي حد للاستخدام</th>
                        <th> عدد مرات الاستخدام</th>
                        <th> تم انشاؤه في </th>
                        <th>اخر مره تم استخدامه في </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($offersUsagesDetails as $offerDetails)
                    <tr>
                        <td class="offer-code_id">{{ $offerDetails->phone_number }}</td>
                        <td class="offer-code_id">{{ $offerDetails->offer->code->name }}</td>
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
