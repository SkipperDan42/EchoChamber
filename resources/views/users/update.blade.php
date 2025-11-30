@extends('layouts.myapp')

@section('content')
    <div class="card shadow-sm mx-auto"
         style="max-width: 600px;"
    >
        <!-- Header -->
        <div class="card-header d-flex align-items-center bg-white border-bottom-0">
            <h1>
                Update Account Details
            </h1>
        </div>
        <div class="card-body">
            <form method="POST"
                  action="{{ route('users.store', $user->id) }}"
            >
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="username"
                           class="form-label"
                    >
                        Username
                    </label>
                    <input type="text"
                           class="form-control"
                           id="username"
                           name="username"
                           value="{{ old('username', $user->username) ?? ""}}"
                    >
                    @error('username')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="first_name"
                           class="form-label"
                    >
                        First Name
                    </label>
                    <input type="text"
                           class="form-control"
                           id="first_name"
                           name="first_name"
                           value="{{ old('first_name', $user->first_name) ?? ""}}"
                    >
                    @error('first_name')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="last_name"
                           class="form-label"
                    >
                        Last Name
                    </label>
                    <input type="text"
                           class="form-control"
                           id="last_name"
                           name="last_name"
                           value="{{ old('last_name', $user->last_name) ?? ""}}"
                    >
                    @error('last_name')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email"
                           class="form-label"
                    >
                        Email
                    </label>
                    <input type="email"
                           class="form-control"
                           id="email"
                           name="email"
                           value="{{ old('email', $user->email) ?? ""}}"
                    >
                    @error('email')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div>
                    <br>
                    <p style="color:red">
                        Leave the password field empty to keep as is.
                    </p>
                </div>
                <div class="mb-3">
                    <label for="password"
                           class="form-label"
                    >
                        Password
                    </label>
                    <input type="password"
                           class="form-control"
                           id="password"
                           name="password"
                    >
                    @error('password')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation"
                           class="form-label"
                    >
                        Confirm Password
                    </label>
                    <input type="password"
                           class="form-control"
                           id="password_confirmation"
                           name="password_confirmation"
                    >
                    @error('password_confirmation')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="row align-items-cente">
                    <div class="col text-start">
                        <button type="submit"
                                class="btn btn-success"
                        >
                            Update
                        </button>
                    </div>
                    <div class="col text-end">
                        <a class="btn btn-danger"
                           href="{{ route("users.details", $user->id) }}"
                        >
                            Back
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

