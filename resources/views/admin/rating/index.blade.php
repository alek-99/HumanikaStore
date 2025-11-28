@extends('layouts.admin')

@section('title', 'Data Ulasan Produk')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">📊 Data Ulasan Produk</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Rating & Ulasan</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Produk</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Order ID</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($ratings as $rating)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <!-- User -->
                            <td>
                                <strong>{{ $rating->user->name ?? 'User Tidak Ditemukan' }}</strong><br>
                                <small class="text-muted">{{ $rating->user->email ?? '' }}</small>
                            </td>

                            <!-- Produk -->
                            <td>
                                {{ $rating->product->name ?? 'Produk Tidak Ditemukan' }}
                            </td>

                            <!-- Rating Bintang -->
                            <td>
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating->rating)
                                        <span class="text-warning fs-5">&#9733;</span>
                                    @else
                                        <span class="text-secondary fs-5">&#9734;</span>
                                    @endif
                                @endfor
                                <span class="ms-2">({{ $rating->rating }}/5)</span>
                            </td>

                            <!-- Komentar -->
                            <td>{{ $rating->comment }}</td>

                            <!-- Order -->
                            <td>
                                #{{ $rating->order_id }}
                            </td>

                            <!-- Date -->
                            <td>
                                {{ $rating->created_at->format('d M Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <h6 class="text-muted">Belum ada ulasan</h6>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>
@endsection
