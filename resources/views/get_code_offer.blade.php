@extends('layouts.app')

@section('style')
    <link href="{{ asset('/css/get_offer.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="" style="margin-top: 50px">
        <div>
            <div id="celebrate" class="confetti">
                @for ($i = 0; $i < 20; $i++)
                    <div class="confetti-piece"></div>
                @endfor
            </div>
            <div class="text-center mt-5 mb-3" style="">
                <img src="shops-images/logo.png" alt="Logo" style=" max-width: 300px; " /><br>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <div class="card" style="box-shadow: none; width: 100%; max-width: 500px;">
                    <div class="card-body text-center " style="width: 100%;">
                        <form id="offerForm" class="text-center mb-3">
                            @csrf
                            <p id="offerValidationMessage" class="alert alert-danger text-center"
                                style="display: none; position: fixed; top: 10px; left: 50%; transform: translateX(-50%); z-index: 1000; width: 80%; max-width: 500px;">
                                أدخل كود و
                                أدخل رقم هاتف سعودي صحيح يتكون من 9 أرقام ويبدأ بالرقم 5
                            </p>

                            <div class="mb-3 d-flex flex-column" style="gap: 10px;">
                                <div class="input-group ">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-tag" style="color: #e43c7c;"></i>
                                    </span>
                                    <input id="code" type="text" class="form-control" name="code" required
                                        placeholder="أدخل كود العرض" />
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text phone-icon">
                                        <i class="fa-solid fa-phone-volume" style="color: #e43c7c;"></i>
                                    </span>

                                    <input id="phone" type="number" class="form-control" name="phone" required
                                        title="أدخل رقم هاتف سعودي صحيح يتكون من 9 أرقام ويبدأ بالرقم 5"
                                        placeholder="رقم الهاتف (9 أرقام)">
                                </div>
                            </div>
                            <div class="input-group d-flex justify-content-center">
                                <input type="submit" value="أحصل علي العرض" class="btn rounded-pill submit-button">
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
                                            <input type="number" class="form-control otp-input"
                                                id="otp-input-{{ $i }}" maxlength="1" required>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 d-flex flex-column" style="width: 100%;">
                                <input id="submitButton" type="submit" value="تأكيد"
                                    class="btn submit-button w-50 rounded-pill">
                            </div>
                        </form>

                        <script>
                            document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
                                input.addEventListener('input', (e) => {
                                    e.target.value = e.target.value.slice(0, 1);
                                    if (e.target.value.length === 1 && index < inputs.length - 1) {
                                        inputs[index + 1].focus();
                                    }
                                });

                                input.addEventListener('keydown', (e) => {
                                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                                        inputs[index - 1].focus();
                                    }
                                });
                            });
                        </script>

                    </div>
                </div>
            </div>


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
    <script src="{{ asset('/js/get_offer.js') }}"></script>
@endsection
