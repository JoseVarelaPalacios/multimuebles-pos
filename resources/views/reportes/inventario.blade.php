<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2d3748;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #2d3748;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #718096;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #2d3748;
            color: #ffffff;
            padding: 8px;
            text-align: left;
        }
        td {
            border-bottom: 1px solid #e2e8f0;
            padding: 8px;
        }
        .stock-bajo {
            color: red;
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 0px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #a0aec0;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Multimuebles POS</h1>
        <p>Reporte General de Inventario</p>
        <p>Fecha de impresión: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Mueble</th>
                <th>Categoría</th>
                <th>Material</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->categoria }}</td>
                    <td>{{ $producto->material ?? 'N/A' }}</td>
                    <td>${{ number_format($producto->precio, 2) }}</td>
                    <td class="{{ $producto->cantidad_stock <= 2 ? 'stock-bajo' : '' }}">
                        {{ $producto->cantidad_stock }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Documento generado automáticamente por el Sistema de Gestión Multimuebles.
    </div>

</body>
</html>