
@extends('frontend.layouts.sign')

@section('title', 'Login')

@section('content')
    <section class="shop login section" style="background-image: url('/backend/img/back.jpg'); background-size: cover;">
        <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-5 col-md-5 mt-5">
                <div class="shadow-lg my-5">
                <div class="p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="center">
                        <div class="p-5">
                            <h2 class="text-center mb-4">Login</h2>
                        <!-- Form -->
                        <form class="form" method="post" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Your Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required="required" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Your Password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required="required" value="{{ old('password') }}">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="news">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="submit">Login</button>
                                <a href="{{ route('register.form') }}" class="btn btn-secondary">Register</a>
                            </div>
                       {{-- <div class="text-center mt-3">
    @if (Route::has('password.request'))
        <a class="lost-pass" href="{{ route('password.reset') }}">
            Forgot Password?
        </a>
    @endif
</div> --}}

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
        /* Center the form */
        .shop.login .card {
            margin-top: 70px; /* Adjust as needed */
        }
         /* Custom styles specific to this page */
         .shop.login .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        /* Center the form */
        .shop.login .card {
            margin-top: 70px; /* Adjust as needed */
        }

        /* Additional styles for the background */
        .shop.login.section {
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed; /* Optional: If you want the background to be fixed */
            height: 100vh; /* Set height to 100% of viewport height */
        }
    </style>

    <!-- Bootstrap CSS CDN Links -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
@endpush
