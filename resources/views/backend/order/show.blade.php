@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')

<h5 class="header text-center">CUSTOMER ORDER DETAILS</h5>
<div class="card" style="height: 80vh; overflow-y: auto;">
<div class="card">
  <div class="card-body">
  
    @if($order)
    <table class="table table-striped table-hover">
      <thead>
      <tr style="background-color: #6a6e6b; color: white;">
            <th>ID</th>
            <th>Order No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Quantity</th>
            <th>Shipping Fee</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <td>{{$order->id}}</td>
    <td>{{$order->order_number}}</td>
    <td>{{$order->first_name}} {{$order->last_name}}</td>
    <td>{{$order->email}}</td>
    <td>{{$order->quantity}}</td>
    <td>Php {{ optional($order->shipping)->price }}</td>
    <td>Php{{ number_format($order->total_amount, 2) }}</td>
    <td>  @if($order->status=='new')
    <span class="badge badge-primary">{{$order->status}}</span>
@elseif($order->status=='process')
    <span class="badge badge-warning">{{$order->status}}</span>
@elseif($order->status=='delivered')
    <span class="badge badge-success">{{$order->status}}</span>
@elseif($order->status=='ready')
    <span class="badge badge-info">{{$order->status}}</span> <!-- Use 'info' class for blue color -->
@elseif($order->status=='shipout')
    <span class="badge badge-secondary">{{$order->status}}</span> <!-- Use 'secondary' class for a different color -->
@else
    <span class="badge badge-danger">{{$order->status}}</span>
@endif
            </td>
            <td class = "d-flex">
                <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
               
            </td>

        </tr>
      </tbody>
    </table>
   <div>

<!-- Display Product Names -->
<!-- Display Product Names -->

    

      <h5  class="text-center">ITEMS PURCHASED</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->cart as $cartItem)
                <tr>
                    <td>{{ $cartItem->product->title }}</td>
                     <td>{{ $cartItem->size }}</td> 
                    <td>{{ $cartItem->quantity }}</td>
                    <td>{{ $cartItem->amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- End Display Product Names -->

<!-- End Display Product Names -->

<!-- End Display Product Names -->

   <div class="order-table">
    <table class="table table-striped table-hover">
        <h5 class= "text-center color: white;">ORDER INFORMATION<h5>
<thead>
<tr style="background-color: #336699; color: white;">
            <th>ID</th>
            <th>Order No.</th>
            <th>Order Date</th>
            <th>Quantity</th>
            <th>Order Status</th>
            <th>Shipping Fee</th>
            <th>Coupon</th>
            <th>Total Amount</th>
            <th>Payment Method</th>
            <th>Payment Status</th>
        </tr>
        </thead>
        <tbody>
        <td>{{$order->id}}</td>
         <td>{{$order->order_number}}</td>
         <td>{{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('g : i a')}}</td>
          <td>{{$order->quantity}}</td>
          <td>
          
                                        @if($order->status=='new')
                                        <span class="badge badge-primary">{{$order->status}}</span>
                                        @elseif($order->status=='process')
                                        <span class="badge badge-warning">{{$order->status}}</span>
                                        @elseif($order->status=='delivered')
                                        <span class="badge badge-success">{{$order->status}}</span>
                                        @else
                                        <span class="badge badge-danger">{{$order->status}}</span>
                                        @endif
             </td>
             <td>Php {{optional($order->shipping)->price}}</td>
             <td>Php {{number_format($order->coupon, 2)}}</td>
              <td>Php {{number_format($order->total_amount, 2)}}</td>
              <td>@if($order->payment_method=='cod') Cash on Delivery @else Paypal @endif</td>
                <td>{{$order->payment_status}}</td>
        </tbody>
        </table>
</div>

        <div class="orders-table">
 <table class="table table-striped table-hover">
        <h5 class= "text-center">SHIPPING DETAILS<h5>
<thead>
<tr style="background-color: #1c552d; color: white;">
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone No.</th>
            <th>Sitio</th>
            <th>Barangay</th>
            <th>Postal Code</th>
          
        </tr>
        </thead>
        <tbody>
           <td>{{$order->first_name}} {{$order->last_name}}</td>
             <td>{{$order->email}}</td>
               <td>{{$order->phone}}</td>
               <td>{{$order->address1}}, {{$order->address2}}</td>
                     <td>{{$order->country}}</td>
                 <td>{{$order->post_code}}</td>
        </tbody>
        </table>

        @endif
    </div>
</div>
@endsection

@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    div.dataTables_wrapper div.dataTables_paginate {
        display: none;
    }
</style>
@endpush

@push('scripts')

<!-- Page level plugins -->
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
    $('#order-dataTable').DataTable({
        "columnDefs": [{
            "orderable": false,
            "targets": [8]
        }]
    });

    // Sweet alert

    function deleteData(id) {

    }
</script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.dltBtn').click(function (e) {
            var form = $(this).closest('form');
            var dataID = $(this).data('id');
            // alert(dataID);
            e.preventDefault();
            swal({
                    title: "Are you sure?",
                    text: "Warning: Once deleted you cannot recover the data!!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    } else {

                    }
                });
        })
    })
</script>
@endpush
@push('styles')
<style>
    .order-table {
        margin-bottom:1.5rem;
        color:#6a6e6b;      
    }
    
    .card-body{
        margin-bottom:1.5em;
        margin-top:1.5em;
         color:#6a6e6b;   
    }
    .orders-table {
        margin-bottom:1.5rem;
        color:#6a6e6b;      
    }
</style>
@endpush