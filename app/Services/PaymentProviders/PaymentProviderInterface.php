<?php

namespace App\Services\PaymentProviders;

use App\Models\PaymentTransaction;

interface PaymentProviderInterface
{
    /**
     * Initialize payment with the provider
     */
    public function initializePayment(PaymentTransaction $transaction, array $customerData): array;

    /**
     * Check payment status
     */
    public function checkPaymentStatus(PaymentTransaction $transaction): array;

    /**
     * Handle webhook from provider
     */
    public function handleWebhook(array $payload): bool;

    /**
     * Cancel payment
     */
    public function cancelPayment(PaymentTransaction $transaction): bool;

    /**
     * Get provider configuration
     */
    public function getConfig(): array;
}
