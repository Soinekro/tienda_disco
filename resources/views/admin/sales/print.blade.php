<!DOCTYPE html>
<html>
<head>
    <title>Ticket de Venta</title>
    <style>
        /* Estilos CSS para el ticket */
        body {
            font-family: Arial, sans-serif;
        }

        .ticket {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .customer-info {
            margin-bottom: 20px;
        }

        .items {
            margin-bottom: 20px;
        }

        .item {
            margin-bottom: 10px;
        }

        .item-name {
            font-weight: bold;
        }

        .item-price {
            float: right;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>Ticket de Venta</h1>
        </div>

        <div class="customer-info">
            <p>Nombre del cliente: {{ $sale->client->name ?? 'Varios'}}</p>
            <p>Dirección: {{ $sale->client->address ?? ''}}</p>
        </div>

        <div class="items">
            <h2>Items:</h2>
            @foreach ($sale->details as $item)
                <div class="item">
                    <span class="item-name">{{ $item->product->name }}</span>
                    <span class="item-price">{{ $item->total}}</span>
                </div>
            @endforeach
        </div>

        <div class="total">
            <p>Total: {{ $sale->total }}</p>
        </div>
    </div>
</body>
</html>
