@extends('layouts.myapp')

@section('content')
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <!-- Header -->
        <div class="card-body d-flex justify-content-between align-items-center bg-white border-bottom-0">

            <div>
                <h2>Already have an account?</h2>
                <br>
                <h2>Then Login</h2>
            </div>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>

    <br>

    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <!-- Header -->
        <div class="card-body d-flex justify-content-between align-items-center bg-white border-bottom-0">

            <h2>
                Alternatively Create an Account
            </h2>
            <a class="btn btn-primary" href="{{ route('register') }}">
                Sign Up
            </a>
        </div>
    </div>
@endsection

