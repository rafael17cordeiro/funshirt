<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Recibo da Encomenda</title>
</head>

<body
    style="background-color: #f3f4f6; font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; padding: 40px 20px; margin: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); max-width: 600px; margin: 0 auto;">
                    <tr>
                        <td style="padding: 32px; color: #4b5563; font-size: 14px; line-height: 1.6;">

                            <h2
                                style="color: #111827; font-size: 18px; font-weight: 600; margin-top: 0; margin-bottom: 16px;">
                                Olá, {{ $order->customer->user->name ?? 'Cliente' }}!
                            </h2>

                            <p style="margin-bottom: 20px;">
                                Obrigado por comprar na <strong style="color: #111827;">FunShirt</strong>.
                            </p>

                            <div
                                style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 12px 16px; margin-bottom: 20px; border-radius: 4px;">
                                <p style="margin: 0; color: #166534; font-weight: 500;">
                                    O seu pagamento foi recebido com sucesso!
                                </p>
                            </div>

                            <p style="margin-bottom: 20px;">
                                A sua encomenda <strong
                                    style="color: #111827;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong> já
                                está a ser processada.
                                Enviamos em anexo a fatura/recibo em formato PDF para os seus registos.
                            </p>

                            <div style="text-align: center; margin: 32px 0;">
                                <a href="{{ route('catalog.index') }}"
                                    style="background-color: #111827; color: #ffffff; padding: 12px 28px; text-decoration: none; border-radius: 6px; font-weight: 600; display: inline-block; font-size: 14px;">
                                    Voltar para a Loja
                                </a>
                            </div>

                            <div style="margin-top: 32px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                                <p style="margin: 0; font-size: 14px; color: #6b7280;">Com os melhores cumprimentos,</p>
                                <p style="margin: 4px 0 0 0; color: #111827; font-weight: 600;">A Equipa FunShirt</p>
                            </div>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>