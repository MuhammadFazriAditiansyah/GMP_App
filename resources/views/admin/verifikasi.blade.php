@extends('layout')

@section('content')
    <div class="container-fluid mt-4">
        <div
            class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between flex-wrap">
            <h4 class="mb-3 mb-md-0"><i class="fas fa-list"></i> Daftar Akun Belum Terverifikasi</h4>
        </div>

        @if (session('success'))
            <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3 mt-3" style="z-index: 1100">
                <div class="toast show align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        <div class="table-responsive mt-3">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Departemen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td  style="min-width: 300px;">{{ $user->name }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-start flex-grow-1"
                                    style="min-width: 360px;">
                                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-2"
                                        style="width: 40px; height: 40px; font-weight: bold;">
                                        {{ strtoupper(substr($user->email, 0, 2)) }}
                                    </div>
                                    <span class="text-break">{{ $user->email }}</span>
                                </div>
                            </td>
                            <td>{{ $user->department }}</td>
                            <td>
                                <form action="{{ route('admin.verifikasi.user', $user->id) }}" method="POST"
                                    class="d-inline verify-form">
                                    @csrf
                                    <button type="button" class="btn btn-success btn-sm btn-verify">Verifikasi</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">Semua akun sudah diverifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Verifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin memverifikasi akun ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="confirmBtn">Verifikasi</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.querySelector('.toast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, {
                    delay: 3000,
                    autohide: true
                });
                toast.show();
            }

            let formToSubmit = null;

            document.querySelectorAll('.btn-verify').forEach(button => {
                button.addEventListener('click', function() {
                    formToSubmit = this.closest('form');
                    var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                    confirmModal.show();
                });
            });

            document.getElementById('confirmBtn').addEventListener('click', function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
            });
        });
    </script>
@endsection
