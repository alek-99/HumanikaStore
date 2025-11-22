@extends('layouts.user')

@section('title', $product->name)

@push('style')
<style>
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
    }

    .product-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 1rem;
        animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Breadcrumb */
    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--gray-500);
        margin-bottom: 1.5rem;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .breadcrumb-nav::-webkit-scrollbar {
        display: none;
    }

    .breadcrumb-nav a {
        color: var(--gray-500);
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb-nav a:hover {
        color: var(--primary);
    }

    .breadcrumb-nav span {
        color: var(--gray-800);
        font-weight: 500;
    }

    /* Product Layout */
    .product-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: start;
    }

    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
    }

    /* Product Image */
    .product-gallery {
        position: sticky;
        top: 8rem;
    }

    @media (max-width: 768px) {
        .product-gallery {
            position: static;
            margin-bottom: 1rem;
        }
    }

    .main-image {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
        border-radius: 16px;
        background: var(--gray-100);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .main-image:hover {
        transform: scale(1.02);
    }

    .image-placeholder {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .image-placeholder svg {
        width: 64px;
        height: 64px;
        color: var(--gray-400);
    }

    /* Product Info */
    .product-info {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.875rem;
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
        color: var(--primary-dark);
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        width: fit-content;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.2);
    }

    .product-title {
        font-size: clamp(1.5rem, 5vw, 1.75rem);
        font-weight: 700;
        color: var(--gray-900);
        line-height: 1.3;
        margin: 0;
    }

    .product-price {
        font-size: clamp(1.5rem, 6vw, 2rem);
        font-weight: 800;
        color: var(--primary);
        margin: 0;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .product-description {
        color: var(--gray-600);
        line-height: 1.7;
        margin: 0;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .product-description {
            font-size: 0.85rem;
        }
    }

    .stock-info {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: var(--gray-50);
        border-radius: 8px;
        font-size: 0.875rem;
        color: var(--gray-600);
        width: fit-content;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .stock-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--success);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Alerts */
    .alert-custom {
        padding: 1rem;
        border-radius: 12px;
        font-size: 0.875rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .alert-danger-custom {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .alert-danger-custom ul {
        margin: 0;
        padding-left: 1rem;
    }

    /* Order Form */
    .order-form {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--gray-200);
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-label-custom {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid var(--gray-200);
        border-radius: 10px;
        font-size: 0.938rem;
        color: var(--gray-800);
        background: white;
        transition: all 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .form-input::placeholder {
        color: var(--gray-400);
    }

    textarea.form-input {
        resize: vertical;
        min-height: 80px;
    }

    .form-hint {
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    /* Payment Method Select */
    .payment-select {
        position: relative;
    }

    .payment-select select {
        appearance: none;
        cursor: pointer;
        padding-right: 2.5rem;
    }

    .payment-select::after {
        content: '';
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid var(--gray-500);
        pointer-events: none;
    }

    /* E-Wallet Section */
    .ewallet-section {
        background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
        border: 1px solid #e9d5ff;
        border-radius: 12px;
        padding: 1.25rem;
        display: none;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.1);
    }

    .ewallet-section.show {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .ewallet-title {
        font-weight: 600;
        color: #7c3aed;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .ewallet-number {
        background: white;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-family: 'SF Mono', 'Roboto Mono', monospace;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .qr-container {
        text-align: center;
    }

    .qr-label {
        font-size: 0.813rem;
        color: var(--gray-600);
        margin-bottom: 0.75rem;
    }

    .qr-image {
        max-width: 180px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .qr-image:hover {
        transform: scale(1.05);
    }

    /* File Upload */
    .file-upload {
        position: relative;
    }

    .file-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px dashed var(--gray-300);
        border-radius: 10px;
        background: var(--gray-50);
        cursor: pointer;
        transition: all 0.2s;
    }

    .file-input:hover {
        border-color: var(--primary);
        background: #f5f3ff;
    }

    .file-input:focus {
        outline: none;
        border-color: var(--primary);
        border-style: solid;
    }

    /* Submit Button */
    .btn-submit {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }

    .btn-submit:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }

    /* Quantity Input */
    .quantity-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        max-width: 140px;
    }

    .qty-btn {
        width: 40px;
        height: 40px;
        border: 1.5px solid var(--gray-200);
        border-radius: 8px;
        background: white;
        color: var(--gray-600);
        font-size: 1.25rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        user-select: none;
    }

    .qty-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: #f5f3ff;
    }

    .qty-btn:active {
        transform: scale(0.95);
    }

    .qty-input {
        width: 60px;
        text-align: center;
        padding: 0.5rem;
        border: 1.5px solid var(--gray-200);
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
    }

    .qty-input:focus {
        outline: none;
        border-color: var(--primary);
    }

    /* Hide number input arrows */
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .qty-input[type=number] {
        -moz-appearance: textfield;
    }

    /* Mobile Optimizations */
    @media (max-width: 480px) {
        .product-container {
            padding: 0.5rem;
        }

        .breadcrumb-nav {
            font-size: 0.75rem;
        }

        .product-grid {
            gap: 1.5rem;
        }

        .category-badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.75rem;
        }

        .stock-info {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }

        .form-input {
            padding: 0.625rem 0.875rem;
            font-size: 0.9rem;
        }

        .btn-submit {
            padding: 0.875rem;
            font-size: 0.95rem;
        }

        .quantity-wrapper {
            max-width: 120px;
        }

        .qty-btn {
            width: 36px;
            height: 36px;
            font-size: 1.1rem;
        }

        .qty-input {
            width: 50px;
            font-size: 0.9rem;
        }

        .ewallet-section {
            padding: 1rem;
        }

        .qr-image {
            max-width: 150px;
        }
    }
</style>
@endpush

@section('content')
<div class="product-container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb-nav">
        <a href="{{ route('user.produk.index') }}">Kembali</a>
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span>{{ $product->name }}</span>
    </nav>

    <div class="product-grid">

        <!-- Product Image -->
        <div class="product-gallery">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}"
                     class="main-image">
            @else
                <div class="image-placeholder">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </div>

        <!-- Product Info & Form -->
        <div class="product-info">

            @if($product->kategori)
                <span class="category-badge">{{ $product->kategori }}</span>
            @endif

            <h1 class="product-title">{{ $product->name }}</h1>

            <p class="product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>

            @if($product->deskripsi)
                <p class="product-description">{{ $product->deskripsi }}</p>
            @endif

            <div class="stock-info">
                <span class="stock-dot"></span>
                Stok tersedia: <strong>{{ $product->stok }}</strong>
            </div>

            <!-- Error Alerts -->
            @if(session('error'))
                <div class="alert-custom alert-danger-custom">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-custom alert-danger-custom">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Order Form -->
            <form action="{{ route('order.store', $product->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="order-form">
                @csrf

                <!-- Quantity -->
                <div class="form-group">
                    <label class="form-label-custom">Jumlah Beli</label>
                    <div class="quantity-wrapper">
                        <button type="button" class="qty-btn" onclick="decreaseQty()">−</button>
                        <input type="number" name="quantity" id="quantity" class="qty-input" value="1" min="1" max="{{ $product->stok }}" required>
                        <button type="button" class="qty-btn" onclick="increaseQty()">+</button>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="form-group">
                    <label class="form-label-custom">Alamat Pengiriman</label>
                    <textarea name="alamat_pengiriman"
                              class="form-input"
                              rows="3"
                              placeholder="Masukkan alamat lengkap atau titik COD..."
                              required></textarea>
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label class="form-label-custom">Nomor WhatsApp</label>
                    <input type="text"
                           name="no_hp"
                           class="form-input"
                           placeholder="Contoh: 08123456789"
                           required>
                </div>

                <!-- Payment Method -->
                <div class="form-group">
                    <label class="form-label-custom">Metode Pembayaran</label>
                    <div class="payment-select">
                        <select name="payment_method" id="payment_method" class="form-input" required>
                            <option value="">Pilih metode pembayaran</option>
                            <option value="e-wallet">E-Wallet (OVO / DANA / GoPay)</option>
                            <option value="cash_on_delivery">Cash on Delivery (COD)</option>
                        </select>
                    </div>
                </div>

                <!-- E-Wallet Section -->
                <div id="ewallet_section" class="ewallet-section">
                    <div class="ewallet-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Pembayaran E-Wallet
                    </div>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Transfer ke nomor:</p>
                    <div class="ewallet-number">0812-3456-7890</div>
                    <div class="qr-container">
                        <p class="qr-label">Atau scan QR Code</p>
                        <img src="" 
                             alt="QR E-Wallet"
                             class="qr-image">
                    </div>
                </div>

                <!-- Payment Proof -->
                <div class="form-group">
                    <label class="form-label-custom">Bukti Pembayaran</label>
                    <input type="file" 
                           name="bukti_pembayaran" 
                           class="file-input"
                           accept=".jpg,.jpeg,.png,.pdf">
                    <span class="form-hint">Format: JPG, PNG, PDF (Maks. 2MB)</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Buat Pesanan
                </button>
            </form>

        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    // Payment method toggle
    document.getElementById('payment_method').addEventListener('change', function() {
        const section = document.getElementById('ewallet_section');
        if (this.value === 'e-wallet') {
            section.classList.add('show');
        } else {
            section.classList.remove('show');
        }
    });

    // Quantity controls
    function increaseQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    // SweetAlert notifications
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#6366f1'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session("error") }}',
            confirmButtonColor: '#ef4444'
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'warning',
            title: 'Validasi Gagal!',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#f59e0b'
        });
    @endif
</script>
@endsection