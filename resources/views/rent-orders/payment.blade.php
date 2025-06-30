<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-xl mx-auto py-10 text-center">
        <h1 class="text-2xl font-bold mb-4">💳 Pembayaran</h1>
        <p class="mb-6 text-gray-600">Silakan selesaikan pembayaran Anda melalui Midtrans.</p>
        <div id="snap-container" class="mt-6"></div>

        <!-- Loading spinner -->
        <div id="loading" class="flex items-center justify-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <span class="ml-2 text-gray-600">Memuat pembayaran...</span>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
        // Hide loading when snap is ready
        document.getElementById('loading').style.display = 'none';

        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                // Tampilkan pesan loading sebelum redirect
                document.body.innerHTML = '<div class="max-w-xl mx-auto py-20 text-center"><h2 class="text-xl font-bold text-green-600">✅ Pembayaran Berhasil!</h2><p>Mengarahkan ke halaman sukses...</p></div>';
                setTimeout(() => {
                    window.location.href = '/rent-orders/success';
                }, 2000);
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                window.location.href = '/rent-orders/pending';
            },
            onError: function(result) {
                console.log('Payment error:', result);
                alert("Terjadi kesalahan dalam pembayaran: " + (result.status_message || 'Unknown error'));
            },
            onClose: function() {
                alert("Jendela pembayaran ditutup. Anda dapat melanjutkan pembayaran nanti.");
                window.location.href = '/rents';
            }
        });
    </script>
</body>
</html>
