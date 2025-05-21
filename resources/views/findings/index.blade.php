@extends('layout')

@section('content')

    <div class="d-flex flex-wrap mt-4 container align-items-center justify-content-between">
        <h4 class="mt-1"><i class="fas fa-list"></i> Data Finding & Closing</h4>
    </div>

    <div class="container">
        @if (Session::get('success'))
            <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3 mt-3">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('success') }} <i class="fas fa-check-circle me-2"></i>
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
    </div>

    @auth
        @if (auth()->user()->role === 'admin')
            <div class="container mt-2">
                <div class="row">
                    <!-- Total Finding -->
                    <div class="col-md-4 mb-4">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $countFindings }}</h3>
                                <p>Total Finding</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Closing -->
                    <div class="col-md-4 mb-4">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $countStatus }}</h3>
                                <p>Total Closing</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total User -->
                    <div class="col-md-4 mb-4">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $countUsers }}</h3>
                                <p>Total User</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <div class="d-flex flex-wrap container align-items-center justify-content-between">
        <form method="GET" action="{{ route('findings.index') }}" class="d-flex gap-2 flex-wrap align-items-center"
            id="searchForm">
            <select name="year" onchange="this.form.submit()" class="form-select rounded-pill shadow-sm"
                style="width: 90px; height: 42px;">
                @foreach ($years as $y)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>

            <select name="week" class="form-select rounded-pill shadow-sm" style="width: 170px; height: 42px;">
                <option value="">Semua Minggu</option>
                @for ($i = 1; $i <= 52; $i++)
                    <option value="{{ $i }}" {{ request('week') == $i ? 'selected' : '' }}>Week
                        {{ $i }}</option>
                @endfor
            </select>

            <select name="department" id="department" class="form-select rounded-pill shadow-sm"
                style="width: 210px; height: 42px;">
                <option value="">Semua Departemen</option>
                @foreach (['Produksi', 'Warehouse', 'Engineering', 'HR', 'QA'] as $dept)
                    <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                        {{ $dept }}</option>
                @endforeach
            </select>

            <button type="submit" id="searchBtn"
                class="btn btn-dark rounded-pill px-4 py-2 shadow-sm d-flex align-items-center gap-2" style="height: 42px;">
                <span id="searchText"><i class="fas fa-search"></i></span>
                <span id="searchSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                    aria-hidden="true"></span>
            </button>
        </form>

        <div class="d-flex gap-2 mt-3 mt-md-0">
            @auth
                @if (auth()->user()->role === 'user' || auth()->user()->role === 'admin')
                    <a href="{{ route('findings.exportPDF', ['week' => request('week'), 'department' => request('department')]) }}"
                        id="exportPdfBtn"
                        class="btn btn-danger rounded-pill px-4 py-2 shadow-sm d-flex align-items-center gap-2">
                        <span id="exportPdfText"><i class="fas fa-file-pdf"></i> PDF</span>
                        <span id="exportPdfSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('findings.export', ['week' => request('week'), 'department' => request('department')]) }}"
                        id="exportExcelBtn"
                        class="btn btn-success rounded-pill px-4 py-2 shadow-sm d-flex align-items-center gap-2">
                        <span id="exportExcelText"><i class="fas fa-file-excel"></i> Excel</span>
                        <span id="exportExcelSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                    </a>
                @endif

                @if (auth()->user()->role === 'admin')
                    <a class="btn btn-primary rounded-pill px-4 py-2 shadow-sm d-flex align-items-center gap-2"
                        href="{{ route('findings.create') }}">
                        <i class="fas fa-plus"></i>Tambah Finding
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <div class="container table-responsive pb-5">
        <table class="table table-bordered table-hover text-center mx-auto mt-1">
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
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <style>
        .small-box {
            position: relative;
            display: block;
            background: #17a2b8;
            /* default info */
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .small-box:hover {
            transform: translateY(-3px);
        }

        .small-box .inner h3 {
            font-size: 28px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }

        .small-box .inner p {
            font-size: 16px;
            margin: 0;
        }

        .small-box .icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 50px;
            opacity: 0.3;
        }

        .small-box-footer {
            display: block;
            padding-top: 10px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: bold;
        }

        .bg-info {
            background-color: #17a2b8 !important;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }


        .toast-container {
            max-width: 600px;
        }

        .toast {
            width: 100%;
        }

        #searchBtn {
            background: linear-gradient(45deg, #000000, #0063c6);
            border: none;
            color: white;
            transition: background 0.3s ease, opacity 0.3s ease;
        }

        #searchBtn:hover {
            opacity: 0.85;
        }
    </style>

    <script>
        function showImage(src) {
            document.getElementById('modalImage').src = src;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.forEach(function(toastEl) {
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 3000,
                    autohide: true
                });
                toast.show();
            });

            handleExport('searchBtn', 'searchText', 'searchSpinner');
            handleExport('exportPdfBtn', 'exportPdfText', 'exportPdfSpinner');
            handleExport('exportExcelBtn', 'exportExcelText', 'exportExcelSpinner');
        });

        function handleExport(buttonId, textId, spinnerId) {
            const button = document.getElementById(buttonId);
            if (!button) return;

            button.addEventListener('click', function() {
                document.getElementById(textId)?.classList.add('d-none');
                document.getElementById(spinnerId)?.classList.remove('d-none');
                button.classList.add('disabled');

                setTimeout(function() {
                    document.getElementById(textId)?.classList.remove('d-none');
                    document.getElementById(spinnerId)?.classList.add('d-none');
                    button.classList.remove('disabled');
                }, 900);
            });
        }
    </script>

@endsection
