@extends('staff.layout.master')
@section('title','Dashboard')
@section('main-content')
<div class="container-fluid">
@if(isset($lowStockAlert) && !empty($lowStockAlert))
    <div id="stockAlert" class="alert alert-danger text-center" role="alert">
        <strong>{{ $lowStockAlert }}</strong>
    </div>
    
@endif
     <!-- Navigation -->
    <nav class="navbar navbar-expand navbar-light bg-black topbar mb-4 static-top shadow ">


</li>

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>
        

        <!-- Topbar Navbar -->

        <ul class="navbar-nav ml-auto">
<li class="nav-item dropdown no-arrow mx-1">
       @include('staff.notification.show')
      </li>
      
            <!-- Logout Dropdown -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Staff</span>
                  <img class="img-profile rounded-circle" src="{{ asset('images/F-2.png') }}">

                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>

        </ul>

    </nav>
    <!-- End of Topbar -->
    <!-- Page Heading -->
   
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800 font-weight-bold" >Dashboard</h1>
       <div id="stockAlertContainer">
       
    </div>
    </div>

    <!-- Content Row -->
    <div class="row">

      <!-- Category -->
      
      <div class="col-xl-3 col-md-6 mb-4 animated zoomIn" id="categoryCard">
        <div class="card bg-danger text-white shadow">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Category</div>
                    <div class="h5 mb-0 font-weight-bold text-white-800">
                        <span class="category-value" style ="color : white"></span>
                    </div>
                </div>
                <div class="col-auto">
                </div>
            </div>
        </div>
    </div>
</div>


      <!-- Products -->
      <div class="col-xl-3 col-md-6 mb-4 animated zoomIn" id="productsCard">
        <div class="card bg-success text-white shadow">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Products</div>
                    <div class="h5 mb-0 font-weight-bold text-white-800">
                        <span class="products-value" style ="color : white"></span>
                    </div>
                </div>
                <div class="col-auto">
                </div>
            </div>
        </div>
    </div>
</div>

      <!-- Order -->
      <div class="col-xl-3 col-md-6 mb-4 animated zoomIn" id="orderCard">
        <div class="card bg-info text-white shadow">
      
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Order</div>
                    <div class="h5 mb-0 font-weight-bold text-white-800">
                        <span class="order-value" style ="color : white"></span>
                    </div>
                </div>
                <div class="col-auto">
                </div>
            </div>
        </div>
    </div>
</div>

      <!-- Content Row -->
<div class="row">

<!-- Category -->
<!-- ... (other cards) ... -->

<div class="col-xl-10 col-md-6 mb-2 offset-xl-1">
        <img src="{{ asset('frontend/img/ferlan.jpg') }}" alt="Ferlan Merchandise Image" class="img-fluid landscape-image mx-auto" style="width: 100%;">
    </div>

</div>






    
  </div>
  
@endsection
<style>

</style>
@push('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Include Font Awesome CSS (add this in your HTML head if not already included) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

<script>
    // Disable back button on staff dashboard to prevent going back after logout
    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
    });
