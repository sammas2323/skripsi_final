<x-layout>
  <x-slot name="title">{{ $title }}</x-slot>

  <div class="py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Daftar Transaksi</h1>

    {{-- Filter dan Tombol Hapus --}}
    <form method="GET" action="{{ route('dashboard') }}">
      <div class="flex justify-between items-center mb-4">
        <div class="flex items-center gap-2 flex-wrap">
          <input type="text" name="keyword" placeholder="Cari nama/email" value="{{ request('keyword') }}" class="border rounded px-2 py-1 text-sm w-64">
          <input type="date" name="start_date" value="{{ request('start_date') }}" class="border rounded px-2 py-1 text-sm">
          <span>-</span>
          <input type="date" name="end_date" value="{{ request('end_date') }}" class="border rounded px-2 py-1 text-sm">
          <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm">Filter</button>
        </div>

        @if ($role === 'admin' && $transactions->count())
        <button type="button" id="delete-selected-btn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
          Hapus yang dipilih
        </button>
        @endif
      </div>
    </form>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white shadow rounded-lg">
      <form id="bulk-delete-form" method="POST" action="{{ route('rent-orders.bulkDelete') }}">
        @csrf
        @method('DELETE')

        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              @if ($role === 'admin')
                <th class="px-4 py-2"><input type="checkbox" id="select-all" class="form-checkbox"></th>
              @endif
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
              @if ($role === 'admin')
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pengguna</th>
              @endif
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Telepon</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mulai Sewa</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($transactions as $transaction)
              <tr>
                @if ($role === 'admin')
                  <td class="px-4 py-2 text-sm"><input type="checkbox" name="selected_ids[]" value="{{ $transaction->id }}" class="form-checkbox"></td>
                @endif
                <td class="px-4 py-2 text-sm text-gray-700">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">
                  {{ $transaction->name }}
                  @if ($transaction->user_id === auth()->id())
                    <span class="text-xs text-green-600">(Anda)</span>
                  @endif
                </td>
                @if ($role === 'admin')
                  <td class="px-4 py-2 text-sm text-gray-700">{{ $transaction->user->name ?? '-' }}</td>
                @endif
                <td class="px-4 py-2 text-sm text-gray-700">{{ $transaction->email }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $transaction->phone }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $transaction->tanggal_mulai_sewa->format('d M Y') }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $transaction->jumlah_bulan }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">Rp{{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                <td class="px-4 py-2 text-sm">
                    @if ($transaction->status_payment === 'paid')
                        <span class="text-green-800 bg-green-100 px-2 py-1 rounded text-xs font-medium">Lunas</span>
                    @elseif ($transaction->status_payment === 'unpaid')
                        <span class="text-yellow-800 bg-yellow-100 px-2 py-1 rounded text-xs font-medium">Menunggu</span>
                    @elseif ($transaction->status_payment === 'failed')
                        <span class="text-red-800 bg-red-100 px-2 py-1 rounded text-xs font-medium">Gagal</span>
                    @else
                        <span class="text-gray-800 bg-gray-100 px-2 py-1 rounded text-xs font-medium capitalize">{{ $transaction->status_payment ?? '-' }}</span>
                    @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="10" class="text-center text-gray-500 py-4 text-sm">Tidak ada transaksi ditemukan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </form>
    </div>
  </div>

  {{-- SweetAlert & Delete Logic --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const deleteBtn = document.getElementById('delete-selected-btn');
      const form = document.getElementById('bulk-delete-form');

      deleteBtn?.addEventListener('click', () => {
        const selected = form.querySelectorAll('input[name="selected_ids[]"]:checked');
        if (selected.length === 0) {
          Swal.fire('Oops!', 'Pilih minimal satu transaksi.', 'warning');
          return;
        }

        Swal.fire({
          title: 'Yakin ingin menghapus?',
          text: 'Data yang dihapus tidak bisa dikembalikan!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#e3342f',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Ya, hapus',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) form.submit();
        });
      });

      document.getElementById('select-all')?.addEventListener('change', (e) => {
        form.querySelectorAll('input[name="selected_ids[]"]').forEach(cb => cb.checked = e.target.checked);
      });
    });
  </script>

  {{-- Flash Alerts --}}
  @if (session('success'))
    <script>
      Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 2000, showConfirmButton: false });
    </script>
  @endif
  @if (session('error'))
    <script>
      Swal.fire({ icon: 'error', title: 'Gagal', text: '{{ session("error") }}', timer: 3000, showConfirmButton: false });
    </script>
  @endif
</x-layout>
