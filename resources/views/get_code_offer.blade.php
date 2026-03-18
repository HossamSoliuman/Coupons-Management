@extends('layouts.app')

@section('style')
    <link href="{{ asset('/css/get_offer.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="logo">
            <img src={{ asset('img/logo.png') }} alt="" style="max-width: 150px">
        </div>
        <form id="offerForm" class="text-center mb-3">
            @csrf
            <input type="hidden" name="qr_key" id="qrKey" value="{{ $qr_key }}">
            <p id="offerValidationMessage" class="alert alert-danger text-center" style="display: none;">
                أدخل كود و
                أدخل رقم هاتف سعودي صحيح يتكون من 9 أرقام ويبدأ بالرقم 5
            </p>

            <div class="input-group">
                <input id="code" type="text" class="form-control" name="code" required
                    placeholder="أدخل كود العرض" />
                <i class="fa-solid fa-tag input-icon"></i>
            </div>
            <div class="input-group">
                <input id="phone" type="number" class="form-control" name="phone" required
                    placeholder="رقم الهاتف (9 أرقام)" />
                <i class="fa-solid fa-phone input-icon"></i>
            </div>
            <div class="input-group">
                <input type="submit" value="احصل على العرض" class="submit-button">
            </div>

            <div id="loadingSpinner" style="display: none;">
                <img src={{ asset('img/spinner.gif') }} alt="Loading..." style="width:100px" />
            </div>
        </form>

        <form id="otpForm" style="display: none;" aria-hidden="true">
            @csrf
            <p id="otpWrongMessage" class="alert alert-danger text-center" style="display: none">
                الرمز الذي أدخلته غير صحيح.
            </p>
            <label for="otp" class="form-label">أدخل الكود المرسل إليك</label>
            <div class="otp-inputs mb-3">
                @for ($i = 0; $i < 6; $i++)
                    <input type="number" class="otp-input" id="otp-input-{{ $i }}" maxlength="1" required>
                @endfor
            </div>
            <div class="input-group">
                <input id="submitButton" type="submit" value="تأكيد" class="submit-button">
            </div>
        </form>
    </div>

    <div class="modal result" id="responseModal" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered success_tic" role="document">
            <div class="modal-content">
                <a class="close" style="z-index: 3000;" href="#" data-dismiss="modal">&times;</a>
                <div class="page-body text-center" id="responseBody">
                    <div id="modalMessage"></div>
                    <img id="failedModalGif" src={{ asset('img/failedModal.gif') }} alt="failed" style="max-width: 140px" />
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/js/get_offer.js') }}"></script>
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
@endsection
