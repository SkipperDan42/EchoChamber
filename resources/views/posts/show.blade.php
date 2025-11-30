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
        <div class="card-header bg-white">

            <!-- Edit Buttons -->
            <div class="row justify-content-between align-items-center mb-2 py-2 border-bottom">

                <!-- If Auth User is Post Owner then Backpedal and Delete options -->
                @if ($post->user_id == auth()->user()->id)

                    <!-- If Auth User is Admin they may clap their own Post -->
                    @if (auth()->user()->administrator_flag)
                        <div class="col-auto col-sm-auto">
                            <form action="{{ route('posts.clap', $post) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-secondary">
                                    &#x1F44F; Clap
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="col-auto col-sm-auto">
                            <a class="btn btn-warning"
                               href="/posts/{{ $post->id }}/edit"
                               role="button">
                                &#x1F4DD; Backpedal
                            </a>
                    </div>

                    <div class="col-auto col-sm-auto">
                        <a class="btn btn-danger"
                           href="/posts/{{ $post->id }}/delete"
                           role="button">
                            &#x1F5D1; Delete
                        </a>
                    </div>

                <!-- If Auth User is not Post Owner then Clap and Echo options -->
                @else
                    <div class="col-auto col-sm-auto">
                        <form action="{{ route('posts.clap', $post) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-secondary">
                                &#x1F44F; Clap
                            </button>
                        </form>
                    </div>

                    <div class="col-auto col-sm-auto">
                        <a class="btn btn-warning"
                           href="/posts/{{ $post->id }}/edit"
                           role="button">
                            &#x1F5E3; Echo
                        </a>
                    </div>

                    <!-- If Auth User is Admin they may Delete others Posts -->
                    @if (auth()->user()->administrator_flag)
                        <div class="col-auto col-sm-auto">
                            <a class="btn btn-danger"
                               href="/posts/{{ $post->id }}/delete"
                               role="button">
                                &#x1F5D1; Delete
                            </a>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Profile of Post Owner -->
            <div class="row align-items-center">
                <div class="col text-start fw-bold text-primary">
                    <a class= "btn btn-info" href="/user/{{$post->user->id}}/posts">
                        &#x1F464;
                        {{ $post->user->username ?? 'Unknown' }}
                    </a>
                </div>

                <!-- Profile of Original Post Owner if Repost -->
                @if ($post->echoed)
                    <div class="col text-center text-muted small">
                        <a class= "btn btn-info" href="/user/{{$echoedPost->user->id }}/posts">
                            &#x1F5E3;
                            {{ $echoedPost->user->username }}
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
                <img src="{{ $post->media }}" class="card-img-top" alt="Post image">
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

        <!-- Comments Dropdown -->
        <div class="border-top">
            <ul class="list-group list-group-flush">
                <!-- Each comment displayed with username, content and claps -->
                @foreach ($post->comments as $comment)
                    <li class="list-group-item d-flex justify-content-between align-items-start">

                        <!-- LEFT COLUMN (vertical) -->
                        <div class="d-flex flex-column gap-2 align-items-stretch">

                            <div>
                                <a class="btn btn-info w-100" href="/user/{{$comment->user->id}}/posts">
                                    {{ $comment->user->username ?? 'Unknown' }}
                                </a>
                            </div>

                            @if ($comment->user_id == auth()->user()->id)

                                @if (auth()->user()->administrator_flag)
                                    <div>
                                        <form method="POST" class="w-100 m-0">
                                            @csrf
                                            <button class="btn btn-secondary w-100" type="submit">
                                                &#x1F44F; {{ $comment->claps }}
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                <div>
                                    <a class="btn btn-warning w-100" href="">
                                        &#x1F4DD; Backpedal
                                    </a>
                                </div>

                                <div>
                                    <a class="btn btn-danger w-100" href="">
                                        &#x1F5D1;️ Delete
                                    </a>
                                </div>

                            @else
                                <div>
                                    <form method="POST" class="w-100 m-0">
                                        @csrf
                                        <button class="btn btn-secondary w-100" type="submit">
                                            &#x1F44F; {{ $comment->claps }}
                                        </button>
                                    </form>
                                </div>

                                @if (auth()->user()->administrator_flag)
                                    <div>
                                        <a class="btn btn-danger w-100" href="">
                                            &#x1F5D1; Delete
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- CENTER COLUMN -->
                        <div class="flex-grow-1 text-center px-3">
                            {{ $comment->content }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
