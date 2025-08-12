<x-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Tentang Kontrakan Tony</h2>
    </x-slot>

    <div class="p-6 bg-white rounded-xl shadow-md mt-4 space-y-4">
        <img src="{{ asset('img/kontrakann.jpg') }}" alt="Foto Kontrakan Tony" class="rounded-lg w-full h-64 object-cover shadow-md">

        <h3 class="text-xl font-semibold text-gray-700">Selamat Datang di Kontrakan Tony!</h3>

        <p class="text-gray-600 leading-relaxed">
            Kontrakan Tony menyediakan berbagai pilihan tempat tinggal dan tempat usaha yang nyaman, tenang, dan terjangkau. Cocok untuk kamu yang mencari hunian sederhana maupun kios untuk memulai usaha.
        </p>

        <p class="text-gray-600 leading-relaxed">
            Kami menawarkan unit kontrakan rumah lengkap dengan kamar mandi dalam, dapur, listrik prabayar, dan air bersih. Selain itu, tersedia juga kios usaha beragam ukuran yang cocok untuk berbagai jenis bisnis rumahan maupun UMKM.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
            <div class="bg-gray-100 p-4 rounded-lg">
                <h4 class="font-medium text-gray-700">Kontrakan Rumah</h4>
                <p class="text-gray-600 text-sm">Harga mulai dari <strong>Rp600.000 per bulan</strong>. Cocok untuk individu, pasangan muda, atau keluarga kecil.</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg">
                <h4 class="font-medium text-gray-700">Kios Usaha</h4>
                <p class="text-gray-600 text-sm">Harga mulai dari <strong>Rp350.000 per bulan</strong>. Cocok untuk usaha kecil, jualan, atau penyimpanan stok barang.</p>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('rents.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Lihat Daftar Unit
            </a>
        </div>
    </div>
</x-layout>
