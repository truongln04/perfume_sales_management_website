<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Hệ thống quản trị website bán nước hoa - quản lý danh mục, sản phẩm, đơn hàng, báo cáo.">
    <meta name="keywords" content="Admin, Quản trị, Nước hoa, Laravel, Quản lý danh mục, Quản lý sản phẩm">
    <meta name="author" content="MyCompany">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang quản trị')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            transition: width 0.3s ease;
            overflow: hidden;
        }
        .sidebar.collapsed {
            width: 53px !important;
        }
        .sidebar .nav-link {
            color: #ddd;
            border-radius: 6px;
            margin-bottom: 4px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .sidebar i {
            width: 20px;
            text-align: center;
        }
        .sidebar.collapsed .label {
            display: none;
        }
        .main-content {
            transition: margin-left 0.3s ease;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-dark text-white d-flex flex-column"
           style="width:240px; height:100vh; position:fixed; top:0; left:0;">
        <div class="p-3 border-bottom fw-bold d-flex justify-content-between align-items-center">
            <span><i class="fa fa-gem me-2 text-warning"></i> <span class="label">ADMINPANEL</span></span>
            <button id="toggleBtn" class="btn btn-sm btn-outline-light">
                <i class="fa fa-angle-double-left"></i>
            </button>
        </div>
        <nav class="nav flex-column px-2 py-3 flex-grow-1">
            <a href="{{ route('categories.index') }}" class="nav-link text-white"><i class="fa fa-home me-2"></i>Trang chủ</a>
            <a href="{{ route('categories.index') }}" class="nav-link text-white"><i class="fa fa-users me-2"></i>Tài khoản</a>
            <a href="{{ route('categories.index') }}" class="nav-link text-white"><i class="fa fa-tags me-2"></i>Danh mục</a>
            <a href="{{ route('brands.index') }}" class="nav-link text-white"><i class="fa fa-industry me-2"></i>Thương hiệu</a>
            <a href="{{ route('categories.index') }}" class="nav-link text-white"><i class="fa fa-box me-2"></i>Sản phẩm</a>
            <a href="{{ route('suppliers.index') }}" class="nav-link text-white"><i class="fa fa-truck me-2"></i>Nhà cung cấp</a>
            <a href="{{ route('categories.index') }}" class="nav-link text-white"><i class="fa fa-clipboard-list me-2"></i>Phiếu nhập</a>
            <a href="{{ route('categories.index') }}" class="nav-link text-white"><i class="fa fa-warehouse me-2"></i>Tồn kho</a>
            <a href="{{ route('categories.index') }}" class="nav-link text-white"><i class="fa fa-shopping-cart me-2"></i>Đơn hàng</a>
            <a href="{{ route('categories.index') }}" class="nav-link text-white"><i class="fa fa-chart-bar me-2"></i>Báo cáo</a>
        </nav>
        <div class="p-3 border-top text-center">
            <small class="text-muted">© 2025 MyCompany</small>
        </div>
    </aside>

    <!-- Nội dung chính -->
    <div id="mainContent" class="main-content flex-grow-1"
         style="margin-left:240px; min-height:100vh; background:#f8f9fa;">
        <header class="bg-white shadow-sm p-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">@yield('header', 'Trang quản trị')</h5>
            <div>
                <img src="{{ asset('images/admin-avatar.png') }}" alt="Admin Avatar" class="rounded-circle" width="40" height="40">
            </div>
        </header>
        <main class="p-4">
            @yield('content')
        </main>
    </div>
</div>

<script>
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        if (sidebar.classList.contains('collapsed')) {
            mainContent.style.marginLeft = '70px';
            toggleBtn.innerHTML = '<i class="fa fa-angle-double-right"></i>';
        } else {
            mainContent.style.marginLeft = '240px';
            toggleBtn.innerHTML = '<i class="fa fa-angle-double-left"></i>';
        }
    });
</script>
</body>
</html>
