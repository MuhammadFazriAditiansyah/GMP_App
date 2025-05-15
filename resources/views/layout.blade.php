<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>GMP - App</title>
    <style>
        html,
        body {
            height: 100%;
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            flex: 1;
        }

        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            font-size: 18px;
            /* Ukuran teks lebih besar */
            font-weight: 500;
            color: #333 !important;
            transition: color 0.3s ease-in-out;
        }

        .nav-link:hover {
            color: #28a745 !important;
        }

        .navbar-brand {
            font-size: 22px;
            /* Ukuran teks untuk brand */
            font-weight: bold;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 600;
        }

        /* Footer Styles */
        .footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-top: auto;
            border-top: 1px solid #ddd;
        }

        .footer a {
            color: #28a745;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg align-items-center">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" style="font-size: 26px;">
                <i class="fas fa-seedling me-2" style="color: #28a745;"></i> GMP App
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="{{ route('findings.index') }}"><i class="fas fa-list"></i> Data
                            Finding & Closing</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="{{ route('user.index') }}"><i class="fas fa-user"></i> Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">
        @yield('content')
    </div>

    @stack('scripts')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} GMP App. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
