@extends('layouts.myapp')

@section('nav_dashboard', 'active')

@section('content')

    <!-- CARDS FOR USER POST -->
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0">
            <div class="fw-bold text-primary">
                {{ $post->user->username ?? 'Unknown' }}
            </div>

            @if ($post->echoed && isset($echoedPosts[$post->echoed]))
                <div class="text-muted small">
                    &#x1F5E3; {{ $echoedPosts[$post->echoed]->user->username }}
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
            <div> &#x1F4E3; {{ $post->echoes }}</div>
        </div>

        <!-- Comments Dropdown -->
        <div class="border-top" id="commentsSection">
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

    <!-- Pagination links -->
    <div class="d-flex justify-content-center">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>
@endsection
