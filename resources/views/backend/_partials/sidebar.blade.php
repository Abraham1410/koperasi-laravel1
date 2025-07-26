<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ route('home') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-success"><i class="fa fa-hashtag me-2"></i>KOPERASI</h3>
        </a>

        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('assets/backend/img/' . auth()->user()->image) }}" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                <span>{{ auth()->user()->roles->pluck('name')->implode(', ') }}</span>
            </div>
        </div>

        <div class="navbar-nav w-100">
            <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->is('home*') ? 'active' : '' }}">
                <i class="fa fa-home bg-white text-dark rounded-circle p-2 me-2"></i>Dashboard
            </a>

            @can('user-list')
            <a href="{{ route('user') }}" class="nav-item nav-link {{ request()->is('users*') ? 'active' : '' }}">
                <i class="fa fa-user bg-white text-dark rounded-circle p-2 me-2"></i>User
            </a>
            @endcan

            @can('nasabah-list')
            <a href="{{ route('nasabah') }}" class="nav-item nav-link {{ request()->is('nasabah*') ? 'active' : '' }}">
                <i class="fa fa-users bg-white text-dark rounded-circle p-2 me-2"></i>Anggota
            </a>
            @endcan

            @can('simpanan-list')
            <a href="{{ route('simpanan') }}" class="nav-item nav-link {{ request()->is('simpanan*') ? 'active' : '' }}">
                <i class="fa fa-money-bill-wave bg-white text-dark rounded-circle p-2 me-2"></i>Simpanan
            </a>
            @endcan

            @can('pinjaman-list')
            <a href="{{ route('pinjaman') }}" class="nav-item nav-link {{ request()->is('pinjaman*') ? 'active' : '' }}">
                <i class="fa fa-hand-holding-usd bg-white text-dark rounded-circle p-2 me-2"></i>Pinjaman
            </a>
            @endcan

            @can('penarikan-list')
            <a href="{{ route('penarikan') }}" class="nav-item nav-link {{ request()->is('penarikan*') ? 'active' : '' }}">
                <i class="fa fa-cash-register bg-white text-dark rounded-circle p-2 me-2"></i>Penarikan
            </a>
            @endcan

            @can('akun-list')
            <a href="{{ route('akun.index') }}" class="nav-item nav-link {{ request()->is('akun*') ? 'active' : '' }}">
                <i class="fa fa-book bg-white text-dark rounded-circle p-2 me-2"></i>Daftar Akun
            </a>
            @endcan

            @can('saldo-awal-list')
            <a href="{{ route('saldo-awal.index') }}" class="nav-item nav-link {{ request()->is('saldo-awal*') ? 'active' : '' }}">
                <i class="fa fa-wallet bg-white text-dark rounded-circle p-2 me-2"></i>Saldo Awal
            </a>
            @endcan

            @can('laporan_list')
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-file-alt bg-white text-dark rounded-circle p-2 me-2"></i>Laporan
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('laporan.jurnal_umum') }}" class="dropdown-item">Jurnal Umum</a>
                    <a href="{{ route('laporan.buku_besar') }}" class="dropdown-item">Buku Besar</a>
                    <a href="{{ route('laporan.neraca_saldo') }}" class="dropdown-item">Neraca Saldo</a>
                    <a href="{{ route('laporan.lphu') }}" class="dropdown-item">LPHU</a>
                    <a href="{{ route('laporan.neraca') }}" class="dropdown-item">Neraca</a>
                    <a href="{{ route('laporan.arus_kas') }}" class="dropdown-item">Arus Kas</a>
                </div>
            </div>
            @endcan


            @can('role-list')
            <a href="{{ url('show-roles') }}" class="nav-item nav-link {{ request()->is('show-roles*') ? 'active' : '' }}">
                <i class="fa fa-user-shield bg-white text-dark rounded-circle p-2 me-2"></i>Role
            </a>
            @endcan
        </div>
    </nav>
</div>
