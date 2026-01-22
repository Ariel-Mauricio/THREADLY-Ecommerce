<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de Pedido</title>
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

        <!-- Status Update -->
        <tr>
            <td style="padding: 40px 30px 20px; text-align: center;">
                @php
                    $icon = match($order->status) {
                        'paid' => '💳',
                        'processing' => '⚙️',
                        'shipped' => '🚚',
                        'delivered' => '📦',
                        'cancelled' => '❌',
                        default => '📋',
                    };
                    $bgColor = match($order->status) {
                        'paid', 'delivered' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                        'shipped' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                        'cancelled' => 'linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%)',
                        default => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                    };
                    $statusBgColor = $order->status === 'cancelled' ? '#fef2f2' : '#ecfdf5';
                    $statusTextColor = $order->status === 'cancelled' ? '#dc2626' : '#059669';
                    $iconStyle = "width: 80px; height: 80px; background: {$bgColor}; border-radius: 50%; margin: 0 auto; line-height: 80px; text-align: center;";
                    $statusStyle = "background: {$statusBgColor}; color: {$statusTextColor}; padding: 4px 12px; border-radius: 20px; font-size: 12px; float: right; font-weight: 600;";
                @endphp
                <div style="{{ $iconStyle }}">
                    <span style="font-size: 40px;">{{ $icon }}</span>
                </div>
                
                @if($order->status === 'shipped')
                    <h2 style="color: #0f172a; margin: 20px 0 10px; font-size: 24px;">¡Tu pedido está en camino!</h2>
                    <p style="color: #64748b; margin: 0; font-size: 16px;">Hemos enviado tu pedido. Pronto lo recibirás.</p>
                @elseif($order->status === 'delivered')
                    <h2 style="color: #0f172a; margin: 20px 0 10px; font-size: 24px;">¡Pedido Entregado!</h2>
                    <p style="color: #64748b; margin: 0; font-size: 16px;">Tu pedido ha sido entregado exitosamente.</p>
                @elseif($order->status === 'paid')
                    <h2 style="color: #0f172a; margin: 20px 0 10px; font-size: 24px;">¡Pago Confirmado!</h2>
                    <p style="color: #64748b; margin: 0; font-size: 16px;">Tu pago ha sido procesado correctamente.</p>
                @elseif($order->status === 'cancelled')
                    <h2 style="color: #0f172a; margin: 20px 0 10px; font-size: 24px;">Pedido Cancelado</h2>
                    <p style="color: #64748b; margin: 0; font-size: 16px;">Tu pedido ha sido cancelado.</p>
                @else
                    <h2 style="color: #0f172a; margin: 20px 0 10px; font-size: 24px;">Actualización de tu Pedido</h2>
                    <p style="color: #64748b; margin: 0; font-size: 16px;">El estado de tu pedido ha cambiado.</p>
                @endif
            </td>
        </tr>

        <!-- Order Info -->
        <tr>
            <td style="padding: 20px 30px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border-radius: 12px;">
                    <tr>
                        <td style="padding: 20px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding: 10px 0;">
                                        <strong style="color: #0f172a;">Pedido:</strong>
                                        <span style="color: #6366f1; float: right; font-weight: 600;">{{ $order->order_number }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; border-top: 1px solid #e2e8f0;">
                                        <strong style="color: #0f172a;">Nuevo estado:</strong>
                                        <span style="{{ $statusStyle }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; border-top: 1px solid #e2e8f0;">
                                        <strong style="color: #0f172a;">Total:</strong>
                                        <span style="color: #6366f1; float: right; font-weight: 700; font-size: 18px;">${{ number_format($order->total, 2) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        @if($order->status === 'shipped')
        <!-- Shipping Timeline -->
        <tr>
            <td style="padding: 20px 30px;">
                <h3 style="color: #0f172a; margin: 0 0 15px; font-size: 18px;">📍 Seguimiento del envío</h3>
                <div style="background-color: #f8fafc; border-radius: 12px; padding: 20px;">
                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                        <div style="width: 12px; height: 12px; background: #10b981; border-radius: 50%; margin-right: 15px;"></div>
                        <div>
                            <strong style="color: #0f172a; display: block;">Pedido enviado</strong>
                            <small style="color: #64748b;">{{ $order->shipped_at ? $order->shipped_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center;">
                        <div style="width: 12px; height: 12px; background: #e2e8f0; border-radius: 50%; margin-right: 15px;"></div>
                        <div>
                            <strong style="color: #64748b; display: block;">Entrega estimada</strong>
                            <small style="color: #64748b;">1-3 días hábiles</small>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @endif

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
