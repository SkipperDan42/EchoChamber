@extends('layouts.myapp')

<!-- LOGIC FOR ACTIVE PAGE AND BUTTONS -->
@php
    $authProfile = ($user == auth()->user());
@endphp
<!-- If this is the profile of the currently authenticated user -->
@if ($authProfile)
    @section('nav_settings', 'active')
    @section('nav_my_details', 'active')

<!-- If this is another user profile dashboard active -->
@else
    @section('nav_dashboard', 'active')
@endif

@section('buttons')
    <div class="col text-end dropdown">
        <button class="btn btn-warning dropdown-toggle"
                type="button"
                id="dropdownMenuButton"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
        >
            Boorhole
        </button>
        <div class="dropdown-menu"
             aria-labelledby="dropdownMenuButton"
        >
            <a class="dropdown-item"
               href="{{ route("users.details", $user) }}"
               role="button"
            >
                {{$authProfile ? 'My Deets' : 'Boor Deets'}}
            </a>
            <a class="dropdown-item"
               href="{{ route("users.posts", $user) }}"
               role="button"
            >
                {{$authProfile ? 'My Shouts' : 'Boor Shouts'}}
            </a>
            <a class="dropdown-item"
               href="{{ route("users.comments", $user) }}"
               role="button"
            >
                {{$authProfile ? 'My Whispers' : 'Boor Whispers'}}
            </a>
            <a class="dropdown-item"
               href="{{ route("users.stats", $user) }}"
               role="button"
            >
                Alternative Facts
            </a>
        </div>
    </div>
@endsection



@section('content')
    <!-- CARD FOR POST -->
    <div class="card shadow-sm mx-auto"
         style="max-width: 600px;"
    >
        <!-- If Auth User is this User or Admin then Update Details and Change Password options -->
        @if ($user->id == auth()->user()->id || auth()->user()->administrator_flag)
            <!-- Header -->
            <div class="card-header bg-white">
                <!-- Edit Buttons -->
                <div class="row justify-content-between align-items-center py-2">
                    <div class="col-auto col-sm-auto">
                            <a class="btn btn-warning"
                               href="{{ route("users.update", $user->id) }}"
                               role="button"
                            >
                                &#x1F4DD; Update Details
                            </a>
                    </div>

                    <div class="col-auto col-sm-auto">
                        <a class="btn btn-danger"
                           href="{{ route("users.delete", $user->id) }}"
                           role="button"
                        >
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
