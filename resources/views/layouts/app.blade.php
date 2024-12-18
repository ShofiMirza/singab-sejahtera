<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiNgab Sejahtera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8fafc;
        }
        main {
            flex: 1;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .bg-primary {
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            border: none;
        }
        .text-primary {
            color: #2563eb !important;
        }
        .border-primary {
            border-color: #2563eb !important;
        }
        footer {
            background-color: #f0f9ff !important;
            border-top: 1px solid #e5e7eb;
        }
        .nav-link {
            position: relative;
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0.5rem;
            right: 0.5rem;
            height: 2px;
            background-color: #fff;
            border-radius: 1px;
        }
        .btn {
            border-radius: 0.5rem;
        }
        .card {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-house-heart-fill me-2"></i>
                SiNgab Sejahtera
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    @if(auth()->user()->role == 'Admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('keluarga.*') ? 'active' : '' }}" href="{{ route('keluarga.index') }}">Data Keluarga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">Data User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('detail-bantuan.history') ? 'active' : '' }}" href="{{ route('detail-bantuan.history') }}">Riwayat Pembangunan</a>
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Logout</button>
                        </form>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="bg-light py-3">
        <div class="container text-center">
            <small>&copy; 2024 SiNgab Sejahtera. All rights reserved.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    @stack('scripts')
</body>
</html> 