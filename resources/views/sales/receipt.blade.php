<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>
        Recibo REC-{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
    </title>

    <style>

        body{
            font-family: Arial, sans-serif;
            max-width:380px;
            margin:auto;
            padding:10px;
            font-size:13px;
        }

        h2{
            text-align:center;
            margin-bottom:5px;
        }

        .store{
            text-align:center;
            font-size:12px;
            margin-bottom:10px;
        }

        .info{
            text-align:center;
            font-size:12px;
            margin-bottom:10px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            font-size:12px;
        }

        table th,
        table td{
            border-bottom:1px dashed #ccc;
            padding:5px;
        }

        .total{
            margin-top:8px;
            font-weight:bold;
        }

        .footer{
            text-align:center;
            margin-top:20px;
            font-size:11px;
        }

        hr{
            border:none;
            border-top:1px dashed #ccc;
            margin:15px 0;
        }

        .print-btn{

            width:100%;
            padding:12px;

            border:none;
            border-radius:8px;

            background:#16a34a;
            color:white;

            font-weight:bold;
            cursor:pointer;

            margin-bottom:15px;
        }

        @media print{

            .print-btn{
                display:none;
            }

            body{
                margin:0;
                padding:0;
            }

            @page{
                margin:0;
            }
        }

    </style>

</head>

<body>

<button
    class="print-btn"
    onclick="window.print()">

    🖨 IMPRIMIR RECIBO

</button>

<h2>
    🛒 MINHA LOJA
</h2>

<div class="store">

    📍 Maputo - Moçambique
    <br>

    📞 +258 87 39 68 660

</div>

<hr>

<div class="info">

    <strong>
        RECIBO Nº
        REC-{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
    </strong>

    <br>

    Data:
    {{ $sale->created_at->format('d/m/Y H:i') }}

    <br>

    Atendido por:
    {{ Auth::user()->name }}

</div>

<hr>

<table>

    <thead>

        <tr>

            <th align="left">
                Produto
            </th>

            <th align="center">
                Qtd
            </th>

            <th align="right">
                Total
            </th>

        </tr>

    </thead>

    <tbody>

        @foreach($sale->items as $item)

            <tr>

                <td>
                    {{ $item->product->name }}
                </td>

                <td align="center">
                    {{ $item->quantity }}
                </td>

                <td align="right">

                    {{ number_format(
                        $item->quantity * $item->price,
                        2
                    ) }}

                    MZN

                </td>

            </tr>

        @endforeach

    </tbody>

</table>

<hr>

<div class="total">

    TOTAL:
    {{ number_format($sale->total,2) }}
    MZN

</div>

<div class="total">

    RECEBIDO:
    {{ number_format($sale->received ?? 0,2) }}
    MZN

</div>

<div class="total">

    TROCO:
    {{ number_format(
        ($sale->received ?? 0) - $sale->total,
        2
    ) }}
    MZN

</div>

<hr>

<div class="footer">

    <strong>
        Obrigado pela preferência!
    </strong>

    <br>

    Volte sempre.

    <br><br>

    📞 Encomendas:
    +258 87 39 68 660

    <br>

    📍 Maputo - Moçambique

</div>

</body>

</html>