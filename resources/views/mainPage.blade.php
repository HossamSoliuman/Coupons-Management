@extends('layouts.app')

@section('content')
    <div class="container text-center mt-5">
        <h4>مرحبًا بك في تطبيق سعادة</h4>
        <h5>يرجى زيارة متاجرنا ومسح رمز</h5>
        <h5><strong>QR Code</strong> </h5>
        <h5> للحصول على العروض</h5>
        <img src="{{ asset('img/logo.png') }}" alt="شعار التطبيق" class="img-fluid mx-auto d-block" style="max-width: 500px;">
    </div>
@endsection
