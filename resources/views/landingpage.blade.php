<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMP - App</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #1e1e1e;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 0.8rem 1rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: #198754;
            font-size: 25px;
        }

        .hero {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/image/landing.gif');
            background-size: cover;
            background-position: center;
            padding: 120px 0;
            border-radius: 30px;
            margin: 40px auto;
            max-width: 95%;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        @media (min-width: 768px) {
            .hero h1 {
                font-size: 3.5rem;
            }
        }

        .btn-main {
            background-color: #198754;
            color: #fff;
            padding: 12px 30px;
            font-size: 1rem;
            border: none;
            border-radius: 50px;
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.3);
            transition: all 0.3s;
        }

        .btn-main:hover {
            background-color: #157347;
        }

        .section-title {
            text-align: center;
            margin: 50px 0 30px;
            font-weight: 700;
            color: #198754;
        }

        .footer {
            background: linear-gradient(to right, #157347, #157347);
            padding: 15px 0;
            text-align: center;
            color: #ffffff;
            border-top: none;
            font-weight: 500;
            letter-spacing: 0.5px;
            position: relative;
        }

        .btn-outline-green {
            border-color: #198754;
            color: #198754;
        }

        .btn-outline-green:hover {
            background-color: #198754;
            color: white;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand"><i class="fas fa-seedling me-2" style="color: #228d3b;"></i> GMP App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <div class="d-flex flex-column flex-md-row gap-2 mt-3 mt-md-0">
                    <a href="{{ route('login') }}" class="btn btn-outline-green rounded-pill px-4">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-person-plus-fill me-1"></i> Bergabung
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero text-white">
        <div class="container">
            <h1 class="mb-3">MONITORING <span class="text-warning">GMP</span></h1>
            <h5 class="mb-4">Sistem pencatatan temuan dan perbaikan Good Manufacturing Practices secara digital dan
                real-time.</h5>
            <a href="{{ route('login') }}" class="btn btn-main"> <i class="bi bi-arrow-right-square"></i> Masuk Sekarang</a>
        </div>
    </section>

    <!-- Fitur Utama -->
    <div class="container mt-5">
        <div class="row text-center">
            <div class="col-12 col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <i class="fas fa-search fa-3x text-danger mb-3"></i>
                        <h5 class="card-title">Monitoring</h5>
                        <p class="card-text">Pantau temuan GMP secara real-time.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <i class="fas fa-tasks fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Manajemen</h5>
                        <p class="card-text">Atur dan kelola closing dengan mudah.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Evaluasi</h5>
                        <p class="card-text">Pastikan setiap temuan terselesaikan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container table-responsive pb-5">
        <h2 class="section-title">Daftar Temuan Terbaru</h2>
        <table class="table table-bordered table-hover text-center mx-auto mt-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th style="width: 17%;">Before</th>
                    <th style="width: 17%;">After</th>
                    <th style="width: 12%;">Departemen</th>
                    <th style="width: 12%;">Kriteria GMP</th>
                    <th style="width: 25%;">Deskripsi</th>
                    <th style="width: 10%;">Status</th>
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <th>Aksi</th>
                        @endif
                    @endauth
                </tr>
            </thead>
            <tbody>
                @forelse ($findings as $no => $finding)
                    <tr class="{{ $no % 2 == 0 ? 'table-light' : '' }}">
                        <td class="align-middle">{{ $no + 1 }}</td>
                        <td class="align-middle">
                            @if ($finding->image)
                                <img src="{{ asset('storage/' . $finding->image) }}" width="150"
                                    class="img-thumbnail" data-bs-toggle="tooltip" title="Klik untuk memperbesar"
                                    onclick="showImage('{{ asset('storage/' . $finding->image) }}')">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            @if ($finding->image2)
                                <div class="d-flex flex-column align-items-center">
                                    <img src="{{ asset('storage/' . $finding->image2) }}" width="150"
                                        class="img-thumbnail mb-2" data-bs-toggle="tooltip"
                                        title="Klik untuk memperbesar"
                                        onclick="showImage('{{ asset('storage/' . $finding->image2) }}')">

                                    @auth
                                        @if (auth()->user()->department === $finding->department && $finding->image2)
                                            <a href="{{ route('findings.editPhotoForm', $finding->id) }}"
                                                class="btn btn-sm btn-warning text-white">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            @else
                                @auth
                                    @if (auth()->user()->role === 'user')
                                        <a href="{{ route('findings.uploadPhotoForm', $finding->id) }}"
                                            class="btn btn-sm btn-success">
                                            <i class="fas fa-upload"></i> Upload Foto
                                        </a>
                                    @else
                                        <span class="text-muted">Foto belum diupload</span>
                                    @endif
                                @else
                                    <span class="text-muted">Foto belum diupload</span>
                                @endauth
                            @endif
                        </td>
                        <td class="align-middle">{{ $finding->department }}</td>
                        <td class="align-middle">{{ $finding->gmp_criteria }}</td>
                        <td class="align-middle">{{ $finding->description }}</td>
                        <td class="align-middle">
                            @php
                                $statusClass = $finding->status === 'Open' ? 'btn-danger' : 'btn-success';
                            @endphp

                            @auth
                                @if (auth()->user()->role === 'admin')
                                    <button type="button" class="btn btn-sm {{ $statusClass }}" data-bs-toggle="modal"
                                        data-bs-target="#confirmStatusModal{{ $finding->id }}">
                                        {{ $finding->status }}
                                    </button>
                                    <!-- Modal ubah status -->
                                    <div class="modal fade" id="confirmStatusModal{{ $finding->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Ubah Status</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin mengubah status menjadi
                                                    <strong>{{ $finding->status === 'Open' ? 'Close' : 'Open' }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary me-auto"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('findings.toggleStatus', $finding->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-primary">Ubah</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="btn {{ $statusClass }} btn-sm">{{ $finding->status }}</span>
                                @endif
                            @else
                                <span class="btn {{ $statusClass }} btn-sm">{{ $finding->status }}</span>
                            @endauth
                        </td>

                        @auth
                            @if (auth()->user()->role === 'admin')
                                <td class="align-middle">
                                    <div class="d-flex flex-column flex-md-row justify-content-center">
                                        <a href="{{ route('findings.edit', $finding->id) }}"
                                            class="btn btn-sm me-md-2 mb-2 mb-md-0 p-2"
                                            style="border: 1px solid rgb(255, 149, 0); background-color: white; color: rgb(255, 149, 0);"
                                            onmouseover="this.style.backgroundColor='rgb(255, 149, 0)'; this.style.color='white';"
                                            onmouseout="this.style.backgroundColor='white'; this.style.color='rgb(255, 149, 0)';">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm"
                                            style="border: 1px solid red; background-color: white; color: red;"
                                            onmouseover="this.style.backgroundColor='red'; this.style.color='white';"
                                            onmouseout="this.style.backgroundColor='white'; this.style.color='red';"
                                            data-bs-toggle="modal" data-bs-target="#modalDelete{{ $finding->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="modalDelete{{ $finding->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-danger">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat
                                                    dibatalkan.
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('findings.delete', $finding->id) }}"
                                                        method="POST" class="w-100 d-flex">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-secondary me-auto"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        @endauth
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Data belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} GMP App - All Rights Reserved</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showImage(src) {
            document.getElementById('modalImage').src = src;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }
    </script>
</body>

</html>
