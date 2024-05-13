@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-11">
                <h1>{{ $shop->name }} Codes</h1>
                <button type="button" class=" mb-3 btn btn-sm rounded btn-dark" data-toggle="modal"
                    data-target="#staticBackdrop">
                    Add a new Code
                </button>

                <!-- Creating Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">New Code</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @if (!$codes->count())
                                <div class="modal-body">
                                    <p>There are no codes available</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm rounded btn-dark"
                                        data-dismiss="modal">Close</button>
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
                                                @foreach ($codes as $code)
                                                    <option value="{{ $code->id }}">{{ $code->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="unit_cost" class="form-control"
                                                placeholder="Price for each one" required>
                                        </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-light">Add</button>
                                    <button type="button" class="btn btn-sm rounded btn-dark"
                                        data-dismiss="modal">Close</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Edit Code Modal -->
                <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Code</h5>
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
                                        <input type="text" name="name" class="form-control" placeholder="Code name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" name="unit_cost" class="form-control"
                                            placeholder="Price for each one" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-light" id="saveChangesBtn">Save
                                    Changes</button>
                                <button type="button" class="btn btn-sm rounded btn-dark"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th> Name</th>
                            <th> Used Times</th>
                            <th> price </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shop->codes as $code)
                            <tr data-code-id="{{ $code->id }}" data-shop-id="{{ $shop->id }}">
                                <td class=" code-name">{{ $code->name }}</td>
                                <td class=" code-used-times">{{ $code->used_times }}</td>
                                <td class=" code-unit-cost">{{ $code->pivot->unit_cost }}</td>
                                <td class="d-flex">
                                    <form action="{{ route('shops.codes.destroy', ['shop' => $shop->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                        <input type="hidden" name="code_id" value="{{ $code->id }}">
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
