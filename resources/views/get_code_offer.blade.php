@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/get_code.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="d-flex flex-column gap-6 justify-content-center align-items-center mt-5" style="height: 94vh">
            <div id="celebrate" class="confetti">
                <div class="confetti-piece"></div>
                <!-- More confetti pieces here -->
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
                                                    +9665
                                                </span>
                                            </div>
                                            <input id="phone" type="text" class="form-control text-center"
                                                style="border-radius: 0 28px 28px 0;" name="phone" required
                                                pattern="[0-9]{8}" oninput="this.reportValidity()"
                                                title="أدخل رقم هاتف سعودي صحيح" placeholder="رقم الهاتف (8 أرقام)">
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
@endsection

@section('scripts')
    <script>
        function get_offer(phone, code) {
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
                get_offer(phone, code);
            });
        });
    </script>
@endsection
