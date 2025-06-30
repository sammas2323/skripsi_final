<x-layout title="Pembayaran Gagal">
    <div class="max-w-2xl mx-auto py-10 text-center">
        <h1 class="text-3xl font-bold text-red-600 mb-4">Pembayaran Gagal ❌</h1>
        <p class="text-lg text-gray-700 mb-6">Maaf, transaksi Anda tidak berhasil diproses.</p>

        <div class="bg-red-100 text-red-800 p-4 rounded shadow mb-6">
            <p><strong>Status:</strong> <span class="font-semibold">Failed</span></p>
            <p><strong>Silakan coba kembali atau hubungi admin jika masalah berlanjut.</strong></p>
        </div>

        <a href="{{ route('rents.index') }}" class="inline-block mt-4 px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
            Kembali ke Daftar Kontrakan
        </a>
    </div>
</x-layout>
