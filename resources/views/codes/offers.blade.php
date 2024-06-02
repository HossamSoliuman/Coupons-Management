@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-11">
                <h1>{{ $code->name }} Offers</h1>
                <button type="button" class="border rounded mb-3 btn btn-sm btn-dark" data-toggle="modal"
                    data-target="#staticBackdrop">
                    Add an Offer
                </button>

                <!-- Creating Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Add an Offer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('offers.store') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="code_id" value="{{ $code->id }}">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="shop_id" id="">
                                            @foreach ($shops as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Offer name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="amount" class="form-control" placeholder="Offer amount"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" name="max_usage_times" class="form-control"
                                            placeholder="Offer max usage times" required>
                                    </div>
                                    <input type="hidden" name="page" value="code">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-light">Add</button>
                                <button type="button" class="btn btn-sm rounded btn-dark"
                                    data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Offer Modal -->
                <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Offer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" method="post">
                                    @csrf
                                    @method('PUT')@csrf
                                    <div class="form-group">
                                        <input type="hidden" name="code_id" value="{{ $code->id }}">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Offer name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="amount" class="form-control" placeholder="Offer amount"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="max_usage_times" class="form-control"
                                            placeholder="Offer max usage times" required>
                                    </div>
                                    <input type="hidden" name="page" value="code">
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
                            <th> Shop Name</th>
                            <th> Name</th>
                            <th> Amount</th>
                            <th> Max usage times</th>
                            <th> Used_times</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($code->offers as $offer)
                            <tr data-offer-id="{{ $offer->id }}" data-code-id="{{ $offer->code->id }}"
                                data-shop-id="{{ $offer->shop->id }}">
                                <td class=" offer-shop_id">{{ $offer->shop->name }}</td>
                                <td class=" offer-name">{{ $offer->name }}</td>
                                <td class=" offer-amount">{{ $offer->amount }}</td>
                                <td class=" offer-max_usage_times">{{ $offer->max_usage_times }}</td>
                                <td class=" offer-used_times">{{ $offer->used_times }}</td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-sm btn-light btn-edit" data-toggle="modal"
                                        data-target="#editModal">
                                        Edit
                                    </button>
                                    <form action="{{ route('offers.destroy', ['offer' => $offer->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="page" value="code">
                                        <button type="submit" class="ml-1 rounded btn-sm btn btn-dark">Delete</button>
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
@endsection
