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
        font-size: 15px;
    }

    .first-row-links a:hover {
        background-color: #E0E0E0;
        box-shadow: #bebebe 1px 3px 9px;
    }

    .second-row-links {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 5px;
        margin-top: 20px;
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

    .btn-close-modal:hover, .btn-save-modal:hover {
        color: white
    }
    .form-group {
        text-align: justify;
    }
    .actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin: 0;
        padding: 0;
    }
    td, th {
        text-align: center !important;
    }
</style>

@endsection





@section('content')
<div class="container mt-5">
    <div class="row justify-content-center mt-5">
        <div class="col-md-11">
            <div class="page-header">
                <h1>العروض</h1>
                <button type="button" class="btn create-btn" data-toggle="modal" data-target="#staticBackdrop">
                    إنشاء عرض جديد
                </button>

            </div>

            <!-- Creating Modal -->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">عرض جديد</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('offers.store') }}" method="post">
                                @csrf
                                {{-- <div class="form-group">
                                        <select class="form-control" name="shop_id" id="">
                                            @foreach ($shops as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->name }} </option>
                                @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="code_id" id="">
                                @foreach ($codes as $code)
                                <option value="{{ $code->id }}">{{ $code->name }} </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="shop">اختار متجر: </label>
                                <select class="form-control" name="shop_id" id="shop">
                                    @foreach ($shops as $shop)
                                    <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="code">اختار كود خصم : </label>
                                <select class="form-control" name="code_id" id="code">
                                    <!-- Codes will be populated dynamically via JavaScript -->
                                </select>
                                <div class="spinner-border text-primary" role="status" id="code-loading" style="display: none;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>



                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="اسم العرض" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="amount" class="form-control" placeholder="قيمة العرض" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="max_usage_times" class="form-control" placeholder="أقصي عدد مرات لاستخدام هذا العرض" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-save-modal">ادخال البيانات</button>
                        <button type="button" class="btn btn-close-modal" data-dismiss="modal">اغلاق</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Offer Modal -->
        <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">تعديل العرض</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="post">
                            @csrf
                            @method('PUT')@csrf
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="اسم العرض" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="amount" class="form-control" placeholder="قيمة هذا العرض" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="max_usage_times" class="form-control" placeholder="أقصي عدد مرات لاستخدام هذا العرض"  required>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-save-modal" id="saveChangesBtn">حفظ التغييرات</button>
                        <button type="button" class="btn btn-close-modal" data-dismiss="modal">اغلاق</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <!-- <th> Code Name</th>
                    <th> Shop Name</th>
                    <th> Name</th>
                    <th> Amount</th>
                    <th> Max usage times</th>
                    <th> Used times</th>
                    <th>Actions</th> -->
                    <th> اسم كود الخصم</th>
                    <th> اسم المتجر</th>
                    <th> الاسم</th>
                    <th> القيمة</th>
                    <th>أقصي حد للاستخدام</th>
                    <th>عدد مرات الاستخدام</th>
                    <th>التعديل والحذف</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offers as $offer)
                <tr data-offer-id="{{ $offer->id }}" data-code-id="{{ $offer->code->id }}" data-shop-id="{{ $offer->shop->id }}">
                    <td class=" offer-code_id">{{ $offer->code->name }}</td>
                    <td class=" offer-shop_id">{{ $offer->shop->name }}</td>
                    <td class=" offer-name">{{ $offer->name }}</td>
                    <td class=" offer-amount">{{ $offer->amount }}</td>
                    <td class=" offer-max_usage_times">{{ $offer->max_usage_times }}</td>
                    <td class=" offer-used_times">{{ $offer->used_times }}</td>
                    <td class="actions">
                        <button type="button" class=" edit-btn" data-toggle="modal" data-target="#editModal">
                                    تعديل
                    </button>
                        <form action="{{ route('offers.destroy', ['offer' => $offer->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
        $('.btn-edit').on('click', function() {

            var ShopId = $(this).closest('tr').data('shop-id');
            $('#editModal select[name="shop_id"]').val(ShopId);

            var CodeId = $(this).closest('tr').data('code-id');
            $('#editModal select[name="code_id"]').val(CodeId);

            var OfferName = $(this).closest("tr").find(".offer-name").text();
            $('#editModal input[name="name"]').val(OfferName);
            var OfferAmount = $(this).closest("tr").find(".offer-amount").text();
            $('#editModal input[name="amount"]').val(OfferAmount);
            var OfferMax_usage_times = $(this).closest("tr").find(".offer-max_usage_times").text();
            $('#editModal input[name="max_usage_times"]').val(OfferMax_usage_times);
            var OfferUsed_times = $(this).closest("tr").find(".offer-used_times").text();
            $('#editModal input[name="used_times"]').val(OfferUsed_times);
            var OfferId = $(this).closest('tr').data('offer-id');
            $('#editForm').attr('action', '/offers/' + OfferId);
            $('#editModal').modal('show');
        });
        $('#saveChangesBtn').on('click', function() {
            $('#editForm').submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        fetchCodes();

        $('#shop').on('change', function() {
            fetchCodes();
        });

        function fetchCodes() {
            var shopId = $('#shop').val();
            $('#code').prop('disabled', true);
            $('#code-loading').show();
            $.ajax({
                url: "{{ route('shops.codes', ['shop' => ':shopId']) }}".replace(':shopId', shopId),
                type: 'GET',
                success: function(response) {
                    $('#code').empty();
                    $.each(response, function(index, code) {
                        $('#code').append('<option value="' + code.id + '">' + code.name +
                            '</option>');
                    });
                    $('#code').prop('disabled', false);
                    $('#code-loading').hide();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#code').prop('disabled', false);
                    $('#code-loading').hide();
                }
            });
        }
    });
</script>
@endsection
