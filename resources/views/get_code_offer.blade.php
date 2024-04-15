@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="background-color: #F8F6E3; height: 100vh;">
        <div class="row justify-content-center align-items-center" style="height: 100%;">
            <div class="col-md-6">
                <div class="card shadow rounded-lg">
                    <div class="card-header" style="background-color: #6AD4DD; color: #F8F6E3; text-align: center;">
                        <h4 style="font-family: Arial, sans-serif;">احصل على العرض</h4>
                    </div>
                    <div class="card-body">
                        <form id="offerForm">
                            <div class="form-group text-center">
                                <label class="text-center" for="code"
                                    style="color: #7AA2E3; font-family: Arial, sans-serif;">ادخل كود العرض</label>
                                <input type="text" class="form-control text-center rounded-pill" id="code"
                                    name="code" required>
                            </div>
                            <button type="submit" class="btn btn-block rounded-pill"
                                style="background-color: #97E7E1; font-family: Arial, sans-serif; font-size: 18px; font-weight: bold;">
                                <i class="bi bi-arrow-left"></i> ارسال</button>
                        </form>
                    </div>
                </div>
                <div class="card mt-4" id="offerResponse" style="display: none;">
                    <div class="card-body text-center">
                        <div id="responseMessage"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="responseModalLabel" style="font-family: Arial, sans-serif; text-align: center;">الرد</h5> --}}
                    <button type="button d-inline" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center" id="responseBody">
                    <div id="modalMessage"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#offerForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'GET',
                    url: '/api/offer',
                    data: formData,
                    success: function(response) {
                        $('#offerResponse').show();
                        $('#responseMessage').html(
                            '<div class="alert alert-success" role="alert"><p class="h3"> مبروك ربحت </p>' +
                            '<p>' + response.success.name + '</p>' +
                            '<p class="h1 text-bold">' + response.success.amount + '</p>' +
                            '</div>');
                        $('#responseModalLabel').text('نجاح');
                        $('#modalMessage').html(
                            '<div class="alert alert-success" role="alert"><p>مبروك ربحت </p>' +
                            response.success.amount + '</div>');
                        $('#responseModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        $('#offerResponse').show();
                        $('#responseMessage').html(
                            '<div class="alert alert-danger" role="alert">' + xhr
                            .responseJSON.error + '</div>');
                        $('#responseModalLabel').text('خطأ');
                        $('#modalMessage').html(
                            '<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 24px;"></i> حدث خطأ. ' +
                            xhr.responseJSON.error + '</div>');
                        $('#responseModal').modal('show');
                    }
                });
            });
        });
    </script>
@endsection
