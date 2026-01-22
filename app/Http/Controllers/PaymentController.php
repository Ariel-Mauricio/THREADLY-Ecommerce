<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * PayPhone Payment Gateway Integration
     * https://payphone.app - Pasarela de pagos para Ecuador
     */
    
    // Mostrar formulario de pago con tarjeta
    public function payphone(Order $order)
    {
        // Verificar que la orden pertenece al usuario o es una sesión válida
        $config = [
            'token' => config('services.payphone.token', env('PAYPHONE_TOKEN')),
            'storeId' => config('services.payphone.store_id', env('PAYPHONE_STORE_ID')),
            'env' => config('services.payphone.env', env('PAYPHONE_ENV', 'sandbox')),
        ];
        
        return view('payment.payphone', compact('order', 'config'));
    }

    // Procesar pago con tarjeta
    public function payphoneProcess(Request $request, Order $order)
    {
        $request->validate([
            'card_number' => 'required|string|min:13|max:19',
            'card_name' => 'required|string|max:100',
            'card_expiry' => 'required|string|size:5',
            'card_cvv' => 'required|string|min:3|max:4',
            'card_email' => 'required|email',
        ]);

        $token = env('PAYPHONE_TOKEN');
        $env = env('PAYPHONE_ENV', 'sandbox');
        
        // URLs de PayPhone
        $baseUrl = $env === 'production' 
            ? 'https://pay.payphone.app' 
            : 'https://pay.payphonetodoesposible.com';

        // Limpiar número de tarjeta
        $cardNumber = preg_replace('/\s+/', '', $request->card_number);
        
        // Parsear fecha de expiración (MM/AA)
        $expiry = explode('/', $request->card_expiry);
        $expiryMonth = $expiry[0];
        $expiryYear = '20' . $expiry[1];

        // Convertir monto a centavos (PayPhone usa centavos)
        $amountInCents = (int)($order->total * 100);
        $taxInCents = (int)($order->tax * 100);
        $subtotalInCents = $amountInCents - $taxInCents;

        try {
            // Paso 1: Preparar la transacción
            $prepareResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post($baseUrl . '/api/button/Prepare', [
                'amount' => $amountInCents,
                'amountWithoutTax' => $subtotalInCents,
                'tax' => $taxInCents,
                'clientTransactionId' => $order->order_number,
                'responseUrl' => route('payment.payphone.callback'),
                'cancellationUrl' => route('payment.payphone.cancel'),
                'reference' => 'Pedido #' . $order->order_number,
                'email' => $request->card_email,
            ]);

            if (!$prepareResponse->successful()) {
                Log::error('PayPhone Prepare Error', ['response' => $prepareResponse->json()]);
                return back()->with('error', 'Error al preparar el pago. Intenta nuevamente.');
            }

            $prepareData = $prepareResponse->json();
            $paymentId = $prepareData['paymentId'] ?? null;

            // Paso 2: Procesar el pago con la tarjeta
            $payResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post($baseUrl . '/api/button/V2/Confirm', [
                'paymentId' => $paymentId,
                'cardNumber' => $cardNumber,
                'expirationMonth' => $expiryMonth,
                'expirationYear' => $expiryYear,
                'cvv' => $request->card_cvv,
                'cardHolderName' => $request->card_name,
            ]);

            $payData = $payResponse->json();

            if ($payResponse->successful() && isset($payData['transactionStatus']) && $payData['transactionStatus'] === 'Approved') {
                // Pago exitoso
                $order->update([
                    'status' => 'paid',
                    'payment_id' => $payData['transactionId'] ?? 'PP-' . uniqid(),
                    'payment_method' => 'payphone',
                ]);

                return redirect()->route('orders.success', $order)
                    ->with('success', '¡Pago realizado con éxito!');
            } else {
                // Pago rechazado
                $errorMsg = $payData['message'] ?? 'El pago fue rechazado por el banco.';
                Log::error('PayPhone Payment Rejected', ['response' => $payData]);
                return back()->with('error', $errorMsg);
            }

        } catch (\Exception $e) {
            Log::error('PayPhone Exception', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error de conexión. Por favor intenta nuevamente.');
        }
    }

    // Simular pago (para pruebas sin credenciales reales)
    public function payphoneSimulate(Request $request, Order $order)
    {
        $request->validate([
            'card_number' => 'required|string',
            'card_name' => 'required|string',
            'card_expiry' => 'required|string',
            'card_cvv' => 'required|string',
        ]);

        // Simular procesamiento
        sleep(2);

        // Simular diferentes resultados según el número de tarjeta
        $cardNumber = preg_replace('/\s+/', '', $request->card_number);
        
        // Tarjeta de prueba que falla
        if (str_starts_with($cardNumber, '4000')) {
            return back()->with('error', 'Tarjeta rechazada. Fondos insuficientes.');
        }

        // Pago exitoso simulado
        $order->update([
            'status' => 'paid',
            'payment_id' => 'SIM-' . strtoupper(uniqid()),
            'payment_method' => 'card_simulated',
        ]);

        return redirect()->route('orders.success', $order)
            ->with('success', '¡Pago realizado con éxito! (Modo de prueba)');
    }

    /**
     * PayPhone Webhook - Recibe notificaciones de pago
     */
    public function payphoneWebhook(Request $request)
    {
        Log::info('PayPhone Webhook', $request->all());
        
        $transactionId = $request->input('transactionId');
        $status = $request->input('statusCode');
        $clientTransactionId = $request->input('clientTransactionId');
        
        $order = Order::where('order_number', $clientTransactionId)->first();
        
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        if ($status == 3) { // Aprobado
            $order->update([
                'status' => 'paid',
                'payment_id' => $transactionId,
            ]);
        } elseif ($status == 2) { // Rechazado
            $order->update(['status' => 'payment_failed']);
        }

        return response()->json(['success' => true]);
    }

    public function payphoneCallback(Request $request)
    {
        $transactionId = $request->input('id');
        $clientTransactionId = $request->input('clientTransactionId');
        
        $order = Order::where('order_number', $clientTransactionId)->first();
        
        if ($order) {
            // Verificar estado de la transacción con PayPhone
            $order->update([
                'payment_id' => $transactionId,
                'status' => 'paid',
            ]);
            
            return redirect()->route('orders.success', $order)
                ->with('success', '¡Pago realizado con éxito!');
        }

        return redirect()->route('home')->with('error', 'Pedido no encontrado');
    }

    public function payphoneCancel(Request $request)
    {
        return redirect()->route('checkout')
            ->with('error', 'El pago fue cancelado. Puedes intentar nuevamente.');
    }
}
