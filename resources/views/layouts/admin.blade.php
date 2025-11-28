<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin Panel | Humanika Store')</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* Highlight active nav */
    .nav-link.active {
        background-color: rgba(59,130,246,0.15); /* biru muda */
        color: #3b82f6 !important;
        border-left: 4px solid #3b82f6;
        font-weight: 600;
    }
  </style>
</head>

<body class="bg-gray-100 font-sans">

  <div class="grid grid-cols-5 grid-rows-5 min-h-screen">

    <!-- Sidebar -->
   <aside class="col-span-1 row-span-5 bg-gray-900 text-white flex flex-col justify-between shadow-lg min-h-screen h-full">

      <div>
        <div class="p-4 text-center border-b border-gray-700">
  <!-- Logo -->
  <img src="{{ asset('storage/images/humanika_logo-removebg-preview.png') }}" 
       alt="Logo Humanika Store" 
       class="w-16 h-16 mx-auto rounded-full shadow mb-2 object-cover">

  <h2 class="text-2xl font-bold text-blue-400 tracking-wide">Humanika Store</h2>
  <p class="text-xs text-gray-400 mt-1">Admin Dashboard</p>
</div>

        <ul class="p-4 space-y-2 text-sm">
          {{-- Dashboard --}}
          <li>
            <a href="{{ route('admin.dashboard') }}"
              class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-700 transition">
              <i class="bi bi-house-door"></i> <span>Dashboard</span>
            </a>
          </li>

          {{-- Produk --}}
          <li>
            <a href="{{ route('admin.product.index') }}"
              class="nav-link {{ request()->routeIs('admin.product.index') ? 'active' : '' }} flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-700 transition">
              <i class="bi bi-box-seam"></i> <span>Produk</span>
            </a>
          </li>
         

          {{-- Laporan --}}
          <li>
            <a href="{{ route('admin.laporan.index') }}"
              class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-700 transition">
              <i class="bi bi-bar-chart-line"></i> <span>Laporan</span>
            </a>
          </li>

          {{-- Orderan --}}
          <li>
            <a href="{{ route('admin.orders.index') }}"
              class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-700 transition">
              <i class="bi bi-bag-check"></i> <span>Orderan</span>
            </a>
          </li>

          {{-- ulasan --}}
          <li>
            <a href="{{ route('admin.rating.index') }}"
              class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-700 transition">
              <i class="bi bi-chat-left-quote"></i> <span>Ulasan Customer</span>
            </a>
          </li>


          {{-- Kelola Admin --}}
           <li>
            <a href="{{ route('admin.users.index') }}"
              class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-700 transition">
              <i class="bi bi-people-fill"></i> <span>Kelola Admin</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="p-4 border-t border-gray-700 mb-8">
        <a class="nav-link text-warning" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-1"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="col-span-4 row-span-4 bg-gray-50 p-6 overflow-y-auto">
      @yield('content')
    </main>

    <!-- Footer -->
    <footer class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-300 text-center py-2 text-sm shadow">
    <small class="text-gray-500">&copy; {{ date('Y') }} 
        <strong>Humanika Store</strong>. All rights reserved.
    </small>
</footer>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- SweetAlert auto trigger -->
  <script>
    @if (session('success'))
      Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: "{{ session('success') }}",
          timer: 2500,
          showConfirmButton: false
      });
    @endif

    @if (session('error'))
      Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: "{{ session('error') }}",
          timer: 2500,
          showConfirmButton: false
      });
    @endif
  </script>

  @stack('scripts')
</body>
</html>
