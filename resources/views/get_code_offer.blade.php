@extends('layouts.app')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap');

    * {
        font-family: "Cairo", sans-serif;
    }

    .form-control:hover {
        border-width: 2px;
    }

    .form-control:focus {
        border-color: #EAFFD0 !important;
        box-shadow: 0 0 0 .2rem #EAFFD0 !important;
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
        0% {
            transform: scale(0);
            opacity: 0;
        }

        60% {
            transform: scale(1.2);
            opacity: 1;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .result {
        animation: result 1s ease-in-out;
    }

    .delay-succes {
        animation-delay: 2s;
        animation-fill-mode: backwards;
    }

    @keyframes discount {
        0% {
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
        }

        60% {
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 1;
        }

        100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
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

    .modal-content,
    .alert {
        border-radius: 28px !important;
    }

    .success_tic .page-body {
        max-width: 300px;
        background-color: #FFFFFF;
        margin: 10% auto;
    }

    .success_tic .page-body .head {
        text-align: center;
    }

    .success_tic .close {
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

    .inputCard {
        box-shadow: 0 2px 12px 5px #EAFFD0 !important;
        height: 450px;
    }

    .card-body {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #offerForm {
        width: 100%;
    }

    .confettiShow {
        display: flex !important;
    }

    .confetti {
        justify-content: center;
        align-items: center;
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
        /* z-index: 2000; */
        display: none;
    }

    .confetti-piece {
        position: absolute;
        width: 10px;
        height: 30px;
        background: #ffd300;
        top: 0;
        opacity: 0;
    }

    .confetti-piece:nth-child(1) {
        left: 7%;
        -webkit-transform: rotate(-40deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 182ms;
        -webkit-animation-duration: 1116ms;
    }

    .confetti-piece:nth-child(2) {
        left: 14%;
        -webkit-transform: rotate(4deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 161ms;
        -webkit-animation-duration: 1076ms;
    }

    .confetti-piece:nth-child(3) {
        left: 21%;
        -webkit-transform: rotate(-51deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 481ms;
        -webkit-animation-duration: 1103ms;
    }

    .confetti-piece:nth-child(4) {
        left: 28%;
        -webkit-transform: rotate(61deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 334ms;
        -webkit-animation-duration: 708ms;
    }

    .confetti-piece:nth-child(5) {
        left: 35%;
        -webkit-transform: rotate(-52deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 302ms;
        -webkit-animation-duration: 776ms;
    }

    .confetti-piece:nth-child(6) {
        left: 42%;
        -webkit-transform: rotate(38deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 180ms;
        -webkit-animation-duration: 1168ms;
    }

    .confetti-piece:nth-child(7) {
        left: 49%;
        -webkit-transform: rotate(11deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 395ms;
        -webkit-animation-duration: 1200ms;
    }

    .confetti-piece:nth-child(8) {
        left: 56%;
        -webkit-transform: rotate(49deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 14ms;
        -webkit-animation-duration: 887ms;
    }

    .confetti-piece:nth-child(9) {
        left: 63%;
        -webkit-transform: rotate(-72deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 149ms;
        -webkit-animation-duration: 805ms;
    }

    .confetti-piece:nth-child(10) {
        left: 70%;
        -webkit-transform: rotate(10deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 351ms;
        -webkit-animation-duration: 1059ms;
    }

    .confetti-piece:nth-child(11) {
        left: 77%;
        -webkit-transform: rotate(4deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 307ms;
        -webkit-animation-duration: 1132ms;
    }

    .confetti-piece:nth-child(12) {
        left: 84%;
        -webkit-transform: rotate(42deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 464ms;
        -webkit-animation-duration: 776ms;
    }

    .confetti-piece:nth-child(13) {
        left: 91%;
        -webkit-transform: rotate(-72deg);
        -webkit-animation: makeItRain 1000ms infinite ease-out;
        -webkit-animation-delay: 429ms;
        -webkit-animation-duration: 818ms;
    }

    .confetti-piece:nth-child(odd) {
        background: #7431e8;
    }

    .confetti-piece:nth-child(even) {
        z-index: 1;
    }

    .confetti-piece:nth-child(4n) {
        width: 5px;
        height: 12px;
        -webkit-animation-duration: 2000ms;
    }

    .confetti-piece:nth-child(3n) {
        width: 3px;
        height: 10px;
        -webkit-animation-duration: 2500ms;
        -webkit-animation-delay: 1000ms;
    }

    .confetti-piece:nth-child(4n-7) {
        background: red;
    }

    @-webkit-keyframes makeItRain {
        from {
            opacity: 0;
        }

        50% {
            opacity: 1;
        }

        to {
            -webkit-transform: translateY(350px);
        }
    }
</style>

@section('content')
    <div class="container">
        <div class="d-flex flex-column gap-6 justify-content-center align-items-center mt-5" style="height: 94vh">
            <div id="celebrate" class="confetti">
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
            </div>
            <!-- <div class="mb-5 discount" id="discount">
                    <img src="gift-discount.gif" alt="Logo" style="max-width: 300px" />
                </div> -->
            <div class="mb-5 text-center">
                <img src="logo.jpeg" alt="Logo" style="max-width: 200px;" />
            </div>
            <div class="col-md-8">
                <div class="card inputCard" style="border-radius: 25px">
                    <div class="card-body text-center">
                        {{-- id="offerForm" --}}
                        <form id="offerForm">
                            @csrf
                            <div class="d-flex justify-content-center">
                                <div class="w-50">
                                    <!-- <div class="mb-3 text-center">
                                            <img src="logo.jpeg" alt="Logo" style="max-width: 200px;">
                                        </div> -->

                                    <div class="mb-3">
                                        <h4 class="mb-5">إحصل على العرض الخاص بك</h4>
                                        <label for="code" class="form-label">أدخل كود العرض</label>
                                        <input id="code" type="text" class="form-control text-center"
                                            style="border-radius: 28px;" name="code" required />
                                    </div>
                                    <div class="mb-3">

                                        <label for="phone" class="form-label">أدخل رقم الهاتف</label>
                                        <input id="phone" type="text" class="form-control text-center"
                                            style="border-radius: 28px;" name="phone" required pattern="^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$" oninvalid="this.setCustomValidity('يرجي إدخال رقم هاتف سعودي')">
                                    </div>

                                    <div class="mb-3 text-center" style="margin-top: 54px;">
                                        <button type="submit" class="btn font-size-large send-button"
                                            style="
                                            border-radius: 25px;
                                            background-color: #EAFFD0;
                                        ">
                                            <i class="bi bi-arrow-left"></i> إرسال
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <div
                        class="card mt-4 message-card"
                        id="offerResponse"
                        style="display: none; border-radius: 8px"
                    >
                        <div class="card-body text-center" style="border-radius: 25px">
                            <div id="responseMessage"></div>
                        </div>
                    </div> -->
            </div>
        </div>
    </div>
    <div class="modal result" id="responseModal" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
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
                <a class="close" style="z-index: 3000;" href="#" data-dismiss="modal">&times;</a>
                <div class="page-body">
                    <div class="text-center" id="responseBody">
                        <div id="modalMessage"></div>
                    </div>

                    <div style="text-align: center">
                        <!-- <img
                                id="discountModalGif"
                                src="discountModal.gif"
                                alt="succes"
                                style="max-width: 140px"
                            /> -->
                        <img id="failedModalGif" src="failedModal.gif" alt="failed" style="max-width: 140px" />
                        <div></div>
                    </div>
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
                        $('#code').val("");
                        $('#phone').val("");
                        $('#offerResponse').show();
                        $('#offerResponse').addClass("message-card-delay-succes");
                        // $('#responseMessage').html(
                        //     '<div class="alert" role="alert" style="background-color: #95E1D3;><p class="h3"> مبروك ربحت </p>' +
                        //     '<p class="h4 text-bold">' + response.success.name + '</p>' +
                        //     '<p class="h1 text-bold">' + response.success.amount + '</p>' +
                        //     '</div>');
                        $('#responseModalLabel').text('نجاح');
                        $('#modalMessage').html(
                            '<div class="alert" role="alert" style="margin-bottom: 0;"><p class="h3 mb-3">مبروك ربحت </p>' +
                            '<p class="h4 text-bold" style="margin-bottom: 0;">' + response
                            .success.name + '</p>' + '<p class="h1 text-bold mt-4">' +
                            response.success.amount + '</p>' + '</div>');
                        $('#responseModal').modal('show');
                        // $('#responseModal').addClass('delay-succes');
                        $('#failedModalGif').addClass('gifHidden');
                        $('#celebrate').addClass('confettiShow');
                        // $('#discountModalGif').removeClass('gifHidden');
                        // $('#discount').addClass('discount-animation');
                        setTimeout(function() {
                            // $('#discount').removeClass('discount-animation');
                            // $('#responseModal').removeClass('delay-succes');
                            $('#celebrate').removeClass('confettiShow');
                        }, 6000);
                    },
                    error: function(xhr, status, error) {
                        $('#code').val("");
                        $('#phone').val("");
                        $('#offerResponse').show();
                        // $('#responseMessage').html(
                        //     '<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 18px; margin-right: 4px;"></i>' + xhr
                        //     .responseJSON.error + '</div>');
                        $('#responseModalLabel').text('خطأ');
                        $('#modalMessage').html(
                            '<div class="alert" role="alert">' +
                            '<p class="h3">حدث خطأ. ' + xhr.responseJSON.error + '</p>' +
                            '</div>');
                        $('#responseModal').modal('show');
                        // $('#discountModalGif').addClass('gifHidden');
                        $('#failedModalGif').removeClass('gifHidden');
                    }
                });
            });
        });
    </script>
@endsection

<!-- <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 18px; margin-right: 4px;"></i> -->
