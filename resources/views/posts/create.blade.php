@extends('layouts.myapp')

@section('nav_profile', 'active')

@section('content')
    <br>

    <div class="card shadow-sm mx-auto"
         style="max-width: 600px;"
    >
        <!-- Header -->
        <div class="card-header d-flex align-items-center bg-white border-bottom-0">
            <h1>
                Create a Post
            </h1>
        </div>
        <div class="card-body">
            <form method="POST"
                  action="{{ route('posts.store') }}"
            >
                @csrf

                {{-- Input for Post Title --}}
                <div class="form-group mb-3">
                    <label class="form-label"
                           for="title"
                    >
                        Title
                    </label>
                    <input class="form-control"
                           id="title"
                           type="text"
                           name="title"
                           value="{{ old("title", $post->title ?? "") }}"
                    >

                    {{-- Inline error message --}}
                    @error('title')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Input for Post Content --}}
                <div class="form-group mb-3">
                    <label class="form-label"
                           for="content"
                    >
                        Content
                    </label>
                    <textarea class="form-control"
                              id="content"
                              type="text"
                              name="content"
                              rows="5"
                    >
                        {{ old("content", $post->content ?? "") }}
                    </textarea>

                    {{-- Inline error message --}}
                    @error('content')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Input for Media Link --}}
                <div class="form-group mb-3">
                    <label class="form-label"
                           for="media"
                    >
                        Media
                    </label>
                    <input class="form-control"
                           id="media"
                           type="text"
                           name="media"
                           value="{{ old("media", $post->media ?? "") }}"
                    >

                    {{-- Inline error message --}}
                    @error('media')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Hidden input to pass edited post data --}}
                <input type="hidden"
                       name="id"
                       value="{{ $post->id ?? null }}"
                >

                {{-- Submit and Cancel buttons --}}
                <input type="submit"
                       value="Submit"
                >
                <a href="{{ route('posts.index') }}">
                    Cancel
                </a>
            </form>
        </div>
    </div>

@endsection
