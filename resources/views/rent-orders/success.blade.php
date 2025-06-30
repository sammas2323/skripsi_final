<x-layout title="Pembayaran Berhasil">
    <div class="max-w-2xl mx-auto py-10 text-center">
        <h1 class="text-3xl font-bold text-green-600 mb-4">Pembayaran Berhasil ✅</h1>
        <p class="text-lg text-gray-700 mb-6">Terima kasih, transaksi Anda telah berhasil!</p>

        <div class="bg-green-100 text-green-800 p-4 rounded shadow mb-6">
            <p><strong>Status:</strong> <span class="font-semibold">Berhasil (Paid)</span></p>
            <p><strong>Waktu:</strong> {{ now()->format('d M Y H:i') }}</p>
        </div>

        @if (isset($order))
            <div class="text-left bg-gray-50 border border-gray-200 p-4 rounded mb-6">
                <h2 class="text-lg font-semibold mb-2">Detail Pemesanan</h2>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><strong>Nama Kontrakan:</strong> {{ $order->rent->title }}</li>
                    <li><strong>Penyewa:</strong> {{ $order->name }}</li>
                    <li><strong>Tanggal Mulai Sewa:</strong> {{ \Carbon\Carbon::parse($order->tanggal_mulai_sewa)->format('d M Y') }}</li>
                    <li><strong>Jumlah Bulan:</strong> {{ $order->jumlah_bulan }}</li>
                    <li><strong>Total Harga:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</li>
                </ul>
            </div>

            {{-- Tombol Tambah ke Google Calendar --}}
            @if(Auth::user()->google_access_token && Auth::user()->google_refresh_token)
                <a href="{{ route('rent-orders.addToCalendar', $order->id) }}"
                   class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Tambahkan ke Google Calendar
                </a>
            @else
                <a href="{{ route('google.oauth', ['redirect_to' => route('rent-orders.addToCalendar', $order->id)]) }}"
                   class="inline-block mt-4 px-6 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                    Hubungkan & Tambahkan ke Calendar
                </a>
            @endif
        @endif

        <a href="{{ route('rents.index') }}" class="inline-block mt-4 ml-2 px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            Kembali ke Daftar Kontrakan
        </a>
    </div>
</x-layout>
