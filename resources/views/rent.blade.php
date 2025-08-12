<x-layout>
    {{-- <x-slot:header>{{ $header }}</x-slot:header> --}}
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <body class="bg-gray-100">

  <div class="max-w-4xl mx-auto px-4 py-8">
    <a href="/rents" class="text-blue-600 hover:underline mb-4 inline-block">&larr; Kembali ke daftar</a>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <!-- Gambar Kontrakan -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        @foreach ($rent->images as $image)
        <img src="{{ asset('storage/' . $image->path) }}" alt="Gambar Kontrakan" class="rounded shadow w-full max-h-96 object-cover">
        @endforeach
    </div>

      <div class="p-6 space-y-4">
        <!-- Judul -->
        <h1 class="text-3xl font-bold">{{ $rent->title }}</h1>

        <!-- Lokasi -->
        <p class="text-gray-600 text-sm">
          {{ $rent['address'] }}
        </p>

        <!-- Harga -->
        <p class="text-green-600 text-2xl font-bold">
          {{ $rent['price'] }}
        </p>

        <!-- Detail Fasilitas -->
        <div class="text-gray-700 space-y-1">
          <p><strong>Kamar Tidur:</strong> {{ $rent->detail->bedrooms }}</p>
          <p><strong>Kamar Mandi:</strong> {{ $rent->detail->bathrooms }}</p>
          <p><strong>Luas Bangunan:</strong> {{ $rent->detail->building_size }} m</p>
          <p><strong>Listrik:</strong> {{ $rent->detail->electricity }}</p>
          <p><strong>Air:</strong> {{ $rent->detail->water }}</p>
        </div>

        <!-- Deskripsi -->
        <div>
          <h2 class="text-lg font-semibold mt-4">Deskripsi</h2>
          <p class="text-gray-700 mt-1">
            Kontrakan nyaman cocok untuk keluarga kecil, lokasi strategis dekat dengan sekolah dan pasar. Lingkungan aman dan tenang.
          </p>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-6 flex gap-4">
          <a href="{{ route('rent-orders.create') }}?rent_id={{ $rent->id }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Lanjut Sewa</a>          
        </div>
      </div>
    </div>
  </div>

</body>
</x-layout>