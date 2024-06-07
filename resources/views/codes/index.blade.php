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

</style>

@endsection


@section('content')
<div class="container mt-5">
    <div class="row justify-content-center mt-5">

        <div class="col-md-11">
            <div class="page-header">
                <h1>أكواد الخصم</h1>

                <button type="button" class="create-btn" data-toggle="modal" data-target="#staticBackdrop">
                إنشاء كود خصم جديد
                </button>
            </div>

            <!-- Creating Modal -->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">كود خصم جديد</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('codes.store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="اسم كود الخصم" required>
                                </div>
                                <div class="form-group">
                                    <input type="number" name="unit_cost" class="form-control" placeholder="سعر كود الخصم" required>
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
            <!-- Edit Code Modal -->
            <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">تعديل كود الخصم</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="post">
                                @csrf
                                @method('PUT')@csrf
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="اسم كود الخصم" required>
                                </div>
                                <div class="form-group">
                                    <input type="number" name="unit_cost" class="form-control" placeholder="سعر كود الخصم" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-save-modal" id="saveChangesBtn">حفظ التغييرات</button>
                            <button type="button" class="btn  btn-close-modal " data-dismiss="modal">اغلاق</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($codes as $code)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-around">
                                <h5 class="card-title">{{ $code->name }}</h5>
                            </div>
                            <div class="row first-row-links">
                                <a href="{{ route('codes.offers.usage', ['code' => $code->id]) }}" class="">
                                الاستخدام
                                </a>
                                <a href="{{ route('codes.show', ['code' => $code->id]) }}" class="">
                                    العروض
                                </a>
                                <a href="{{ route('codes.shops', ['code' => $code->id]) }}" class="">
                                    المتاجر
                                </a>
                            </div>
                            <div class="row second-row-links">
                                <button type="button" class="edit-btn" data-toggle="modal" data-target="#editModal" data-code-id="{{ $code->id }}" data-unit-cost="{{ $code->unit_cost }}">
                                    تعديل
                                </button>
                                <form class="col" action="{{ route('codes.destroy', ['code' => $code->id]) }}" method="post">
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
            var codeId = $(this).data('code-id');
            var codeName = $(this).closest(".card").find(".card-title").text();
            var shopId = $(this).data('shop-id');
            var unitCost = $(this).data('unit-cost');

            $('#editModal input[name="name"]').val(codeName);
            $('#editModal select[name="shop_id"]').val(shopId);
            $('#editModal input[name="unit_cost"]').val(unitCost);
            $('#editForm').attr('action', '/codes/' + codeId);
            $('#editModal').modal('show');
        });

        $('#saveChangesBtn').on('click', function() {
            $('#editForm').submit();
        });
    });
</script>
@endsection
