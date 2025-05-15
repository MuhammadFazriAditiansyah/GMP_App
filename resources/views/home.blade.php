@extends('layout')

@section('content')
    <div class="container mt-5">
        <div class="container">
            @if (Session::get('success'))
                <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3 mt-3">
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Success</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif
            @if (Session::get('error'))
                <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3 mt-3">
                    <div class="toast show bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Error</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            {{ session('error') }} <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                </div>
            @endif
            @if (Session::get('canAccess'))
                <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3 mt-3">
                    <div class="toast show bg-warning text-dark" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Peringatan</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            {{ Session::get('canAccess') }}<i class="bi bi-exclamation-triangle-fill ms-2"></i>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="jumbotron text-center bg-success text-white p-5 rounded shadow-lg w-100">
            <div class="d-flex align-items-center justify-content-center mb-3">
                <h1 class="display-4 fw-bold mb-0">
                    Selamat Datang <span class="text-warning">{{ Auth::user()->name }}</span>
                </h1>
            </div>
            <p class="lead">Kelola data GMP dengan mudah, cepat, dan efisien.</p>
            <hr class="my-4 border-light">
            <p class="fs-5">Pantau dan kelola temuan serta penutupan dengan sistem yang terintegrasi.</p>
            <div class="d-grid gap-2 d-md-flex justify-content-center mt-4">
                <a href="{{ route('findings.index') }}" class="btn btn-warning btn-lg shadow">Lihat Temuan dan Closing</a>
            </div>
        </div>
    </div>

    {{-- Fitur Utama --}}
    <div class="container mt-5 pb-5">
        <div class="row text-center">
            <div class="col-12 col-md-4 mb-3">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <i class="fas fa-search fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Monitoring</h5>
                        <p class="card-text">Pantau temuan GMP secara real-time.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <i class="fas fa-tasks fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Manajemen</h5>
                        <p class="card-text">Atur dan kelola closing dengan mudah.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Evaluasi</h5>
                        <p class="card-text">Pastikan setiap temuan terselesaikan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alasan Memilih --}}
    <div class="container mt-2 mb-5">
        <div class="text-center">
            <h2 class="fw-bold text-success">Mengapa Memilih GMP App?</h2>
            <p class="fs-5 text-muted">Aplikasi kami dirancang untuk mempermudah pengelolaan GMP dengan fitur-fitur
                unggulan.</p>
        </div>
        <div class="row mt-4 align-items-center">
            <div class="col-12 col-md-6 d-none d-md-block">
                <img src="{{ asset('image/animasi1.gif') }}" class="img-fluid" style="margin-left: 60px;"
                    alt="GMP App Illustration">
            </div>
            <div class="col-12 col-md-6">
                <ul class="list-group list-group-flush fs-5">
                    <li class="list-group-item"><i class="fas fa-check text-success"></i> Antarmuka yang intuitif dan mudah
                        digunakan</li>
                    <li class="list-group-item"><i class="fas fa-check text-success"></i> Data tersimpan dengan aman dan
                        terenkripsi</li>
                    <li class="list-group-item"><i class="fas fa-check text-success"></i> Akses kapan saja dan di mana saja
                    </li>
                    <li class="list-group-item"><i class="fas fa-check text-success"></i> Notifikasi dan pengingat otomatis
                    </li>
                </ul>
                <div class="mt-4 d-flex justify-content-center">
                    <a href="{{ route('findings.index') }}" class="btn btn-lg btn-success shadow px-4">Mulai Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        //toast notification
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua elemen toast
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            // Aktifkan dan atur timeout
            toastElList.forEach(function(toastEl) {
                var toast = new bootstrap.Toast(toastEl, {
                    delay: 3000, // waktu delay dalam milidetik (3 detik)
                    autohide: true // supaya otomatis hide
                });
                toast.show();
            });
        });
    </script>
@endsection
