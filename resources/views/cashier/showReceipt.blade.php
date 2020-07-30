<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant App -Receipt -SaleID : {{ $sale->id }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/receipt.css') }}" media="all">
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/no-print.css') }}" media="print">
</head>
<body>
    <div id="wrapper">
        <div id="receipt-header">
            <h3 id="restaurant-name">Restaurant App HOJIN</h3>
            <p>Address: 341 N Vakanda Ave</p>
            <p>Analpolis, 123 1234</p>
            <p>Tel: 434-3434-3434</p>
            <p>Reference Receipt: <Strong>{{ $sale->id }}</Strong></p>
        </div>
        <div id="receipt-body">
            <table class="tb-sale-detail">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saleDetails as $saleDetail)
                        <tr>
                            <td width="30">{{ $saleDetail->menu_id }}</td>
                            <td width="180">{{ $saleDetail->menu_name }}</td>
                            <td width="50">{{ $saleDetail->quantity }}</td>
                            <td width="55">{{ $saleDetail->menu_price }}</td>
                            <td width="65">{{ $saleDetail->menu_price * $saleDetail->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="tb-sale-total">
                <tbody>
                    <tr>
                        <td>Total Quantity</td>
                        <td>{{ $saleDetail->count() }}</td>
                        <td>Total</td>
                        <td>$ {{ number_format($sale->total_price, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Payment Type</td>
                        <td colspan="2">{{ $sale->payment_type }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Paid Amount</td>
                        <td colspan="2">$ {{ number_format($sale->total_recieved, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Change</td>
                        <td colspan="2">$ {{ number_format($sale->change, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="receipt-footer">
            <p>Thank you !</p>
        </div>
        <div id="buttons">
            <a href="/cashier">
                <button class="btn btn-back btn-success">
                    Back to Cashier
                </button>
            </a>
            <button class="btn btn-print btn-warning" type="button" onclick="window.print(); return false;">
                Print 
            </button>
        </div>
    </div>
</body>
</html>