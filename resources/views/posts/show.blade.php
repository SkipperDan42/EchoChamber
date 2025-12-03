@extends('layouts.myapp')

<!-- LOGIC FOR ACTIVE PAGE -->
<!-- Is this is the post of the currently authorised user - change navbar style-->
@if ($post->user->id === auth()->id())
    @section('nav_dashboard', '#FFFFFF')
    @section('nav_profile', '#5de5fe')
    @section('nav_settings', '#FFFFFF')
@else
    @section('nav_profile', '#FFFFFF')
    @section('nav_dashboard', '#5de5fe')
    @section('nav_settings', '#FFFFFF')
@endif

@section('content')

    <!-- CARD FOR POST -->
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">

        <!-- Header -->
        <div class="card-header bg-white">

            <!-- Edit Buttons -->
            <div class="row justify-content-between align-items-center mb-2 py-2 border-bottom">

                <!-- If Auth User is Post Owner then Backpedal and Delete options -->
                @if ($post->user_id == auth()->user()->id)

                    <div class="col-auto col-sm-auto">
                            <a class="btn btn-warning"
                               href="{{ route("posts.edit", $post->id) }}"
                               role="button"
                            >
                                &#x1F4DD; Backpedal
                            </a>
                    </div>

                    <div class="col-auto col-sm-auto">
                        <a class="btn btn-danger"
                           href="{{ route("posts.delete", $post->id) }}"
                           role="button"
                        >
                            &#x1F5D1; Delete
                        </a>
                    </div>

                <!-- If Auth User is not Post Owner then Clap and Echo options -->
                @else
                    <div class="col-auto col-sm-auto">
                        <form action="{{ route('posts.clap', $post) }}"
                              method="POST"
                              class="d-inline"
                        >
                            @csrf
                            @php
                                $userClapped = $post->claps()
                                                        ->where('user_id', auth()->user()->id)
                                                        ->exists();
                            @endphp
                            <button class="btn {{ $userClapped ? 'btn-success' : 'btn-secondary' }}">
                                &#x1F44F; Clap
                            </button>
                        </form>
                    </div>

                    <div class="col-auto col-sm-auto">
                        <a class="btn btn-warning"
                           href="{{ route("posts.edit", $post->id) }}"
                           role="button"
                        >
                            &#x1F5E3; Echo
                        </a>
                    </div>

                    <!-- If Auth User is Admin they may Delete others Posts -->
                    @if (auth()->user()->administrator_flag)
                        <div class="col-auto col-sm-auto">
                            <a class="btn btn-danger"
                               href="{{ route("posts.delete", $post->id) }}"
                               role="button"
                            >
                                &#x1F5D1; Delete
                            </a>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Profile of Post Owner -->
            <div class="row align-items-center">
                <div class="col text-start fw-bold text-primary">
                    <a class= "btn btn-info"
                       href="{{ route("users.posts", $post->user->id) }}"
                    >
                        &#x1F464;
                        {{ $post->user->username ?? 'Unknown' }}
                    </a>
                </div>

                <!-- Profile of Original Post Owner if Repost -->
                @if ($post->echoed && $post->echoed_post != null)
                    <div class="col text-center text-muted small">
                        <a class= "btn btn-info"
                           href="{{ route("users.posts", $post->echoed_post->user->id) }}"
                        >
                            &#x1F5E3;
                            {{ $post->echoed_post->user->username }}
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
            <div  class="border-bottom">
                <img src="{{ $post->media }}"
                     class="card-img-top"
                     alt="Post image">
            </div>
        @endif

        <!-- Body -->
        <div class="card-body border-bottom">

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
                &#x1F44F; {{ $post->claps }}
            </div>

            <!-- Echoes (reposts) of Post -->
            <div>
                &#x1F5E3; {{ $post->echoes }}
            </div>

            <!-- Comment count and dropdown button -->
            <div>
                &#x1F4AC; {{ $post->comments->count() }} Comments
            </div>
        </div>

        <!-- Comments -->
        <div class="border-top border-bottom">
            <ul class="list-group list-group-flush">
                <!-- Each comment displayed with username, content, and claps -->
                @foreach ($post->comments as $comment)
                    <li class="list-group-item d-flex justify-content-between align-items-start">

                        <!-- LEFT COLUMN -->
                        <div class="d-flex flex-column gap-2 align-items-start">
                            <!-- Username -->
                            <a class="btn btn-sm btn-info"
                               href="{{ route('users.posts', $comment->user->id) }}">
                                {{ $comment->user->username ?? 'Unknown' }}
                            </a>

                            <!-- Clap Button -->
                            @if ($comment->user_id != auth()->id())
                                <form action="{{ route('comments.clap', $comment) }}" method="POST">
                                    @csrf
                                    @php
                                        $userClapped = $comment->claps()
                                                                ->where('user_id', auth()->id())
                                                                ->exists();
                                    @endphp
                                    <button class="btn btn-sm {{ $userClapped ? 'btn-success' : 'btn-secondary' }}">
                                        &#x1F44F; {{ $comment->claps }}
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-sm btn-secondary">
                                    &#x1F44F; {{ $comment->claps }}
                                </button>
                            @endif
                        </div>

                        <!-- CENTER COLUMN -->
                        <div class="flex-grow-1 text-center px-3">
                            {{ $comment->content }}
                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="d-flex flex-column gap-2 align-items-end">
                            @if ($comment->user_id == auth()->user()->id)
                                <!-- Backpedal/Edit -->
                                <a class="btn btn-sm btn-warning"
                                   href="{{ route('comments.edit', $comment) }}">
                                    &#x1F4DD;
                                </a>

                                <!-- Delete -->
                                <a class="btn btn-sm btn-danger"
                                   href="{{ route('comments.delete', $comment) }}">
                                    &#x1F5D1;️
                                </a>
                            @elseif(auth()->user()->administrator_flag)
                                <!-- Admin delete -->
                                <a class="btn btn-sm btn-danger"
                                   href="{{ route('comments.delete', $comment) }}">
                                    &#x1F5D1;
                                </a>
                            @endif
                        </div>

                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Add Comment Dropdown -->
        <div class="mx-2 my-2" id="addComment">
            <form method="POST"
                  action="{{ route('comments.store') }}"
                  class="mt-3"
            >
                @csrf

                <!-- Input for Post Content -->
                <div class="form-group mx-2 my-2">
                    <textarea class="form-control"
                              id="content"
                              type="text"
                              name="content"
                              rows="5"
                              placeholder="Write a comment..."
                    ></textarea>

                    <!-- Inline error message -->
                    @error('content')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Hidden input to pass user data -->
                <input type="hidden"
                       name="user_id"
                       value="{{ auth()->user()->id }}"
                >

                <!-- Hidden input to pass post data -->
                <input type="hidden"
                       name="post_id"
                       value="{{ $post->id }}"
                >

                <!-- Submit button -->
                <div class="d-flex mx-2 my-2">
                    <button type="submit" class="btn btn-primary px-4">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <br>
@endsection
