<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\PaymentTransaction;
use App\Models\Purchase;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Get available payment methods
     */
    public function getPaymentMethods(): JsonResponse
    {
        $methods = $this->paymentService->getAvailablePaymentMethods();
        
        return response()->json([
            'success' => true,
            'data' => $methods,
        ]);
    }

    /**
     * Initialize payment for a purchase
     */
    public function initializePayment(Request $request): JsonResponse
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        try {
            DB::beginTransaction();

            $purchase = Purchase::findOrFail($request->purchase_id);
            $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);

            // Check if user can make this purchase
            if ($purchase->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to make this purchase',
                ], 403);
            }

            // Check if purchase is already completed
            if ($purchase->statut === 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase already completed',
                ], 400);
            }

            // Check if payment method is active
            if (!$paymentMethod->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment method not available',
                ], 400);
            }

            $customerData = [
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'phone_number' => $request->phone_number,
            ];

            $transaction = $this->paymentService->initializePayment($purchase, $paymentMethod, $customerData);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => [
                    'transaction_id' => $transaction->transaction_id,
                    'amount' => $transaction->amount,
                    'fees' => $transaction->fees,
                    'total_amount' => $transaction->getTotalAmount(),
                    'currency' => $transaction->currency,
                    'status' => $transaction->status,
                    'payment_url' => $transaction->provider_response['payment_url'] ?? null,
                    'qr_code_url' => $transaction->provider_response['qr_code_url'] ?? null,
                    'ussd_code' => $transaction->provider_response['ussd_code'] ?? null,
                    'om_url' => $transaction->provider_response['om_url'] ?? null,
                    'expires_at' => $transaction->expires_at,
                ],
                'message' => 'Payment initialized successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment initialization error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Payment initialization failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(string $transactionId): JsonResponse
    {
        $transaction = PaymentTransaction::where('transaction_id', $transactionId)->first();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }

        // Check if user can access this transaction
        if ($transaction->purchase->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to access this transaction',
            ], 403);
        }

        try {
            $status = $this->paymentService->checkPaymentStatus($transaction);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'transaction_id' => $transaction->transaction_id,
                    'status' => $transaction->fresh()->status,
                    'amount' => $transaction->amount,
                    'fees' => $transaction->fees,
                    'total_amount' => $transaction->getTotalAmount(),
                    'currency' => $transaction->currency,
                    'paid_at' => $transaction->paid_at,
                    'provider_status' => $status['provider_status'] ?? null,
                    'message' => $status['message'] ?? '',
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Payment status check error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to check payment status',
            ], 500);
        }
    }

    /**
     * Cancel payment
     */
    public function cancelPayment(string $transactionId): JsonResponse
    {
        $transaction = PaymentTransaction::where('transaction_id', $transactionId)->first();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }

        // Check if user can cancel this transaction
        if ($transaction->purchase->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to cancel this transaction',
            ], 403);
        }

        if (!$transaction->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot cancel transaction with status: ' . $transaction->status,
            ], 400);
        }

        try {
            $result = $this->paymentService->cancelPayment($transaction);
            
            return response()->json([
                'success' => $result,
                'message' => $result ? 'Payment cancelled successfully' : 'Failed to cancel payment',
            ]);

        } catch (\Exception $e) {
            Log::error('Payment cancellation error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel payment',
            ], 500);
        }
    }

    /**
     * Get user's payment transactions
     */
    public function getUserTransactions(Request $request): JsonResponse
    {
        $transactions = PaymentTransaction::whereHas('purchase', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->with(['purchase.formation', 'paymentMethod'])
        ->orderBy('created_at', 'desc')
        ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $transactions,
        ]);
    }

    /**
     * Payment success callback
     */
    public function paymentSuccess(string $transactionId)
    {
        $transaction = PaymentTransaction::where('transaction_id', $transactionId)->first();

        if (!$transaction) {
            return redirect()->to(config('app.frontend_url') . '/payment/error?message=Transaction not found');
        }

        // Check payment status one more time
        try {
            $this->paymentService->checkPaymentStatus($transaction);
            $transaction->refresh();
        } catch (\Exception $e) {
            Log::error('Payment success callback error: ' . $e->getMessage());
        }

        $status = $transaction->status;
        $message = match($status) {
            'completed' => 'Payment completed successfully',
            'pending' => 'Payment is being processed',
            'failed' => 'Payment failed',
            default => 'Payment status unknown'
        };

        return redirect()->to(config('app.frontend_url') . "/payment/{$status}?transaction_id={$transactionId}&message=" . urlencode($message));
    }

    /**
     * Payment cancel callback
     */
    public function paymentCancel(string $transactionId)
    {
        $transaction = PaymentTransaction::where('transaction_id', $transactionId)->first();

        if ($transaction && $transaction->isPending()) {
            $transaction->update(['status' => 'cancelled']);
        }

        return redirect()->to(config('app.frontend_url') . '/payment/cancelled?transaction_id=' . $transactionId);
    }

    /**
     * TouchPoint webhook handler
     */
    public function touchPointWebhook(Request $request): JsonResponse
    {
        $result = $this->paymentService->handleWebhook('touchpoint', $request->all());
        
        return response()->json([
            'success' => $result,
        ], $result ? 200 : 400);
    }

    /**
     * PayTech webhook handler
     */
    public function payTechWebhook(Request $request): JsonResponse
    {
        $result = $this->paymentService->handleWebhook('paytech', $request->all());
        
        return response()->json([
            'success' => $result,
        ], $result ? 200 : 400);
    }

    /**
     * PayDunya webhook handler
     */
    public function payDunyaWebhook(Request $request): JsonResponse
    {
        $result = $this->paymentService->handleWebhook('paydunya', $request->all());
        
        return response()->json([
            'success' => $result,
        ], $result ? 200 : 400);
    }

    /**
     * Get payment statistics (admin only)
     */
    public function getPaymentStatistics(): JsonResponse
    {
        // This should be protected by admin middleware
        $stats = $this->paymentService->getPaymentStatistics();
        
        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
