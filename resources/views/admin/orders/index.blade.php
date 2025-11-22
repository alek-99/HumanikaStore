@extends('layouts.admin')
@section('title', 'Data Orderan User')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 fw-bold">Data Orderan User</h2>
 <!-- ======== REKAPAN DATA ======== -->
    <div class="row mb-4">

        <!-- Total Order -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h6 class="text-muted">Total Order</h6>
                <h3 class="fw-bold text-primary">{{ $totalOrder }}</h3>
            </div>
        </div>

        <!-- Total Penjualan -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h6 class="text-muted">Total Penjualan</h6>
                <h4 class="fw-bold text-success">
                    Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                </h4>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h6 class="text-muted">Pending</h6>
                <h3 class="fw-bold text-warning">{{ $statusCount['pending'] }}</h3>
            </div>
        </div>

        <!-- Process -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h6 class="text-muted">Process</h6>
                <h3 class="fw-bold text-info">{{ $statusCount['process'] }}</h3>
            </div>
        </div>

    </div>

    <!-- ROW 2 -->
    <div class="row mb-4">

        <!-- Confirmed -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h6 class="text-muted">Confirmed</h6>
                <h3 class="fw-bold text-success">{{ $statusCount['confirmed'] }}</h3>
            </div>
        </div>

        <!-- Canceled -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h6 class="text-muted">Canceled</h6>
                <h3 class="fw-bold text-danger">{{ $statusCount['canceled'] }}</h3>
            </div>
        </div>

    </div>

    <!-- ======== REKAP BULANAN ======== -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-bold">
            Rekap Penjualan Bulanan
        </div>

        <div class="card-body p-0">
            <table class="table mb-0 table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>Bulan</th>
                        <th>Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekapBulanan as $row)
                    <tr>
                        <td>{{ DateTime::createFromFormat('!m', $row->bulan)->format('F') }}</td>
                        <td>Rp {{ number_format($row->total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Filter -->
    <form method="GET" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <select name="status" class="form-select shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="pending"   {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="process"   {{ request('status')=='process' ? 'selected' : '' }}>Process</option>
                    <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="canceled"  {{ request('status')=='canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary shadow-sm w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Tabel -->
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ $order->quantity }}</td>

                        <td>
                            <span class="badge 
                                @if($order->status=='pending') bg-warning text-dark
                                @elseif($order->status=='process') bg-info
                                @elseif($order->status=='confirmed') bg-success
                                @else bg-danger @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>

                        <td>Rp {{ number_format($order->product->harga * $order->quantity, 0, ',', '.') }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>

                        <td>
                            <!-- Detail -->
                            <button class="btn btn-sm btn-info text-white"
                                data-bs-toggle="modal"
                                data-bs-target="#detail{{ $order->id }}">
                                Detail
                            </button>

                            <!-- Update -->
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#update{{ $order->id }}">
                                Edit
                            </button>

                            <!-- Hapus -->
                            <form action="{{ route('admin.orders.destroy', $order->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus order?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detail{{ $order->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header bg-light">
                                    <h5 class="modal-title">Detail Order</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p><strong>User:</strong> {{ $order->user->name }}</p>
                                    <p><strong>Produk:</strong> {{ $order->product->name }}</p>
                                    <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
                                    <p><strong>No HP:</strong> {{ $order->no_hp }}</p>
                                    <p><strong>Alamat:</strong> {{ $order->alamat_pengiriman }}</p>
                                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Modal Update -->
                 
<div class="modal fade" id="update{{ $order->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title">Update Status</h5>

                <!-- WAJIB: type="button" -->
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                @csrf

                <div class="modal-body">
                    <label class="form-label">Pilih Status</label>
                    <select name="status" class="form-select" required>
                        <option value="pending"   {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                        <option value="process"   {{ $order->status=='process'?'selected':'' }}>Process</option>
                        <option value="confirmed" {{ $order->status=='confirmed'?'selected':'' }}>Confirmed</option>
                        <option value="canceled"  {{ $order->status=='canceled'?'selected':'' }}>Canceled</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <!-- WAJIB: Tambahkan type="button" supaya tidak submit -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <!-- Submit hanya melalui tombol ini -->
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <div class="mt-3">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
