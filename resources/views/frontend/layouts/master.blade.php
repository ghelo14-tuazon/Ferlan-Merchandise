<!DOCTYPE html>
<html lang="zxx">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SYI5X1L+9UL6aZIATD6E5/6RTt8+pR6L4N2t4Q" crossorigin="anonymous">

	@include('frontend.layouts.head')	
	  <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

     /*   .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff; /* Background color of the preloader 
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 8px solid #f3f3f3; /* Light grey
            border-top: 8px solid #3498db; /* Blue 
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }*/

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Add this class to hide the preloader when the content is loaded */
        .loaded {
            display: none;
        }
    </style>
</head>
<body class="js">
	
	
	
	@include('frontend.layouts.notification')
	<!-- Header -->
	@include('frontend.layouts.header')
	<!--/ End Header -->
	@yield('main-content')
	
	@include('frontend.layouts.footer')

</body>
</html>