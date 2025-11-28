@extends('layouts.admin')

@section('title', 'Dashboard Admin')
<style>
/* PERKECIL CARD STATISTIK */
.stat-card .card-body {
    padding: 1.2rem !important;   /* dari p-4 menjadi lebih kecil */
}

.stat-card .icon-box {
    padding: 0.8rem !important;   /* kecilkan icon container */
}

.stat-card i {
    font-size: 1.5rem !important; /* icon lebih kecil */
}

.stat-card h2 {
    font-size: 1.8rem !important; /* angka besar lebih kecil */
}

.stat-card h6 {
    font-size: 0.65rem !important; /* label kecil */
}

.stat-card small {
    font-size: 0.7rem !important;
}
</style>

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-2" style="font-size: 2rem; color: #1a1a1a;">
                        <i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1.1rem;">
                        Selamat datang kembali, <span class="fw-semibold text-primary">{{ Auth::user()->name }}</span> 👋
                    </p>
                </div>
                <div class="text-end">
                    <small class="text-muted d-block">{{ date('l, d F Y') }}</small>
                    <small class="text-muted">{{ date('H:i') }} WIB</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <!-- Total Produk -->
        <div class="col-xl-4 col-lg-6">
           <div class="card border-0 shadow-sm h-100 hover-card stat-card">

                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-box-seam text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary">Inventory</span>
                    </div>
                    <h6 class="text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Total Produk</h6>
                    <h2 class="fw-bold mb-0" style="font-size: 2.5rem; color: #1a1a1a;">{{ $totalProduk }}</h2>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-success"><i class="bi bi-arrow-up"></i> Produk tersedia</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Order -->
        <div class="col-xl-4 col-lg-6">
            <div class="card border-0 shadow-sm h-100 hover-card stat-card">

                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-cart-check text-info" style="font-size: 2rem;"></i>
                        </div>
                        <span class="badge bg-info bg-opacity-10 text-info">Transaksi</span>
                    </div>
                    <h6 class="text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Total Order</h6>
                    <h2 class="fw-bold mb-0" style="font-size: 2.5rem; color: #1a1a1a;">{{ $totalOrder }}</h2>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-info"><i class="bi bi-graph-up"></i> Semua pesanan</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Selesai -->
        <div class="col-xl-4 col-lg-6">
            <div class="card border-0 shadow-sm h-100 hover-card stat-card">

                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success">Completed</span>
                    </div>
                    <h6 class="text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Order Selesai</h6>
                    <h2 class="fw-bold mb-0" style="font-size: 2.5rem; color: #1a1a1a;">{{ $orderSelesai }}</h2>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-success"><i class="bi bi-check2"></i> Berhasil diselesaikan</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Proses -->
        <div class="col-xl-4 col-lg-6">
           <div class="card border-0 shadow-sm h-100 hover-card stat-card">

                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-hourglass-split text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-warning">Processing</span>
                    </div>
                    <h6 class="text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Order Proses</h6>
                    <h2 class="fw-bold mb-0" style="font-size: 2.5rem; color: #1a1a1a;">{{ $orderProses }}</h2>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-warning"><i class="bi bi-clock-history"></i> Sedang diproses</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Admin -->
        <div class="col-xl-4 col-lg-6">
           <div class="card border-0 shadow-sm h-100 hover-card stat-card">

                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-dark bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-person-gear text-dark" style="font-size: 2rem;"></i>
                        </div>
                        <span class="badge bg-dark bg-opacity-10 text-dark">Management</span>
                    </div>
                    <h6 class="text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Total Admin</h6>
                    <h2 class="fw-bold mb-0" style="font-size: 2.5rem; color: #1a1a1a;">{{ $totalAdmin }}</h2>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-dark"><i class="bi bi-shield-check"></i> Administrator aktif</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total User -->
        <div class="col-xl-4 col-lg-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-secondary bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-people text-secondary" style="font-size: 2rem;"></i>
                        </div>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary">Customers</span>
                    </div>
                    <h6 class="text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Total User</h6>
                    <h2 class="fw-bold mb-0" style="font-size: 2.5rem; color: #1a1a1a;">{{ $totalUser }}</h2>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-secondary"><i class="bi bi-person-check"></i> Pengguna terdaftar</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-lightning-charge text-warning me-2"></i>Quick Actions
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.product.index') }}" class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center quick-action-btn">
                                <i class="bi bi-plus-circle fs-3 mb-2"></i>
                                <span>Tambah Produk</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-info w-100 py-3 d-flex flex-column align-items-center quick-action-btn">
                                <i class="bi bi-card-list fs-3 mb-2"></i>
                                <span>Kelola Orderan </span>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-success w-100 py-3 d-flex flex-column align-items-center quick-action-btn">
                                <i class="bi bi-bar-chart fs-3 mb-2"></i>
                                <span>Lihat Laporan</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100 py-3 d-flex flex-column align-items-center quick-action-btn">
                                <i class="bi bi-people fs-3 mb-2"></i>
                                <span>Kelola Admin</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
}

.icon-box {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.quick-action-btn {
    transition: all 0.3s ease;
    border-width: 2px;
}

.quick-action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
}

.card {
    border-radius: 1rem !important;
}

@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
@endsection