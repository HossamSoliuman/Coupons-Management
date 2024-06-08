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
    th {
        font-weight: 500 !important;
    }
    td, th{
        text-align: center !important;
    }
</style>

@endsection


@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-11">
                <div class="page-header">
                <h1>المستخدمين</h1>
                <button type="button" class="btn create-btn" data-toggle="modal" data-target="#staticBackdrop">
                    اضافه مستخدم جديد
                </button>
                </div>

                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">مستخدم جديد</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('users.store') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="اسم المستخدم"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control" placeholder="البريد الالكتروني الخاص بالمستخدم"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="كلمة السر الخاصه بالمستخدم" required>
                                    </div>
                                    <div class="form-group">
                                        <select name="shop_id" class="form-control" id="">
                                            @foreach ($shops as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach
                                        </select>
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

                <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">تعديل بيانات المستخدم</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="اسم المستخدم "
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control" placeholder="البريد الاليكتروني الخاص بالمستخدم"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="تحديث كلمة السر" required>
                                    </div>
                                    <div class="form-group">
                                            <div class="form-group">
                                                <select name="shop_id" class="form-control" id="">
                                                    @foreach ($shops as $shop)
                                                        <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
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
                            <!-- <th> Name</th>
                            <th> Email</th>
                            <th> Shop</th>
                            <th>Actions</th> -->
                            <th> الاسم</th>
                            <th> البريد الاليكتروني</th>
                            <th> المتجر</th>
                            <th>التعديل والحذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr data-user-id="{{ $user->id }}">
                                <td class=" user-name">{{ $user->name }}</td>
                                <td class=" user-email">{{ $user->email }}</td>
                                @if ($user->role == 'admin')
                                    <td class=" user-role">{{ $user->role }}</td>
                                @else
                                <td class="user-shop_id" data-shop-id="{{ $user->shop_id }}">{{ $user->shop->name }}</td>
                                @endif
                                <td class="actions">
                                    <button type="button" class="edit-btn" data-toggle="modal"
                                        data-target="#editModal">
                                        تعديل
                                    </button>
                                    <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post">
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
                var UserName = $(this).closest("tr").find(".user-name").text();
                $('#editModal input[name="name"]').val(UserName);
                var UserEmail = $(this).closest("tr").find(".user-email").text();
                $('#editModal input[name="email"]').val(UserEmail);
                var UserPassword = $(this).closest("tr").find(".user-password").text();
                $('#editModal input[name="password"]').val(UserPassword); // You don't seem to have a field with class user-password
                var UserShop_id = $(this).closest("tr").find(".user-shop_id").data('shop-id');
                $('#editModal select[name="shop_id"]').val(UserShop_id); // Update this line
                var UserId = $(this).closest('tr').data('user-id');
                $('#editForm').attr('action', '/users/' + UserId);
                $('#editModal').modal('show');

                var userRole = $(this).closest("tr").find(".user-role").text();
                if (userRole === 'admin') {
                    $('#editModal select[name="shop_id"]').closest('.form-group').hide();
                } else {
                    $('#editModal select[name="shop_id"]').closest('.form-group').show();
                }
            });

            $('#saveChangesBtn').on('click', function() {
                $('#editForm').submit();
            });
        });
    </script>


@endsection
