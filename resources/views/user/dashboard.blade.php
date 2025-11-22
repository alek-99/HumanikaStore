@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">

    <!-- Welcome Section -->
    <div class="welcome-banner mb-4 p-4 rounded-4 bg-gradient text-gray-500 position-relative overflow-hidden">
        <div class="position-relative" style="z-index: 2;">
            <h4 class="fw-bold mb-2 fs-5 fs-md-4">Halo  Selamat datang, {{ Auth::check() ? Auth::user()->name : 'Tamu' }}</h4>
            <p class="mb-0 opacity-90 small">Selamat berbelanja & nikmati pengalaman terbaik.</p>
        </div>
        <div class="position-absolute top-0 end-0 opacity-20" style="font-size: 6rem; margin-top: -0.5rem; margin-right: -0.5rem;">
            <i class="bi bi-bag-heart"></i>
        </div>
    </div>

 <!-- Single Stats Card -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">

        <h5 class="fw-bold text-primary mb-4">Ringkasan Order</h5>

        <div class="row text-center g-4">

            <!-- Diproses -->
            <div class="col-4">
                <div class="d-flex flex-column align-items-center">
                    <div class="p-3 rounded-circle bg-warning bg-opacity-25 mb-2">
                        <i class="bi bi-gear-wide-connected text-warning fs-4"></i>
                    </div>
                    <h6 class="text-uppercase text-muted small mb-1" style="letter-spacing: .5px;">Diproses</h6>
                    <h3 class="fw-bold mb-0">{{ $orderProses }}</h3>
                    <small class="text-muted">Order Proses</small>
                </div>
            </div>

            <!-- Pending -->
            <div class="col-4 border-start border-end">
                <div class="d-flex flex-column align-items-center">
                    <div class="p-3 rounded-circle bg-warning bg-opacity-25 mb-2">
                        <i class="bi bi-clock-history text-warning fs-4"></i>
                    </div>
                    <h6 class="text-uppercase text-muted small mb-1" style="letter-spacing: .5px;">Pending</h6>
                    <h3 class="fw-bold mb-0">{{ $orderPending }}</h3>
                    <small class="text-muted">Order Pending</small>
                </div>
            </div>

            <!-- Selesai -->
            <div class="col-4">
                <div class="d-flex flex-column align-items-center">
                    <div class="p-3 rounded-circle bg-success bg-opacity-25 mb-2">
                        <i class="bi bi-check-circle text-success fs-4"></i>
                    </div>
                    <h6 class="text-uppercase text-muted small mb-1" style="letter-spacing: .5px;">Selesai</h6>
                    <h3 class="fw-bold mb-0">{{ $produkDibeli }}</h3>
                    <small class="text-muted">Order Selesai</small>

                    <a href="{{ route('user.orders.index') }}"
                       class="btn btn-sm btn-outline-success rounded-pill mt-3 px-3">
                        <i class="bi bi-list-check me-1"></i>Riwayat
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>


    <!-- Menu Cepat & Kontak -->
    <div class="row g-3 mb-4">
        <!-- Menu Cepat -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body p-3 p-md-4">
                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                        <i class="bi bi-grid-3x3-gap-fill text-primary me-2"></i> 
                        <span>Menu Cepat</span>
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('user.produk.index') }}" class="quick-menu-link text-decoration-none d-block">
                                <div class="quick-menu-card p-3 rounded-3 text-center h-100">
                                    <div class="icon-circle bg-primary bg-opacity-10 rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart-plus text-primary"></i>
                                    </div>
                                    <small class="fw-semibold text-dark d-block">Belanja</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('user.orders.index') }}" class="quick-menu-link text-decoration-none d-block">
                                <div class="quick-menu-card p-3 rounded-3 text-center h-100">
                                    <div class="icon-circle bg-success bg-opacity-10 rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-box-seam text-success"></i>
                                    </div>
                                    <small class="fw-semibold text-dark d-block">Pesanan</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="" class="quick-menu-link text-decoration-none d-block">
                                <div class="quick-menu-card p-3 rounded-3 text-center h-100">
                                    <div class="icon-circle bg-warning bg-opacity-10 rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart3 text-warning"></i>
                                    </div>
                                    <small class="fw-semibold text-dark d-block">Keranjang</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('profile.edit') }}" class="quick-menu-link text-decoration-none d-block">
                                <div class="quick-menu-card p-3 rounded-3 text-center h-100">
                                    <div class="icon-circle bg-info bg-opacity-10 rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-circle text-info"></i>
                                    </div>
                                    <small class="fw-semibold text-dark d-block">Profil</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hubungi Kami -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body p-3 p-md-4">
                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                        <i class="bi bi-telephone-fill text-success me-2"></i> 
                        <span>Hubungi Kami</span>
                    </h5>
                    
                    <div class="contact-list">
                        <div class="contact-item d-flex align-items-center mb-3 p-2 rounded-3">
                            <div class="contact-icon bg-primary bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-whatsapp text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block mb-1">WhatsApp</small>
                                <a href="https://wa.me/6281234567890" class="text-dark fw-semibold text-decoration-none hover-link">
                                    +62 812-3456-7890
                                </a>
                            </div>
                        </div>

                       <div class="contact-item d-flex align-items-start mb-3 p-3 rounded-3 border bg-white shadow-sm">
    <!-- Icon -->
    <div class="contact-icon bg-info bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center" 
         style="width: 45px; height: 45px;">
        <i class="bi bi-envelope text-info fs-5"></i>
    </div>

    <!-- Content -->
    <div>
        <small class="text-muted d-block mb-1">Email</small>
        <a href="mailto:info@humanikastore.com" 
           class="text-dark fw-semibold text-decoration-none hover-link">
            info@humanikastore.com
        </a>

        <p class="text-muted mb-0 mt-2" style="font-size: 0.9rem;">
            Atau kunjungi Sekretariat HUMANIKA di <br>
            <span class="fw-semibold text-dark">Kampus 2 UNBAJA</span>
        </p>
    </div>
