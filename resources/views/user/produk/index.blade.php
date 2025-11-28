@extends('layouts.user')

@section('title', 'Daftar Produk')

@push('style')
<style>
/* =============================== */
/*         REVIEW TOGGLE UI        */
/* =============================== */
.review-section {
    transition: all 0.3s ease;
}

.review-item {
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.4s ease;
}

/* CRITICAL: Styling bintang yang kuat */
.review-stars,
.review-stars span,
.star-filled,
.star-empty {
    display: inline-block !important;
    line-height: 1 !important;
}

.review-stars {
    color: #f59e0b !important;
    font-size: 20px !important;
    letter-spacing: 2px !important;
}

.star-filled {
    color: #f59e0b !important;
}

.star-empty {
    color: #d1d5db !important;
}

/* =============================== */
/*         PRODUCT CARD HOVER      */
/* =============================== */
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

/* =============================== */
/*         RATING DISPLAY          */
/* =============================== */
.rating-summary {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}

.rating-number {
    font-weight: bold;
    color: #1f2937;
}

.review-count {
    color: #6b7280;
    font-size: 0.875rem;
}

/* =============================== */
/*         LATEST REVIEW BOX       */
/* =============================== */
.latest-review-box {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border-left: 3px solid #3b82f6;
}

/* =============================== */
/*         TOGGLE BUTTON           */
/* =============================== */
.toggle-review-btn {
    transition: all 0.3s ease;
}

.toggle-review-btn:hover {
    transform: scale(1.05);
}

/* =============================== */
/*         REVIEW CARD             */
/* =============================== */
.review-card {
    background: #f9fafb;
    border-left: 4px solid #6366f1;
    transition: all 0.3s ease;
}

