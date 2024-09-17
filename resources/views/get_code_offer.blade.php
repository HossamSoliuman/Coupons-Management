@extends('layouts.app')

@section('style')
    <link href="{{ asset('/css/get_offer.css') }}" rel="stylesheet">
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
                <img src="shops-images/logo.png" alt="Logo" style=" max-width: 250px; " /><br>
               
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
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-tag" style="color: #12ceb3;"></i>
                                    </span>
                                    <input id="code" type="text" class="form-control" name="code"
                                        inputmode='none' required placeholder="أدخل كود العرض" />
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text phone-icon">
                                        <i class="fa-solid fa-phone-volume" style="color: #12ceb3;"></i>
                                    </span>

                                    <input id="phone" type="text" class="form-control" name="phone"
                                        inputmode='none' required
                                        title="أدخل رقم هاتف سعودي صحيح يتكون من 9 أرقام ويبدأ بالرقم 5"
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
                                            <input type="text" class="form-control otp-input"
                                                id="otp-input-{{ $i }}" maxlength="1" required>
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

    <div class="modal result" id="responseModal" role="dialog" aria-labelledby="responseModalLabel"
        aria-hidden="true">
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
    <script src="{{ asset('/js/get_offer.js') }}"></script>
@endsection
