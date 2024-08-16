@extends('layouts.app')

@section('style')
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
    <style>
        .keyboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 10px;
        }

        .key {
            margin: 5px;
            padding: 10px 15px;
            border-radius: 5px;
            background-color: #EAFFD0;
            cursor: pointer;
            font-size: 18px;
            text-align: center;
        }

        .key:hover {
            background-color: #d4f1b3;
        }
    </style>
@endsection

@section('content')
    <div class="mt-5">
        <div>
            <div id="celebrate" class="confetti">
                @for ($i = 0; $i < 20; $i++)
                    <div class="confetti-piece"></div>
                @endfor
            </div>
            <div class="text-center">
                <img src="logo.jpeg" alt="Logo" style="max-width: 200px;" />
            </div>
            <div class="col-12 mt-5">
                <div class="card" style="border-radius: 25px;">
                    <div class="card-body text-center">
                        <form id="offerForm">
                            @csrf
                            <h4 class="mb-5">إحصل على العرض الخاص بك</h4>
                            <p id="phoneValidationMessage" class="alert alert-danger text-center"
                                style="display: none; position: fixed; top: 10px; left: 50%; transform: translateX(-50%); z-index: 1000; width: 80%; max-width: 500px;">
                                أدخل رقم هاتف سعودي صحيح يتكون من 9 أرقام ويبدأ بالرقم 5
                            </p>

                            <div class="row justify-content-around">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="code" class="form-label">أدخل كود العرض</label>
                                        <input id="code" type="text" class="form-control text-center"
                                            style="border-radius: 28px;" name="code" disabled />
                                        <div id="codeKeyboard" class="mt-3">
                                            @foreach (range('A', 'Z') as $letter)
                                                <button type="button" class="btn btn-sm send-button"
                                                    style="border-radius: 25px; background-color: #EAFFD0;"
                                                    onclick="addToInput('code', '{{ $letter }}')">{{ $letter }}</button>
                                            @endforeach
                                            <button type="button" class="btn btn-sm send-button"
                                                style="border-radius: 25px; background-color: #EAFFD0;"
                                                onclick="deleteFromInput('code')">Del</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">أدخل رقم الهاتف</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="border-radius: 28px 0 0 28px;">
                                                    <img src="saudi-flag2.png" alt="Saudi Flag"
                                                        style="width: 20px; height: auto;">
                                                    +966
                                                </span>
                                            </div>
                                            {{-- <input id="phone" type="text" class="form-control text-center"
                                                style="border-radius: 0 28px 28px 0;" name="phone"
                                                placeholder="رقم الهاتف (9 أرقام)"> --}}
                                            <input id="phone" type="text" class="form-control text-center" disabled
                                                style="border-radius: 0 28px 28px 0;" name="phone" inputmode='none'
                                                required pattern="5[0-9]{8}" onchange="this.reportValidity()"
                                                title=
                                                "أدخل رقم هاتف سعودي صحيح يتكون من 9 أرقام ويبدأ بالرقم 5"
                                                placeholder="رقم الهاتف (9 أرقام)">
                                        </div>
                                        <div id="phoneKeyboard" class="mt-3">
                                            @foreach (range(0, 9) as $number)
                                                <button type="button" class="btn btn-sm send-button"
                                                    style="border-radius: 25px; background-color: #EAFFD0;"
                                                    onclick="addToInput('phone', '{{ $number }}')">{{ $number }}</button>
                                            @endforeach
                                            <button type="button" class="btn btn-sm send-button"
                                                style="border-radius: 25px; background-color: #EAFFD0;"
                                                onclick="deleteFromInput('phone')">Del</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 text-center" style="margin-top: 54px;">
                                <button type="submit" id="submitButton" class="btn btn-lg send-button"
                                    style="border-radius: 25px; background-color: #EAFFD0;">
                                    <i class="bi bi-arrow-left"></i> إرسال
                                </button>
                                <div id="loadingSpinner" style="display: none;">
                                    <img src="spinner.gif" alt="Loading..." style="width:100px" />
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

            <script>
                function addToInput(inputId, value) {
                    let input = document.getElementById(inputId);
                    let currentValue = input.value;
                    input.value += value;
                }

                function deleteFromInput(inputId) {
                    let input = document.getElementById(inputId);
                    input.value = input.value.slice(0, -1);
                }
            </script>
        </div>
    </div>

    <div class="modal result" id="responseModal" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered success_tic" role="document">
            <div class="modal-content">
                <a class="close" style="z-index: 3000;" href="#" data-dismiss="modal">&times;</a>
                <div class="page-body">
                    <div class="text-center" id="responseBody">
                        <div id="modalMessage"></div>
                    </div>
                    <div style="text-align: center">
                        <img id="failedModalGif" src="failedModal.gif" alt="failed" style="max-width: 140px" />
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal result" id="otpModal" role="dialog" aria-labelledby="otpModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-dialog-centered success_tic" role="document">
            <div class="modal-content">
                <a class="close" style="z-index: 3000;" href="#" id="closeOtpModal">&times;</a>
                <div class="page-body">
                    <form id="otpForm">
                        <div class="mb-3 text-center">
                            <p id="otpWrongMessage" class="alert alert-danger text-center" style="display: none">
                                الرمز الذي أدخلته غير صحيح.
                            </p>
                            <input type="hidden" name="phone" id="otp_phone" disabled required>
                            <label for="otp" class="form-label text-center">أدخل رمز التحقق</label>
                            <input id="otp" type="text" class="form-control text-center" name="otp"
                                disabled placeholder="رمز التحقق (OTP)">
                            <div id="otpKeyboard" class="mt-3">
                                @foreach (range(0, 9) as $number)
                                    <button type="button" class="btn btn-sm send-button"
                                        style="border-radius: 25px; background-color: #EAFFD0;"
                                        onclick="addToInput('otp', '{{ $number }}')">{{ $number }}</button>
                                @endforeach
                                <button type="button" class="btn btn-sm send-button"
                                    style="border-radius: 25px; background-color: #EAFFD0;"
                                    onclick="deleteFromInput('otp')">Del</button>
                            </div>
                        </div>


                        <div class="mb-3 text-center" style="margin-top: 54px;">
                            <button type="submit" class="btn font-size-large send-button"
                                style="border-radius: 25px; background-color: #EAFFD0;">
                                <i class="bi bi-arrow-left"></i> تأكيد
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('closeOtpModal').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('otpModal').style.display = 'none';
        });

        function get_offer(phone, code) {
            $('#otpModal').hide();
            $.ajax({
                type: 'GET',
                url: '/api/offer',
                data: {
                    phone: phone,
                    code: code
                },
                success: function(response) {
                    $('#code').val("");
                    $('#phone').val("");
                    $('#offerResponse').show();
                    $('#offerResponse').addClass("message-card-delay-succes");
                    $('#responseModalLabel').text('نجاح');
                    $('#modalMessage').html(
                        '<div class="alert" role="alert" style="margin-bottom: 0;"><p class="h3 mb-3">مبروك ربحت </p>' +
                        '<p class="h4 text-bold" style="margin-bottom: 0;">' + response.success.name +
                        '</p>' +
                        '<p class="h1 text-bold mt-4">' + response.success.amount + '</p>' + '</div>'
                    );
                    $('#failedModalGif').attr('src', 'gift-discount.gif');
                    $('#responseModal').modal('show');
                    $('#failedModalGif').addClass('gifHidden');
                    $('#celebrate').addClass('confettiShow');
                    setTimeout(function() {
                        $('#celebrate').removeClass('confettiShow');
                    }, 6000);
                },
                error: function(xhr) {
                    $('#code').val("");
                    $('#phone').val("");
                    $('#offerResponse').show();
                    $('#modalMessage').html(
                        '<div class="alert" role="alert">' +
                        '<p class="h3">' + xhr.responseJSON.error + '</p>' +
                        '</div>'
                    );
                    $('#responseModal').modal('show');
                    $('#failedModalGif').removeClass('gifHidden');
                }
            });
        }

        function validatePhoneInput() {
            let input = document.getElementById('phone');
            input.disabled = false;
            if (!input.checkValidity()) {
                input.disabled = true;
                return false;
            } else {
                input.disabled = true;
                return true;
            }
            input.disabled = true;
        }

        function startLoading() {
            $('#loadingSpinner').show();
            $('#submitButton').hide();
        }

        function endLoading() {
            $('#loadingSpinner').hide();
            $('#submitButton').show();
        }
        $(document).ready(function() {
            $('#offerForm').submit(function(event) {
                event.preventDefault();
                var phone = $('#phone').val();
                var code = $('#code').val();

                startLoading();

                if (!validatePhoneInput()) {
                    $('#phoneValidationMessage').show();
                    setTimeout(function() {
                        $('#phoneValidationMessage').hide();
                    }, 4000);
                    endLoading();
                    return;
                }
                $('#otp_phone').val(phone);
                $.ajax({
                    type: 'GET',
                    url: '/api/verify-phone',
                    data: {
                        phone: phone,
                        code: code
                    },
                    success: function(response) {
                        endLoading();
                        if (response.verified) {
                            get_offer(phone, code);
                        } else {
                            $('#otpForm').trigger("reset");
                            $('#otpWrongMessage').hide();
                            $('#otpModal').show();
                        }
                    },
                    error: function(xhr) {
                        endLoading();
                        get_offer(phone, code);
                    }
                });
            });

            $('#otpForm').submit(function(event) {
                event.preventDefault();
                var phone = $('#otp_phone').val();
                var otp = $('#otp').val();
                $.ajax({
                    type: 'GET',
                    url: '/api/verify-otp',
                    data: {
                        phone: phone,
                        otp: otp
                    },
                    success: function(response) {
                        if (response.success) {
                            get_offer(phone, response.code);
                            $('#otpForm').trigger("reset");
                            $('#otpWrongMessage').hide();
                        } else {
                            $('#otpForm').trigger("reset");
                            $('#otpWrongMessage').show();
                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.error);
                    }
                });
            });
        });
    </script>
@endsection
