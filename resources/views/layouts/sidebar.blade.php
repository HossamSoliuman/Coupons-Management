<style>
    .nav-color {
        background-color: #fe759f !important;
        height: 100vh;
        position: fixed;
        top: 0px;
        bottom: 0;
        display: flex;
        flex-direction: column;

    }

    .nav-item {
        width: 100%;
        border-radius: 15px;
        margin-bottom: 10px;
    }

    .nav-item:hover {
        background-color: #FE9EBB;
    }
    .nav-item:last-of-type:hover {
        background-color: #ff4d4f;
        color: black;

    }
    .nav-item button {
        all: unset;
    }

    .nav-item a,
    .nav-item button {
        display: flex;
        align-items: center;
        gap: 25px;
        padding: 10px;
        padding-right: 30px;
        color: black;
        font-size: 20px;
        font-weight: bold;
    }
    .active-nav-item,   .active-nav-item:hover {
        background-color: #EAFFD0;
    }

</style>

<nav id="sidebar" class="col-md-3 col-lg-2 position-sticky d-md-block nav-color p-0">
    <div class="mx-auto" style="max-width: 160px; text-align: center;">
        <img src="logo-trans.png" alt="Logo" class="my-4 mw-100" />
    </div>
    <ul class="nav d-flex flex-column align-items-start p-2 flex-grow-1">
        <li class="nav-item {{ request()->routeIs('admin.index') ? 'active-nav-item' : '' }}">
            <a href="{{ route('admin.index') }}">
                <i class="bi bi-house-door"></i> الرئيسية
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('shops.index') ? 'active-nav-item' : '' }}">
            <a href="{{ route('shops.index') }}">
                <i class="bi bi-shop"></i> المتاجر
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('codes.index') ? 'active-nav-item' : '' }}">
            <a href="{{ route('codes.index') }}">
                <i class="bi bi-123"></i> أكواد الخصم
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('offers.index') ? 'active-nav-item' : '' }}">
            <a href="{{ route('offers.index') }}">
                <i class="bi bi-gift"></i> العروض
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('users.index') ? 'active-nav-item' : '' }}">
            <a href="{{ route('users.index') }}">
                <i class="bi bi-person"></i> المستخدمين
            </a>
        </li>
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
                </button>
            </form>
        </li>
    </ul>
</nav>
