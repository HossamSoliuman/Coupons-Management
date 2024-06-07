<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>سعادة</title>
    <link rel="icon" href="logo.jpeg">



    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">

    <!-- MDB CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @yield('styles')
</head>

<body>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger d-inline top-right-alert" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <script>
        setTimeout(function() {
            $(".alert").alert('close');
        }, 5000);
    </script>
    <style>
        .top-right-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>
    <div class="container-fluid" dir="rtl">
        <div class="row">
            @include('layouts.sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="min-height: 100vh;">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>

</html>
