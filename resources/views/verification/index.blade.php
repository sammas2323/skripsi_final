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

    <!-- Form Verifikasi OTP -->
    <form action="/verify" method="post" class="space-y-4">
      @csrf
      <input type="hidden" value="register" name="type">
        <button type="submit"
           class="w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition">
          Kirim Kode via Gmail
        </button>
      </div>
    </form>
  </div>
</body>
</html>
