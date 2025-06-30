<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rent Order #{{ $order->midtrans_order_id }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>
<div class="container py-5">
    <div class="row">
        <div class="col-12 col-md-8 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5>Data Sewa</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-condensed mb-0">
                        <tr>
                            <td>ID Order</td>
                            <td><strong>#{{ $order->midtrans_order_id }}</strong></td>
                        </tr>
                        <tr>
                            <td>Nama Penyewa</td>
                            <td><strong>{{ $order->name }}</strong></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><strong>{{ $order->email }}</strong></td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td><strong>{{ $order->phone }}</strong></td>
                        </tr>
                        <tr>
                            <td>Tanggal Mulai Sewa</td>
                            <td><strong>{{ \Carbon\Carbon::parse($order->tanggal_mulai_sewa)->translatedFormat('d F Y') }}</strong></td>
                        </tr>
                        <tr>
                            <td>Jumlah Bulan</td>
                            <td><strong>{{ $order->jumlah_bulan }} bulan</strong></td>
                        </tr>
                        <tr>
                            <td>Total Harga</td>
                            <td><strong>Rp {{ number_format($order->total_harga, 2, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td>Status Order</td>
                            <td><strong>{{ ucfirst($order->status) }}</strong></td>
                        </tr>
                        <tr>
                            <td>Status Pembayaran</td>
                            <td><strong class="{{ $order->status_payment === 'paid' ? 'text-success' : 'text-warning' }}">
                                {{ ucfirst($order->status_payment) }}
                            </strong></td>
                        </tr>
                        <tr>
                            <td>Tanggal Dibuat</td>
                            <td><strong>{{ $order->created_at->format('d M Y H:i') }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Kolom Pembayaran --}}
        <div class="col-12 col-md-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5>Pembayaran</h5>
                </div>
                <div class="card-body">
                    @if ($order->status_payment === 'unpaid' && $snapToken)
                        <button class="btn btn-primary w-100" id="pay-button">Bayar Sekarang</button>
                    @elseif ($order->status_payment === 'paid')
                        <div class="alert alert-success mb-0">
                            ✅ Pembayaran berhasil.
                        </div>
                    @elseif ($order->status_payment === 'failed')
                        <div class="alert alert-danger mb-0">
                            ❌ Pembayaran gagal. Silakan coba lagi.
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            ⏳ Menunggu pembayaran...
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Snap Midtrans --}}
@if ($order->status_payment === 'unpaid' && $snapToken)
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function (e) {
        e.preventDefault();
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                // Tampilkan pesan loading sebelum redirect
                document.body.innerHTML = '<div class="max-w-xl mx-auto py-20 text-center"><h2 class="text-xl font-bold text-green-600">✅ Pembayaran Berhasil!</h2><p>Mengarahkan ke halaman sukses...</p></div>';
                setTimeout(() => {
                    window.location.href = '/rent-orders/{{ $order->id }}/success';
                }, 2000);
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                window.location.href = '/rent/pending';
            },
            onError: function(result) {
                console.log('Payment error:', result);
                window.location.href = '/rent/error';
            },
            onClose: function() {
                alert("Jendela pembayaran ditutup. Anda dapat melanjutkan pembayaran nanti.");
                window.location.href = '/rents';
            }
        });
    });
</script>
@endif
</body>
</html>
