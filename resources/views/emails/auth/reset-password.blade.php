<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
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

        <!-- Content -->
        <tr>
            <td style="padding: 40px 30px;">
                <h2 style="color: #0f172a; margin: 0 0 20px; font-size: 24px; text-align: center;">
                    🔐 Restablecer Contraseña
                </h2>
                
                <p style="color: #64748b; font-size: 16px; line-height: 1.6; margin: 0 0 20px;">
                    Hola,
                </p>
                
                <p style="color: #64748b; font-size: 16px; line-height: 1.6; margin: 0 0 20px;">
                    Recibimos una solicitud para restablecer la contraseña de tu cuenta en THREADLY. 
                    Haz clic en el siguiente botón para crear una nueva contraseña:
                </p>

                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ $url }}" 
                       style="display: inline-block; background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%); color: white; text-decoration: none; padding: 15px 40px; border-radius: 30px; font-weight: 600; font-size: 16px;">
                        Restablecer Contraseña
                    </a>
                </div>

                <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin: 0 0 10px;">
                    Este enlace expirará en <strong>60 minutos</strong>.
                </p>

                <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin: 0 0 20px;">
                    Si no solicitaste restablecer tu contraseña, puedes ignorar este correo de forma segura.
                </p>

                <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">

                <p style="color: #94a3b8; font-size: 12px; line-height: 1.6; margin: 0;">
                    Si tienes problemas con el botón, copia y pega la siguiente URL en tu navegador:
                </p>
                <p style="color: #6366f1; font-size: 12px; line-height: 1.6; margin: 10px 0 0; word-break: break-all;">
                    {{ $url }}
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #0f172a; padding: 30px; text-align: center;">
                <p style="color: rgba(255,255,255,0.7); margin: 0 0 10px; font-size: 14px;">
                    ¿Necesitas ayuda? Contáctanos
                </p>
                <p style="color: white; margin: 0 0 5px; font-size: 14px;">
                    📧 soporte@threadly.ec
                </p>
                <p style="color: rgba(255,255,255,0.5); margin: 20px 0 0; font-size: 12px;">
                    © {{ date('Y') }} THREADLY. Todos los derechos reservados.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
