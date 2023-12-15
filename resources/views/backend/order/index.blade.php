@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Order Lists</h6>
        <div class="float-right">
            <label for="orderStatusFilter">Filter by Status:</label>
            <select id="orderStatusFilter" class="form-control">
                <option value="">All</option>
                <option value="new">New</option>
                <option value="process">Process</option>
                <option value="ready">Ready</option>

                <option value="shipout">ShipOut</option>
                <option value="delivered">Delivered</option>
                 <option value="cancel">Cancel</option>
                <!-- Add more options if needed -->
            </select>
        </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        @if(count($orders)>0)
        <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
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
            @foreach($orders as $order)  
            @php
                $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
            @endphp 
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->order_number}}</td>
                    <td>{{$order->first_name}} {{$order->last_name}}</td>
                    <td>{{$order->email}}</td>
                    <td>{{$order->quantity}}</td>
                    <td>@foreach($shipping_charge as $data) Php {{number_format($data,2)}} @endforeach</td>
                    <td>Php {{number_format($order->total_amount,2)}}</td>
                    <td>
                   @if($order->status=='new')
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
                  <td class="d-flex">
    <a href="{{ route('order.show', $order->id) }}" class="btn btn-warning btn-sm mr-1" style="height: 30px; width: 30px; border-radius: 50%;" data-toggle="tooltip" title="View" data-placement="bottom"><i class="fas fa-eye"></i></a>

    <a href="{{ route('order.edit', $order->id) }}" class="btn btn-primary btn-sm mr-1" style="height: 30px; width: 30px; border-radius: 50%;" data-toggle="tooltip" title="Edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
</td>
                </tr>  
            @endforeach
          </tbody>
        </table>
      <span style="float:right">@include('backend.pagination.custom', ['paginator' => $orders])</span>
        @else
          <h6 class="text-center">No orders found!!! Please order some products</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
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
    "order": [
        [0, 'desc'] // Assuming the first column (ID) represents the order you want
    ],
    "columnDefs": [
        {
            "orderable": false,
            "targets": [8]
        }
    ]
});

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.dltBtn').click(function(e){
        var form=$(this).closest('form');
        var dataID=$(this).data('id');
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
    });

    $('#orderStatusFilter').change(function () {
        var status = $(this).val();
        var table = $('#order-dataTable').DataTable();

        if (status === "") {
            table.columns(7).search("").draw(); // Assuming the status column is at index 7
        } else {
            table.columns(7).search(status).draw();
        }
    });
});
</script>
@endpush
