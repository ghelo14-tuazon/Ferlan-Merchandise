
@extends('frontend.layouts.sign')

@section('title', 'Register')

@section('content')
    <section class="shop login section">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-8 col-12 my-auto mx-auto">
                    <div class="card p-4">
                        <h2 class="text-center mb-4">Register</h2>
                        

                        <!-- Form -->
                        <form class="form" method="post" action="{{ route('register.submit') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required="required" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Your Email<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="email" name="email" required="required" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Your Password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required="required" value="{{ old('password') }}" placeholder ="Should contain Letter and Number (Min. of 8)">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required="required" value="{{ old('password_confirmation') }}">
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="submit">Register</button>
                                <a href="{{ route('login.form') }}" class="btn btn-secondary">Login</a>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection

@push('styles')
    <style>
        /* Custom styles specific to this page */
        .shop.login .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
         .shop.login .card {
            margin-top: 70px; /* Adjust as needed */
        }
    </style>
@endpush