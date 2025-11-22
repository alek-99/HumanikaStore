@extends('layouts.admin')

@section('title', 'Kelola Admin')

@section('content')

<div class="card shadow-sm p-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Kelola Admin</h4>

        <!-- Tombol Tambah -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Admin
        </button>
    </div>

    <!-- Table Admin -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th width="50">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>

                        <!-- Tombol Edit -->
                        <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $admin->id }}">
                            Edit
                        </button>

                        <!-- Tombol Hapus -->
                        <button class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal{{ $admin->id }}">
                            Hapus
                        </button>

                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $admin->id }}" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="{{ route('admin.users.update', $admin->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header bg-warning">
                          <h5 class="modal-title">Edit Admin</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                          <div class="mb-3">
                              <label>Nama</label>
                              <input type="text" name="name" value="{{ $admin->name }}" class="form-control" required>
                          </div>

                          <div class="mb-3">
                              <label>Email</label>
                              <input type="email" name="email" value="{{ $admin->email }}" class="form-control" required>
                          </div>

                          <div class="mb-3">
                              <label>Password (Opsional)</label>
                              <input type="password" name="password" class="form-control">
                              <small class="text-muted">Biarkan kosong jika tidak diganti.</small>
                          </div>
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          <button type="submit" class="btn btn-warning">Update</button>
                        </div>

                      </form>
                    </div>
                  </div>
                </div>

                <!-- Modal Delete -->
                <div class="modal fade" id="deleteModal{{ $admin->id }}" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">Hapus Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <div class="modal-body">
                        <p>Yakin ingin menghapus admin <strong>{{ $admin->name }}</strong>?</p>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                        <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Hapus</button>
                        </form>
                      </div>

                    </div>
                  </div>
                </div>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white">Tambah Admin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
              <label>Nama</label>
              <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>

      </form>
    </div>
  </div>
</div>

@endsection
