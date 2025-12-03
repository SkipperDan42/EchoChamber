@extends('layouts.myapp')

<!-- LOGIC FOR ACTIVE PAGE AND BUTTONS -->
@if ($profileUser)
    <!-- Is this is the profile of the currently authorised user then change navbar style-->
    @if ($profileUser->id === auth()->id())
        @section('nav_dashboard', '#FFFFFF')
        @section('nav_profile', '#5de5fe')
        @section('nav_settings', '#FFFFFF')
    @else
        @section('nav_profile', '#FFFFFF')
        @section('nav_dashboard', '#5de5fe')
        @section('nav_settings', '#FFFFFF')
    @endif

    @section('buttons')
        <!-- Is this is the profile of the currently authorised user - add shout button -->
        @if ($profileUser->id === auth()->id())
            <div class="col text-center">
                <a class="btn btn-primary"
                   href="{{ route("posts.create") }}"
                   role="button"
                >
                    Start Shouting
                </a>
            </div>
        @endif

        <!-- Add buttons for all profiles -->
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
                   href="{{ route("users.details", $profileUser) }}"
                   role="button"
                >
                    Boor Deets
                </a>
                <a class="dropdown-item"
                   href="{{ route("users.posts", $profileUser) }}"
                   role="button"
                >
                    Boor Shouts
                </a>
                <a class="dropdown-item"
                   href="{{ route("users.comments", $profileUser) }}"
                   role="button"
                >
                    Boor Whispers
                </a>
                <a class="dropdown-item"
                   href="{{ route("users.stats", $profileUser) }}"
                   role="button"
                >
                    Alternative Facts
                </a>
            </div>
        </div>
    @endsection
@else
    <!-- If this is not a user profile -->
    @section('nav_dashboard', '#5de5fe')
    @section('nav_profile', '#FFFFFF')
    @section('nav_settings', '#FFFFFF')
    @section('buttons')
        <div class="col text-center">
            <a class="btn btn-primary"
               href="{{ route("posts.create") }}"
               role="button"
            >
                Start Shouting
            </a>
        </div>
        <div class="col text-end">
        </div>
    @endsection
@endif

@section('content')

    <!-- Loop through all comments and display as cards -->
    @foreach ($comments as $comment)

        <!-- CARD FOR POST -->
        <div class="card shadow-sm mx-auto" style="max-width: 600px;"
             onclick="window.location.href='{{ route('posts.show', $comment->post) }}'">

            <!-- Header -->
            <div class="card-header bg-white">

                <!-- Profile of Post Owner -->
                <div class="row align-items-center">
                    <div class="col text-start fw-bold text-primary">
                        <a class= "btn btn-info"
                           href="{{ route("users.posts", $comment->post->user?->id) }}"
                        >
                            &#x1F464;
                            {{ $comment->post->user->username ?? 'Unknown' }}
                        </a>
                    </div>

                    <!-- Profile of Original Post Owner if Repost -->
                    @if ($comment->post->echoed && $comment->post->echoed_post != null)
                        <div class="col text-center text-muted small">
                            <a class= "btn btn-info"
                               href="{{ route("users.posts", $comment->post->echoed_post->user->id) }}"
                            >
                                &#x1F5E3;
                                {{ $comment->post->echoed_post->user->username ?? 'Unknown' }}
                            </a>
                        </div>
                    @endif

                    <!-- DateTime of Post Creation -->
                    <div class="col text-end w-bold text-info">
                        {{ $comment->post->created_at->format('H:i d/m/Y') ?? 'Unknown' }}
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body border-bottom">
                <!-- Title -->
                <h5 class="card-title mb-2">
                    {{ $comment->post->title }}
                </h5>
            </div>

            <!-- Footer -->
            <div class="card-footer bg-white border-bottom border-top-0 d-flex justify-content-between align-items-center">

                <!-- Claps (likes) on Post -->
                <div>
                    &#x1F44F; {{ $comment->post->claps }}
                </div>

                <!-- Echoes (reposts) of Post -->
                <div>
                    &#x1F5E3; {{ $comment->post->echoes }}
                </div>

                <!-- Comment count -->
                <div>
                    &#x1F4AC; {{ $comment->post->comments->count() }} Comments
                </div>
            </div>

            <!-- Comments Dropdown -->
            <div class="d-flex justify-content-between my-2 mx-3">
                <div style="color: deepskyblue">
                    <strong>
                        {{ $comment->user->username }}:
                    </strong>
                    {{ $comment->content }}
                </div>
                <div>
                    &#x1F44F; {{ $comment->claps }}
                </div>
            </div>
        </div>

        <br>
    @endforeach
    <!-- Pagination links -->
    <div class="d-flex justify-content-center">
        {{ $comments->links('pagination::bootstrap-5') }}
    </div>
@endsection
