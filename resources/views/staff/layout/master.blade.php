<!DOCTYPE html>
<html lang="en">

@include('staff.layout.head')

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

   
    <!-- Sidebar -->
    @include('staff.layout.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
  
        <!-- Topbar -->
      <!-- Topbar -->
   
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        @yield('main-content')
        <!-- /.container-fluid -->
   @yield('content')
      </div>
      <!-- End of Main Content -->
      @include('backend.layouts.footer')
          <!-- Success Modal -->

</body>

</html>