</div>


                        <div class="mt-4 pt-3 border-top">
                            <small class="text-muted d-block mb-2 fw-semibold">Ikuti Kami</small>
                            <div class="d-flex gap-2">
                                <a href="#" class="social-link btn btn-sm btn-outline-primary rounded-circle">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="#" class="social-link btn btn-sm btn-outline-danger rounded-circle">
                                    <i class="bi bi-instagram"></i>
                                </a>
                                <a href="#" class="social-link btn btn-sm btn-outline-info rounded-circle">
                                    <i class="bi bi-twitter"></i>
                                </a>
                                <a href="#" class="social-link btn btn-sm btn-outline-success rounded-circle">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Promo -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm promo-card bg-primary bg-opacity-10 h-100 rounded-4">
                <div class="card-body d-flex align-items-center p-3 p-md-4">
                    <div class="promo-icon me-3">
                        <i class="bi bi-gift text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Promo Spesial</h6>
                        <small class="text-muted d-block">Dapatkan Promo Menarik Di Humanika Store</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm promo-card bg-success bg-opacity-10 h-100 rounded-4">
                <div class="card-body d-flex align-items-center p-3 p-md-4">
                    <div class="promo-icon me-3">
                        <i class="bi bi-truck text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Gratis Ongkir</h6>
                        <small class="text-muted d-block">Untuk pengiriman Area Kampus Unabaja</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- CSS --}}
<style>
/* Welcome Banner */
.welcome-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
}

/* Statistics Cards */
.stat-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 1rem !important;
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15) !important;
}

.icon-wrapper {
    width: 60px;
    height: 60px;
    transition: all 0.3s ease;
}

.icon-wrapper i {
    font-size: 1.75rem;
}

.stat-card:hover .icon-wrapper {
    transform: scale(1.15) rotate(5deg);
}

/* Button Actions */
.btn-action {
    transition: all 0.3s ease;
    font-weight: 600;
}

.btn-action:hover {
    transform: scale(1.05);
}

/* Quick Menu */
.quick-menu-card {
    background: #f8f9fa;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.quick-menu-link:hover .quick-menu-card {
    background: white;
    border-color: #e9ecef;
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.icon-circle {
    width: 55px;
    height: 55px;
    transition: all 0.3s ease;
}

.icon-circle i {
    font-size: 1.5rem;
}

.quick-menu-link:hover .icon-circle {
    transform: scale(1.1);
}

/* Contact Section */
.contact-item {
    transition: all 0.3s ease;
}

.contact-item:hover {
    background: #f8f9fa;
    transform: translateX(5px);
}

.contact-icon {
    width: 45px;
    height: 45px;
}

.contact-icon i {
    font-size: 1.25rem;
}

.hover-link {
    transition: all 0.3s ease;
}

.hover-link:hover {
    color: #0d6efd !important;
    padding-left: 5px;
}

/* Social Links */
.social-link {
    width: 38px;
    height: 38px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.social-link:hover {
    transform: translateY(-3px) scale(1.1);
}

/* Promo Cards */
.promo-card {
    transition: all 0.3s ease;
}

.promo-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
}

.promo-icon i {
    font-size: 3rem;
}

/* Card Styling */
.card {
    border-radius: 1rem !important;
}

/* Responsive Mobile */
@media (max-width: 576px) {
    .stat-card h3 { 
        font-size: 1.75rem; 
    }
    
    .icon-wrapper { 
        width: 50px; 
        height: 50px; 
    }
    
    .icon-wrapper i { 
        font-size: 1.4rem !important; 
    }
    
    .icon-circle {
        width: 45px;
        height: 45px;
    }
    
    .icon-circle i {
        font-size: 1.2rem !important;
    }
    
    .promo-icon i {
        font-size: 2.25rem;
    }
    
    .contact-icon {
        width: 40px;
        height: 40px;
    }
    
    .contact-icon i {
        font-size: 1.1rem;
    }
    
    .quick-menu-card {
        padding: 0.75rem !important;
    }
    
    h5 {
        font-size: 1.1rem;
    }
    
    .social-link {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }
}

@media (min-width: 768px) {
    .icon-wrapper {
        width: 70px;
        height: 70px;
    }
    
    .icon-wrapper i {
        font-size: 2rem !important;
    }
}

/* Smooth Animations */
* {
    -webkit-tap-highlight-color: transparent;
}

.card, .btn, .quick-menu-card, .contact-item {
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
}
</style>

@endsection