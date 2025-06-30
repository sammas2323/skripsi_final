<?php

namespace App\Http\Controllers;

use App\Models\RentOrder;
use Illuminate\Http\Request;
use App\Services\MidtransService;

class MidtransController extends Controller
{
    public function callback(Request $request, MidtransService $midtransService)
    {
        // Log untuk debugging
        // Log::info('Midtrans Callback:', $request->all());

        if ($midtransService->isSignatureKeyVerified()) {
            $order = $midtransService->getOrder();

            if (!$order) {
                // \Log::error('Order tidak ditemukan untuk callback Midtrans');
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak ditemukan',
                ], 404);
            }

            $status = $midtransService->getStatus();
            // \Log::info('Status dari Midtrans:', ['status' => $status, 'order_id' => $order->midtrans_order_id]);

            // Perbaiki status mapping
            if ($status === 'paid') {
                $order->update([
                    'status' => 'processing',
                    'status_payment' => 'paid',
                ]);
                // \Log::info('Order berhasil diupdate ke paid', ['order_id' => $order->id]);
            } elseif ($status === 'pending') {
                // Status tetap pending
            } elseif (in_array($status, ['expire', 'cancel', 'deny', 'failure'])) {
                $order->update([
                    'status' => 'cancelled',
                    'status_payment' => 'failed',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil diproses',
            ]);
        } else {
            // \Log::error('Signature verification failed untuk Midtrans callback');
            return response()->json([
                'message' => 'Unauthorized signature',
            ], 401);
        }
    }
}
