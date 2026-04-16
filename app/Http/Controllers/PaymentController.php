<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\UserDetails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('allowApplication');
    }

    public function initPayment($id)
    {
        $bill = Bill::findOrFail($id);
        $userDetails = UserDetails::where('username', $bill->username)->first();
        if (!$userDetails) {
            return redirect()->route('student.dashboard')->with('error', 'User details not found for this bill.');
        }

        if ($bill->payment_status == -1) {
            return redirect()->route('student.dashboard')->with('error', 'This bill is not eligible for payment.');
        }

        if ($bill->payment_id) {
            $paymentStatus = $this->checkPaymentStatus($bill->payment_id);
            if ($paymentStatus['status_code'] == 1) {
                $this->updateBill($bill, $paymentStatus);
                return redirect()->route('student.dashboard')->with('success', 'Payment already completed for this bill.');
            }
        }

        try {
            $response = Http::withToken(config('app.payment.token'))
                ->post('https://payment.ru.ac.bd/api/create_payment', [
                    'bill_id' => $bill->bill_id,
                    'amount' => $bill->amount,
                    'callback_url' => route('payment.confirm', ['id' => $bill->id]),
                    'mobile' => $userDetails->mobile,
                    'name' => $userDetails->name,
                ]);

            if ($response->failed()) {
                throw new Exception('Payment initialization failed.');
            }

            $bill->payment_id = $response['payment_id'];
            $bill->save();

            $response = $response->json();
            if ($response['status_code'] == 0) {
                return redirect()->away($response['payment_url']);
            }

            return redirect()->route('student.dashboard')->with('error', 'Failed to initiate payment. Please try again.');
        } catch (\Exception $e) {
            Log::error('Payment initiation failed: ' . $e->getMessage());
            return redirect()->route('student.dashboard')->with('error', 'Failed to initiate payment.');
        }
        // Logic to initialize payment (e.g., create a payment record, generate a payment link, etc.)
        return response()->json(['message' => 'Payment initialized successfully']);
    }

    public function confirmPayment($id)
    {
        $bill = Bill::findOrFail($id);
        if (!$bill->payment_id) {
            return redirect()->route('student.dashboard')->with('error', 'No payment found for this bill.');
        }

        $paymentData = $this->checkPaymentStatus($bill->payment_id);

        if ($paymentData['status_code'] == 1) {
            try {
                $this->updateBill($bill, $paymentData);
            } catch (\Exception $e) {
                return redirect()->route('student.dashboard')->with('error', 'Payment data update failed.');
            }

            return redirect()->route('student.dashboard')->with('success', 'Payment confirmed successfully.');
        }

        return redirect()->route('student.dashboard')->with('error', 'Payment confirmation failed. Please try again.');
    }

    private function updateBill($bill, $paymentData)
    {
        $bill->payment_status = 1;
        $bill->payment_method = $paymentData['payment_method'];
        $bill->payment_date = $paymentData['payment_time'];
        $bill->tnx_id = $paymentData['pgw_txnid'];
        $bill->save();
    }

    private function checkPaymentStatus($paymentId)
    {
        try {
            $response = Http::withToken(config('app.payment.token'))
                ->accept('application/json')
                ->post("https://payment.ru.ac.bd/api/payment_status/{$paymentId}");

            if ($response->failed()) {
                return null;
            }

            return $response->json();
        } catch (Exception $e) {
            Log::error('Payment status check failed: ' . $e->getMessage());
            return null;
        }
    }
}
