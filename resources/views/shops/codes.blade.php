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
    .actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin: 0;
        padding: 0;
    }
</style>

@endsection


@section('content')
<div class="container mt-5">
    <div class="row justify-content-center mt-5">
        <div class="col-md-11">
            <div class="page-header">
                <h1> أكواد خصم : {{ $shop->name }}</h1>
                <button type="button" class="create-btn" data-toggle="modal" data-target="#staticBackdrop">
                    اضافة كود خصم جديد
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
                        @if (!$notAssoCodes->count())
                        <div class="modal-body">
                            <p>لا توجد أكواد خصم متاحه.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-close-modal" data-dismiss="modal">اغلاق</button>
                        </div>
                        @else
                        <div class="modal-body">
                            <form action="{{ route('shops.codes.store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                </div>
                                <div class="form-group">
                                    <select name="code_id" id="" class="form-control" required>
                                        @foreach ($notAssoCodes as $code)
                                        <option value="{{ $code->id }}">{{ $code->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="number" name="unit_cost" class="form-control" placeholder="سعر كل كود خصم" required>
                                </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-save-modal">ادخال البيانات</button>
                            <button type="button" class="btn btn-close-modal" data-dismiss="modal">اغلاق</button>
                            </form>
                        </div>
                        @endif
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
                                <input type="hidden" name="is_shop_page" value="1">
                                <div class="form-group">
                                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="اسم كود الخصم" required>
                                </div>
                                <div class="form-group">
                                    <input type="number" name="unit_cost" class="form-control" placeholder="سعر كل كود خصم" required>
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
                        <th>الاسم</th>
                        <th> عدد مرات الاستخدام</th>
                        <th> السعر </th>
                        <th>الحذف</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($shop->codes as $code)
                    <tr data-code-id="{{ $code->id }}" data-shop-id="{{ $shop->id }}">
                        <td class=" code-name">{{ $code->name }}</td>
                        <td class=" code-used-times">{{ $code->used_times }}</td>
                        <td class=" code-unit-cost">{{ $code->unit_cost }}</td>
                        <td class="actions">
                            <form action="{{ route('shops.codes.destroy', ['shop' => $shop->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                <input type="hidden" name="code_id" value="{{ $code->id }}">
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
            var CodeName = $(this).closest("tr").find(".code-name").text();
            $('#editModal input[name="name"]').val(CodeName);

            var UnitCost = $(this).closest("tr").find(".code-unit-cost").text();
            $('#editModal input[name="unit_cost"]').val(UnitCost);

            var ShopId = $(this).closest('tr').data('shop-id');
            $('#editModal select[name="shop_id"]').val(ShopId);

            var CodeId = $(this).closest('tr').data('code-id');
            $('#editForm').attr('action', '/codes/' + CodeId);
            $('#editModal').modal('show');
        });

        $('#saveChangesBtn').on('click', function() {
            $('#editForm').submit();
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const codeSelect = document.querySelector('select[name="code_id"]');
        const unitCostInput = document.querySelector('input[name="unit_cost"]');

        codeSelect.addEventListener('change', function() {
            const codeId = this.value;
            fetch(`/codes/${codeId}/unit-cost`)
                .then(response => response.json())
                .then(data => {
                    if (data.success === 1 && data.hasOwnProperty('data')) {
                        unitCostInput.value = data.data;
                    } else {
                        console.error('Invalid response format:', data);
                    }
                })
                .catch(error => {
                    console.error('Error fetching unit cost:', error);
                });
        });
        codeSelect.dispatchEvent(new Event('change'));
    });
</script>



@endsection
