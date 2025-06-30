<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\RentOrder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RentOrderController extends Controller
{
    public function create(Request $request)
    {
        $rentId = $request->query('rent_id');
        $rent = Rent::findOrFail($rentId);

        return view('rent-orders.create', [
            'title' => 'Form Penyewaan',
            'rent' => $rent,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rent_id' => 'required|exists:rents,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'tanggal_mulai_sewa' => 'required|date|after_or_equal:today',
            'jumlah_bulan' => 'required|integer|min:1',
        ]);

        $rent = Rent::findOrFail($request->rent_id);
        $totalHarga = $rent->price * $request->jumlah_bulan;

        $rentOrder = RentOrder::create([
            'midtrans_order_id' => 'ORDER-' . Str::uuid()->toString(),
            'rent_id' => $rent->id,
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'tanggal_mulai_sewa' => $request->tanggal_mulai_sewa,
            'jumlah_bulan' => $request->jumlah_bulan,
            'total_harga' => $totalHarga,
        ]);
         return redirect()->route('rent-orders.show', $rentOrder->id);
    }

    public function show(MidtransService $midtransService, $id)
    {
        $order = RentOrder::findOrFail($id);

        if ($order->status_payment === 'unpaid') {
            $snapToken = $midtransService->createSnapToken($order);
        } else {
            $snapToken = null; // Bisa juga disimpan ke kolom `snap_token` kalau mau reuse
        }

        return view('rent-orders.show', [
            'order' => $order,
            'snapToken' => $snapToken,
            'title' => 'Detail Pemesanan'
        ]);
    }

    public function success($id)
    {
        $order = RentOrder::with('rent')->findOrFail($id);

        return view('rent-orders.success', [
            'title' => 'Pembayaran Berhasil',
            'order' => $order
        ]);
    }



    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:rent_orders,id'
        ]);

        RentOrder::whereIn('id', $request->ids)->delete();

        return back()->with('success', 'Pesanan berhasil dihapus.');
    }

    // ➕ Tambahkan ke Google Calendar secara manual setelah pembayaran
    public function addToCalendar($id){
    $order = RentOrder::with('rent')->findOrFail($id);
    $user = Auth::user();

    if (!$user->google_access_token || !$user->google_refresh_token) {
        return redirect()->route('google.oauth')->with('error', 'Silakan hubungkan akun Google Anda terlebih dahulu.');
    }

    try {
        $calendarService = new GoogleCalendarService($user);

        $start = Carbon::parse($order->tanggal_mulai_sewa)->startOfDay();
        $end = $start->copy()->addMonths((int) $order->jumlah_bulan)->startOfDay();

        $judul = 'Sewa: ' . ($order->rent->title ?? 'Tanpa Nama Kontrakan');
        $deskripsi = 'Sewa oleh ' . $order->name . ' selama ' . $order->jumlah_bulan . ' bulan.';

        $calendarService->createEvent(
            $judul,
            $deskripsi,
            $start->toRfc3339String(),
            $end->toRfc3339String()
        );

            return back()->with('success', 'Event berhasil ditambahkan ke Google Calendar.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan event ke Google Calendar.');
        }
    }

}
