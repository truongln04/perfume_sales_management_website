<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Hệ thống quản trị website bán nước hoa">
    <meta name="keywords" content="Admin, Laravel, Perfume Shop">
    <meta name="author" content="MyCompany">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Trang quản trị')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            transition: width 0.3s ease;
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: 60px !important;
        }

        .sidebar .nav-link {
            color: #ddd;
            border-radius: 6px;
            margin-bottom: 4px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .sidebar .nav-link.active {
            background: #0d6efd;
            color: #fff;
        }

        .sidebar i {
            width: 22px;
            text-align: center;
        }

        .sidebar.collapsed .label {
            display: none;
        }

        .main-content {
            transition: margin-left 0.3s ease;
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- TOPBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 shadow-sm">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="/">
            Perfume Shop
        </a>

        <div class="ms-auto d-flex align-items-center gap-2">

            @auth
                <span class="text-white">
                    Xin chào, {{ Auth::user()->ten_hien_thi }}
                </span>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-danger btn-sm">
                        <i class="fa fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
            @endauth

        </div>
    </div>
</nav>

<div class="d-flex">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="sidebar bg-dark text-white d-flex flex-column"
        style="width:240px; height:calc(100vh - 56px); position:fixed; top:56px; left:0;">

        <div class="p-3 border-bottom fw-bold d-flex justify-content-between align-items-center">
            <span>
                <i class="fa fa-gem me-2 text-warning"></i>
                <span class="label">ADMIN PANEL</span>
            </span>

            <button id="toggleBtn" class="btn btn-sm btn-outline-light">
                <i class="fa fa-angle-double-left"></i>
            </button>
        </div>

        <nav class="nav flex-column px-2 py-3 flex-grow-1">

            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white"><i class="fa fa-home me-2"></i>Trang chủ</a>
            <a href="{{ route('accounts.index') }}" class="nav-link text-white"><i class="fa fa-users me-2"></i>Tài khoản</a>
            <a href="{{ route('categories.index') }}" class="nav-link text-white"><i class="fa fa-tags me-2"></i>Danh mục</a>
            <a href="{{ route('brands.index') }}" class="nav-link text-white"><i class="fa fa-industry me-2"></i>Thương hiệu</a>
            <a href="{{ route('products.index') }}" class="nav-link text-white"><i class="fa fa-box me-2"></i>Sản phẩm</a>
            <a href="{{ route('suppliers.index') }}" class="nav-link text-white"><i class="fa fa-truck me-2"></i>Nhà cung cấp</a>
            <a href="{{ route('receipts.index') }}" class="nav-link text-white"><i class="fa fa-clipboard-list me-2"></i>Phiếu nhập</a>
            <a href="{{ route('warehouse.index') }}" class="nav-link text-white"><i class="fa fa-warehouse me-2"></i>Tồn kho</a>
            <a href="{{ route('orders.index') }}" class="nav-link text-white"><i class="fa fa-shopping-cart me-2"></i>Đơn hàng</a>
            <a href="{{ route('reports.index') }}" class="nav-link text-white"><i class="fa fa-chart-bar me-2"></i>Báo cáo</a>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-home me-2"></i>
                <span class="label">Trang chủ</span>
            </a>

            <a href="{{ route('admin.accounts.index') }}"
               class="nav-link {{ request()->routeIs('admin.accounts.*') ? 'active' : '' }}">
                <i class="fa fa-users me-2"></i>
                <span class="label">Tài khoản</span>
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fa fa-tags me-2"></i>
                <span class="label">Danh mục</span>
            </a>

            <a href="{{ route('admin.brands.index') }}"
               class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                <i class="fa fa-industry me-2"></i>
                <span class="label">Thương hiệu</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fa fa-box me-2"></i>
                <span class="label">Sản phẩm</span>
            </a>

            <a href="{{ route('admin.suppliers.index') }}"
               class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
                <i class="fa fa-truck me-2"></i>
                <span class="label">Nhà cung cấp</span>
            </a>

            <a href="{{ route('admin.receipts.index') }}"
               class="nav-link {{ request()->routeIs('admin.receipts.*') ? 'active' : '' }}">
                <i class="fa fa-clipboard-list me-2"></i>
                <span class="label">Phiếu nhập</span>
            </a>

            <a href="{{ route('admin.warehouse.index') }}"
               class="nav-link {{ request()->routeIs('admin.warehouse.*') ? 'active' : '' }}">
                <i class="fa fa-warehouse me-2"></i>
                <span class="label">Tồn kho</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fa fa-shopping-cart me-2"></i>
                <span class="label">Đơn hàng</span>
            </a>

        </nav>

        <div class="p-3 border-top text-center">
            <small class="text-muted">© 2025 MyCompany</small>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div id="mainContent"
         class="main-content flex-grow-1"
         style="margin-left:240px; width:100%; min-height:calc(100vh - 56px); background:#f8f9fa;">

        <header class="bg-white shadow-sm p-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">@yield('header', 'Trang quản trị')</h5>

            <div class="d-flex align-items-center gap-2">
                <span>{{ Auth::user()->ten_hien_thi }}</span>

                <img src="{{ asset('images/admin-avatar.png') }}"
                     alt="Avatar"
                     class="rounded-circle"
                     width="40"
                     height="40">
            </div>
        </header>

        <main class="p-4">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </main>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const toggleBtn = document.getElementById('toggleBtn');
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');

toggleBtn?.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');

    if (sidebar.classList.contains('collapsed')) {
        mainContent.style.marginLeft = '60px';
        toggleBtn.innerHTML = '<i class="fa fa-angle-double-right"></i>';
    } else {
        mainContent.style.marginLeft = '240px';
        toggleBtn.innerHTML = '<i class="fa fa-angle-double-left"></i>';
    }
});
</script>

@stack('scripts')

</body>
</html>