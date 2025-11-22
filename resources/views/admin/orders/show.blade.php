@extends('layouts.admin')
@section('title', 'Detail Order')

@section('content')
<div class="container mt-4">

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

    <div class="card shadow-sm">
        <div class="card-header">
            <h4>Detail Order #{{ $order->id }}</h4>
        </div>
        <div class="card-body">

            <table class="table">
                <tr>
                    <th>User</th>
                    <td>{{ $order->user->name }}</td>
                </tr>
                <tr>
                    <th>Produk</th>
                    <td>{{ $order->product->name }}</td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td>{{ $order->quantity }}</td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td>Rp {{ number_format($order->total_harga,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td>{{ $order->no_hp }}</td>
                </tr>
                <tr>
                    <th>Alamat Pengiriman</th>
                    <td>{{ $order->alamat_pengiriman }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Order</th>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Bukti Pembayaran</th>
                    <td>
                        @if($order->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $order->bukti_pembayaran) }}" target="_blank">Lihat Bukti</a>
                        @else
                            Tidak ada bukti pembayaran
                        @endif
                    </td>
                </tr>
            </table>

        </div>
    </div>

</div>
@endsection