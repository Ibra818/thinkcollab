<?php

namespace App\Services\PaymentProviders;

use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class PayDunyaProvider implements PaymentProviderInterface
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('payment.paydunya.base_url', 'https://app.paydunya.com/api/v1');
        $this->apiKey = config('payment.paydunya.api_key');
        $this->secretKey = config('payment.paydunya.secret_key');
    }

    public function initializePayment(PaymentTransaction $transaction, array $customerData): array
    {
        $paymentMethod = $transaction->paymentMethod;
        
        // Create invoice first
        $invoiceData = $this->createInvoice($transaction);
        
        if (!$invoiceData['success']) {
            throw new Exception('Failed to create PayDunya invoice: ' . $invoiceData['message']);
        }

        $invoiceToken = $invoiceData['token'];
        
        // Initialize payment based on method type
        switch ($paymentMethod->code) {
            case 'om_sn':
                return $this->initializeOrangeMoney($transaction, $customerData, $invoiceToken);
            case 'wave_sn':
                return $this->initializeWave($transaction, $customerData, $invoiceToken);
            case 'free_sn':
                return $this->initializeFreeMoney($transaction, $customerData, $invoiceToken);
            case 'expresso_sn':
                return $this->initializeExpresso($transaction, $customerData, $invoiceToken);
            default:
                throw new Exception('Payment method not supported by PayDunya');
        }
    }

    protected function createInvoice(PaymentTransaction $transaction): array
    {
        $purchase = $transaction->purchase;
        $formation = $purchase->formation;

        $data = [
            'invoice' => [
                'total_amount' => $transaction->amount / 100, // Convert from centimes
                'description' => "Achat formation: {$formation->titre}",
            ],
            'store' => [
                'name' => config('app.name', 'Bint School'),
                'website_url' => config('app.url'),
            ],
            'actions' => [
                'cancel_url' => route('payment.cancel', $transaction->transaction_id),
                'return_url' => route('payment.success', $transaction->transaction_id),
            ],
        ];

        $response = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => $this->apiKey,
            'PAYDUNYA-PRIVATE-KEY' => $this->secretKey,
            'PAYDUNYA-TOKEN' => $this->generateToken(),
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/checkout-invoice/create', $data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('PayDunya invoice creation failed: ' . $response->body());
    }

    protected function initializeOrangeMoney(PaymentTransaction $transaction, array $customerData, string $invoiceToken): array
    {
        $data = [
            'customer_name' => $customerData['customer_name'],
            'customer_email' => $customerData['customer_email'],
            'phone_number' => $customerData['phone_number'],
            'invoice_token' => $invoiceToken,
            'api_type' => 'QRCODE', // or 'OTP'
        ];

        $response = Http::post($this->baseUrl . '/softpay/new-orange-money-senegal', $data);

        if ($response->successful()) {
            $result = $response->json();
            return [
                'success' => $result['success'],
                'transaction_id' => $invoiceToken,
                'reference' => $invoiceToken,
                'status' => 'pending',
                'payment_url' => $result['url'] ?? null,
                'qr_code_url' => $result['url'] ?? null,
                'om_url' => $result['other_url']['om_url'] ?? null,
                'provider_response' => $result,
            ];
        }

        throw new Exception('Orange Money initialization failed: ' . $response->body());
    }

    protected function initializeWave(PaymentTransaction $transaction, array $customerData, string $invoiceToken): array
    {
        $data = [
            'wave_senegal_fullName' => $customerData['customer_name'],
            'wave_senegal_email' => $customerData['customer_email'],
            'wave_senegal_phone' => $customerData['phone_number'],
            'wave_senegal_payment_token' => $invoiceToken,
        ];

        $response = Http::post($this->baseUrl . '/softpay/wave-senegal', $data);

        if ($response->successful()) {
            $result = $response->json();
            return [
                'success' => $result['success'],
                'transaction_id' => $invoiceToken,
                'reference' => $invoiceToken,
                'status' => 'pending',
                'payment_url' => $result['url'] ?? null,
                'provider_response' => $result,
            ];
        }

        throw new Exception('Wave initialization failed: ' . $response->body());
    }

    protected function initializeFreeMoney(PaymentTransaction $transaction, array $customerData, string $invoiceToken): array
    {
        $data = [
            'free_money_fullName' => $customerData['customer_name'],
            'free_money_email' => $customerData['customer_email'],
            'free_money_phone' => $customerData['phone_number'],
            'free_money_payment_token' => $invoiceToken,
        ];

        $response = Http::post($this->baseUrl . '/softpay/free-money-senegal', $data);

        if ($response->successful()) {
            $result = $response->json();
            return [
                'success' => $result['success'],
                'transaction_id' => $invoiceToken,
                'reference' => $invoiceToken,
                'status' => 'pending',
                'message' => $result['message'],
                'provider_response' => $result,
            ];
        }

        throw new Exception('Free Money initialization failed: ' . $response->body());
    }

    protected function initializeExpresso(PaymentTransaction $transaction, array $customerData, string $invoiceToken): array
    {
        $data = [
            'expresso_sn_fullName' => $customerData['customer_name'],
            'expresso_sn_email' => $customerData['customer_email'],
            'expresso_sn_phone' => $customerData['phone_number'],
            'payment_token' => $invoiceToken,
        ];

        $response = Http::post($this->baseUrl . '/softpay/expresso-senegal', $data);

        if ($response->successful()) {
            $result = $response->json();
            return [
                'success' => $result['success'],
                'transaction_id' => $invoiceToken,
                'reference' => $invoiceToken,
                'status' => 'pending',
                'message' => $result['message'],
                'provider_response' => $result,
            ];
        }

        throw new Exception('Expresso initialization failed: ' . $response->body());
    }

    public function checkPaymentStatus(PaymentTransaction $transaction): array
    {
        $response = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => $this->apiKey,
            'PAYDUNYA-PRIVATE-KEY' => $this->secretKey,
            'PAYDUNYA-TOKEN' => $this->generateToken(),
        ])->get($this->baseUrl . '/checkout-invoice/confirm/' . $transaction->provider_transaction_id);

        if ($response->successful()) {
            $result = $response->json();
            
            $status = 'pending';
            if ($result['response_code'] === '00') {
                $status = 'completed';
            } elseif (in_array($result['response_code'], ['01', '02', '03'])) {
                $status = 'failed';
            }

            return [
                'status' => $status,
                'provider_status' => $result['response_code'],
                'message' => $result['response_text'] ?? '',
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
            // Verify webhook signature if provided
            if (!$this->verifyWebhookSignature($payload)) {
                Log::warning('PayDunya webhook signature verification failed');
                return false;
            }

            $invoiceToken = $payload['data']['token'] ?? null;
            if (!$invoiceToken) {
                Log::error('PayDunya webhook missing token');
                return false;
            }

            // Find transaction by provider_transaction_id
            $transaction = PaymentTransaction::where('provider_transaction_id', $invoiceToken)->first();
            if (!$transaction) {
                Log::error('PayDunya webhook: transaction not found', ['token' => $invoiceToken]);
                return false;
            }

            // Update transaction status based on webhook data
            $status = $payload['data']['status'] ?? 'pending';
            if ($status === 'completed') {
                $transaction->markAsCompleted($payload);
            } elseif ($status === 'failed') {
                $transaction->markAsFailed($payload['data']['message'] ?? 'Payment failed', $payload);
            }

            return true;
        } catch (Exception $e) {
            Log::error('PayDunya webhook processing error: ' . $e->getMessage());
            return false;
        }
    }

    public function cancelPayment(PaymentTransaction $transaction): bool
    {
        // PayDunya doesn't have a direct cancel API, transactions expire automatically
        return true;
    }

    public function getConfig(): array
    {
        return [
            'name' => 'PayDunya',
            'supported_methods' => ['om_sn', 'wave_sn', 'free_sn', 'expresso_sn'],
            'base_url' => $this->baseUrl,
        ];
    }

    protected function generateToken(): string
    {
        return hash('sha512', $this->apiKey . $this->secretKey);
    }

    protected function verifyWebhookSignature(array $payload): bool
    {
        // Implement signature verification if PayDunya provides it
        return true;
    }
}
