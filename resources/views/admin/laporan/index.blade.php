@extends('layouts.admin')

@section('title', 'Laporan Penjualan Bulanan')

@section('content')
<div class="container my-5">

    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Laporan Penjualan Bulanan</h4>
        </div>

        <div class="card-body">

            <!-- FILTER BULAN & TAHUN -->
            <form action="{{ route('admin.laporan.index') }}" method="GET" class="row g-3 mb-4">

                <div class="col-md-3">
                    <label class="form-label fw-bold">Bulan</label>
                    <select name="bulan" class="form-select" required>
                        @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ date("F", mktime(0,0,0,$i,1)) }}
                        </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Tahun</label>
                    <select name="tahun" class="form-select" required>
                        @for($i = 2023; $i <= date('Y'); $i++)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <a href="{{ route('laporan.exportExcel', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                       class="btn btn-success w-100">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                </div>

            </form>

            <!-- INFO RINGKAS -->
            <div class="row text-center mb-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <h5>Total Order</h5>
                        <h3 class="text-primary">{{ $totalOrder }}</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <h5>Total Penjualan</h5>
                        <h3 class="text-success">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-danger">Tidak ada data bulan ini</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
