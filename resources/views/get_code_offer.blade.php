@extends('layouts.app')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap');

    * {
        font-family: "Cairo", sans-serif;
    }

    .form-control:hover {
        border-width: 2px;
    }

    .send-button:hover :first-child::before {
        animation: send-button 2s both infinite;
    }

    @keyframes send-button {
        to {
            transform: translateX(-15px);
        }
    }

    .message-card {
        z-index: -1;
        transform: translateY(-130px);
        animation: message-card 1s forwards;
    }

    .message-card-delay-succes {
        transform: translateY(-290px);
        animation-delay: 2s;
        animation-duration: 2s;
    }

    @keyframes message-card {
        to {
            transform: translateY(0px);
        }
    }

    .modal-dialog {
        opacity: 0;
        animation: modal-dialog 0.5s forwards;
    }

    @keyframes modal-dialog {
        to {
            opacity: 1;
        }
    }

    @keyframes result {
        0% { transform: scale(0); opacity: 0; }
        60% { transform: scale(1.2); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }

    .result {
        animation: result 1s ease-in-out;
    }

    .delay-succes {
        animation-delay: 2s;
        animation-fill-mode: backwards;
    }

    @keyframes discount {
        0% { transform: translate(-50%, -50%) scale(0); opacity: 0; }
        60% { transform: translate(-50%, -50%) scale(1.2); opacity: 1; }
        100% { transform: translate(-50%, -50%) scale(1); opacity: 1;}
    }

    .discount {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        z-index: 100;
    }

    .discount-animation {
        animation: discount 2s ease-in-out;
    }

    .modal-content, .alert {
        border-radius: 28px !important;
    }

    .success_tic .page-body{
        max-width:300px;
        background-color:#FFFFFF;
        margin:10% auto;
    }
    .success_tic .page-body .head{
        text-align:center;
    }
    .success_tic .close{
        opacity: 1;
        position: absolute;
        right: 10px;
        top: 10px;
        font-size: 30px;
        padding: 3px 15px;
        margin-bottom: 10px;
    }

    .GifHidden {
        display: none;
    }
</style>

@section('content')
<div class="container">
    <div
        class="d-flex flex-column gap-6 justify-content-center align-items-center mt-5"
        style="height: 94vh"
    >
        <div class="mb-5 discount" id="discount">
            <img src="gift-discount.gif" alt="Logo" style="max-width: 300px" />
        </div>
        <div class="mb-5 text-center">
            <img src="logo.jpeg" alt="Logo" style="max-width: 200px" />
        </div>
        <div class="col-md-8">
            <div class="card" style="border-radius: 25px">
                <div class="card-body text-center">
                    <form id="offerForm">
                        @csrf
                        <div class="d-flex justify-content-center">
                            <div class="w-50">
                                <!-- <div class="mb-3 text-center">
                                    <img src="logo.jpeg" alt="Logo" style="max-width: 200px;">
                                </div> -->

                                <div class="mb-3">
                                    <h4 class="mb-5">إحصل علي العرض</h4>
                                    <label for="code" class="form-label"
                                        >أدخل كود العرض</label
                                    >
                                    <input
                                        id="code"
                                        type="text"
                                        class="form-control text-center"
                                        style="border-radius: 28px"
                                        name="code"
                                        required
                                    />
                                </div>

                                <div class="mb-3 text-center">
                                    <button
                                        type="submit"
                                        class="btn font-size-large send-button"
                                        style="
                                            border-radius: 25px;
                                            background-color: #ff75a0;
                                        "
                                    >
                                        <i class="bi bi-arrow-left"></i> إرسال
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div
                class="card mt-4 message-card"
                id="offerResponse"
                style="display: none; border-radius: 8px"
            >
                <div class="card-body text-center" style="border-radius: 25px">
                    <div id="responseMessage"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div
    class="modal result"
    id="responseModal"
    role="dialog"
    aria-labelledby="responseModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered success_tic" role="document">
        <!-- <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="responseModalLabel" style="font-family: Arial, sans-serif; text-align: center;">الرد</h5> --}}
                <button type="button d-inline" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="responseBody">
                <div id="modalMessage"></div>
            </div>
        </div> -->
        <div class="modal-content">
            <a class="close" href="#" data-dismiss="modal">&times;</a>
            <div class="page-body">
                <div class="text-center" id="responseBody">
                    <div id="modalMessage"></div>
                </div>

                <div style="text-align: center">
                    <img
                        id="discountModalGif"
                        src="discountModal.gif"
                        alt="succes"
                        style="max-width: 140px"
                    />
                    <img
                        id="failedModalGif"
                        src="failedModal.gif"
                        alt="failed"
                        style="max-width: 140px"
                    />
                    <div></div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- <div class="container-fluid" style="background-color: #F8F6E3; height: 100vh;">
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
    </div> -->
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
                        $('#offerResponse').addClass("message-card-delay-succes");
                        $('#responseMessage').html(
                            '<div class="alert" role="alert" style="background-color: #95E1D3;><p class="h3"> مبروك ربحت </p>' +
                            '<p class="h4 text-bold">' + response.success.name + '</p>' +
                            '<p class="h1 text-bold">' + response.success.amount + '</p>' +
                            '</div>');
                        $('#responseModalLabel').text('نجاح');
                        $('#modalMessage').html(
                            '<div class="alert" role="alert" style="margin-bottom: 0;"><p class="h3 mb-3">مبروك ربحت </p>' +
                            '<p class="h4 text-bold" style="margin-bottom: 0;">' + response.success.name + '</p>' + '</div>');
                        $('#responseModal').modal('show');
                        $('#responseModal').addClass('delay-succes');
                        $('#failedModalGif').addClass('gifHidden');
                        $('#discountModalGif').removeClass('gifHidden');
                        $('#discount').addClass('discount-animation');
                        setTimeout(function() {
                            $('#discount').removeClass('discount-animation');
                            $('#responseModal').removeClass('delay-succes');
                        }, 4000);
                    },
                    error: function(xhr, status, error) {
                        $('#offerResponse').show();
                        $('#responseMessage').html(
                            '<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 18px; margin-right: 4px;"></i>' + xhr
                            .responseJSON.error + '</div>');
                        $('#responseModalLabel').text('خطأ');
                        $('#modalMessage').html(
                            '<div class="alert" role="alert">' +
                            '<p class="h3">حدث خطأ. ' + xhr.responseJSON.error + '</p>' + '</div>');
                        $('#responseModal').modal('show');
                        $('#discountModalGif').addClass('gifHidden');
                        $('#failedModalGif').removeClass('gifHidden');
                    }
                });
            });
        });
    </script>
@endsection

<!-- <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 18px; margin-right: 4px;"></i> -->
