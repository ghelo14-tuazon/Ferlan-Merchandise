<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        p {
            margin: 0 0 10px;
        }

        strong {
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Order Receipt</h1>
    <p><strong>Payment: COD</strong></p>
    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Quantity:</strong> {{ $order->quantity }}</p>

    <p><strong>Products:</strong></p>
    <ul>
      @foreach($products as $product)
    <p><strong>Product Name:</strong> {{ $product->product->title }}</p>
    <!-- Add more details as needed -->
@endforeach
    </ul>

    <p><strong>Item Total:</strong> Php {{ number_format($itemTotal, 2) }}</p>
    <p><strong>Shipping Fee:</strong> Php {{ number_format($shippingCharge, 2) }}</p>
    <p><strong>Total Amount:</strong> Php {{ number_format($order->total_amount, 2) }}</p>
</body>
</html>
