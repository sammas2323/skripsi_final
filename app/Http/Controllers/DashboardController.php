<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentOrder;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Menampilkan semua transaksi (untuk admin) atau hanya milik user login
        $query = RentOrder::with(['rent', 'user'])->orderBy('created_at', 'desc');

        // Jika ingin menampilkan hanya transaksi milik user:
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        // Filter opsional: tanggal mulai sewa
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_mulai_sewa', [$request->start_date, $request->end_date]);
        }

        // Filter berdasarkan keyword (nama/email)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                  ->orWhere('email', 'like', "%$keyword%");
            });
        }

        $transactions = $query->get();

        return view('dashboard.transactions', [
        'transactions' => $transactions,
        'role' => Auth::user()->role,
        'title' => 'Dashboard'
        ]);
    }
}
