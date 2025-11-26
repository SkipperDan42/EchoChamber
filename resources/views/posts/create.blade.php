@extends('layouts.myapp')

@section('nav_profile', 'active')

@section('content')
    <br>

    <div>
        <form method="POST" action="{{route('posts.store')}}">
            @csrf

            {{-- Input for Post Title --}}
            <div class="form-group">
                <p>Title:
                    <input type="text"
                           name="title"
                           value="{{ old("title", $post->title ?? "") }}"
                    >
                </p>

                {{-- Inline error message --}}
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input for Post Content --}}
            <div class="form-group">
                <p>Content:
                    <input type="text"
                           name="content"
                           value="{{old("content", $post->content ?? "")}}"
                    >
                </p>

                {{-- Inline error message --}}
                @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input for Media Link --}}
            <div class="form-group">
                <p>Media:
                    <input type="text"
                           name="media"
                           value="{{old("media", $post->media ?? "")}}"
                    >
                </p>

                {{-- Inline error message --}}
                @error('media')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Hidden input to pass edited post data --}}
            <input type="hidden" name="id" value="{{ $post->id ?? null }}">

            {{-- Submit and Cancel buttons --}}
            <input type="submit" value="Submit">
            <a href="{{route('posts.feed')}}">
                Cancel
            </a>
        </form>
    </div>

@endsection
