@extends('layouts.myapp')

<!-- Change navbar style-->
@section('nav_dashboard', '#FFFFFF')
@section('nav_profile', '#5de5fe')
@section('nav_settings', '#FFFFFF')

@section('content')
    <br>

    <div class="card shadow-sm mx-auto"
         style="max-width: 600px;"
    >
        <!-- Header -->
        <div class="card-header text-center bg-white my-2">
            <h1>
                Whisper
            </h1>
        </div>
        <div class="card-body">
            <form method="POST"
                  action="{{ route('comments.store') }}"
            >
                @csrf

                <!-- Input for Comment Content -->
                <div class="form-group mb-3">
                    <textarea class="form-control"
                              id="content"
                              type="text"
                              name="content"
                              rows="5"
                    >{{ old("content", $comment->content ?? "") }}</textarea>

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
                       value="{{ $comment->post->id }}"
                >

                <!-- Hidden input to pass edited post data -->
                <input type="hidden"
                       name="id"
                       value="{{ $comment->id ?? null }}"
                >

                <!-- Submit and Cancel buttons -->
                <div class="d-flex justify-content-between mx-2 my-2">
                    <button type="submit"
                            class="btn btn-success px-4"
                    >
                        Submit
                    </button>
                    <a href="{{ route('posts.show', $comment->post->id) }}"
                       class="btn btn-danger"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
