@extends('layouts.admin')

@section('title', 'Hồ sơ cá nhân')
@section('header', 'Hồ sơ cá nhân')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-sm border-0">
                <div class="card-body text-center">

                    @php
                        $avatar = auth()->user()->anh_dai_dien;
                    @endphp

                    {{-- Avatar --}}
                    @if($avatar && Str::startsWith($avatar, ['http://','https://']))
                        <img src="{{ $avatar }}"
                             class="rounded-circle border mb-3"
                             width="120" height="120"
                             style="object-fit:cover">
                    @else
                        <img src="{{ $avatar ? asset('images/'.$avatar) : 'https://via.placeholder.com/120' }}"
                             class="rounded-circle border mb-3"
                             width="120" height="120"
                             style="object-fit:cover">
                    @endif

                    {{-- Info --}}
                    <h4 class="fw-bold">{{ auth()->user()->ten_hien_thi }}</h4>
                    <p class="text-muted mb-1">{{ auth()->user()->email }}</p>
                    <p class="text-muted mb-1">SĐT: {{ auth()->user()->sdt ?? '---' }}</p>

                    <span class="badge bg-primary mt-2">
                        {{ auth()->user()->vai_tro }}
                    </span>

                    <hr>

                    <a href="{{ route('admin.profile.edit') }}"
                       class="btn btn-primary">
                        <i class="fa fa-edit me-1"></i> Chỉnh sửa
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection