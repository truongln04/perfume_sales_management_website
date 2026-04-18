<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perfume Shop')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="/">
            Perfume Shop
        </a>

        <div class="ms-auto d-flex align-items-center gap-2">

            @auth
                <span class="text-white">
                    Xin chào, {{ Auth::user()->ten_hien_thi }}
                </span>

                @if(in_array(strtolower(Auth::user()->vai_tro), ['admin','nhanvien']))
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm">
                        Dashboard
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-danger btn-sm">Logout</button>
                </form>
            @endauth

        </div>
    </div>
</nav>

<div class="container mt-4">   

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>