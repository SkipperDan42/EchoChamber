@extends('layouts.myapp')

@section('nav_profile', 'active')

@section('content')

    <br>

    <div>
        <form method="POST" action="{{route('posts.store')}}">
            @csrf
            <div class="form-group">
                <p>Title:
                    <input type="text"
                           title="title"
                           value="{{old("title")}}"
                    >
                </p>

                {{-- Inline error message --}}
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <p>Content:
                    <input type="text"
                           name="content"
                           value="{{old("content")}}"
                    >
                </p>

                {{-- Inline error message --}}
                @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <p>Media:
                    <input type="text"
                           name="media"
                           value="{{old("media")}}"
                    >
                </p>

                {{-- Inline error message --}}
                @error('media')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <input type="submit" value="Submit">
            <a href="{{route('posts.feed')}}">Cancel</a>
        </form>
    </div>

@endsection
