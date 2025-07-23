<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Anggota - Koperasi Merah Putih')</title>

    <!-- Bootstrap & Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-image: url('{{ asset('src/bg-ketabang.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="font-sans text-[#333] flex flex-col min-h-screen bg-white/50">

    <!-- Header -->
    <header class="text-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold">KOPERASI</h2>
            <div class="ms-auto">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->nama ?? 'John Doe' }}
                            <svg id="chevronIcon" class="ms-1" style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('anggota.profile.edit') }}">Profile</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-sm text-white">
        &copy; {{ date('Y') }} Kantor Kelurahan Ketabang. Kelurahan Ketabang, Kecamatan Genteng, Surabaya.
    </footer>

    <script>
        const dropdownToggle = document.getElementById('navbarDropdown');
        const chevronIcon = document.getElementById('chevronIcon');

        dropdownToggle?.addEventListener('click', function () {
            setTimeout(() => {
                const isExpanded = dropdownToggle.getAttribute('aria-expanded') === 'true';
                chevronIcon.style.transform = isExpanded ? 'rotate(180deg)' : 'rotate(0deg)';
            }, 100);
        });
    </script>
</body>
</html>
