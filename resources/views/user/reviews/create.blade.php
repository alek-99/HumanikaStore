@extends('layouts.user')

@section('title', 'Beri Ulasan')

@section('content')
<style>
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-300: #d1d5db;
        --gray-500: #6b7280;
        --gray-700: #374151;
    }

    .review-container {
        max-width: 700px;
        margin: 0 auto;
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-700);
        margin-bottom: 1.5rem;
    }

    .product-box {
        display: flex;
        gap: 1rem;
        background: var(--gray-50);
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid var(--gray-100);
        margin-bottom: 2rem;
    }

    .product-img {
        width: 90px;
        height: 90px;
        border-radius: 10px;
        object-fit: cover;
        background: var(--gray-100);
    }

    .rating-stars {
        display: flex;
        gap: .5rem;
        margin-bottom: 1rem;
    }

    .rating-stars input {
        display: none;
    }

    .rating-stars label {
        font-size: 2rem;
        cursor: pointer;
        color: #d1d5db;
        transition: .2s;
    }

    .rating-stars input:checked ~ label,
    .rating-stars label:hover,
    .rating-stars label:hover ~ label {
        color: #facc15;
    }

    textarea {
        width: 100%;
        border-radius: 12px;
        padding: 1rem;
        border: 1px solid var(--gray-300);
        min-height: 130px;
        font-size: 0.95rem;
    }

    .btn-primary {
        padding: 0.75rem 1.5rem;
        background: var(--primary);
        color: white;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .btn-back {
        text-decoration: none;
        margin-top: 1rem;
        display: inline-block;
        color: var(--gray-500);
    }
</style>

<div class="review-container">

    <h1 class="page-title">Beri Ulasan</h1>

    {{-- Product Info --}}
    <div class="product-box">
        @if ($order->product->image)
            <img src="{{ asset('storage/' . $order->product->image) }}" class="product-img">
        @else
            <div class="product-img" style="display:flex;align-items:center;justify-content:center;color:#9ca3af;">
                No Image
            </div>
        @endif

        <div>
            <h3 style="font-size:1.25rem;font-weight:600;color:var(--gray-700);">
                {{ $order->product->name }}
            </h3>
            <p style="color:var(--gray-500);">
                Harga: <strong>Rp {{ number_format($order->product->harga, 0, ',', '.') }}</strong>
            </p>
        </div>
    </div>

    {{-- Form Review --}}
    <form method="POST" action="{{ route('reviews.store', $order->id) }}">
        @csrf

        <label style="font-weight:600;color:var(--gray-700);font-size:1rem;">Rating</label>
        <div class="rating-stars">
            @for ($i = 5; $i >= 1; $i--)
                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}">
                <label for="star{{ $i }}">★</label>
            @endfor
        </div>

        @error('rating')
            <p style="color:#dc2626;font-size:0.875rem;">{{ $message }}</p>
        @enderror

        <label style="font-weight:600;color:var(--gray-700);font-size:1rem;">Komentar</label>
        <textarea name="comment" placeholder="Tuliskan pengalaman kamu...">{{ old('comment') }}</textarea>

        <button type="submit" class="btn-primary mt-3">Kirim Ulasan</button>

        <a href="{{ route('user.orders.index') }}" class="btn-back">← Kembali ke Pesanan</a>
    </form>

</div>

@endsection
