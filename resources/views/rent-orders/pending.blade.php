<x-layout title="Pembayaran Tertunda">
    <div class="max-w-2xl mx-auto py-10 text-center">
        <h1 class="text-3xl font-bold text-yellow-600 mb-4">Pembayaran Tertunda ⏳</h1>
        <p class="text-lg text-gray-700 mb-6">Transaksi Anda sedang menunggu konfirmasi pembayaran.</p>

        <div class="bg-yellow-100 text-yellow-800 p-4 rounded shadow mb-6">
            <p><strong>Status:</strong> <span class="font-semibold">Pending</span></p>
            <p><strong>Silakan selesaikan pembayaran Anda secepatnya.</strong></p>
        </div>

        <a href="{{ route('rents.index') }}" class="inline-block mt-4 px-6 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
            Kembali ke Daftar Kontrakan
        </a>
    </div>
</x-layout>
