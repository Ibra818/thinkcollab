<?php

namespace App\Services;

use App\Models\PaymentMethod;
use App\Models\PaymentTransaction;
use App\Models\Purchase;
use App\Services\PaymentProviders\PaymentProviderInterface;
use App\Services\PaymentProviders\PayTechProvider;
use App\Services\PaymentProviders\PayDunyaProvider;
use App\Services\PaymentProviders\TouchPointProvider;
use Exception;

class PaymentService
{
    protected array $providers = [
        'touchpoint' => TouchPointProvider::class,
    ];

    /**
     * Get available payment methods
     */
    public function getAvailablePaymentMethods(): array
    {
        return PaymentMethod::active()
            ->orderBy('type')
            ->orderBy('name')
            ->get()
            ->groupBy('type')
            ->toArray();
    }

    /**
     * Initialize payment
     */
    public function initializePayment(Purchase $purchase, PaymentMethod $paymentMethod, array $customerData): PaymentTransaction
    {
        // Calculate fees
        $fees = $paymentMethod->calculateFees($purchase->montant_total);
        
        // Create transaction record
        $transaction = PaymentTransaction::create([
            'purchase_id' => $purchase->id,
            'payment_method_id' => $paymentMethod->id,
            'amount' => $purchase->montant_total,
            'currency' => $paymentMethod->currency,
            'fees' => $fees,
            'status' => 'pending',
            'phone_number' => $customerData['phone_number'] ?? null,
            'customer_name' => $customerData['customer_name'] ?? null,
            'customer_email' => $customerData['customer_email'] ?? null,
            'expires_at' => now()->addMinutes(30), // 30 minutes expiration
        ]);

        try {
            // Get payment provider
            $provider = $this->getProvider($paymentMethod->provider);
            
            // Initialize payment with provider
            $providerResponse = $provider->initializePayment($transaction, $customerData);
            
            // Update transaction with provider response
            $transaction->update([
                'provider_transaction_id' => $providerResponse['transaction_id'] ?? null,
                'provider_reference' => $providerResponse['reference'] ?? null,
                'provider_response' => $providerResponse,
                'status' => $providerResponse['status'] ?? 'pending',
            ]);

            return $transaction;
        } catch (Exception $e) {
            $transaction->markAsFailed($e->getMessage());
            throw $e;
        }
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(PaymentTransaction $transaction): array
    {
        try {
            $provider = $this->getProvider($transaction->paymentMethod->provider);
            $status = $provider->checkPaymentStatus($transaction);
            
            // Update transaction status if changed
            if ($status['status'] !== $transaction->status) {
                if ($status['status'] === 'completed') {
                    $transaction->markAsCompleted($status);
                } elseif ($status['status'] === 'failed') {
                    $transaction->markAsFailed($status['message'] ?? 'Payment failed', $status);
                } else {
                    $transaction->update([
                        'status' => $status['status'],
                        'provider_response' => array_merge($transaction->provider_response ?? [], $status),
                    ]);
                }
            }

            return $status;
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Handle webhook from payment provider
     */
    public function handleWebhook(string $provider, array $payload): bool
    {
        try {
            $providerInstance = $this->getProvider($provider);
            return $providerInstance->handleWebhook($payload);
        } catch (Exception $e) {
            \Log::error('Payment webhook error: ' . $e->getMessage(), [
                'provider' => $provider,
                'payload' => $payload,
            ]);
            return false;
        }
    }

    /**
     * Get payment provider instance
     */
    protected function getProvider(string $provider): PaymentProviderInterface
    {
        if (!isset($this->providers[$provider])) {
            throw new Exception("Payment provider '{$provider}' not supported");
        }

        $providerClass = $this->providers[$provider];
        return new $providerClass();
    }

    /**
     * Cancel payment
     */
    public function cancelPayment(PaymentTransaction $transaction): bool
    {
        if (!$transaction->isPending()) {
            return false;
        }

        try {
            $provider = $this->getProvider($transaction->paymentMethod->provider);
            $result = $provider->cancelPayment($transaction);
            
            if ($result) {
                $transaction->update(['status' => 'cancelled']);
            }
            
            return $result;
        } catch (Exception $e) {
            \Log::error('Payment cancellation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get payment statistics
     */
    public function getPaymentStatistics(): array
    {
        $total = PaymentTransaction::count();
        $completed = PaymentTransaction::completed()->count();
        $pending = PaymentTransaction::pending()->count();
        $failed = PaymentTransaction::failed()->count();

        return [
            'total_transactions' => $total,
            'completed_transactions' => $completed,
            'pending_transactions' => $pending,
            'failed_transactions' => $failed,
            'success_rate' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
            'total_amount' => PaymentTransaction::completed()->sum('amount'),
            'total_fees' => PaymentTransaction::completed()->sum('fees'),
        ];
    }
}
