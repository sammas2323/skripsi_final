<x-layout>
    {{-- <x-slot:header>{{ $header }}</x-slot:header> --}}
    <x-slot:title>{{ $title }}</x-slot:title>

     <section id="home" class="pt-32 pb-16 bg-indigo-600 text-white text-center">
        <div class="max-w-5xl mx-auto px-4">
            <h2 class="text-4xl font-bold mb-4">Selamat datang di Kontrakan Tony</h2>
            <p class="text-lg mb-6">Temukan rumah kontrakan terbaik sesuai kebutuhan dan budget Anda.</p>
            <a href="/rents" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">Lihat Properti</a>
        </div>
    </section>

    <section id="listings" class="py-16 bg-gray-100">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-2xl font-bold text-center mb-10">Daftar Kontrakan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      <!-- Kartu Kontrakan -->
      
      @foreach ($rents as $rent)
      <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <img src="{{ asset('storage/' . $rent->image) }}" alt="Kontrakan A" class="w-full h-48 object-cover">
        <div class="p-4 space-y-2">
          <h2 class="text-xl font-semibold">{{ $rent['title'] }}</h2>
          <p class="text-sm text-gray-600">{{ $rent['address'] }}</p>
          <p class="text-green-600 font-bold text-lg">Rp.{{ $rent['price'] }}</p>
          <p class="text-sm text-gray-500">{{ $rent['type'] }}</p>
          <a href="/rents/{{ $rent['slug'] }}" class="block text-center bg-gray-100 hover:bg-gray-200 py-2 rounded-lg mt-2">Lihat Detail</a>
        </div>
      </div>
      @endforeach
</x-layout>