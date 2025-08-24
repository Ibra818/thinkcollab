<?php

namespace App\Services\PaymentProviders;

use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class PayTechProvider implements PaymentProviderInterface
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('payment.paytech.base_url', 'https://paytech.sn/api/payment');
        $this->apiKey = config('payment.paytech.api_key');
        $this->secretKey = config('payment.paytech.secret_key');
    }

    public function initializePayment(PaymentTransaction $transaction, array $customerData): array
    {
        $purchase = $transaction->purchase;
        $formation = $purchase->formation;

        $data = [
            'item_name' => "Formation: {$formation->titre}",
            'item_price' => $transaction->amount / 100, // Convert from centimes
            'currency' => $transaction->currency,
            'ref_command' => $transaction->transaction_id,
            'command_name' => "Achat formation {$formation->titre}",
            'env' => config('payment.paytech.environment', 'test'), // test or prod
            'ipn_url' => route('payment.webhook.paytech'),
            'success_url' => route('payment.success', $transaction->transaction_id),
            'cancel_url' => route('payment.cancel', $transaction->transaction_id),
            'custom_field' => json_encode([
                'transaction_id' => $transaction->transaction_id,
                'purchase_id' => $purchase->id,
                'user_id' => $purchase->user_id,
            ]),
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

        $response = Http::withHeaders([
            'API_KEY' => $this->apiKey,
            'API_SECRET' => $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/request-payment', $data);

        if ($response->successful()) {
            $result = $response->json();
            
            if ($result['success'] === 1) {
                return [
                    'success' => true,
                    'transaction_id' => $result['token'],
                    'reference' => $result['token'],
                    'status' => 'pending',
                    'payment_url' => $result['redirect_url'],
                    'provider_response' => $result,
                ];
            } else {
                throw new Exception('PayTech payment initialization failed: ' . ($result['errors'] ?? 'Unknown error'));
            }
        }

        throw new Exception('PayTech API request failed: ' . $response->body());
    }

    public function checkPaymentStatus(PaymentTransaction $transaction): array
    {
        $response = Http::withHeaders([
            'API_KEY' => $this->apiKey,
            'API_SECRET' => $this->secretKey,
        ])->post($this->baseUrl . '/payment-status', [
            'token' => $transaction->provider_transaction_id,
        ]);

        if ($response->successful()) {
            $result = $response->json();
            
            $status = 'pending';
            if ($result['success'] === 1) {
                switch ($result['type_event']) {
                    case 'sale_complete':
                        $status = 'completed';
                        break;
                    case 'sale_canceled':
                    case 'sale_failed':
                        $status = 'failed';
                        break;
                    default:
                        $status = 'pending';
                }
            }

            return [
                'status' => $status,
                'provider_status' => $result['type_event'] ?? 'unknown',
                'message' => $result['message'] ?? '',
                'provider_response' => $result,
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Failed to check payment status',
        ];
    }

    public function handleWebhook(array $payload): bool
    {
        try {
            // Verify webhook signature
            if (!$this->verifyWebhookSignature($payload)) {
                Log::warning('PayTech webhook signature verification failed');
                return false;
            }

            $token = $payload['token'] ?? null;
            if (!$token) {
                Log::error('PayTech webhook missing token');
                return false;
            }

            // Find transaction by provider_transaction_id
            $transaction = PaymentTransaction::where('provider_transaction_id', $token)->first();
            if (!$transaction) {
                Log::error('PayTech webhook: transaction not found', ['token' => $token]);
                return false;
            }

            // Update transaction status based on webhook data
            $typeEvent = $payload['type_event'] ?? '';
            
            switch ($typeEvent) {
                case 'sale_complete':
                    $transaction->markAsCompleted($payload);
                    break;
                case 'sale_canceled':
                case 'sale_failed':
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
            Log::error('PayTech webhook processing error: ' . $e->getMessage());
            return false;
        }
    }

    public function cancelPayment(PaymentTransaction $transaction): bool
    {
        $response = Http::withHeaders([
            'API_KEY' => $this->apiKey,
            'API_SECRET' => $this->secretKey,
        ])->post($this->baseUrl . '/cancel-payment', [
            'token' => $transaction->provider_transaction_id,
        ]);

        if ($response->successful()) {
            $result = $response->json();
            return $result['success'] === 1;
        }

        return false;
    }

    public function getConfig(): array
    {
        return [
            'name' => 'PayTech',
            'supported_methods' => ['card', 'om_sn', 'wave_sn', 'free_sn'],
            'base_url' => $this->baseUrl,
            'fees' => [
                'card' => '2.5%',
                'mobile_money' => '1.5-2.0%',
            ],
        ];
    }

    protected function verifyWebhookSignature(array $payload): bool
    {
        // PayTech webhook signature verification
        $signature = $_SERVER['HTTP_SIGNATURE'] ?? '';
        if (empty($signature)) {
            return false;
        }

        $expectedSignature = hash_hmac('sha256', json_encode($payload), $this->secretKey);
        return hash_equals($expectedSignature, $signature);
    }
}
