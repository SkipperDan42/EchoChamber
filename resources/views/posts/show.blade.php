@extends('layouts.myapp')

<!-- Change active page depending on if page is a profile AND
        the profile belongs to the currently authenticated user -->
@if ($profileUser && $profileUser->id === auth()->id())
    @section('nav_profile', 'active')
@else
    @section('nav_dashboard', 'active')
@endif

@section('content')

    <!-- CARD FOR POST -->
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">

        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0">

            <!-- Profile of Post Owner -->
            <div class="d-flex flex-column justify-content-center">
                <div class="fw-bold text-primary">
                    <a href="/profile/{{$post->user->id}}">
                        {{ $post->user->username ?? 'Unknown' }}
                    </a>
                </div>

                <!-- Profile of Original Post Owner if Repost -->
                @if ($post->echoed)
                    <div class="text-muted small">
                        &#x1F5E3;
                        <a href="/profile/{{$echoedPost->user->id }}">
                            {{ $echoedPost->user->username }}
                        </a>
                    </div>
                @endif
            </div>

            <!-- Backpedal (edit) Button if Auth User is Post Owner -->
            @if ($post->user_id == auth()->user()->id)
                <div class="text-muted small">
                    <a class="btn btn-primary"
                       href="/posts/edit/{{ $post->id }}"
                       role="button">
                        Backpedal
                    </a>
                </div>
                <!-- Echo (repost) Button if Auth User is Post Owner -->
            @else
                <div class="text-muted small">
                    <a class="btn btn-primary"
                       href="/posts/edit/{{ $post->id }}"
                       role="button">
                        Echo
                    </a>
                </div>
            @endif

            <!-- DateTime of Post Creation -->
            <div class="fw-bold text-primary">
                {{ $post->created_at->format('H:i d/m/Y') ?? 'Unknown' }}
            </div>
        </div>

        <!-- Media if Posted -->
        @if ($post->media)
            <!-- Media -->
            <img src="{{ $post->media }}" class="card-img-top" alt="Post image">
        @endif

        <!-- Body -->
        <div class="card-body">

            <!-- Title -->
            <h5 class="card-title mb-2">
                {{ $post->title }}
            </h5>

            <!-- Content if Posted-->
            @if ($post->content)
                <p class="card-text">
                    {{ $post->content }}
                </p>
            @endif
        </div>

        <!-- Footer -->
        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">

            <!-- Claps (likes) on Post -->
            <div>
                <form action="{{ route('posts.clap', $post) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-link">
                        &#x1F44F;
                    </button>
                </form>
                {{ $post->claps }}
            </div>

            <!-- Echoes (reposts) of Post -->
            <div> &#x1F5E3; {{ $post->echoes }}</div>

            <!-- Comment count and dropdown button -->
            <div>
                &#x1F4AC; {{ $post->comments->count() }} Comments
            </div>
        </div>

        <!-- Comments Dropdown -->
        <div class="border-top">
            <ul class="list-group list-group-flush">
                <!-- Each comment displayed with username, content and claps -->
                @foreach ($post->comments as $comment)
                    <li class="list-group-item d-flex justify-content-between">
                        <div>
                            <strong>{{ $comment->user->username }}:</strong>
                            {{ $comment->content }}
                        </div>
                        <div>
                            <div> &#x1F44F; {{ $comment->claps }}</div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
