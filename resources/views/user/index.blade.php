@extends('layout')

@section('content')
    <style>
        .profile-card,
        .edit-form {
            min-height: 100%;
            border-radius: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #fff;
            /* Memberikan border putih */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-label i {
            margin-right: 6px;
        }

        .badge-role {
            font-size: 1rem;
            background: linear-gradient(to right, #00b09b, #96c93d);
            color: white;
            border-radius: 12px;
            padding: 10px 30px;
            text-align: center;
            margin-top: 10px;
        }

        .badge-department {
            font-size: 1rem;
            background: linear-gradient(to right, #4CAF50, #8BC34A);
            color: white;
            border-radius: 12px;
            padding: 8px 30px;
            text-align: center;
            margin-top: 10px;
        }

        .form-section {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .profile-card-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Memastikan konten berada di tengah */
            align-items: center;
            /* Memusatkan konten */
            text-align: center;
            padding: 20px;
        }

        .logout-btn {
            width: auto;
            border-radius: 12px;
            color: red;
            background: transparent;
            border: 2px solid red;
            padding: 5px 20px;
            margin-top: 20px;
        }

        .logout-btn:hover {
            color: white;
            background-color: red;
        }

        .profile-avatar-container {
            position: relative;
            display: inline-block;
        }

        .online-status {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #4CAF50;
            border-radius: 50%;
            width: 15px;
            height: 15px;
            border: 2px solid white;
        }

        .profile-card-content h4,
        .profile-card-content p {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .alert {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            padding: 10px;
        }
    </style>

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

    <div class="container mt-5 pb-5">
        <div class="row justify-content-center align-items-stretch g-4">
            {{-- Profil Card --}}
            <div class="col-lg-5 d-flex">
                <div class="card p-4 profile-card w-100 d-flex flex-column">
                    {{-- Konten Profil --}}
                    <div class="profile-card-content">
                        <div class="profile-avatar-container mb-4 mt-1">
                            <!-- Foto Profil -->
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=ffc107&color=000&size=128"
                                alt="Avatar" class="profile-avatar">
                        </div>

                        <h3 class="fw-bold mb-1">{{ auth()->user()->name }}</h3>
                        <p class="text-muted mb-2" style="font-size: 18px;">{{ auth()->user()->email }}</p>

                        {{-- Role --}}
                        <span class="badge badge-role mx-auto mt-1">
                            {{ ucfirst(auth()->user()->department) }}
                        </span>
                    </div>

                    {{-- Tombol Logout --}}
                    <form action="{{ route('logout') }}" method="POST" class="mt-auto text-center">
                        @csrf
                        <button type="submit" class="logout-btn" style="margin-bottom: 65px;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            {{-- Form Edit --}}
            <div class="col-lg-7 d-flex">
                <div class="card p-4 shadow-sm edit-form w-100 form-section">
                    <div>
                        <form action="{{ route('user.update', auth()->user()->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-user"></i> Nama</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }} "
                                    class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control border-end-0"
                                        placeholder="biarkan kosong jika tidak diubah">
                                    <span class="input-group-text bg-white border-start-0"
                                        style="border-left: none; cursor: pointer;" id="togglePassword">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-building"></i> Departemen</label>
                                <select name="department" class="form-control" required>
                                    @if (auth()->user()->department === 'Produksi')
                                        <option value="produksi"
                                            {{ auth()->user()->department == 'produksi' ? 'selected' : '' }}>Produksi
                                        </option>
                                    @elseif (auth()->user()->department === 'Warehouse')
                                        <option value="warehouse"
                                            {{ auth()->user()->department == 'warehouse' ? 'selected' : '' }}>Warehouse
                                        </option>
                                    @elseif (auth()->user()->department === 'Engineering')
                                        <option value="engineering"
                                            {{ auth()->user()->department == 'engineering' ? 'selected' : '' }}>Engineering
                                        </option>
                                    @elseif (auth()->user()->department === 'HR')
                                        <option value="HR" {{ auth()->user()->department == 'HR' ? 'selected' : '' }}>
                                            HR</option>
                                    @elseif (auth()->user()->department === 'QA')
                                        <option value="QA" {{ auth()->user()->department == 'QA' ? 'selected' : '' }}>
                                            QA</option>
                                    @endif
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-user-tag"></i> Role</label>
                                <select name="role" class="form-control" required>
                                    @if (auth()->check() && auth()->user()->role === 'admin')
                                        <option value="admin" {{ auth()->user()->role == 'admin' ? 'selected' : '' }}>
                                            Admin
                                        </option>
                                    @endif
                                    @if (auth()->check() && auth()->user()->role === 'user')
                                        <option value="user" {{ auth()->user()->role == 'user' ? 'selected' : '' }}>User
                                        </option>
                                    @endif
                                    @if (auth()->check() && auth()->user()->role === 'guest')
                                        <option value="guest" {{ auth()->user()->role == 'guest' ? 'selected' : '' }}>
                                            Guest
                                        </option>
                                    @endif
                                </select>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-success px-4">
                                    <i class="fas fa-save "></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
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


        // toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    </script>
@endsection
 