<?php

namespace App\Services\PaymentProviders;

use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class TouchPointProvider implements PaymentProviderInterface
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $webhookSecret;

    public function __construct()
    {
        $this->baseUrl = config('services.intouch.base_uri', 'https://api.touchpoint.intouchgroup.net/v1');
        $this->apiKey = config('services.intouch.api_key');
        $this->webhookSecret = config('services.intouch.webhook_secret');
    }

    public function initializePayment(PaymentTransaction $transaction, array $customerData): array
    {
        $purchase = $transaction->purchase;
        $formation = $purchase->formation;
        $paymentMethod = $transaction->paymentMethod;

        // Prepare payload according to InTouch documentation
        $data = [
            'item_name' => "Formation: {$formation->titre}",
            'item_price' => $transaction->amount / 100, // Convert from centimes to XOF
            'currency' => $transaction->currency,
            'ref_command' => $transaction->transaction_id,
            'command_name' => "Achat formation: {$formation->titre}",
            'success_url' => route('payment.success', $transaction->transaction_id),
            'cancel_url' => route('payment.cancel', $transaction->transaction_id),
            'ipn_url' => route('payment.webhook.touchpoint'),
            'target_payment' => $this->mapPaymentMethodCode($paymentMethod->code),
        ];

        // Add customer data if provided
        if (!empty($customerData['customer_name'])) {
            $data['customer_name'] = $customerData['customer_name'];
        }
        if (!empty($customerData['customer_email'])) {
            $data['customer_email'] = $customerData['customer_email'];
        }
        if (!empty($customerData['phone_number'])) {
            $data['customer_phone'] = $customerData['phone_number'];
        }

        $response = Http::withToken($this->apiKey)
                        ->post($this->baseUrl . '/payment/request-payment', $data);

        if ($response->successful()) {
            $result = $response->json();
            
            // Check if redirect_url is provided
            if (isset($result['redirect_url'])) {
                return [
                    'success' => true,
                    'transaction_id' => $transaction->transaction_id,
                    'reference' => $transaction->transaction_id,
                    'status' => 'pending',
                    'payment_url' => $result['redirect_url'],
                    'provider_response' => $result,
                ];
            } else {
                throw new Exception('TouchPoint payment initialization failed: No redirect URL provided');
            }
        }

        throw new Exception('TouchPoint API request failed: ' . $response->body());
    }

    public function checkPaymentStatus(PaymentTransaction $transaction): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'X-API-Secret' => $this->secretKey,
        ])->get($this->baseUrl . '/payments/' . $transaction->provider_transaction_id . '/status');

        if ($response->successful()) {
            $result = $response->json();
            
            if ($result['success'] ?? false) {
                $paymentStatus = $result['data']['status'] ?? 'pending';
                
                $status = match($paymentStatus) {
                    'completed', 'success', 'paid' => 'completed',
                    'failed', 'declined', 'error' => 'failed',
                    'cancelled', 'canceled' => 'cancelled',
                    default => 'pending'
                };

                return [
                    'status' => $status,
                    'provider_status' => $paymentStatus,
                    'message' => $result['data']['message'] ?? '',
                    'provider_response' => $result,
                ];
            }
        }

        return [
            'status' => 'error',
            'message' => 'Failed to check payment status',
        ];
    }

    public function handleWebhook(array $payload): bool
    {
        try {
            // Verify webhook signature according to InTouch documentation
            if (!$this->verifyWebhookSignature()) {
                Log::warning('TouchPoint webhook signature verification failed');
                return false;
            }

            $refCommand = $payload['ref_command'] ?? null;
            $status = $payload['status'] ?? null;
            
            if (!$refCommand || !$status) {
                Log::error('TouchPoint webhook missing required fields', [
                    'ref_command' => $refCommand,
                    'status' => $status
                ]);
                return false;
            }

            // Find transaction by transaction_id (ref_command)
            $transaction = PaymentTransaction::where('transaction_id', $refCommand)->first();
            if (!$transaction) {
                Log::error('TouchPoint webhook: transaction not found', ['ref_command' => $refCommand]);
                return false;
            }

            // Update transaction status based on webhook data
            switch (strtoupper($status)) {
                case 'SUCCESS':
                    $transaction->markAsCompleted($payload);
                    break;
                case 'FAILED':
                case 'CANCELLED':
                case 'CANCELED':
                    $transaction->markAsFailed($payload['message'] ?? 'Payment failed', $payload);
                    break;
                default:
                    // Update with current status but don't change to completed/failed
                    $transaction->update([
                        'provider_response' => array_merge($transaction->provider_response ?? [], $payload),
                    ]);
            }

            return true;
        } catch (Exception $e) {
            Log::error('TouchPoint webhook processing error: ' . $e->getMessage());
            return false;
        }
    }

    public function cancelPayment(PaymentTransaction $transaction): bool
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'X-API-Secret' => $this->secretKey,
        ])->post($this->baseUrl . '/payments/' . $transaction->provider_transaction_id . '/cancel');

        if ($response->successful()) {
            $result = $response->json();
            return $result['success'] ?? false;
        }

        return false;
    }

    public function getConfig(): array
    {
        return [
            'name' => 'TouchPoint',
            'supported_methods' => ['card', 'om_sn', 'wave_sn', 'free_sn'],
            'base_url' => $this->baseUrl,
            'features' => [
                'qr_code' => true,
                'ussd' => true,
                'mobile_redirect' => true,
            ],
        ];
    }

    protected function mapPaymentMethodCode(string $code): string
    {
        return match($code) {
            'om_sn' => 'Orange Money',
            'wave_sn' => 'Wave',
            'free_sn' => 'Free Money',
            'wizall_sn' => 'Wizall',
            default => $code
        };
    }

    protected function verifyWebhookSignature(): bool
    {
        // InTouch webhook signature verification using Bearer token
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $expectedAuth = 'Bearer ' . $this->webhookSecret;
        
        return hash_equals($expectedAuth, $authHeader);
    }
}
