@extends('layouts.admin')

@section('content')
<div class="card mt-3">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 text-primary fw-bold">Quản lý tài khoản</h5>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary">
                Thêm mới
            </a>

            <form method="GET" action="{{ url('accounts') }}">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Tìm theo tên hoặc email..."
                       value="{{ request('search') }}">
            </form>
        </div>
    </div>

   

    <div class="card-body p-0">
        <table class="table table-hover table-striped m-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tên hiển thị</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>SĐT</th>
                    <th>Google ID</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
            @forelse($accounts as $acc)
                <tr>
                    <td>{{ $acc->id_tai_khoan }}</td>

                    <td>
                        @if($acc->anh_dai_dien)
                            @if(Str::startsWith($acc->anh_dai_dien, ['http://','https://']))
        <img src="{{ $acc->anh_dai_dien }}"
             width="40" height="40"
             class="rounded-circle border">
    @else
        <img src="{{ asset('images/' . $acc->anh_dai_dien) }}"
             width="40" height="40"
             class="rounded-circle border">
    @endif
                        @else
                            N/A
                        @endif
                    </td>

                    <td>{{ $acc->ten_hien_thi }}</td>
                    <td>{{ $acc->email }}</td>

                    <td>
                        <span class="badge
                            @if($acc->vai_tro == 'ADMIN') bg-danger
                            @elseif($acc->vai_tro == 'NHANVIEN') bg-primary
                            @else bg-success
                            @endif">
                            {{ $acc->vai_tro }}
                        </span>
                    </td>

                    <td>{{ $acc->sdt }}</td>
                    <td>{{ $acc->google_id }}</td>

                    <td>
                        <a href="{{ route('admin.accounts.edit', $acc->id_tai_khoan) }}"
                           class="btn btn-sm btn-warning">
                            Sửa
                        </a>

                        <form action="{{ route('admin.accounts.destroy', $acc->id_tai_khoan) }}"
      method="POST"
      style="display:inline-block"
      onsubmit="return confirm('Xóa tài khoản này?')">

    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-sm btn-danger">
        Xóa
    </button>
</form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Không có dữ liệu</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection