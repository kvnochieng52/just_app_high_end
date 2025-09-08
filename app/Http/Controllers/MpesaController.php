<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MpesaController extends Controller
{
    /**
     * Handle M-Pesa confirmation callback
     * Route: POST https://justhomes.co.ke/confirmation
     */
    public function confirmation(Request $request): JsonResponse
    {
        try {
            // Log the incoming request
            Log::info('=== M-PESA CONFIRMATION CALLBACK ===', [
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => Carbon::now()->toDateTimeString()
            ]);

            // Get raw JSON data
            $rawData = $request->getContent();
            Log::info('Raw callback data:', ['data' => $rawData]);

            // Check if data is empty
            if (empty($rawData)) {
                Log::warning('Empty callback data received');
                return $this->successResponse();
            }

            // Decode JSON data
            $callbackData = json_decode($rawData, true);

            // Check for JSON decode errors
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Invalid JSON received', ['error' => json_last_error_msg()]);
                return $this->successResponse();
            }

            Log::info('Decoded callback data:', $callbackData);

            // Process STK Push callback
            if (isset($callbackData['Body']['stkCallback'])) {
                $this->processStkCallback($callbackData['Body']['stkCallback']);
            }
            // Process C2B callback
            elseif (isset($callbackData['TransactionType'])) {
                $this->processC2BCallback($callbackData);
            }
            // Unknown callback format
            else {
                Log::warning('Unknown callback format received', [
                    'available_keys' => array_keys($callbackData)
                ]);
            }

            return $this->successResponse();
        } catch (\Exception $e) {
            Log::error('M-Pesa confirmation callback error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            // Always return success to M-Pesa to avoid retries
            return $this->successResponse();
        }
    }

    /**
     * Process STK Push callback
     */
    private function processStkCallback(array $stkCallback): void
    {
        $checkoutRequestId = $stkCallback['CheckoutRequestID'] ?? 'unknown';
        $merchantRequestId = $stkCallback['MerchantRequestID'] ?? 'unknown';
        $resultCode = $stkCallback['ResultCode'] ?? -1;
        $resultDesc = $stkCallback['ResultDesc'] ?? 'No description';

        Log::info('STK Push Callback Details:', [
            'checkout_request_id' => $checkoutRequestId,
            'merchant_request_id' => $merchantRequestId,
            'result_code' => $resultCode,
            'result_desc' => $resultDesc
        ]);

        if ($resultCode == 0) {
            // Payment successful
            Log::info('✅ STK PUSH PAYMENT SUCCESSFUL', [
                'checkout_request_id' => $checkoutRequestId
            ]);

            // Extract transaction details
            if (isset($stkCallback['CallbackMetadata']['Item'])) {
                $transactionDetails = [];
                foreach ($stkCallback['CallbackMetadata']['Item'] as $item) {
                    $name = $item['Name'] ?? 'unknown';
                    $value = $item['Value'] ?? 'unknown';
                    $transactionDetails[$name] = $value;
                }

                Log::info('Transaction Details:', $transactionDetails);

                // TODO: Update your database/business logic here
                // Example:
                // $this->updatePaymentStatus($checkoutRequestId, 'completed', $transactionDetails);
            }
        } else {
            // Payment failed or cancelled
            Log::info('❌ STK PUSH PAYMENT FAILED', [
                'checkout_request_id' => $checkoutRequestId,
                'reason' => $resultDesc
            ]);

            // TODO: Update your database/business logic here
            // Example:
            // $this->updatePaymentStatus($checkoutRequestId, 'failed', ['reason' => $resultDesc]);
        }
    }

    /**
     * Process C2B callback
     */
    private function processC2BCallback(array $callbackData): void
    {
        $transactionType = $callbackData['TransactionType'] ?? 'unknown';
        $transId = $callbackData['TransID'] ?? 'unknown';
        $amount = $callbackData['TransAmount'] ?? '0';
        $billRefNumber = $callbackData['BillRefNumber'] ?? 'unknown';
        $msisdn = $callbackData['MSISDN'] ?? 'unknown';
        $firstName = $callbackData['FirstName'] ?? '';
        $lastName = $callbackData['LastName'] ?? '';

        Log::info('✅ C2B PAYMENT RECEIVED:', [
            'transaction_type' => $transactionType,
            'trans_id' => $transId,
            'amount' => $amount,
            'bill_ref_number' => $billRefNumber,
            'msisdn' => $msisdn,
            'customer_name' => trim("$firstName $lastName")
        ]);

        // TODO: Process the C2B payment in your business logic
        // Example:
        // $this->processC2BPayment($transId, $amount, $billRefNumber, $msisdn);
    }

    /**
     * Return success response to M-Pesa
     */
    private function successResponse(): JsonResponse
    {
        $response = [
            'ResultCode' => 0,
            'ResultDesc' => 'Success'
        ];

        Log::info('Sending success response to M-Pesa', $response);

        return response()->json($response, 200);
    }

    // TODO: Implement these methods based on your business logic

    /**
     * Update payment status in database
     */
    // private function updatePaymentStatus(string $checkoutRequestId, string $status, array $details = []): void
    // {
    //     // Update your payment records here
    //     // Example:
    //     // Payment::where('checkout_request_id', $checkoutRequestId)
    //     //        ->update([
    //     //            'status' => $status,
    //     //            'transaction_details' => json_encode($details),
    //     //            'updated_at' => now()
    //     //        ]);
    // }

    /**
     * Process C2B payment
     */
    // private function processC2BPayment(string $transId, string $amount, string $billRef, string $msisdn): void
    // {
    //     // Process C2B payment here
    //     // Example:
    //     // C2BPayment::create([
    //     //     'transaction_id' => $transId,
    //     //     'amount' => $amount,
    //     //     'bill_reference' => $billRef,
    //     //     'msisdn' => $msisdn,
    //     //     'status' => 'completed'
    //     // ]);
    // }
}
