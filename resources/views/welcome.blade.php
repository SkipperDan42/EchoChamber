<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- CSS -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/echo-chamber.css') }}" rel="stylesheet">


</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{asset('images/title.png')}}" alt="Logo" width="140" height="70">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto fs-4">
                    <li class="nav-item"><a class="nav-link active me-5" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link me-5" href="#">Profile</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown fs-4">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Settings</a>
                        <ul class="dropdown-menu dropdown-menu-end fs-5">
                            <li><a class="dropdown-item" href="#">User Details</a></li>
                            <li><a class="dropdown-item" href="#">Statistics</a></li>
                            <li><a class="dropdown-item" href="#">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <br>

    <!-- CARDS FOR USER POSTS -->
    <div class="card mx-auto" style="width: 18rem;">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>

    <br>

    <!-- PAGINATION -->
    <div class="container-fluid">
        <nav aria-label="Dashboard Page Navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>

    <!-- RUN JS SCRIPTS -->
    <script src="{{ asset('js/old_bootstrap.bundle.js') }}" defer></script>
</body>
</html>
