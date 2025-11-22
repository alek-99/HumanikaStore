<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Humanika Store')</title>

 
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle (sudah termasuk Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body {
      font-family: 'Inter', sans-serif;
    }

    .gradient-bg {
      background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
    }

    .card-hover {
      transition: all 0.3s ease;
    }

    .card-hover:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
    }

    .nav-item {
      transition: all 0.3s ease;
    }

    .nav-item.active {
      color: #3b82f6;
    }

    .nav-item:not(.active):hover {
      color: #60a5fa;
    }

    .badge {
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.7; }
    }

    .sidebar-overlay {
      backdrop-filter: blur(4px);
    }
  </style>
  @stack('style')
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- HEADER -->
  <header class="fixed top-0 left-0 right-0 gradient-bg shadow-lg z-30">
    <div class="px-4 py-4 flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md overflow-hidden">
          <!-- Logo -->
          <img src="{{ asset('storage/images/humanika_logo-removebg-preview.png') }}" alt="Logo" class="w-8 h-8 object-contain">
        </div>
        <div>
          <h1 class="text-white text-lg font-bold leading-tight">Humanika Store</h1>
          <p class="text-blue-200 text-xs">Buy Now</p>
        </div>
      </div>

      <div class="flex items-center space-x-3">
        <!-- Notifikasi -->
        {{-- <button class="relative text-white hover:text-blue-200 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
          <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center badge">3</span>
        </button> --}}

        <!-- Tombol Menu -->
        <button id="menu-btn" class="text-white hover:text-blue-200 transition focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>
  </header>

  <!-- SIDEBAR -->
  <aside id="sidebar" class="fixed top-0 right-0 w-80 h-full bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-40">
    <div class="gradient-bg p-6 flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
        </div>
        <div>
          <h2 class="text-white text-lg font-semibold">Menu</h2>
          <p class="text-blue-200 text-xs">Selamat datang, {{ Auth::user()->name ?? 'Tamu' }}</p>
        </div>
      </div>
      <button id="close-btn" class="text-white hover:text-blue-200 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <nav class="p-4">
      <ul class="space-y-2">
        <li>
          <a href="{{ route('user.produk.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition group">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-900 group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <span class="text-gray-700 font-medium group-hover:text-blue-900">Produk</span>
          </a>
        </li>
        <li>
          <a href="{{ route('user.orders.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition group">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-900 group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="text-gray-700 font-medium group-hover:text-blue-900">Orderan</span>
          </a>
        </li>
        <li>
            <a class="nav-link text-warning" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-1"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
        </li>

      </ul>
    </nav>
  </aside>

  <!-- OVERLAY -->
  <div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 hidden z-30 sidebar-overlay"></div>

  <!-- MAIN CONTENT -->
 <main class="px-4 pt-28 pb-24 min-h-screen" >
    @yield('content')
</main>

  <!-- FOOTER NAV -->
  <footer class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg z-30">
    <div class="flex justify-around py-3">
      <a href="{{ route('user.dashboard') }}" class="nav-item active flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span class="text-xs font-medium">Home</span>
      </a>

      <a href="{{ route('profile.edit') }}" class="nav-item flex flex-col items-center text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <span class="text-xs font-medium">Profil</span>
      </a>
    </div>
  </footer>

  <!-- JS: Sidebar Toggle -->
  <script>
    const menuBtn = document.getElementById('menu-btn');
    const closeBtn = document.getElementById('close-btn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuBtn.addEventListener('click', () => {
      sidebar.classList.remove('translate-x-full');
      overlay.classList.remove('hidden');
    });

    closeBtn.addEventListener('click', () => {
      sidebar.classList.add('translate-x-full');
      overlay.classList.add('hidden');
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.add('translate-x-full');
      overlay.classList.add('hidden');
    });
  </script>
  {{-- Script --}}
  @yield('scripts')

</body>
</html>
