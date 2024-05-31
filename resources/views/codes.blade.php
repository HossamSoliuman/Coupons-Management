@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">

            <div class="col-md-11">
                <h1>Codes</h1>

                <button type="button" class=" mb-3 btn btn-sm rounded btn-dark" data-toggle="modal"
                    data-target="#staticBackdrop">
                    Create a new Code
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
                            <div class="modal-body">
                                <form action="{{ route('codes.store') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Code name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" name="unit_cost" class="form-control"
                                            placeholder="Price for each one" required>
                                    </div>
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
                <div class="row">
                    @foreach ($codes as $code)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">

                                    <div class="d-flex justify-content-around">
                                        <h5 class="card-title">{{ $code->name }}</h5>
                                    </div>
                                    <div class="row">
                                        <a href="{{ route('codes.offers.usage', ['code' => $code->id]) }}"
                                            class="btn btn-light btn-sm">
                                            Usage
                                        </a>
                                        <a href="{{ route('codes.show', ['code' => $code->id]) }}"
                                            class="btn btn-light btn-sm">
                                            Offers
                                        </a>
                                        <a href="{{ route('codes.shops', ['code' => $code->id]) }}"
                                            class="btn btn-light btn-sm">
                                            Shops
                                        </a>
                                    </div>
                                    <div class="row mt-2 w-100">
                                        <button type="button" class="btn btn-light btn-sm btn-edit col-4"
                                            data-toggle="modal" data-target="#editModal"
                                            data-code-id="{{ $code->id }}" data-unit-cost="{{ $code->unit_cost }}">
                                            Edit
                                        </button>
                                        <form class="col" action="{{ route('codes.destroy', ['code' => $code->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-100 btn btn-dark btn-sm">Delete</button>
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
