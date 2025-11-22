@extends('layouts.admin')

@section('title', 'Manajemen Produk')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Daftar Produk</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </button>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $index => $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="gambar" width="60" class="rounded">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->kategori ?? '-' }}</td>
                        <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td>{{ $product->stok }}</td>
                        <td>
                            <!-- Tombol Show -->
                            <button class="btn btn-sm btn-info text-white showBtn"
                                data-name="{{ $product->name }}"
                                data-deskripsi="{{ $product->deskripsi }}"
                                data-harga="{{ number_format($product->harga, 0, ',', '.') }}"
                                data-stok="{{ $product->stok }}"
                                data-kategori="{{ $product->kategori }}"
                                data-image="{{ $product->image ? asset('storage/' . $product->image) : '' }}"
                                data-bs-toggle="modal" data-bs-target="#showProductModal">
                                <i class="bi bi-eye"></i>
                            </button>

                            <!-- Tombol Edit -->
                            <button class="btn btn-sm btn-warning editBtn" 
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-deskripsi="{{ $product->deskripsi }}"
                                data-harga="{{ $product->harga }}"
                                data-stok="{{ $product->stok }}"
                                data-kategori="{{ $product->kategori }}"
                                data-bs-toggle="modal" data-bs-target="#editProductModal">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <!-- Tombol Delete -->
                            <form action="{{ route('admin.product.destroy', $product) }}" method="POST" class="d-inline" id="deleteForm{{ $product->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $product->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<!-- ===================================================== -->
<!-- 🟢 MODAL TAMBAH PRODUK -->
<!-- ===================================================== -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="">Pilih Kategori</option>
                        <option value="Makanan">Makanan</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Pakaian">Pakaian</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Gambar Produk</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ===================================================== -->
<!-- 🟡 MODAL EDIT PRODUK -->
<!-- ===================================================== -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="editForm" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" id="editName" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" id="editKategori" class="form-select">
                        <option value="">Pilih Kategori</option>
                        <option value="Makanan">Makanan</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Pakaian">Pakaian</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" id="editHarga" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" id="editStok" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="editDeskripsi" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Gambar Baru (opsional)</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- ===================================================== -->
<!-- 🔵 MODAL SHOW PRODUK -->
<!-- ===================================================== -->
<div class="modal fade" id="showProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Detail Produk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-5 text-center">
                        <img id="showImage" src="" alt="Gambar Produk" class="img-fluid rounded shadow-sm mb-2">
                    </div>
                    <div class="col-md-7">
                        <h4 id="showName" class="fw-bold text-primary mb-2"></h4>
                        <p class="text-muted mb-1"><strong>Kategori:</strong> <span id="showKategori"></span></p>
                        <p class="text-muted mb-1"><strong>Harga:</strong> Rp <span id="showHarga"></span></p>
                        <p class="text-muted mb-1"><strong>Stok:</strong> <span id="showStok"></span></p>
                        <hr>
                        <p id="showDeskripsi" class="mt-3"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================================================== -->
<!-- 🧠 JAVASCRIPT INTERAKTIF -->
<!-- ===================================================== -->
<script>
    // 🟡 Handle Edit Button Click
    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            document.getElementById('editForm').action = `/admin/product/${id}`;
            document.getElementById('editName').value = this.dataset.name;
            document.getElementById('editDeskripsi').value = this.dataset.deskripsi;
            document.getElementById('editHarga').value = this.dataset.harga;
            document.getElementById('editStok').value = this.dataset.stok;
            document.getElementById('editKategori').value = this.dataset.kategori;
        });
    });

    // 🔵 Handle Show Button Click
    document.querySelectorAll('.showBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('showName').innerText = this.dataset.name;
            document.getElementById('showDeskripsi').innerText = this.dataset.deskripsi || '-';
            document.getElementById('showHarga').innerText = this.dataset.harga;
            document.getElementById('showStok').innerText = this.dataset.stok;
            document.getElementById('showKategori').innerText = this.dataset.kategori || '-';
            const image = this.dataset.image;
            document.getElementById('showImage').src = image ? image : 'https://via.placeholder.com/300x200?text=No+Image';
        });
    });

    // 🔴 SweetAlert Delete Confirmation
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin hapus produk ini?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + id).submit();
            }
        });
    }
</script>
@endsection
