@extends('frontend.layouts.master')

@section('title','Order Tracking')

@section('main-content')

<section class="tracking_box_area section_gap py-5">
    <div class="container">
        <div class="tracking_box_inner">
            <p>Track order using the order number from your order list page</p>
            <form class="row tracking_form my-4" action="{{route('product.track.order')}}" method="post" novalidate="novalidate">
              @csrf
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control p-2"  name="order_number" placeholder="Enter your order number">
                </div>
                <div class="col-md-8 form-group">
                    <button type="submit" value="submit" class="btn submit_btn">Track</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection