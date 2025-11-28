@extends('layouts.user')
@section('title', 'Pesanan Saya')
@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Pesanan Saya</h1>
        <p class="text-gray-600 mt-2">Kelola dan pantau status pesanan Anda</p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($orders->isEmpty())
        <div class="text-center py-16">
            <div class="mb-4">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-600 mb-6">Sepertinya kamu belum melakukan pemesanan apapun.</p>
            <a href="{{ route('user.produk') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($orders as $index => $order)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold text-gray-800">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h3>
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex gap-4 mb-4">
                            @if ($order->product->image)
                                <img src="{{ asset('storage/' . $order->product->image) }}" 
                                     alt="{{ $order->product->name }}" 
                                     class="w-24 h-24 object-cover rounded">
                            @else
                                <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                            @endif

                            <div class="flex-1">
                                <h4 class="font-semibold text-lg mb-1">{{ $order->product->name }}</h4>
                                <p class="text-gray-600 mb-2">Rp {{ number_format($order->product->harga, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">Jumlah: {{ $order->quantity }} item</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <span class="text-sm text-gray-600 block mb-1">Status</span>
                                @if ($order->status == 'pending')
                                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">Menunggu</span>
                                @elseif ($order->status == 'process')
                                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Diproses</span>
                                @elseif ($order->status == 'confirmed')
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Dikonfirmasi</span>
                                @elseif ($order->status == 'canceled')
                                    <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">Dibatalkan</span>
                                @endif
                            </div>

                            <div>
                                <span class="text-sm text-gray-600 block mb-1">Pembayaran</span>
                                @if ($order->payment_method == 'e-wallet')
                                    <span class="text-gray-800">E-Wallet</span>
                                @elseif ($order->payment_method == 'cash_on_delivery')
                                    <span class="text-gray-800">COD</span>
                                @endif
                            </div>

                            <div>
                                <span class="text-sm text-gray-600 block mb-1">Bukti Bayar</span>
                                @if ($order->bukti_pembayaran)
                                    <span class="text-green-600">✓ Terupload</span>
                                @else
                                    <span class="text-gray-400">Belum ada</span>
                                @endif
                            </div>
                        </div>

                        {{-- REVIEW SECTION --}}
                        @if ($order->rating)
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="text-yellow-400 text-lg">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $order->rating->rating)
                                                        ★
                                                    @else
                                                        ☆
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-sm text-gray-500">{{ $order->rating->created_at->format('d M Y') }}</span>
                                        </div>
                                        <p class="text-sm font-medium text-gray-700 mb-1">
                                            {{ $order->rating->user->name ?? 'User Tanpa Nama' }} ({{ $order->rating->user->email }})
                                        </p>
                                        <p class="text-gray-600 italic">"{{ $order->rating->comment }}"</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="border-t pt-4 flex justify-between items-center">
                            <div class="text-lg font-bold text-gray-800">
                                Total: Rp {{ number_format($order->product->harga * $order->quantity, 0, ',', '.') }}
                            </div>

                            <div class="flex gap-2 flex-wrap justify-end">
                                {{-- TOMBOL REVIEW --}}
                                @if ($order->status === 'confirmed')
                                    @php
                                        $alreadyRated = \App\Models\Rating::where('order_id', $order->id)
                                            ->where('user_id', Auth::id())
                                            ->exists();
                                    @endphp
                                    @if (!$alreadyRated)
                                        <a href="{{ route('user.reviews.create', $order->id) }}" 
                                           class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition text-sm">
                                            ★ Beri Ulasan
                                        </a>
                                    @endif
                                @endif

                                @if ($order->bukti_pembayaran)
                                    <button onclick="openProofModal('{{ $order->id }}')" 
                                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-sm">
                                        Lihat Bukti
                                    </button>
                                @endif

                                {{-- Cancel orderan --}}
                                @if ($order->status == 'pending' || $order->status == 'process')
                                    <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                                onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')"
                                                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm">
                                            Batalkan
                                        </button>
                                    </form>
                                @endif

                                {{-- Konfirmasi Orderan --}}
                                @if ($order->status == 'pending' || $order->status == 'process')
                                    <form action="{{ route('user.orders.confirm', $order->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                                onclick="return confirm('Konfirmasi pesanan telah diterima?')"
                                                class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition text-sm">
                                            Konfirmasi Pesanan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL BUKTI PEMBAYARAN - Lazy Load --}}
                @if ($order->bukti_pembayaran)
                    <div id="proofModal{{ $order->id }}" 
                         class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50 p-4"
                         onclick="closeProofModal('{{ $order->id }}')">
                        <div class="relative max-w-4xl max-h-[90vh] bg-white rounded-lg overflow-hidden" 
                             onclick="event.stopPropagation()">
                            <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center z-10">
                                <h3 class="text-lg font-semibold">Bukti Pembayaran - Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h3>
                                <button onclick="closeProofModal('{{ $order->id }}')" 
                                        class="text-gray-500 hover:text-gray-700 text-2xl leading-none">
                                    ×
                                </button>
                            </div>
                            <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
                                <div id="proofContent{{ $order->id }}" class="flex justify-center items-center min-h-[200px]">
                                    <div class="text-gray-400">Memuat...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>

<script>
    // Lazy load proof image/PDF
    function openProofModal(orderId) {
        const modal = document.getElementById('proofModal' + orderId);
        const content = document.getElementById('proofContent' + orderId);
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
        
        // Load content only when modal opens
        if (!content.dataset.loaded) {
            loadProofContent(orderId);
            content.dataset.loaded = 'true';
        }
    }

    function closeProofModal(orderId) {
        const modal = document.getElementById('proofModal' + orderId);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        
        // Restore body scroll
        document.body.style.overflow = '';
    }

    function loadProofContent(orderId) {
        const content = document.getElementById('proofContent' + orderId);
        
        // Get proof URL from data attribute (you'll need to add this in the modal)
        fetch(`/user/orders/${orderId}/proof`)
            .then(response => response.json())
            .then(data => {
                if (data.type === 'pdf') {
                    content.innerHTML = `
                        <embed src="${data.url}" 
                               type="application/pdf" 
                               class="w-full h-[70vh]" />
                    `;
                } else {
                    content.innerHTML = `
                        <img src="${data.url}" 
                             alt="Bukti Pembayaran" 
                             class="max-w-full h-auto rounded shadow-lg"
                             loading="lazy" />
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading proof:', error);
                content.innerHTML = '<div class="text-red-500">Gagal memuat bukti pembayaran</div>';
            });
    }

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="proofModal"]').forEach(modal => {
                if (!modal.classList.contains('hidden')) {
                    const orderId = modal.id.replace('proofModal', '');
                    closeProofModal(orderId);
                }
            });
        }
    });
</script>

@endsection