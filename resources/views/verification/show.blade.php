<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verifikasi OTP</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Verifikasi OTP</h2>

    @if(session('failed'))
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">{{ session('failed') }}</div>
    @endif

    @if(session('success'))
      <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <form action="/verify/{{ $unique_id }}" method="post" class="space-y-4">
      @method('PUT')
      @csrf
      <label for="otp" class="block text-sm font-medium text-gray-700">Masukkan Kode OTP</label>
      <input
        type="text"
        name="otp"
        id="otp"
        maxlength="6"
        required
        inputmode="numeric"
        pattern="[0-9]*"
        class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
        placeholder="Contoh: 123456"
      >

      <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        Verifikasi
      </button>
    </form>

    <div class="mt-6 text-sm text-center text-gray-600">
      Tidak menerima kode? <a href="" class="text-blue-600 hover:underline">Kirim ulang</a>
    </div>
  </div>
</body>
<script>
  document.getElementById('otp').addEventListener('input', function (e) {
    this.value = this.value.replace(/\D/g, '');
  });
</script>
</html>
