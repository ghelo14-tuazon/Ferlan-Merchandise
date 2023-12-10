@extends('backend.layouts.master')
@section('title', 'Dashboard')
@section('main-content')
<div class="container-fluid">

    <!-- Notifications -->
    @include('backend.layouts.notification')

    <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">DASHBOARD</h1>
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

<div class="col-xl-3 col-md-6 mb-4 animated zoomIn" id="productsCard">
        <div class="card bg-success text-white shadow">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Products</div>
                    <div class="h5 mb-0 font-weight-bold text-white-800">
                        <span class="products-value"  style ="color : white"></span>
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
                        <span class="order-value"  style ="color : white"></span>
                    </div>
                </div>
                <div class="col-auto">
                </div>
            </div>
        </div>
    </div>
</div>

      <!-- Monthly Earnings Chart -->
<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-info text-white">
            <h6 class="m-0 font-weight-bold">Monthly Earnings</h6>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Number of Users (Pie Chart) -->
<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-danger text-white">
            <h6 class="m-0 font-weight-bold">Registered User per Week</h6>
        </div>
        <div class="card-body" style="overflow:hidden">
            <div id="pie_chart" style="width:350px; height:320px;"></div>
        </div>
    </div>
</div>

<!-- Yearly Sales Chart -->
<div class="col-xl-8 col-lg-7"> <!-- Adjusted column classes to match the size of Monthly Earnings -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-success text-white">
            <h6 class="m-0 font-weight-bold">Yearly Sales</h6>
        </div>
        <div class="card-body">
            <div style="width: 100%;">
                <canvas id="yearlySalesChart"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{{-- pie chart --}}
<script type="text/javascript">
  var analytics = <?php echo $users; ?>

  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart()
  {
      var data = google.visualization.arrayToDataTable(analytics);
      var options = {
          title : ''
      };
      var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
      chart.draw(data, options);
  }
</script>
  {{-- line chart --}}
  <script type="text/javascript">
    const url = "{{route('product.order.income')}}";
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
      // *     example: number_format(1234.56, 2, ',', ' ');
      // *     return: '1 234,56'
      number = (number + '').replace(',', '').replace(' ', '');
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + Math.round(n * k) / k;
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }

      // Area Chart Example
      var ctx = document.getElementById("myAreaChart");

        axios.get(url)
              .then(function (response) {
                const data_keys = Object.keys(response.data);
                const data_values = Object.values(response.data);
                var myLineChart = new Chart(ctx, {
                  type: 'line',
                  data: {
                    labels: data_keys, // ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                      label: "Earnings",
                      lineTension: 0.3,
                      backgroundColor: "rgba(78, 115, 223, 0.05)",
                      borderColor: "rgba(78, 115, 223, 1)",
                      pointRadius: 3,
                      pointBackgroundColor: "rgba(78, 115, 223, 1)",
                      pointBorderColor: "rgba(78, 115, 223, 1)",
                      pointHoverRadius: 3,
                      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                      pointHitRadius: 10,
                      pointBorderWidth: 2,
                      data:data_values,// [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
                    }],
                  },
                  options: {
                    maintainAspectRatio: false,
                    layout: {
                      padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                      }
                    },
                    scales: {
                      xAxes: [{
                        time: {
                          unit: 'date'
                        },
                        gridLines: {
                          display: false,
                          drawBorder: false
                        },
                        ticks: {
                          maxTicksLimit: 12
                        }
                      }],
                      yAxes: [{
                        ticks: {
                          maxTicksLimit: 5,
                          padding: 10,
                          // Include a dollar sign in the ticks
                          callback: function(value, index, values) {
                            return 'Php' + number_format(value);
                          }
                        },
                        gridLines: {
                          color: "rgb(234, 236, 244)",
                          zeroLineColor: "rgb(234, 236, 244)",
                          drawBorder: false,
                          borderDash: [2],
                          zeroLineBorderDash: [2]
                        }
                      }],
                    },
                    legend: {
                      display: false
                    },
                    tooltips: {
                      backgroundColor: "rgb(255,255,255)",
                      bodyFontColor: "#858796",
                      titleMarginBottom: 10,
                      titleFontColor: '#6e707e',
                      titleFontSize: 14,
                      borderColor: '#dddfeb',
                      borderWidth: 1,
                      xPadding: 15,
                      yPadding: 15,
                      displayColors: false,
                      intersect: false,
                      mode: 'index',
                      caretPadding: 10,
                      callbacks: {
                        label: function(tooltipItem, chart) {
                          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                          return datasetLabel + ': Php' + number_format(tooltipItem.yLabel);
                        }
                      }
                    }
                  }
                });
              })
              .catch(function (error) {
              //   vm.answer = 'Error! Could not reach the API. ' + error
              console.log(error)
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

  </script>
<script type="text/javascript">
    const yearlySalesUrl = "{{ route('yearly.sales') }}";

    axios.get(yearlySalesUrl)
        .then(function (response) {
            const yearlySalesData = response.data.year;

            // Assuming your data structure has years as keys
            const years = Object.keys(yearlySalesData);
            const salesData = Object.values(yearlySalesData);

            var yearlySalesCtx = document.getElementById("yearlySalesChart");
            var yearlySalesChart = new Chart(yearlySalesCtx, {
                type: 'bar',
                data: {
                    labels: years,
                    datasets: [{
                        label: 'Total Sales',
                        backgroundColor: 'rgba(78, 115, 223, 0.5)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        data: salesData,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0,
                        },
                    },
                    scales: {
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Year', // Custom label for the x-axis
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                maxTicksLimit: 10,
                            },
                        }],
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Sales (Php)', // Custom label for the y-axis
                            },
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                                min: 20000,
                                max: 100000,
                                callback: function (value, index, values) {
                                    return 'Php' + number_format(value);
                                },
                            },
                            gridLines: {
                                color: 'rgb(234, 236, 244)',
                                zeroLineColor: 'rgb(234, 236, 244)',
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2],
                            },
                        }],
                    },
                    legend: {
                        display: false,
                    },
                    tooltips: {
                        backgroundColor: 'rgb(255,255,255)',
                        bodyFontColor: '#858796',
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                        callbacks: {
                            label: function (tooltipItem, chart) {
                                var datasetLabel =
                                    chart.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ': Php' + number_format(tooltipItem.yLabel);
                            },
                        },
                    },
                },
            });
        })
        .catch(function (error) {
            console.log(error);
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