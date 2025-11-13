@extends('layouts.myapp')

@section('nav_dashboard', 'active')

@section('content')

    @foreach ($posts as $post)

        <!-- EAGER LOAD POSTS
                $posts = Post::with('user')->get();
                return view('posts.index', compact('posts'));
        -->

        <!-- CARDS FOR USER POSTS -->
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <!-- Header -->
            <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0">
                <div class="fw-bold text-primary">
                    {{ $post->user->first_name ?? 'Unknown' }} {{ $post->user->last_name  ?? 'Unknown' }}
                </div>
                <div class="text-muted small">
                    Repost: {{ $post->echoed }}
                </div>
            </div>

            <!-- Image -->
            <img src="{{ $post->media }}" class="card-img-top" alt="Post image">

            <!-- Body -->
            <div class="card-body">
                <h5 class="card-title mb-2">
                    {{ $post->title }}
                </h5>
                <p class="card-text">
                    {{ $post->content }}
                </p>
            </div>

            <!-- Footer -->
            <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                <div><i class="bi bi-heart-fill text-danger"></i>{{ $post->claps }}</div>
                <div><i class="bi bi-repeat"></i>{{ $post->echoes }}</div>
                <div>
                    <button class="btn btn-link text-decoration-none p-0" data-bs-toggle="collapse" data-bs-target="#commentsSection">
                        <i class="bi bi-chat-dots"></i> 45 Comments
                    </button>
                </div>
            </div>

            <!-- Comments Dropdown -->
            <div class="collapse" id="commentsSection">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>@commenter1:</strong> Great post!
                    </li>
                    <li class="list-group-item">
                        <strong>@commenter2:</strong> Love the image.
                    </li>
                    <li class="list-group-item">
                        <strong>@commenter3:</strong> Nice layout example.
                    </li>
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
