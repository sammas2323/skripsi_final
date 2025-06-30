<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>

  <div class="max-w-3xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">🛒 Checkout</h1>

    <form method="POST" action="{{ route('rent-orders.store') }}" class="bg-white p-6 rounded-lg shadow space-y-6">
      @csrf

      <input type="hidden" name="rent_id" value="{{ $rent->id }}">

      {{-- Nama --}}
      <div>
        <label class="block font-medium text-gray-700 mb-1">👤 Nama Lengkap</label>
        <input
          type="text"
          name="name"
          value="{{ old('name', auth()->user()->name) }}"
          required
          class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"
        >
      </div>

      {{-- Telepon --}}
      <div>
        <label class="block font-medium text-gray-700 mb-1">📞 Nomor Telepon</label>
        <input
          type="text"
          name="phone"
          value="{{ old('phone') }}"
          required
          class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"
        >
      </div>

      {{-- Email --}}
      <div>
        <label class="block font-medium text-gray-700 mb-1">📧 Email</label>
        <input
          type="email"
          name="email"
          value="{{ old('email', auth()->user()->email) }}"
          required
          class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"
        >
      </div>

      {{-- Tanggal mulai --}}
      <div>
        <label class="block font-medium text-gray-700 mb-1">📅 Tanggal Mulai Sewa</label>
        <input
          type="date"
          name="tanggal_mulai_sewa"
          value="{{ old('tanggal_mulai_sewa') }}"
          required
          class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"
        >
      </div>

      {{-- Jumlah Bulan --}}
      <div>
        <label class="block font-medium text-gray-700 mb-1">📆 Jumlah Bulan</label>
        <input
          type="number"
          name="jumlah_bulan"
          value="{{ old('jumlah_bulan') }}"
          min="1"
          required
          class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"
        >
      </div>

      {{-- Tombol --}}
      <div class="pt-4">
        <button type="submit"
          class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-200">
          💳 Lanjutkan ke Pembayaran
        </button>
      </div>
    </form>
  </div>
</x-layout>
