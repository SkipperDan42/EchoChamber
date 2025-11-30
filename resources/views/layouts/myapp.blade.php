<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<div class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <div class="sticky-top" style="background-color:white; border-bottom:2px solid #000000">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">

                <!-- NAVBAR ICON -->
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('images/title.png') }}" alt="Logo" width="140" height="70" class="d-inline-block align-text-top">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- ALL NAVBAR BUTTONS HIDDEN BEHIND LOGIN -->
                    @auth

                    <!-- NAVBAR LEFT SIDE -->
                    <ul class="navbar-nav mx-auto fs-4">
                        <li class="nav-item">
                            <a class="nav-link me-5 @yield('nav_dashboard')" href="/">
                                The Chamber
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-5 @yield('nav_profile')"
                               href="/user/{{$user = auth()->user()->id}}/posts"
                            >
                                Monologue
                            </a>
                        </li>
                    </ul>

                    <!-- NAVBAR RIGHT SIDE -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown fs-4">
                            <a class="nav-link dropdown-toggle @yield('nav_settings')"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false"
                            >
                                Tools
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end fs-5">
                                <li>
                                    <a class="dropdown-item @yield('nav_user_details')"
                                       href="{{route("users.details", auth()->user()->id)}}"
                                    >
                                        Boor Hole
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item @yield('nav_statistics')"
                                       href="{{route("users.details", auth()->user()->id)}}"
                                    >
                                        Alternative Facts
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}"
                                          method="POST"
                                          class="d-inline"
                                    >
                                        @csrf
                                        <button type="submit"
                                                class="dropdown-item"
                                        >
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    @endauth

                </div>
            </div>
        </nav>

        <!-- FLASH MESSAGE AT PAGE TOP -->
        @if(session('message'))
            <div class="alert alert-success my-2 mx-1"
                 role="alert">
                {{session('message')}}
            </div>
        @endif

        <!-- FLASH DANGER AT PAGE TOP -->
        @if(session('danger'))
            <div class="alert alert-danger my-2 mx-1"
                 role="alert">
                {{session('danger')}}
            </div>
        @endif

        <!-- BUTTON BAR AT PAGE TOP -->
        <div class="row align-items-center my-2 mx-1">

            <!-- Back button is always present -->
            <div class="col text-start">=
                <a class="btn btn-secondary"
                        href="{{ url()->previous() }}"
                >
                    Back
                </a>
            </div>

            <!-- Other buttons may be added per page -->
            @yield('buttons')
        </div>
    </div>

    <div>
        @yield('content')
    </div>

    <!-- RUN JS SCRIPTS -->
    <!-- Alert fade - code here is not my own work, but edited by me -->
    <script>
        // Wait for page to load
        document.addEventListener('DOMContentLoaded', function () {

            // Select all alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {

                // Set timeout to fade and remove after 5 seconds
                setTimeout(function() {
                    alert.classList.add('fade');
                    alert.classList.remove('show');

                    // Remove from DOM after fade transition
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>
