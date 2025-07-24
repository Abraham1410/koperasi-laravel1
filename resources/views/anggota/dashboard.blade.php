<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Anggota - Koperasi Merah Putih</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="font-sans bg-[#f4f4f4] text-[#333] flex flex-col min-h-screen bg-white/50" style="background-image: url('{{ asset('src/bg-ketabang.jpg') }}'); background-size: cover; background-position: center;">

    <!-- Header -->
    <header class="text-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
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
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
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
        <!-- Logo-only Content -->
        <section class="pt-36 pb-2">
            <div class="max-w-4xl mx-auto px-6 flex justify-center items-center">
                <h1 class="text-4xl md:text-5xl font-semibold flex items-center gap-x-2
                        text-white drop-shadow-lg">
                    <i class="fa fa-hashtag"></i>
                    KOPERASI MERAH PUTIH
                </h1>
            </div>
        </section>

        <section class="py-4 max-w-6xl mx-auto px-6 grid">
            <div class="col-span-full flex justify-center">
                <div class="bg-blue-100 border text-blue-800 p-4 rounded-2xl mb-6 w-full max-w-md text-center">
                    <h2 class="text-xl font-semibold">Saldo Anda Saat Ini</h2>
                    <p class="text-xl">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
                </div>
            </div>
        </section>

        <!-- Info Boxes -->
        <section class="pb-16 flex-grow">
            <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8 px-6">
                <!-- Simpanan -->
                <a href="{{ route('anggota.simpanan.index') }}" class="block !no-underline bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300 hover:bg-gray-50">
                    <div class="flex items-center gap-4 mb-2">
                        <i class="fas fa-money-bill-wave bg-white text-gray-800 rounded-full p-3 shadow"></i>
                        <h3 class="text-xl font-semibold text-black">Simpanan</h3>
                    </div>
                    <p class="text-gray-600">Kelola simpanan Anda secara langsung melalui platform.</p>
                </a>

                <!-- Pinjaman -->
                <a href="{{ route('anggota.pinjaman.index') }}" class="block !no-underline bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300 hover:bg-gray-50">
                    <div class="flex items-center gap-4 mb-2">
                        <i class="fas fa-hand-holding-usd bg-white text-gray-800 rounded-full p-3 shadow"></i>
                        <h3 class="text-xl font-semibold text-black">Pinjaman</h3>
                    </div>
                    <p class="text-gray-600">Ajukan pinjaman koperasi secara cepat dan aman.</p>
                </a>

                <!-- Penarikan -->
                <a href="{{ route('anggota.penarikan.index') }}" class="block !no-underline bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300 hover:bg-gray-50">
                    <div class="flex items-center gap-4 mb-2">
                        <i class="fas fa-cash-register bg-white text-gray-800 rounded-full p-3 shadow"></i>
                        <h3 class="text-xl font-semibold text-black">Penarikan</h3>
                    </div>
                    <p class="text-gray-600">Lakukan penarikan dana dengan cepat dan efisien.</p>
                </a>
            </div>
        </section>
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
