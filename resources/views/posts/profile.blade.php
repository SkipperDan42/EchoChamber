@extends('layouts.myapp')

<!-- Change active page depending on if profile belongs to currently authenticated user -->
@if ($posts->first()->user->id == auth()->user()->id)
    @section('nav_profile', 'active')
@else
    @section('nav_dashboard', 'active')
@endif

@section('content')

    @foreach ($posts as $post)

        <!-- Collapse each card independently -->
        @php
            $collapseId = "commentsSection-" . $post->id;
        @endphp

        <!-- CARDS FOR USER POSTS -->
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <!-- Header -->
            <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0">
                <div class="fw-bold text-primary">
                    <a href="/profile/{{$post->user->id}}">
                        {{ $post->user->username ?? 'Unknown' }}
                    </a>
                </div>

                @if ($post->echoed && isset($echoedPosts[$post->echoed]))
                    <div class="text-muted small">
                        &#x1F5E3;
                        <a href="/profile/{{ $echoedPosts[$post->echoed]->user->id }}">
                            {{ $echoedPosts[$post->echoed]->user->username }}
                        </a>
                    </div>
                @endif

                <div class="fw-bold text-primary">
                    {{ $post->created_at->format('H:i d/m/Y') ?? 'Unknown' }}
                </div>
            </div>

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
                <!-- Content -->
                <p class="card-text">
                    {{ $post->content }}
                </p>
            </div>

            <!-- Footer -->
            <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                <div> &#x1F44F; {{ $post->claps }}</div>
                <div> &#x1F5E3; {{ $post->echoes }}</div>
                <div>
                    <button class="btn btn-link text-decoration-none p-0" data-bs-toggle="collapse" data-bs-target="#{{$collapseId}}">
                        &#x1F4AC; {{ $post->comments->count() }} Comments
                    </button>
                </div>
            </div>

            <!-- Comments Dropdown -->
            <div class="collapse border-top" id="{{$collapseId}}">
                <ul class="list-group list-group-flush">
                    @foreach ($post->comments as $comment)
                    <li class="list-group-item d-flex justify-content-between">
                        <div>
                            <strong>{{ $comment->user->first_name }}:</strong>
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

        <br>
    @endforeach

    <!-- Pagination links -->
    <div class="d-flex justify-content-center">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>
@endsection
