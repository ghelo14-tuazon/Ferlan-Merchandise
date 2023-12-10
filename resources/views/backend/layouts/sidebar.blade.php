<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <a class="sidebar-brand d-flex align-items-center justify-content-center">
    <img class="img-profile rounded-circle" src="{{ asset('images/logo2.png') }}" style="max-height: 40px;">

</a>
<a class="text-center font-weight-bold" style="font-size: 20px; font-family: 'Arial', sans-serif;">
  <div class="sidebar-brand-text text-white mx-2">ADMIN</div>
  </a>
   

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('admin')}}">
            
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Banner
    </div>



    <!-- Banners Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
          
            <span>Banners</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Banner Options:</h6>
                <a class="collapse-item" href="{{route('banner.index')}}">Banners</a>
                <a class="collapse-item" href="{{route('banner.create')}}">Add Banners</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Shop
    </div>

    <!-- Categories Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse"
            aria-expanded="true" aria-controls="categoryCollapse">
         


            <span>Category</span>
        </a>
        <div id="categoryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Category Options:</h6>
                <a class="collapse-item" href="{{route('category.index')}}">Category</a>
                <a class="collapse-item" href="{{route('category.create')}}">Add Category</a>
            </div>
        </div>
    </li>

    <!-- Products Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse"
            aria-expanded="true" aria-controls="productCollapse">
           
            <span>Products</span>
        </a>
        <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Product Options:</h6>
                <a class="collapse-item" href="{{route('product.index')}}">Products</a>
                <a class="collapse-item" href="{{route('product.create')}}">Add Product</a>
            </div>
        </div>
    </li>

    
    <!-- Shipping Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shippingCollapse"
            aria-expanded="true" aria-controls="shippingCollapse">
         
            <span>Shipping</span>
        </a>
        <div id="shippingCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Shipping Options:</h6>
                <a class="collapse-item" href="{{route('shipping.index')}}">Shipping</a>
                <a class="collapse-item" href="{{route('shipping.create')}}">Add Shipping</a>
            </div>
        </div>
    </li>

    <!--Orders -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('order.index')}}">
         
            <span>Orders</span>
        </a>
    </li>

     <li class="nav-item">
      <a class="nav-link" href="{{route('coupon.index')}}">
        
          <span>Coupon</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
  
  <div class="sidebar-heading">
       Sales
    </div>

   <!-- resources/views/layouts/sidebar.blade.php -->

<li class="nav-item">
    <a class="nav-link" href="{{ route('salesreport.index') }}">
        <span>Sales Report</span>
    </a>
</li>

       <!-- Include this in your sidebar -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('salesforecast.index') }}">
        <span>Sales Forecasting</span>
    </a>


</ul>
<style>
#accordionSidebar {
    width: 14rem !important;
    background-image: url('/backend/img/back.jpg'); /* Adjust the path as needed */
    background-size: cover; /* Adjust the size as needed */
    background-position: center; /* Adjust the position as needed */
    background-repeat: no-repeat; /* Prevent the background image from repeating */
}



</style>