<header class="border-bottom bg-white sticky-top" style="z-index:1100">
    <div class="container py-3 d-flex align-items-center justify-content-between">
        {{-- Logo --}}
        <a href="{{ route('client.home') }}">
            <img src="https://orchard.vn/wp-content/uploads/2024/04/logo-orchard-2024-small.png"
                 alt="Logo Orchard" style="height:50px;object-fit:contain">
        </a>

        {{-- Search --}}
        <div class="flex-grow-1 mx-4 mx-md-5 position-relative">
            <form action="{{ route('client.products') }}" method="GET">
                <input type="text" name="q" class="form-control form-control-lg rounded-pill ps-5"
                       placeholder="Tìm kiếm sản phẩm..." value="{{ request('q') }}">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            </form>
        </div>

        {{-- Cart + User --}}
        <div class="d-flex align-items-center gap-4">
            <a href="{{ route('client.cart') }}" class="text-dark position-relative">
                <i class="bi bi-cart3 fs-3"></i>
                @php
    $cart = session('cart', []);
     $cartCount = count($cart);
@endphp

@if($cartCount > 0)
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        {{ $cartCount }}
    </span>
@endif
            </a>

            @guest
                {{-- <a href="{{ route('login') }}" class="d-flex align-items-center gap-2 text-dark text-decoration-none"> --}}
                    <a href="/login" class="d-flex align-items-center gap-2 text-dark text-decoration-none">
                    <i class="bi bi-person-circle fs-3"></i>
                    <span class="d-none d-md-inline fw-medium">Đăng nhập</span>
                </a>
            @else
                <div class="dropdown">
                    <a href="#" class="d-block" data-bs-toggle="dropdown">
                        <img src="{{ Auth::user()->anh_dai_dien ?? '/default-avatar.png' }}"
                             alt="Avatar" width="45" height="45"
                             class="rounded-circle object-fit-cover border border-3 border-white shadow-sm">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end p-3 shadow rounded-4" style="min-width:300px">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ Auth::user()->anh_dai_dien ?? '/default-avatar.png' }}"
                                 alt="" width="60" height="60" class="rounded-circle">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ Auth::user()->ten_hien_thi ?? Auth::user()->name }}</h6>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('client.profile') }}" class="btn btn-outline-primary w-100 mb-2 rounded-pill">
                            <i class="bi bi-person me-2"></i> Thông tin cá nhân
                        </a>
                        <a href="{{ route('client.orderslist') }}" class="btn btn-outline-secondary w-100 mb-3 rounded-pill">
                            <i class="bi bi-bag-check me-2"></i> Đơn hàng của tôi
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100 rounded-pill">
                                <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>

    {{-- Menu danh mục --}}
    <nav class="bg-light border-top border-bottom py-2">
        <div class="container d-flex justify-content-center">
            <ul class="nav flex-nowrap gap-3">
                @foreach($categories ?? [] as $cat)
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold text-uppercase px-3"
                           href="{{ route('client.category',$cat->id_danh_muc) }}">
                            {{ $cat->ten_danh_muc }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>