.review-card:hover {
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* Force star visibility */
.star-display {
    font-family: Arial, sans-serif !important;
    font-size: 20px !important;
    line-height: 1 !important;
}

.star-display .star-filled {
    color: #f59e0b !important;
}

.star-display .star-empty {
    color: #d1d5db !important;
}
</style>
@endpush

@section('content')
<div class="container my-5">

    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Daftar Produk</h2>
        <p class="text-muted">Temukan produk terbaik dari Humanika Store</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Grid Produk -->
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card h-100 shadow-sm border-0 product-card">

                <!-- Gambar Produk -->
                <div class="position-relative">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                         class="card-img-top" 
                         style="height:200px; object-fit:cover;"
                         alt="{{ $product->name }}">
                    
                    <!-- Badge Kategori -->
                    @if($product->kategori)
                        <span class="position-absolute top-0 start-0 m-2 badge bg-primary">
                            {{ $product->kategori }}
                        </span>
                    @endif

                    <!-- Badge Stok -->
                    @if($product->stok < 5)
                        <span class="position-absolute top-0 end-0 m-2 badge bg-danger">
                            Stok Terbatas!
                        </span>
                    @endif
                </div>

                <div class="card-body d-flex flex-column">
                    <!-- Nama Produk -->
                    <h5 class="card-title fw-bold mb-2" style="min-height: 48px;">
                        {{ $product->name }}
                    </h5>

                    <!-- ⭐ RATING & ULASAN -->
                    @php
                        $avgRating = $product->ratings->avg('rating'); 
                        $reviewCount = $product->ratings->count();
                        $latestReview = $product->ratings->sortByDesc('id')->first();
                    @endphp

                    @if($reviewCount > 0)
                        <!-- Rating Summary -->
                        <div class="rating-summary">
                            <div class="review-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($i <= round($avgRating))
                                        <span class="star-filled">★</span>
                                    @else
                                        <span class="star-empty">☆</span>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-number">{{ number_format($avgRating, 1) }}</span>
                            <span class="review-count">({{ $reviewCount }} ulasan)</span>
                        </div>

                        <!-- Toggle Button -->
                        <button 
                            id="toggleBtn-{{ $product->id }}"
                            class="btn btn-sm btn-outline-secondary toggle-review-btn mb-2"
                            onclick="toggleReviews({{ $product->id }})">
                            <i class="bi bi-chat-left-text me-1"></i>
                            Lihat Semua Ulasan
                        </button>

                        <!-- Review Container (Hidden by default) -->
                        <div id="reviewsBox-{{ $product->id }}" 
                             class="review-section mb-2" 
                             style="display:none; opacity:0;">
                        </div>

                        <!-- Latest Review Preview -->
                        @if($latestReview)
                        <div class="latest-review-box border rounded p-2 mb-2" style="font-size:13px;">
                            <div class="d-flex justify-content-between align-items-start">
                                <strong class="text-primary">{{ $latestReview->user->name ?? 'User' }}</strong>
                                <small class="text-muted">
                                    {{ $latestReview->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="review-stars" style="font-size: 14px;">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($i <= $latestReview->rating)
                                        <span class="star-filled">★</span>
                                    @else
                                        <span class="star-empty">☆</span>
                                    @endif
                                @endfor
                            </div>
                            <p class="mb-0 mt-1 text-muted fst-italic">
                                "{{ Str::limit($latestReview->comment ?? 'Produk bagus!', 60) }}"
                            </p>
                        </div>
                        @endif
                    @else
                        <!-- No Reviews Yet -->
                        <div class="text-muted small mb-2">
                            <i class="bi bi-star me-1"></i>
                            Belum ada ulasan
                        </div>
                    @endif

                    <!-- Deskripsi -->
                    <p class="text-muted small mb-2" style="min-height: 40px;">
                        {{ Str::limit($product->deskripsi, 80) }}
                    </p>

                    <!-- Spacer -->
                    <div class="mt-auto">
                        <!-- Harga -->
                        <h5 class="text-success fw-bold mb-2">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </h5>

                        <!-- Stok -->
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-box-seam text-secondary me-2"></i>
                            <span class="text-secondary small">
                                Stok: <strong>{{ $product->stok }}</strong>
                            </span>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('user.produk.show', $product->id) }}" 
                           class="btn btn-primary w-100">
                            <i class="bi bi-cart-plus me-2"></i>
                            Lihat & Pesan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <!-- Empty State -->
            <div class="col-12">
                <div class="text-center my-5 py-5">
                    <i class="bi bi-box-seam" style="font-size: 4rem; color: #d1d5db;"></i>
                    <h5 class="text-muted mt-3">Belum ada produk tersedia.</h5>
                    <p class="text-muted">Silakan cek kembali nanti.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination (jika ada) -->
    @if(method_exists($products, 'links'))
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
    @endif
</div>

<!-- =============================== -->
<!--      JAVASCRIPT SECTION         -->
<!-- =============================== -->
<script>
function toggleReviews(productId) {
    const box = document.getElementById(`reviewsBox-${productId}`);
    const btn = document.getElementById(`toggleBtn-${productId}`);

    // Tutup box
    if (box.style.display === "block") {
        box.style.opacity = 0;
        setTimeout(() => {
            box.style.display = "none";
            box.innerHTML = ""; // Clear content
        }, 300);
        btn.innerHTML = '<i class="bi bi-chat-left-text me-1"></i> Lihat Semua Ulasan';
        return;
    }

    // Buka box
    box.style.display = "block";
    btn.innerHTML = '<i class="bi bi-x-circle me-1"></i> Tutup Ulasan';
    box.innerHTML = '<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary" role="status"></div><p class="text-muted small mt-2">Memuat ulasan...</p></div>';

    // Fetch reviews
    fetch(`/product/${productId}/reviews`)
        .then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(data => {
            console.log('Fetched reviews:', data); // Debug log
            
            // Clear loading message
            box.innerHTML = "";

            // Header
            const headerDiv = document.createElement("div");
            headerDiv.className = "d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom";
            headerDiv.innerHTML = `
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-chat-left-dots text-primary me-2"></i>
                    Semua Ulasan (${data.length})
                </h6>
                <button class="btn btn-sm btn-outline-danger" onclick="toggleReviews(${productId})">
                    <i class="bi bi-x-lg"></i>
                </button>
            `;
            box.appendChild(headerDiv);

            // Check if there are reviews
            if (data.length === 0) {
                box.innerHTML += `
                    <div class="text-center py-4">
                        <i class="bi bi-chat-left text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">Belum ada ulasan untuk produk ini.</p>
                    </div>
                `;
                box.style.opacity = "1";
                return;
            }

            // Loop through reviews
            data.forEach((review, i) => {
                console.log('Processing review:', review); // Debug log
                
                // Validate rating - SANGAT PENTING
                let starValue = parseInt(review.rating);
                if (isNaN(starValue) || starValue < 0) starValue = 0;
                if (starValue > 5) starValue = 5;
                
                console.log('Star value:', starValue); // Debug log

                const reviewDiv = document.createElement("div");
                reviewDiv.className = "review-item mb-3";
                reviewDiv.style.opacity = "0";
                reviewDiv.style.transform = "translateY(10px)";

                // Generate stars HTML - MENGGUNAKAN UNICODE LANGSUNG
                let starsHTML = '<div class="star-display" style="font-size:20px; letter-spacing:2px;">';
                for (let x = 1; x <= 5; x++) {
                    if (x <= starValue) {
                        // Bintang penuh - kuning
                        starsHTML += `<span style="color:#f59e0b; display:inline-block;">★</span>`;
                    } else {
                        // Bintang kosong - abu-abu
                        starsHTML += `<span style="color:#d1d5db; display:inline-block;">☆</span>`;
                    }
                }
                starsHTML += '</div>';

                console.log('Generated stars HTML:', starsHTML); // Debug log

                // Build review card
                reviewDiv.innerHTML = `
                    <div class="review-card p-3 border rounded shadow-sm">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong style="color: #1f2937;">
                                    <i class="bi bi-person-circle text-primary me-1"></i>
                                    ${review.user}
                                </strong>
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    ${review.date}
                                </small>
                            </div>
                            ${starsHTML}
                        </div>
                        ${review.comment 
                            ? `<p class="mt-2 mb-0" style="color: #4b5563; font-size: 14px;">${review.comment}</p>` 
                            : '<p class="mt-2 mb-0 text-muted fst-italic small">Tidak ada komentar</p>'
                        }
                    </div>
                `;

                box.appendChild(reviewDiv);

                // Animate in with stagger
                setTimeout(() => {
                    reviewDiv.style.transition = "all 0.4s ease";
                    reviewDiv.style.opacity = "1";
                    reviewDiv.style.transform = "translateY(0)";
                }, 50 + (i * 100));
            });

            // Fade in container
            setTimeout(() => {
                box.style.opacity = "1";
            }, 30);
        })
        .catch(error => {
            console.error('Error loading reviews:', error);
            box.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Error!</strong> Gagal memuat ulasan. Silakan coba lagi.
                    <br><small class="text-muted">${error.message}</small>
                </div>
            `;
            box.style.opacity = "1";
        });
}
</script>
@endsection