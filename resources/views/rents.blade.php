<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>

  @auth
  @if(auth()->user()->role === 'admin')
  <form id="bulk-delete-form" action="{{ route('rents.bulkDelete') }}" method="POST">
    @csrf
    @method('DELETE')
  @endif
  @endauth

  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Daftar Kontrakan</h1>
    @auth
    @if(auth()->user()->role === 'admin')
    <div class="flex gap-2">
      <a href="{{ route('rents.create') }}"
        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
        + Tambah Kontrakan
      </a>
      <button type="submit"
        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
        Hapus Terpilih
      </button>
    </div>
    @endif
    @endauth
  </div>

  <!-- Grid Kontrakan -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($rents as $rent)
    <div class="bg-white rounded-xl shadow-md overflow-hidden relative">
      @auth
      @if(auth()->user()->role === 'admin')
      <input type="checkbox" name="selected_rents[]" value="{{ $rent->id }}"
        class="absolute top-2 left-2 w-4 h-4 text-blue-600">
      @endif
      @endauth

      <img src="{{ asset('storage/' . $rent->image) }}" alt="Kontrakan" class="w-full h-48 object-cover">
      <div class="p-4 space-y-2">
        <h2 class="text-xl font-semibold">{{ $rent->title }}</h2>
        <p class="text-sm text-gray-600">{{ $rent->address }}</p>
        <p class="text-green-600 font-bold text-lg">Rp.{{ $rent->price }}</p>
        <a href="/rents/{{ $rent->slug }}"
          class="block text-center bg-gray-100 hover:bg-gray-200 py-2 rounded-lg mt-2">Lihat Detail</a>
      </div>
    </div>
    @endforeach
  </div>

  @auth
  @if(auth()->user()->role === 'admin')
  </form>
  @endif
  @endauth

  @auth
  @if(auth()->user()->role === 'admin')
  <script>
    const form = document.getElementById('bulk-delete-form');

    form?.addEventListener('submit', function (e) {
      const checkboxes = document.querySelectorAll('input[name="selected_rents[]"]:checked');

      if (checkboxes.length === 0) {
        e.preventDefault(); // Batalkan submit
        Swal.fire({
          icon: 'warning',
          title: 'Tidak Ada Kontrakan Yang Terpilih',
          text: 'Silakan pilih minimal satu kontrakan untuk dihapus.',
          confirmButtonColor: '#d33',
        });
      } else {
        e.preventDefault(); // Batalkan submit sementara
        Swal.fire({
          title: 'Yakin ingin menghapus kontrakan yang dipilih?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal',
          confirmButtonColor: '#d33'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit(); // Kirim form jika dikonfirmasi
          }
        });
      }
    });
  </script>
  @endif
  @endauth

</x-layout>
