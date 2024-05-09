@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-11">
                <h1>Users</h1>
                <button type="button" class="mb-3 btn rounded btn-sm btn-dark" data-toggle="modal" data-target="#staticBackdrop">
                    Create a new User
                </button>

                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">New User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('users.store') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="User name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control" placeholder="User email"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="password" class="form-control"
                                            placeholder="User password" required>
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
                                <button type="submit" class="btn btn-sm btn-light">Submit</button>
                                <button type="button" class="btn btn-sm rounded btn-dark" data-dismiss="modal">Close</button>
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
                                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="User name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control" placeholder="User email"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="password" class="form-control"
                                            placeholder="Update password" required>
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
                                <button type="button" class="btn btn-sm btn-light" id="saveChangesBtn">Save Changes</button>
                                <button type="button" class="btn rounded btn-sm btn-dark" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th> Name</th>
                            <th> Email</th>
                            <th> Shop</th>
                            <th>Actions</th>
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
                                <td class="d-flex">
                                    <button type="button" class="btn btn-light btn-sm btn-edit" data-toggle="modal"
                                        data-target="#editModal">
                                        Edit
                                    </button>
                                    <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-2 rounded btn btn-sm btn-dark">Delete</button>
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
