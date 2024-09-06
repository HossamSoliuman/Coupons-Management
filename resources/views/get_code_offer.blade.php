@extends('layouts.app')

@section('style')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap');

    * {
        font-family: "Cairo", sans-serif;
    }

    .form-control {
        text-align: right;
        background-color: #e2e2e1;
        height: 50px;
        padding-right: 56px;
    }

    .form-control:hover {
        border-width: 2px;
    }

    .form-control:focus {
        border-color: darkgray !important;
        box-shadow: 0px 0px 10px 10px darkgray !important;
        background-color: #e2e2e1;
    }

    .form-label {
        font-size: 18px;
        font-weight: 500;
    }

    .input-group {
        position: relative;
    }

    .input-group-text {
        display: block !important;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        z-index: 10;
        font-size: 22px;
    }

    .otp-inputs {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .otp-input {
        width: 45px;
        height: 45px;
        padding: 0px;
        text-align: center;
        font-size: 16px;
        font-weight: 600;

        @media (min-width: 640px) {
            width: 60px;
            height: 60px;
        }
    }

    .phone-icon {
        transform: translateY(-50%) rotate(220deg);
    }

    .send-button:hover :first-child::before {
        animation: send-button 2s both infinite;
    }

    .keyboard-parent {
        margin-top: 10px;
        display: grid;
        grid-template-columns: repeat(5, auto);

        @media (min-width: 640px) {
            grid-template-columns: repeat(6, auto);
        }
    }

    .keyboard-parent-number {
        @media (min-width: 640px) {
            grid-template-columns: repeat(5, auto);
        }
    }

    .keyboard-button {
        background-color: #d4d4d3;
        font-size: 16px !important;
        font-weight: 600;
        padding: 12px !important;
    }

    .submit-button {
        background-color: black;
        color: white;
        grid-column: span 3;
    }

    .submit-button-number {
        grid-column: span 4;
    }

    .submit-button:hover {
        color: white;
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
<div class="">
    <div>
        <div id="celebrate" class="confetti">
            @for ($i = 0; $i < 20; $i++)
                <div class="confetti-piece"></div>
            @endfor
        </div>
        <div class="text-center mt-4" style="">
            <img src="shops-images/logo-green.png" alt="Logo" style="max-width: 300px;" /><br>
            <div class="mt-2">
                <img src="shops-images/logo-green-text2.png" alt="Logo"style="max-width: 250px;"  />
            </div>
        </div>
        <div class="col-12 d-flex justify-content-center">
            <div class="card" style="box-shadow: none; width: 100%; max-width: 500px;">
                <div class="card-body text-center" style="width: 100%;">
                    <form id="offerForm">
                        @csrf
                        <p id="offerValidationMessage" class="alert alert-danger text-center"
                            style="display: none; position: fixed; top: 10px; left: 50%; transform: translateX(-50%); z-index: 1000; width: 80%; max-width: 500px;">
                            أدخل كود و
                            أدخل رقم هاتف سعودي صحيح يتكون من 9 أرقام ويبدأ بالرقم 5
                        </p>

                        <div class="mb-3 d-flex flex-column" style="gap: 10px;">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
                                <input id="code" type="text" class="form-control" name="code" inputmode='none' required
                                    placeholder="أدخل كود العرض" />
                            </div>
                            <div class="input-group">
                                <span class="input-group-text phone-icon"><i
                                        class="fa-solid fa-phone-volume"></i></span>
                                <input id="phone" type="text" class="form-control" name="phone" inputmode='none'
                                    required title="أدخل رقم هاتف سعودي صحيح يتكون من 9 أرقام ويبدأ بالرقم 5"
                                    placeholder="رقم الهاتف (9 أرقام)">
                            </div>
                            <div id="codeKeyboard" class="keyboard-parent">
                                @foreach (range('A', 'Z') as $letter)
                                    <button type="button" class="btn btn-sm send-button keyboard-button"
                                        onclick="addToInput('code', '{{ $letter }}')">{{ $letter }}</button>
                                @endforeach
                                <button type="button" class="btn btn-sm keyboard-button"
                                    onclick="deleteFromInput('code')"><i class="bi bi-backspace"></i></button>
                                <button type="submit" id="submitButton"
                                    class="btn btn-sm submit-button keyboard-button ">
                                    تأكيد
                                </button>
                            </div>
                            <div id="phoneKeyboard" class="keyboard-parent keyboard-parent-number"
                                style="display: none;" aria-hidden="true">
                                @foreach (range(1, 9) as $number)
                                    <button type="button" class="btn btn-sm send-button keyboard-button"
                                        onclick="addToInput('phone', '{{ $number }}')">{{ $number }}</button>
                                @endforeach
                                <button type="button" class="btn btn-sm send-button keyboard-button"
                                    onclick="addToInput('phone', '{{ 0 }}')">{{ 0 }}</button>
                                <button type="button" class="btn btn-sm keyboard-button"
                                    onclick="deleteFromInput('phone')"><i class="bi bi-backspace"></i></button>
                                <button type="submit" id="submitButton"
                                    class="btn btn-sm submit-button submit-button-number keyboard-button ">
                                    تأكيد
                                </button>
                            </div>
                        </div>

                        <div id="loadingSpinner" style="display: none;">
                            <img src="spinner.gif" alt="Loading..." style="width:100px" />
                        </div>
                    </form>


                    <form id="otpForm" style="width: 100%; display: none" aria-hidden="true">
                        @csrf
                        <p id="otpWrongMessage" class="alert alert-danger text-center" style="display: none">
                            الرمز الذي أدخلته غير صحيح.
                        </p>

                        <div class="mb-3 d-flex flex-column" style="gap: 10px; width: 100%;">
                            <label for="otp" class="form-label text-center">أدخل الكود المرسل إليك</label>
                            <div class="input-group">
                                <div class="otp-inputs">
                                    @for ($i = 0; $i < 6; $i++)
                                        <input type="text" class="form-control otp-input" id="otp-input-{{ $i }}"
                                            maxlength="1" required>
                                    @endfor
                                </div>
                            </div>
                            <div id="otpKeyboard" class="keyboard-parent keyboard-parent-number">
                                @foreach (range(1, 9) as $number)
                                    <button type="button" class="btn btn-sm send-button keyboard-button"
                                        onclick="addToOtpInputs('{{ $number }}')">{{ $number }}</button>
                                @endforeach
                                <button type="button" class="btn btn-sm send-button keyboard-button"
                                    onclick="addToOtpInputs('{{ 0 }}')">{{ 0 }}</button>
                                <button type="button" class="btn btn-sm keyboard-button"
                                    onclick="deleteFromOtpInput()"><i class="bi bi-backspace"></i></button>
                                <button type="submit" id="submitButton"
                                    class="btn btn-sm submit-button submit-button-number keyboard-button">
                                    تأكيد
                                </button>
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

            function addToOtpInputs(value) {
                let inputs = document.querySelectorAll('.otp-input');
                for (let input of inputs) {
                    if (input.value === '') {
                        input.value = value;
                        focusNextInput(input);
                        break;
                    }
                }
            }

            function deleteFromOtpInput() {
                let inputs = document.querySelectorAll('.otp-input');
                for (let i = inputs.length - 1; i >= 0; i--) {
                    if (inputs[i].value !== '') {
                        inputs[i].value = '';
                        focusPreviousInput(inputs[i + 1]);
                        break;
                    }
                }
            }

            function focusNextInput(currentInput) {
                let inputs = document.querySelectorAll('.otp-input');
                for (let i = 0; i < inputs.length; i++) {
                    if (inputs[i] === currentInput) {
                        if (i < inputs.length - 1) {
                            inputs[i + 1].focus();
                        }
                        break;
                    }
                }
            }

            function focusPreviousInput(currentInput) {
                let inputs = document.querySelectorAll('.otp-input');
                for (let i = 0; i < inputs.length; i++) {
                    if (inputs[i] === currentInput) {
                        if (i > 0) {
                            inputs[i - 1].focus();
                        }
                        break;
                    }
                }
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
@endsection

@section('scripts')
<script>
    const phonePattern = /^5[0-9]{8}$/;

    document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
        input.addEventListener('focus', () => {
            input.setAttribute('readonly', true);
        });

        input.addEventListener('blur', () => {
            input.removeAttribute('readonly');
        });
    });

    $('.otp-input').on('keydown keypress keyup', function (e) {
        e.preventDefault();
    });

    $('#code').on('keydown keypress keyup', function (e) {
        e.preventDefault();
    });

    $('#phone').on('keydown keypress keyup', function (e) {
        e.preventDefault();
    });

    $('#otp').on('keydown keypress keyup', function (e) {
        e.preventDefault();
    });

    $('#phone').on('focus', function () {
        $('#phoneKeyboard').show();
        $('#codeKeyboard').hide();
        $('#phone').attr("readonly", true);
        $('#code').attr("readonly", false);
    });

    $('#code').on('focus', function () {
        $('#phoneKeyboard').hide();
        $('#codeKeyboard').show();
        $('#code').attr("readonly", true);
        $('#phone').attr("readonly", false);
    });

    $('#phone').on('blur', function () {
        $('#phone').attr("readonly", false);
    });

    $('#code').on('blur', function () {
        $('#code').attr("readonly", false);
    });

    $('#submitButton').on('click', function () {
        $('#code').attr("readonly", false);
        $('#phone').attr("readonly", false);

        if ($('#phone').val().length && (!phonePattern.test($('#phone').val()) || !$('#code').val().length)) {
            $('#offerValidationMessage').show();

            setTimeout(() => {
                $('#offerValidationMessage').hide();
            }, 3000);
        } else {
            $('#offerValidationMessage').hide();
        }
    });

    function buildSuccessModal(response) {
        const modalBody = $('#modalMessage');
        modalBody.empty();

        const alertDiv = $('<div>', {
            class: 'alert',
            role: 'alert',
            style: 'margin-bottom: 0'
        });

        const title = $('<p>', {
            class: 'h3 mb-3',
            text: 'مبروك ربحت '
        });
        alertDiv.append(title);

        const name = $('<p>', {
            class: 'h4 text-bold',
            style: 'margin-bottom: 0',
            text: response.data.name
        });
        alertDiv.append(name);

        const amount = $('<p>', {
            class: 'h1 text-bold mt-4',
            text: response.data.amount
        });
        alertDiv.append(amount);

        modalBody.append(alertDiv);
    }

    function get_offer(phone, code) {
        $('#otpForm').hide();
        $('#offerForm').show();
        $('#code').focus();

        $.ajax({
            type: 'GET',
            url: '/api/offer',
            data: {
                phone,
                code
            },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    $('#code').val("");
                    $('#phone').val("");
                    $('#offerResponse').show().addClass("message-card-delay-succes");
                    $('#responseModalLabel').text('نجاح');

                    buildSuccessModal(response);

                    $('#failedModalGif').attr('src', 'gift-discount.gif').addClass('gifHidden');
                    $('#responseModal').modal('show');

                    $('#celebrate').addClass('confettiShow');
                    setTimeout(() => $('#celebrate').removeClass('confettiShow'), 6000);
                } else {
                    $('#code').val("");
                    $('#phone').val("");
                    $('#offerResponse').show();

                    $('#modalMessage').html(
                        $('<div>', {
                            class: 'alert',
                            role: 'alert'
                        })
                            .append($('<p>', {
                                class: 'h3',
                                text: response.message
                            }))
                    );

                    $('#responseModal').modal('show');
                    $('#failedModalGif').removeClass('gifHidden');
                }
            },
            error: function (xhr) {

            }
        });
    }

    function startLoading() {
        $('#loadingSpinner').show();
        $('#submitButton').hide();
    }

    function endLoading() {
        $('#loadingSpinner').hide();
        $('#submitButton').show();
    }

    $(document).ready(function () {
        $('#offerForm').submit(function (event) {
            $('#code').attr("readonly", false);
            $('#phone').attr("readonly", false);

            $('#phone').blur();
            $('#phone').blur();

            event.preventDefault();

            if ($('#phone').val().length && (!phonePattern.test($('#phone').val()) || !$('#code').val().length)) {
                $('#offerValidationMessage').show();

                setTimeout(() => {
                    $('#offerValidationMessage').hide();
                }, 3000);
            } else {
                $('#offerValidationMessage').hide();

                var phone = $('#phone').val().toLowerCase();
                var code = $('#code').val().toUpperCase();

                startLoading();

                $.ajax({
                    type: 'GET',
                    url: '/api/verify-phone',
                    data: {
                        phone,
                        code
                    },
                    success: function (response) {
                        endLoading();
                        if (response.verified) {
                            get_offer(phone, code);
                        } else {
                            $('#offerForm').hide();
                            $('#otpForm').show();
                        }
                    },
                    error: function (xhr) {
                        endLoading();
                        $('#offerResponse').show();

                        $('#modalMessage').html(
                            $('<div>', {
                                class: 'alert',
                                role: 'alert'
                            })
                                .append($('<p>', {
                                    class: 'h3',
                                    text: "لم يتم ارسال رسالة التأكيد"
                                }))
                        );

                        $('#responseModal').modal('show');
                        $('#failedModalGif').removeClass('gifHidden');
                    }
                });
            }
        });

        $('#otpForm').submit(function (event) {
            $('.otp-input').blur();

            event.preventDefault();
            let otp = $('.otp-input').map(function () {
                return $(this).val();
            }).get().join('');
            var phone = $('#phone').val().toLowerCase();

            $.ajax({
                type: 'GET',
                url: '/api/verify-otp',
                data: {
                    phone,
                    otp
                },
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        get_offer(phone, response.code);
                        $('#otpForm').trigger("reset");
                        $('#otpWrongMessage').hide();
                    } else {
                        $('#otpForm').trigger("reset");
                        $('#otpWrongMessage').show();
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        });
    });
</script>
@endsection