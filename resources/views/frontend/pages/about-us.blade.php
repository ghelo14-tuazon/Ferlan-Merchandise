@extends('frontend.layouts.master')

@section('title', 'About Us')

@section('main-content')

    <!-- About Us -->
    <section class="about-us section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="about-content">
                        <h3>Welcome To <span>Ferlan Merchandise</span></h3>
                        <p>
                            Ferlan Merchandise is your go-to destination for high-quality products. We take pride in offering a curated selection of items that cater to your needs and preferences. Our commitment is to provide an exceptional shopping experience, ensuring that you find the perfect products that align with your lifestyle.
                        </p>
                    </div>
                    
                    <!-- Product Inquiry Form -->
                    <section class="product-inquiry-form section">
                        <div class="container">
                            <div class="row justify-content-center"> <!-- Center the form horizontally -->
                                <div class="col-md-10">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="card-title text-center">Product Inquiry</h3>
                                            <form action="{{ route('product.inquiry.submit') }}" method="post">
                                                @csrf
                                              <div class="form-group">
    <label for="inquiry-name">Name:</label>

    @auth
        <input type="text" class="form-control" name="inquiry-name" value="{{ auth()->user()->name }}" readonly required>
    @else
        <input type="text" class="form-control" name="inquiry-name" value="" readonly required>
    @endauth
</div>



                                           <div class="form-group">
    <label for="inquiry-email">Email:</label>
    <input type="email" class="form-control" name="inquiry-email" value="{{ auth()->check() ? auth()->user()->email : '' }}" required readonly>
</div>



                                                <div class="form-group">
                                                    <label for="inquiry-message">Message:</label>
                                                    <textarea class="form-control" name="inquiry-message" required></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-primary btn-block">Submit Inquiry</button>
                                            </form>
                                        </div>
                                    </div>

                  @if(auth()->check())
    {{-- Fetch all inquiries for the authenticated user --}}
    @php
        $userInquiries = App\Models\ProductInquiry::where('email', auth()->user()->email)
            ->orderBy('created_at', 'desc')
            ->get();
    @endphp

    {{-- Display only the latest staff reply --}}
    @if($userInquiries->count() > 0)
        @php
            $latestInquiry = $userInquiries->first();
        @endphp
        @if($latestInquiry->staff_reply)
            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="card-title">Your Latest Inquiry</h4>
                    <p>{{ $latestInquiry->message }}</p>
                    <h4 class="card-title mt-3">Staff Reply</h4>
                    <p>{{ $latestInquiry->staff_reply }}</p>
                </div>
            </div>
        @endif
    @endif
@endif


                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                
                <div class="col-lg-6 col-12">
                    <img src="{{ asset('frontend/img/ferlan.jpg') }}" alt="Ferlan Merchandise Image" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Start Shop Services Area -->
    <section class="shop-services section">
        <!-- ... Shop Services content ... -->
    </section>
    <!-- End Shop Services Area -->

@endsection
