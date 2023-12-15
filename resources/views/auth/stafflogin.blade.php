@extends('layouts.app')

@section('content')
<body style="background-image: url('/backend/img/back.jpg'); background-size: cover;">

<div class="row justify-content-center">

            <div class="col-xl-5 col-lg-5 col-md-5 mt-5">

                <div class="shadow-lg my-9">
                    <div class="p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="center">
                                 <div class="p-5">
                                    <div class="text-center">
                                       
                                    <h1 class="h2 mb-3">Staff</h1>

                <div class="card-body">
                    <form method="POST" action="{{ route('staff.login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" >
                            @error('email')
                                <span class="invalid-feedback" role="alert">    
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" >
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-5">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      