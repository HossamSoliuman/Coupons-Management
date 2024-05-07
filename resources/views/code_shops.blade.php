@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-11">
                <h1>{{ $code->name }} Shops</h1>
                <button type="button" class=" mb-3 btn btn-sm rounded btn-dark" data-toggle="modal"
                    data-target="#staticBackdrop">
                    Add a new shop
                </button>

                <!-- Creating Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">New Shop</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('codes.shops.store', ['code' => $code->id]) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="is_shop_page" value="1">
                                    <div class="form-group">
                                        <input type="hidden" name="code_id" value="{{ $code->id }}">
                                    </div>
                                    @if (!$shops)
                                        <p>There are no more shops</p>
                                    @else
                                        <div class="form-group">
                                            <select name="shop_id" id="" class="form-control"
                                                placeholder="Select Shop">
                                                @foreach ($shops as $shop)
                                                    <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-light">Submit</button>
                                <button type="button" class="btn btn-sm rounded btn-dark"
                                    data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th> Name</th>
                            <th> Address</th>
                            <th> Number </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($code->shops as $shop)
                            <tr data-code-id="{{ $code->id }}" data-shop-id="{{ $shop->id }}">
                                <td class=" code-name">{{ $shop->name }}</td>
                                <td class=" code-used-times">{{ $shop->address }}</td>
                                <td class=" code-unit-cost">{{ $shop->number }}</td>
                                <td class="d-flex">
                                    <form action="{{ route('codes.shops.destroy', ['code' => $code->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                        <button type="submit" class="ml-2 rounded btn btn-sm btn-dark">Remove</button>
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
@endsection
