@extends('layouts.admin')

@section('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .create-btn {
        border-radius: 24px;
        background: linear-gradient(55deg, #14A14D 42.18%, #E8BF0D 114.09%);
        border: none;
        padding: 7px 15px;
        color: white;
        font-size: 18px;
        font-weight: bold;
        transition: .2s;
        letter-spacing: 1px;
    }

    .create-btn:hover {
        background: linear-gradient(55deg, #43B370 42.18%, #f0c30f 114.09%);
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
        margin-left: 20px;
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

    .btn-save-modal, .btn-close-modal {
        border-radius: 10px;
        font-size: 16px !important;
        letter-spacing: 1px;
        padding: 5px 10px !important;
    }

    .btn-close-modal {
        background-color: #ff4d4f;
        color: white;
        padding: 5px 20px !important;
    }
    .btn-close-modal:hover {
        color: white
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center mt-5">
        <div class="col-md-11">
            <div class="page-header">
                <h1>المتاجر</h1>
                <button type="button" class="create-btn" data-toggle="modal" data-target="#staticBackdrop">
                    إنشاء متجر جديد
                </button>
            </div>

            <!-- Creating Modal -->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">New Shop</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('shops.store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Shop name" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="address" class="form-control" placeholder="Shop address" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="number" class="form-control" placeholder="Shop number" required>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-light">Submit</button>
                            <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Shop Modal -->
            <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">تعديل بيانات المتجر</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="post">
                                @csrf
                                @method('PUT')@csrf
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Shop name" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="address" class="form-control" placeholder="Shop address" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="number" class="form-control" placeholder="Shop number" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-save-modal " id="saveChangesBtn">حقظ التغييرات</button>
                            <button type="button" class="btn  btn-close-modal " data-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($shops as $shop)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $shop->name }}</h5>
                            <p class="card-text"> العنوان : {{ $shop->address }}</p>
                            <p class="card-text">الرقم : {{ $shop->number }}</p>

                            <div class="row first-row-links">
                                <a href="{{ route('shops.show', ['shop' => $shop->id]) }}" class=" ">أكواد الخصم</a>
                                <a href="{{ route('shops.codes.usages', ['shop' => $shop->id]) }}" class=" ">الاستخدام</a>
                                <a href="{{ route('shops.offers', ['shop' => $shop->id]) }}" class=" ">العروض</a>
                            </div>
                            <div class="row second-row-links">
                                <button type="button" class="edit-btn" data-toggle="modal" data-target="#editModal" data-shop-id="{{ $shop->id }}">تعديل</button>
                                <form action="{{ route('shops.destroy', ['shop' => $shop->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">حذف</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.btn-edit').on('click', function() {
            var shopId = $(this).data('shop-id');
            var shopName = $(this).closest(".card").find(".card-title").text();
            var shopAddress = $(this).closest(".card").find(".card-text:eq(0)").text().split(": ")[1];
            var shopNumber = $(this).closest(".card").find(".card-text:eq(1)").text().split(": ")[1];

            $('#editModal input[name="name"]').val(shopName);
            $('#editModal input[name="address"]').val(shopAddress);
            $('#editModal input[name="number"]').val(shopNumber);
            $('#editForm').attr('action', '/shops/' + shopId);
            $('#editModal').modal('show');
        });

        $('#saveChangesBtn').on('click', function() {
            $('#editForm').submit();
        });
    });
</script>
@endsection
