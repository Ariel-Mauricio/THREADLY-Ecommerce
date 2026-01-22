<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f8fafc;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
        <!-- Header -->
        <tr>
            <td style="background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%); padding: 40px 30px; text-align: center;">
                <h1 style="color: white; margin: 0; font-size: 28px; font-weight: 700;">THREADLY</h1>
                <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0; font-size: 14px;">Camisetas Premium Ecuador</p>
            </td>
        </tr>

        <!-- Success Icon -->
        <tr>
            <td style="padding: 40px 30px 20px; text-align: center;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 40px; color: white;">✓</span>
                </div>
                <h2 style="color: #0f172a; margin: 20px 0 10px; font-size: 24px;">¡Gracias por tu compra!</h2>
                <p style="color: #64748b; margin: 0; font-size: 16px;">Tu pedido ha sido recibido y está siendo procesado.</p>
            </td>
        </tr>

        <!-- Order Details -->
        <tr>
            <td style="padding: 20px 30px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border-radius: 12px; padding: 20px;">
                    <tr>
                        <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                            <strong style="color: #0f172a;">Número de pedido:</strong>
                            <span style="color: #6366f1; float: right; font-weight: 600;">{{ $order->order_number }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                            <strong style="color: #0f172a;">Fecha:</strong>
                            <span style="color: #64748b; float: right;">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                            <strong style="color: #0f172a;">Método de pago:</strong>
                            <span style="color: #64748b; float: right;">{{ $order->payment_method_label }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px 20px;">
                            <strong style="color: #0f172a;">Estado:</strong>
                            <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 12px; float: right;">{{ $order->status_label }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Products -->
        <tr>
            <td style="padding: 20px 30px;">
                <h3 style="color: #0f172a; margin: 0 0 15px; font-size: 18px;">Productos</h3>
                <table width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid #e2e8f0; border-radius: 12px;">
                    @foreach($order->items as $item)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 15px; width: 60px;">
                            @if($item->product && $item->product->image)
                            <img src="{{ str_starts_with($item->product->image, 'http') ? $item->product->image : config('app.url') . '/storage/' . $item->product->image }}" 
                                 alt="{{ $item->product_name }}" 
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            @else
                            <div style="width: 50px; height: 50px; background: #e2e8f0; border-radius: 8px;"></div>
                            @endif
                        </td>
                        <td style="padding: 15px;">
                            <strong style="color: #0f172a; display: block;">{{ $item->product_name }}</strong>
                            <small style="color: #64748b;">
                                @if($item->size) Talla: {{ $item->size }} @endif
                                @if($item->color) | Color: {{ $item->color }} @endif
                                <br>Cantidad: {{ $item->quantity }}
                            </small>
                        </td>
                        <td style="padding: 15px; text-align: right;">
                            <strong style="color: #0f172a;">${{ number_format($item->total, 2) }}</strong>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>

        <!-- Totals -->
        <tr>
            <td style="padding: 20px 30px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding: 8px 0; color: #64748b;">Subtotal</td>
                        <td style="padding: 8px 0; text-align: right; color: #0f172a;">${{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b;">Envío</td>
                        <td style="padding: 8px 0; text-align: right; color: #0f172a;">{{ $order->shipping_cost > 0 ? '$' . number_format($order->shipping_cost, 2) : 'Gratis' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b;">IVA (12%)</td>
                        <td style="padding: 8px 0; text-align: right; color: #0f172a;">${{ number_format($order->tax, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-top: 2px solid #e2e8f0; padding-top: 15px;"></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 18px; font-weight: 700; color: #0f172a;">Total</td>
                        <td style="padding: 8px 0; text-align: right; font-size: 18px; font-weight: 700; color: #6366f1;">${{ number_format($order->total, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Shipping Address -->
        <tr>
            <td style="padding: 20px 30px;">
                <h3 style="color: #0f172a; margin: 0 0 15px; font-size: 18px;">📦 Dirección de Envío</h3>
                <div style="background-color: #f8fafc; border-radius: 12px; padding: 20px;">
                    <p style="margin: 0 0 5px; color: #0f172a; font-weight: 600;">{{ $order->customer_name }}</p>
                    <p style="margin: 0 0 5px; color: #64748b;">{{ $order->shipping_address }}</p>
                    @if($order->address_reference)
                    <p style="margin: 0 0 5px; color: #64748b;">Ref: {{ $order->address_reference }}</p>
                    @endif
                    <p style="margin: 0 0 5px; color: #64748b;">{{ $order->city }}, {{ $order->province }}</p>
                    <p style="margin: 0; color: #64748b;">Tel: {{ $order->customer_phone }}</p>
                </div>
            </td>
        </tr>

        <!-- CTA Button -->
        <tr>
            <td style="padding: 30px; text-align: center;">
                <a href="{{ route('orders.success', $order) }}" 
                   style="display: inline-block; background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%); color: white; text-decoration: none; padding: 15px 30px; border-radius: 30px; font-weight: 600; font-size: 16px;">
                    Ver detalles del pedido
                </a>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #0f172a; padding: 30px; text-align: center;">
                <p style="color: rgba(255,255,255,0.7); margin: 0 0 10px; font-size: 14px;">
                    ¿Tienes preguntas? Contáctanos
                </p>
                <p style="color: white; margin: 0 0 5px; font-size: 14px;">
                    📧 soporte@threadly.ec | 📱 +593 99 123 4567
                </p>
                <p style="color: rgba(255,255,255,0.5); margin: 20px 0 0; font-size: 12px;">
                    © {{ date('Y') }} THREADLY. Todos los derechos reservados.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
