@extends('layouts.myapp')

<!-- Change active page depending on if page is a profile AND
        the profile belongs to the currently authenticated user -->

@section('nav_settings', 'active')
@section('nav_user_details', 'active')

@section('content')
    <!-- CARD FOR POST -->
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">

        <!-- If Auth User is this User or Admin then Update Details and Change Password options -->
        @if ($user->id == auth()->user()->id || auth()->user()->administrator_flag)
            <!-- Header -->
            <div class="card-header bg-white">
                <!-- Edit Buttons -->
                <div class="row justify-content-between align-items-center mb-2 py-2">
                    <div class="col-auto col-sm-auto">
                            <a class="btn btn-warning"
                               href="/user/{{$user->id}}/update"
                               role="button">
                                &#x1F4DD; Update Details
                            </a>
                    </div>

                    <div class="col-auto col-sm-auto">
                        <a class="btn btn-warning"
                           href=""
                           role="button">
                            &#x1F4DD; Change Password
                        </a>
                    </div>

                    <div class="col-auto col-sm-auto">
                        <a class="btn btn-danger"
                           href=""
                           role="button">
                            &#x1F5D1; Delete Account
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Body -->
        <div class="card-body">

            <!-- Username -->
            <h5 class="card-title mb-2">
                Username: {{ $user->username }}
            </h5>

            <!-- First Name -->
            <h5 class="card-title mb-2">
                First Name: {{ $user->first_name }}
            </h5>

            <!-- Last Name -->
            <h5 class="card-title mb-2">
                Last Name: {{ $user->last_name }}
            </h5>

            <!-- Email -->
            <h5 class="card-title mb-2">
                Email: {{ $user->email }}
            </h5>
        </div>
    </div>
@endsection
