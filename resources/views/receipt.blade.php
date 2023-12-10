<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <!-- Include Bootstrap CSS (adjust the path accordingly) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body class="container mt-4">

    <div class="jumbotron">
        <h2 class="display-4">Receipt</h2>
       
        <hr class="my-4">

        <!-- Product Details Section -->
        <h4 class="mb-3">Product Details:</h4>
        <ul class="list-group">
            @foreach ($productDetails as $productDetail)
                <li class="list-group-item d-flex justify-content-between align-items-center justify-content-end">
                    <span class="font-weight-bold">{{ $productDetail['title'] }} = </span>
                    <span class="badge badge-primary badge-pill">{{ $productDetail['quantity'] }} x Php{{ $productDetail['total'] }}</span>
                </li>
            @endforeach
        </ul>

        <!-- Total Order Price Section -->
        <p class="mt-4">Total Order Price: <span class="badge badge-success">Php{{ $totalOrderPrice }}</span></p>
    </div>

</body>

</html>
