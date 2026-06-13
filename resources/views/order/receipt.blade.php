<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Recibo da Encomenda #{{ $order->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.4; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; font-size: 14px; }
        .top-table { width: 100%; line-height: inherit; text-align: left; margin-bottom: 40px; }
        .title { font-size: 28px; font-weight: bold; color: #111; uppercase; }
        .details-table { width: 100%; text-align: left; border-collapse: collapse; margin-bottom: 30px; }
        .details-table th { background: #f9fafb; font-size: 11px; font-weight: bold; text-transform: uppercase; padding: 8px; border-bottom: 2px solid #e5e7eb; }
        .details-table td { padding: 10px 8px; border-bottom: 1px solid #f3f4f6; }
        .text-right { text-align: right; }
        .total-section { margin-top: 20px; float: right; width: 300px; border-top: 2px solid #111; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table class="top-table">
            <tr>
                <td class="title">FUNSHIRT</td>
                <td class="text-right">
                    <strong>Recibo #{{ $order->id }}</strong><br>
                    Data: {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y H:i') }}<br>
                    Estado: Pago
                </td>
            </tr>
        </table>

        <table class="top-table" style="margin-bottom: 20px;">
            <tr>
                <td>
                    <strong>Cliente:</strong><br>
                    {{ $order->customer->user->name ?? 'Cliente FunShirt' }}<br>
                    {{ $order->customer->user->email ?? '' }}
                </td>
                <td class="text-right">
                    <strong>Método de Pagamento:</strong> {{ strtoupper($order->payment_type) }}<br>
                    <strong>Referência:</strong> {{ $order->payment_ref }}
                </td>
            </tr>
        </table>

        <table class="details-table">
            <thead>
                <tr>
                    <th>Artigo</th>
                    <th>Tamanho</th>
                    <th>Cor</th>
                    <th class="text-right">Qtd</th>
                    <th class="text-right">Preço Unit.</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>T-Shirt Manga Curta</td>
                        <td>{{ $item->size }}</td>
                        <td>{{ $item->color_code }}</td>
                        <td class="text-right">{{ $item->qty }}</td>
                        <td class="text-right">{{ number_format($item->unit_price, 2) }} €</td>
                        <td class="text-right">{{ number_format($item->sub_total, 2) }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <table style="width: 100%;">
                <tr>
                    <td><strong>Total Pago:</strong></td>
                    <td class="text-right"><strong>{{ number_format($order->total_price, 2) }} €</strong></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>