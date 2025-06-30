<?php

namespace App\Services;

use App\Models\RentOrder;
use Exception;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransService
{
    protected string $serverKey;
    protected ?Notification $notification = null;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');

        Config::$serverKey = $this->serverKey;
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        try {
            $raw = json_decode(file_get_contents("php://input"), true);

            if (is_array($raw) && isset($raw['transaction_id'])) {
                $this->notification = new Notification();
            }
        } catch (\Exception $e) {
            // \Log::error("MidtransService Notification Error", ['error' => $e->getMessage()]);
            $this->notification = null;
        }
    }

    public function isSignatureKeyVerified(): bool
    {
        if (!$this->notification) return false;

        $localSignatureKey = hash('sha512',
            $this->notification->order_id .
            $this->notification->status_code .
            $this->notification->gross_amount .
            $this->serverKey
        );

        return $localSignatureKey === $this->notification->signature_key;
    }

    public function getOrder(): ?RentOrder
    {
        if (!$this->notification) return null;

        return RentOrder::where('midtrans_order_id', $this->notification->order_id)->first();
    }

    public function getStatus(): string
    {
        if (!$this->notification) return 'unknown';

        return match ($this->notification->transaction_status) {
            'capture' => $this->notification->fraud_status === 'accept' ? 'paid' : 'pending',
            'settlement' => 'paid',
            'deny', 'cancel' => 'failed',
            'expire' => 'failed',
            'pending' => 'unpaid',
            default => 'unpaid',
        };
    }

    public function createSnapToken(RentOrder $order): string
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->midtrans_order_id,
                'gross_amount' => $order->total_harga,
            ],
            'customer_details' => [
                'first_name' => $order->name,
                'email' => $order->email,
                'phone' => $order->phone,
            ],
        ];

        try {
            return Snap::getSnapToken($params);
        } catch (Exception $e) {
            throw new Exception("Midtrans Snap Token Error: " . $e->getMessage());
        }
    }
}
