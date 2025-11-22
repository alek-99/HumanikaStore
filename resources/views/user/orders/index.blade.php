@extends('layouts.user')

@section('title', 'Pesanan Saya')


<style>
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
    }

    .orders-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
    }

    .page-subtitle {
        color: var(--gray-500);
        margin-top: 0.5rem;
    }

    /* Alert Styles */
    .custom-alert {
        padding: 1rem 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-success-custom {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 1px solid #6ee7b7;
        color: #065f46;
    }

    .alert-error-custom {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: 1px solid #fca5a5;
        color: #991b1b;
    }

    .alert-info-custom {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 1px solid #93c5fd;
        color: #1e40af;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--gray-50);
        border-radius: 16px;
        border: 2px dashed var(--gray-200);
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: var(--gray-100);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-state-icon svg {
        width: 40px;
        height: 40px;
        color: var(--gray-400);
    }

    .empty-state h3 {
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--gray-500);
        margin-bottom: 1.5rem;
    }

    .btn-shop {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: var(--primary);
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-shop:hover {
        background: var(--primary-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
    }

    /* Order Cards */
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .order-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border: 1px solid var(--gray-100);
        overflow: hidden;
        transition: all 0.2s;
    }

    .order-card:hover {
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: var(--gray-50);
        border-bottom: 1px solid var(--gray-100);
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .order-id {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.875rem;
    }

    .order-date {
        color: var(--gray-500);
        font-size: 0.813rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .order-body {
        padding: 1.5rem;
    }

    .product-info {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .product-image {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        object-fit: cover;
        background: var(--gray-100);
        flex-shrink: 0;
    }

    .product-image-placeholder {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .product-details {
        flex: 1;
        min-width: 0;
    }

    .product-name {
        font-weight: 600;
        color: var(--gray-800);
        font-size: 1.125rem;
        margin-bottom: 0.375rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-price {
        color: var(--primary);
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }

    .product-qty {
        color: var(--gray-500);
        font-size: 0.875rem;
    }

    .order-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--gray-100);
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .meta-label {
        font-size: 0.75rem;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 500;
    }

    .meta-value {
        font-weight: 600;
        color: var(--gray-700);
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.875rem;
        border-radius: 50px;
        font-size: 0.813rem;
        font-weight: 600;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-process {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-confirmed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-canceled {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .status-pending .status-dot { background: #f59e0b; }
    .status-process .status-dot { background: #3b82f6; }
    .status-confirmed .status-dot { background: #10b981; }
    .status-canceled .status-dot { background: #ef4444; animation: none; }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Payment Method Badge */
    .payment-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.813rem;
        font-weight: 500;
    }

    .payment-ewallet {
        background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
        color: #5b21b6;
    }

    .payment-cod {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    /* Order Footer */
    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: var(--gray-50);
        border-top: 1px solid var(--gray-100);
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .total-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .total-label {
        font-size: 0.813rem;
        color: var(--gray-500);
        font-weight: 400;
    }

    .order-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.625rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-view-proof {
        background: var(--gray-800);
        color: white;
    }

    .btn-view-proof:hover {
        background: var(--gray-900);
        color: white;
    }

    .btn-cancel {
        background: white;
        color: var(--danger);
        border: 1px solid var(--danger);
    }

    .btn-cancel:hover {
        background: var(--danger);
        color: white;
    }

    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .modal-header {
        background: var(--gray-50);
        border-bottom: 1px solid var(--gray-100);
        padding: 1.25rem 1.5rem;
    }

    .modal-title {
        font-weight: 600;
        color: var(--gray-800);
    }

    .modal-body {
        padding: 1.5rem;
    }

    .proof-image {
        border-radius: 12px;
        max-height: 70vh;
        object-fit: contain;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .orders-container {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .product-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .product-image,
        .product-image-placeholder {
            width: 100%;
            height: 180px;
        }

        .order-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .order-actions {
            justify-content: stretch;
        }

        .order-actions .btn-action {
            flex: 1;
            justify-content: center;
        }
    }
</style>


@section('content')
<div class="orders-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Pesanan Saya</h1>
        <p class="page-subtitle">Kelola dan pantau status pesanan Anda</p>
    </div>

    <!-- Session Alerts -->
    @if (session('success'))
        <div class="custom-alert alert-success-custom">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="custom-alert alert-error-custom">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Empty State -->
    @if ($orders->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h3>Belum Ada Pesanan</h3>
            <p>Sepertinya kamu belum melakukan pemesanan apapun.</p>
            <a href="{{ route('products.index') }}" class="btn-shop">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Mulai Belanja
            </a>
        </div>
    @else
        <!-- Orders List -->
        <div class="orders-list">
            @foreach ($orders as $index => $order)
                <div class="order-card">
                    <!-- Order Header -->
                    <div class="order-header">
                        <span class="order-id">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                        <span class="order-date">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>

                    <!-- Order Body -->
                    <div class="order-body">
                        <div class="product-info">
                            @if ($order->product->image)
                                <img src="{{ asset('storage/' . $order->product->image) }}" 
                                     alt="{{ $order->product->name }}" 
                                     class="product-image">
                            @else
                                <div class="product-image-placeholder">
                                    <svg width="32" height="32" fill="none" stroke="#9ca3af" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif

                            <div class="product-details">
                                <h3 class="product-name">{{ $order->product->name }}</h3>
                                <div class="product-price">Rp {{ number_format($order->product->harga, 0, ',', '.') }}</div>
                                <span class="product-qty">Jumlah: {{ $order->quantity }} item</span>
                            </div>
                        </div>

                        <div class="order-meta">
                            <div class="meta-item">
                                <span class="meta-label">Status</span>
                                <div>
                                    @if ($order->status == 'pending')
                                        <span class="status-badge status-pending">
                                            <span class="status-dot"></span>
                                            Menunggu
                                        </span>
                                    @elseif ($order->status == 'process')
                                        <span class="status-badge status-process">
                                            <span class="status-dot"></span>
                                            Diproses
                                        </span>
                                    @elseif ($order->status == 'confirmed')
                                        <span class="status-badge status-confirmed">
                                            <span class="status-dot"></span>
                                            Dikonfirmasi
                                        </span>
                                    @elseif ($order->status == 'canceled')
                                        <span class="status-badge status-canceled">
                                            <span class="status-dot"></span>
                                            Dibatalkan
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="meta-item">
                                <span class="meta-label">Pembayaran</span>
                                <div>
                                    @if ($order->payment_method == 'e-wallet')
                                        <span class="payment-badge payment-ewallet">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            E-Wallet
                                        </span>
                                    @elseif ($order->payment_method == 'cash_on_delivery')
                                        <span class="payment-badge payment-cod">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            COD
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="meta-item">
                                <span class="meta-label">Bukti Bayar</span>
                                <span class="meta-value">
                                    @if ($order->bukti_pembayaran)
                                        <span style="color: var(--success);">✓ Terupload</span>
                                    @else
                                        <span style="color: var(--gray-400);">Belum ada</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Footer -->
                    <div class="order-footer">
                        <div class="total-price">
                            <span class="total-label">Total: </span>
                            Rp {{ number_format($order->product->harga * $order->quantity, 0, ',', '.') }}
                        </div>

                        <div class="order-actions">
                            @if ($order->bukti_pembayaran)
                                <button class="btn-action btn-view-proof" data-bs-toggle="modal" data-bs-target="#buktiModal{{ $order->id }}">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat Bukti
                                </button>

                                <!-- Modal Bukti Pembayaran -->
                                <div class="modal fade" id="buktiModal{{ $order->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Bukti Pembayaran - Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                @if (Str::endsWith($order->bukti_pembayaran, ['.pdf']))
                                                    <iframe src="{{ asset('storage/' . $order->bukti_pembayaran) }}" 
                                                            width="100%" height="500px" style="border-radius: 12px;"></iframe>
                                                @else
                                                    <img src="{{ asset('storage/' . $order->bukti_pembayaran) }}" 
                                                         class="proof-image img-fluid">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($order->status == 'pending' || $order->status == 'process')
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')" style="margin: 0;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn-action btn-cancel">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection