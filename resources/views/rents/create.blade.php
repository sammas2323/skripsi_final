<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>

  <div class="max-w-3xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">📝 Tambah Kontrakan Baru</h1>

    <form action="{{ route('rents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white shadow-xl rounded-lg p-6">
      @csrf

      {{-- Gambar --}}
      <div>
        <label class="block font-semibold mb-1 text-gray-700">📷 Gambar Kontrakan</label>
        <input type="file" name="images[]" multiple class="w-full border border-gray-300 rounded px-3 py-2 file:bg-blue-600 file:text-white file:rounded file:px-4 file:py-1 file:border-none hover:file:bg-blue-700 transition-all">
        <p class="text-sm text-gray-500 mt-1">Bisa memilih beberapa gambar sekaligus</p>
      </div>

      {{-- Judul --}}
      <div>
        <label class="block font-semibold mb-1 text-gray-700">🏠 Judul</label>
        <input type="text" name="title" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('title') }}">
      </div>

      {{-- Alamat --}}
      <div>
        <label class="block font-semibold mb-1 text-gray-700">📍 Alamat</label>
        <textarea name="address" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 resize-none focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('address') }}</textarea>
      </div>

      {{-- Harga --}}
      <div>
        <label class="block font-semibold mb-1 text-gray-700">💰 Harga (Rp)</label>
        <input type="text" name="price" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('price') }}">
      </div>

      {{-- Detail Kontrakan --}}
      <div class="pt-6 border-t">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">🏗️ Detail Kontrakan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-gray-700 font-medium mb-1">🛏️ Kamar Tidur</label>
            <input type="number" name="bedrooms" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('bedrooms') }}">
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">🚿 Kamar Mandi</label>
            <input type="number" name="bathrooms" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('bathrooms') }}">
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">📐 Luas Bangunan (m²)</label>
            <input type="number" name="building_size" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('building_size') }}">
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">⚡ Listrik</label>
            <input type="text" name="electricity" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('electricity') }}">
          </div>

          <div class="md:col-span-2">
            <label class="block text-gray-700 font-medium mb-1">💧 Air</label>
            <input type="text" name="water" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('water') }}">
          </div>
        </div>
      </div>

      {{-- Tombol --}}
      <div class="pt-4">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold text-sm shadow transition-all">
          💾 Simpan Kontrakan
        </button>
      </div>
    </form>
  </div>
</x-layout>
