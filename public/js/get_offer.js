
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

        if ($('#phone').val().length && (!phonePattern.test($('#phone').val()) || !$('#code').val()
            .length)) {
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
