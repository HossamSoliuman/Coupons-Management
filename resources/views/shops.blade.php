@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-11">
                <h1>Shops</h1>
                <button type="button" class=" mb-3 btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                    Create a new Shop
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
                                <form action="{{ route('shops.store') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Shop name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="address" class="form-control" placeholder="Shop address"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="number" class="form-control" placeholder="Shop number"
                                            required>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Shop Modal -->
                <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Shop</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" method="post">
                                    @csrf
                                    @method('PUT')@csrf
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Shop name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="address" class="form-control" placeholder="Shop address"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="number" class="form-control" placeholder="Shop number"
                                            required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
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
                                    <p class="card-text">Address: {{ $shop->address }}</p>
                                    <p class="card-text">Number: {{ $shop->number }}</p>

                                    <div class="row">
                                        <div class="">
                                            <a href="{{ route('shops.show', ['shop' => $shop->id]) }}"
                                                class="btn btn-light btn-sm">
                                                Codes
                                            </a>
                                        </div>
                                        <button type="button" class="btn btn-light btn-sm btn-edit mr-2"
                                            data-toggle="modal" data-target="#editModal"
                                            data-shop-id="{{ $shop->id }}"><i class="bi bi-pencil-square"></i>
                                            Edit
                                        </button>
                                        <form action="{{ route('shops.destroy', ['shop' => $shop->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-dark">Delete</button>
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
