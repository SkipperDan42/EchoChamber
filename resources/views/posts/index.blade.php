@extends('layouts.myapp')

<!-- Change active page depending on if page is a profile AND
        the profile belongs to the currently authenticated user -->
@if ($profileUser && $profileUser->id === auth()->id())
    @section('nav_profile', 'active')
@else
    @section('nav_dashboard', 'active')
@endif

@section('content')

    <div>
        <a class="btn btn-primary" href="/posts/create" role="button">Start Shouting</a>
    </div>

    @foreach ($posts as $post)

        <!-- Collapse each card independently -->
        @php
            $collapseId = "commentsSection-" . $post->id;

        @endphp

        <!-- CARDS FOR USER POSTS -->
        <div class="card shadow-sm mx-auto" style="max-width: 600px;"
             onclick="window.location.href='{{ route('posts.show', $post) }}'">

            <!-- Header -->
            <div class="card-header bg-white">

                <!-- Profile of Post Owner -->
                <div class="row align-items-center">
                    <div class="col text-start fw-bold text-primary">
                        <a class= "btn btn-info" href="/profile/{{$post->user->id}}"
                           onClick="event.stopPropagation()">
                            &#x1F464;
                            {{ $post->user->username ?? 'Unknown' }}
                        </a>
                    </div>

                    <!-- Profile of Original Post Owner if Repost -->
                    @if ($post->echoed && isset($echoedPosts[$post->echoed]))
                        <div class="col text-center text-muted small">
                            <a class= "btn btn-info"
                               href="/profile/{{ $echoedPosts[$post->echoed]->user->id }}"
                               onClick="event.stopPropagation()">
                                &#x1F5E3;
                                {{ $echoedPosts[$post->echoed]->user->username }}
                            </a>
                        </div>
                    @endif

                    <!-- DateTime of Post Creation -->
                    <div class="col text-end w-bold text-info">
                        {{ $post->created_at->format('H:i d/m/Y') ?? 'Unknown' }}
                    </div>
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
                <div> &#x1F44F; {{ $post->claps }} </div>

                <!-- Echoes (reposts) of Post -->
                <div> &#x1F5E3; {{ $post->echoes }} </div>

                <!-- Comment count and dropdown button -->
                <div>
                    <button class="btn btn-link text-decoration-none p-0"
                            data-bs-toggle="collapse" data-bs-target="#{{$collapseId}}"
                            onClick="event.stopPropagation()">
                        &#x1F4AC; {{ $post->comments->count() }} Comments
                    </button>
                </div>
            </div>

            <!-- Comments Dropdown -->
            <div class="collapse border-top" id="{{$collapseId}}">
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

        <br>
    @endforeach

    <!-- Pagination links -->
    <div class="d-flex justify-content-center">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>
@endsection
