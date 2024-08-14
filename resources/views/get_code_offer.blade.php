@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/get_code.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="d-flex flex-column gap-6 justify-content-center align-items-center mt-5" style="height: 94vh">
            <div id="celebrate" class="confetti">
                <div class="confetti-piece"></div>
            </div>

            <div class="mb-5 text-center">
                <img src="logo.jpeg" alt="Logo" style="max-width: 200px;" />
            </div>
            <div class="col-md-8">
                <div class="card inputCard" style="border-radius: 25px">
                    <div class="card-body text-center">
                        <form id="offerForm">
                            @csrf
                            <div class="d-flex justify-content-center">
                                <div class="w-50">
                                    <div class="mb-3">
                                        <h4 class="mb-5">إحصل على العرض الخاص بك</h4>
                                        <label for="code" class="form-label">أدخل كود العرض</label>
                                        <input id="code" type="text" class="form-control text-center"
                                            style="border-radius: 28px;" name="code" required />
                                    </div>
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
                                            <input id="phone" type="text" class="form-control text-center"
                                                style="border-radius: 0 28px 28px 0;" name="phone">
                                            {{-- <input id="phone" type="text" class="form-control text-center"
                                                style="border-radius: 0 28px 28px 0;" name="phone" required
                                                pattern="5[0-9]{8}" oninput="this.reportValidity()"
                                                title="أدخل رقم هاتف سعودي صحيح يتكون من 9 أرقام ويبدأ بالرقم 5"
                                                placeholder="رقم الهاتف (9 أرقام)"> --}}
                                        </div>
                                    </div>

                                    <div class="mb-3 text-center" style="margin-top: 54px;">
                                        <button type="submit" class="btn font-size-large send-button"
                                            style="border-radius: 25px; background-color: #EAFFD0;">
                                            <i class="bi bi-arrow-left"></i> إرسال
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                            <input type="hidden" name="phone" id="otp_phone">
                            <label for="otp" class="form-label text-center">أدخل رمز التحقق</label>
                            <input id="otp" type="text" class="form-control text-center" name="otp" required
                                placeholder="رمز التحقق (OTP)">
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

        $(document).ready(function() {
            $('#offerForm').submit(function(event) {
                event.preventDefault();
                var phone = $('#phone').val();
                var code = $('#code').val();
                $('#otp_phone').val(phone);
                $.ajax({
                    type: 'GET',
                    url: '/api/verify-phone',
                    data: {
                        phone: phone,
                        code: code
                    },
                    success: function(response) {
                        if (response.verified) {
                            get_offer(phone, code);
                        } else {
                            $('#otpForm').trigger("reset");
                            $('#otpWrongMessage').hide();
                            $('#otpModal').show();
                        }
                    },
                    error: function(xhr) {
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