</script>
  <script>
    // Disable back button on staff dashboard to prevent going back after logout
    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
    });

    // Function to display and update the stock alert
    function updateStockAlert(message, alertType) {
        var alertContainer = document.getElementById('stockAlertContainer');

        // Create an alert element
        var alertElement = document.createElement('div');
        alertElement.className = 'alert alert-' + alertType;
        alertElement.role = 'alert';
        alertElement.innerHTML = message;

        // Append the alert to the container
        alertContainer.innerHTML = ''; // Clear previous alerts
        alertContainer.appendChild(alertElement);
    }

    // Example usage:
    // updateStockAlert('Low stock alert! Some products have stock levels below 500', 'warning');
    <!-- Add this script below your existing scripts -->

    // Function to animate counting from 0 to a specified value
    function animateCount(element, start, end, duration) {
        var range = end - start;
        var current = start;
        var increment = end > start ? 1 : -1;
        var stepTime = Math.abs(Math.floor(duration / range));
        var obj = $(element);
        var timer = setInterval(function () {
            current += increment;
            obj.text(current);
            if (current == end) {
                clearInterval(timer);
            }
        }, stepTime);
    }

    // Use the animateCount function for the Category value
    $(document).ready(function () {
        // Set the initial value to 0
        $('.category-value').text(0);

        // Get the actual value from the server (you may need to pass it from your backend)
        var actualValue = {{ \App\Models\Category::countActiveCategory() }};

        // Animate the counting from 0 to the actual value
        animateCount('.category-value', 0, actualValue, 1000); // Adjust the duration as needed
    });
     // Function to animate counting from 0 to a specified value
     function animateCount(element, start, end, duration) {
        var range = end - start;
        var current = start;
        var increment = end > start ? 1 : -1;
        var stepTime = Math.abs(Math.floor(duration / range));
        var obj = $(element);
        var timer = setInterval(function () {
            current += increment;
            obj.text(current);
            if (current == end) {
                clearInterval(timer);
            }
        }, stepTime);
    }

    // Use the animateCount function for the Category, Products, and Order values
    $(document).ready(function () {
        // Set the initial value to 0
        $('.category-value, .products-value, .order-value').text(0);

        // Get the actual values from the server (you may need to pass them from your backend)
        var actualCategoryValue = {{ \App\Models\Category::countActiveCategory() }};
        var actualProductsValue = {{ \App\Models\Product::countActiveProduct() }};
        var actualOrderValue = {{ \App\Models\Order::countActiveOrder() }};

        // Animate the counting from 0 to the actual values
        animateCount('.category-value', 0, actualCategoryValue, 1000); // Adjust the duration as needed
        animateCount('.products-value', 0, actualProductsValue, 1000); // Adjust the duration as needed
        animateCount('.order-value', 0, actualOrderValue, 1000); // Adjust the duration as needed

    });

    $(document).ready(function () {
    // Function to toggle sidebar minimization
    function toggleSidebar() {
        $('body').toggleClass('sidebar-minimized');
    }

    // Minimize sidebar when cursor hits the body
    $(document).on('mousemove', function (e) {
        var sidebar = $('#accordionSidebar');
        if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0) {
            toggleSidebar();
        }
    });

    // Toggle sidebar back when clicking on the sidebar toggle button
    $('#sidebarToggle').on('click', function () {
        toggleSidebar();
    });

    // Toggle sidebar back when clicking on a collapsed menu item
    $('.nav-link.collapsed').on('click', function () {
        toggleSidebar();
    });

    // Function to animate counting from the current value to a specified value
    function animateCount(element, start, end, duration) {
        var range = end - start;
        var current = start;
        var increment = end > start ? 1 : -1;
        var stepTime = Math.abs(Math.floor(duration / range));
        var obj = $(element);

        // Check if animation is already in progress
        if (obj.data('animationInProgress')) {
            return;
        }

        // Set flag to indicate animation is in progress
        obj.data('animationInProgress', true);

        var timer = setInterval(function () {
            current += increment;
            obj.text(current);

            if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                clearInterval(timer);
                // Reset the flag when the animation is complete
                obj.data('animationInProgress', false);
            }
        }, stepTime);
    }

    // Object to store the current values of all cards
    var currentValues = {
        category: 0,
        products: 0,
        order: 0
    };

    // Function to handle card click and restart counting
    function handleCardClick(cardElement, cardType) {
        // Set the current value for the clicked card to 0
        currentValues[cardType] = 0;

        // Get the actual value from the server (you may need to pass it from your backend)
        var actualValue;

        // Example: Fetch actual value from the server based on card type
        switch (cardType) {
            case 'category':
                actualValue = {{ \App\Models\Category::countActiveCategory() }};
                break;
            case 'products':
                actualValue = {{ \App\Models\Product::countActiveProduct() }};
                break;
            case 'order':
                actualValue = {{ \App\Models\Order::countActiveOrder() }};
                break;
            default:
                actualValue = 0;
        }

        // Animate the counting from 0 to the actual value
        animateCount(cardElement, 0, actualValue, 1000); // Adjust the duration as needed

        // Update the current value for the clicked card
        currentValues[cardType] = actualValue;
    }

    // Add click event handlers for each card
    $('#categoryCard').on('click', function () {
        handleCardClick('.category-value', 'category');
    });

    $('#productsCard').on('click', function () {
        handleCardClick('.products-value', 'products');
    });

    $('#orderCard').on('click', function () {
        handleCardClick('.order-value', 'order');
    });
});
function autoZoom() {
        $('#categoryCard').addClass('animated zoomIn');
        setTimeout(function () {
            $('#categoryCard').removeClass('animated zoomIn').addClass('animated zoomOut');
        }, 3000); // Adjust the duration as needed

        setTimeout(function () {
            $('#productsCard').addClass('animated zoomIn');
        }, 3500); // Adjust the delay as needed
        setTimeout(function () {
            $('#productsCard').removeClass('animated zoomIn').addClass('animated zoomOut');
        }, 6500); // Adjust the duration + delay as needed

        setTimeout(function () {
            $('#orderCard').addClass('animated zoomIn');
        }, 7000); // Adjust the delay as needed
        setTimeout(function () {
            $('#orderCard').removeClass('animated zoomIn').addClass('animated zoomOut');
        }, 10000); // Adjust the duration + delay as needed
    }

    // Call the autoZoom function when the document is ready
    $(document).ready(function () {
        autoZoom();
    });
</script>
<style>
    @keyframes zoomIn {
        from {
            transform: scale(0.5);
        }
        to {
            transform: scale(1);
        }
    }

    @keyframes zoomOut {
        from {
            transform: scale(1);
        }
        to {
            transform: scale(0.5);
        }
    }

    /* Apply individual animations to the corresponding cards */
    #categoryCard.animated.zoomIn {
        animation: zoomIn 1s;
    }

    #productsCard.animated.zoomIn {
        animation: zoomIn 1.5s;
    }

    #orderCard.animated.zoomIn {
        animation: zoomIn 2s;
    }

    /* Add hover effect for zoomOut animation */
    #categoryCard:hover {
        animation: zoomOut 1s;
    }

    #productsCard:hover {
        animation: zoomOut 1.5s;
    }

    #orderCard:hover {
        animation: zoomOut 2s;
    }
    #categoryCard.animated.zoomOut:hover,
    #productsCard.animated.zoomOut:hover,
    #orderCard.animated.zoomOut:hover {
        animation: none;
        transform: scale(1);
    }
    /* Add this to your existing style block or file */
.navbar-nav.ml-auto #languageDropdown {
    color: #fff; /* Adjust the color as needed */
    font-size: 18px; /* Adjust the font size as needed */
}

.navbar-nav.ml-auto #languageDropdown .fas.fa-globe {
    margin-right: 5px; /* Adjust the margin as needed */
}


/* You may need to adjust other styles based on your design */


</style>



@endpush