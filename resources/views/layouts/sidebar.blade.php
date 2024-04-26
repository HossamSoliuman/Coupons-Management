@section('styles')
    <style>
        /* sidebar.css */
        .nav-link-custom {
            font-size: 16px;
            font-weight: bold;
            display: flex;
            align-items: flex-start;
            /* Align items to the top */
        }

        .nav-link-custom i {
            margin-top: 4px;
            /* Adjust the margin as needed */
            margin-right: 8px;
            /* Adjust the margin as needed */
        }
    </style>
@endsection
<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark  sidebar">
    <div class="position-sticky">
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link rounded btn btn-light btn-block mb-2 nav-link-custom text-left" href="{{ route('admin.index') }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
                <a class="nav-link btn btn-light btn-block mb-2 nav-link-custom text-left" href="{{ route('shops.index') }}">
                    <i class="bi bi-shop"></i> Shops
                </a>
                <a class="nav-link btn btn-light btn-block mb-2 nav-link-custom text-left" href="{{ route('codes.index') }}">
                    <i class="bi bi-123"></i> Codes
                </a>
                <a class="nav-link btn btn-light btn-block mb-2 nav-link-custom text-left" href="{{ route('offers.index') }}">
                    <i class="bi bi-gift"></i> Offers
                </a>
                <a class="nav-link btn btn-light btn-block mb-2 nav-link-custom text-left" href="{{ route('users.index') }}">
                    <i class="bi bi-person"></i> Users
                </a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="nav-link btn btn-danger btn-block mb-2 nav-link-custom ">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
