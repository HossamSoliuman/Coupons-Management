@extends('layouts.app')

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

    .inputCard {
        box-shadow: 0 2px 12px 5px #EAFFD0 !important;
        height: 450px;
    }

    .card-body {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #loginForm {
        width: 100%;
    }
</style>

@section('content')
<div class="container">
    <div
        class="d-flex flex-column gap-6 justify-content-center align-items-center mt-5"
        style="height: 94vh"
    >
        <div class="mb-5 text-center">
            <img src="logo.jpeg" alt="Logo" style="max-width: 200px" />
        </div>
        <div class="col-md-8">
            <div class="card inputCard" style="border-radius: 25px">
                <div class="card-body text-center">
                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="d-flex justify-content-center">
                            <div class="w-50">
                                <!-- <div class="mb-3 text-center">
                                    <img
                                        src="logo.jpeg"
                                        alt="Logo"
                                        style="max-width: 200px"
                                    />
                                </div> -->

                                <div class="mb-3">
                                    <label for="email" class="form-label"
                                        >البريد الالكتروني</label
                                    >
                                    <input
                                        id="email"
                                        type="email"
                                        class="form-control text-center @error('email') is-invalid @enderror"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        autocomplete="email"
                                        autofocus
                                        style="border-radius: 28px"
                                    />
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label"
                                        >الرقم السري</label
                                    >
                                    <input
                                        id="password"
                                        type="password"
                                        class="form-control text-center @error('password') is-invalid @enderror"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        style="border-radius: 28px"
                                    />
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div
                                    class="mb-3 text-center"
                                    style="margin-top: 54px"
                                >
                                    <button
                                        type="submit"
                                        class="btn font-size-large"
                                        style="
                                            border-radius: 25px;
                                            background-color: #EAFFD0;
                                        "
                                    >
                                        تسجيل دخول
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

@endsection
