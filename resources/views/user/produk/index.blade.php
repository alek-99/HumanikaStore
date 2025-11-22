@extends('layouts.user')

@section('title', 'Daftar Produk')

@section('content')
<div class="container my-5">

    <!-- Header -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Daftar Produk</h2>
        <p class="text-muted">Temukan produk terbaik dari Humanika Store</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Grid Produk -->
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm border-0">
                
                <!-- Gambar Produk -->
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="card-img-top" 
                         style="height: 200px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image" 
                         class="card-img-top">
                @endif

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold">{{ $product->name }}</h5>

                    <p class="text-muted small mb-1">
                        @if($product->kategori)
                            <span class="badge bg-primary">{{ $product->kategori }}</span>
                        @endif
                    </p>

                    <p class="text-muted small">
                        {{ Str::limit($product->deskripsi, 60) }}
                    </p>

                    <h5 class="text-success fw-bold">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </h5>

                    <p class="text-secondary small mb-2">Stok: {{ $product->stok }}</p>

                    <a href="{{ route('user.produk.show', $product->id) }}" 
                       class="btn btn-outline-primary mt-auto">
                        Lihat Dan Pesan
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center my-5">
            <h5 class="text-muted">Belum ada produk tersedia.</h5>
        </div>
        @endforelse
    </div>

    {{-- <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div> --}}

</div>
@endsection
