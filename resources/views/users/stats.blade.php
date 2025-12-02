@extends('layouts.myapp')

<!-- LOGIC FOR ACTIVE PAGE AND BUTTONS -->
@php
    $user = request()->route('user');
    $authProfile = ($user == auth()->user());
@endphp
<!-- If this is the profile of the currently authenticated user -->
@if ($authProfile)
    @section('nav_settings', 'active')
    @section('nav_my_stats', 'active')

    <!-- If this is another user profile dashboard active -->
@else
    @section('nav_dashboard', 'active')
@endif

@section('buttons')
    <div class="col text-end dropdown">
        <button class="btn btn-warning dropdown-toggle"
                type="button"
                id="dropdownMenuButton"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
        >
            Boorhole
        </button>
        <div class="dropdown-menu"
             aria-labelledby="dropdownMenuButton"
        >
            <a class="dropdown-item"
               href="{{ route("users.details", $user) }}"
               role="button"
            >
                {{$authProfile ? 'My Deets' : 'Boor Deets'}}
            </a>
            <a class="dropdown-item"
               href="{{ route("users.posts", $user) }}"
               role="button"
            >
                {{$authProfile ? 'My Shouts' : 'Boor Shouts'}}
            </a>
            <a class="dropdown-item"
               href="{{ route("users.comments", $user) }}"
               role="button"
            >
                {{$authProfile ? 'My Whispers' : 'Boor Whispers'}}
            </a>
            <a class="dropdown-item"
               href="{{ route("users.stats", $user) }}"
               role="button"
            >
                Alternative Facts
            </a>
        </div>
    </div>
@endsection


@section('content')

    <div id="accordion"
         class="accordion py-2 px-3">

        @foreach ($postMetrics as $postMetric => $postMetricValue)
            @php
                $metricID = str_replace(' ', '', $postMetric);
            @endphp
            @if (!empty($postMetricValue))
                <div class="accordion-item">
                    <div class="accordion-header"
                         id="heading{{ $metricID }}"
                    >
                        <h5 class="mb-0">
                            <button class="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $metricID }}"
                                    aria-expanded="false"
                                    aria-controls="collapse{{ $metricID }}"
                            >
                                <h5>
                                    {{ $postMetric }}
                                </h5>
                            </button>
                        </h5>
                    </div>
                    <div id="collapse{{ $metricID }}"
                         class="accordion-collapse collapse"
                         aria-labelledby="heading{{ $metricID }}"
                         data-bs-parent="#accordion"
                    >
                        <div class="card-body">
                            <div class="accordion-body">

                                <!-- CARD FOR POST -->
                                <div class="card shadow-sm mx-auto" style="max-width: 600px;"
                                     onclick="window.location.href='{{ route('posts.show', $postMetricValue) }}'">

                                    <!-- Header -->
                                    <div class="card-header bg-white">

                                        <!-- Profile of Post Owner -->
                                        <div class="row align-items-center">
                                            <div class="col text-start fw-bold text-primary">
                                                <a class= "btn btn-info"
                                                   href="{{ route("users.posts", $postMetricValue->user->id) }}"
                                                >
                                                    &#x1F464;
                                                    {{ $postMetricValue->user->username ?? 'Unknown' }}
                                                </a>
                                            </div>

                                            <!-- Profile of Original Post Owner if Repost -->
                                            @if ($postMetricValue->echoed)
                                                <div class="col text-center text-muted small">
                                                    <a class= "btn btn-info"
                                                       href="{{ route("users.posts", $postMetricValue->echoed_post->user->id) }}"
                                                    >
                                                        &#x1F5E3;
                                                        {{ $postMetricValue->echoed_post->user->username }}
                                                    </a>
                                                </div>
                                            @endif

                                            <!-- DateTime of Post Creation -->
                                            <div class="col text-end w-bold text-info">
                                                {{ $postMetricValue->created_at->format('H:i d/m/Y') ?? 'Unknown' }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Media if Posted -->
                                    @if ($postMetricValue->media)
                                        <!-- Media -->
                                        <div  class="border-bottom">
                                            <img src="{{ $postMetricValue->media }}"
                                                 class="card-img-top"
                                                 alt="Post image">
                                        </div>
                                    @endif

                                    <!-- Body -->
                                    <div class="card-body border-bottom">

                                        <!-- Title -->
                                        <h5 class="card-title mb-2">
                                            {{ $postMetricValue->title }}
                                        </h5>

                                        <!-- Content if Posted-->
                                        @if ($postMetricValue->content)
                                            <p class="card-text">
                                                {{ $postMetricValue->content }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Footer -->
                                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">

                                        <!-- Claps (likes) on Post -->
                                        <div>
                                            &#x1F44F; {{ $postMetricValue->claps }}
                                        </div>

                                        <!-- Echoes (reposts) of Post -->
                                        <div>
                                            &#x1F5E3; {{ $postMetricValue->echoes }}
                                        </div>

                                        <!-- Comment count and dropdown button -->
                                        <div>
                                            &#x1F4AC; {{ $postMetricValue->comments->count() }} Comments
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        @foreach ($commentMetrics as $commentMetric => $commentMetricValue)
            @php
                $metricID = str_replace(' ', '', $commentMetric);
                $commentPost = $commentMetricValue->post
            @endphp

            @if (!empty($commentMetricValue))
                <div class="accordion-item">
                    <div class="accordion-header"
                         id="heading{{ $metricID }}"
                    >
                        <h5 class="mb-0">
                            <button class="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $metricID }}"
                                    aria-expanded="false"
                                    aria-controls="collapse{{ $metricID }}"
                            >
                                <h5>
                                    {{ $commentMetric }}
                                </h5>
                            </button>
                        </h5>
                    </div>
                    <div id="collapse{{ $metricID }}"
                         class="accordion-collapse collapse"
                         aria-labelledby="heading{{ $metricID }}"
                         data-bs-parent="#accordion"
                    >
                        <div class="card-body">
                            <div class="accordion-body">
                                <!-- CARD FOR POST -->
                                <div class="card shadow-sm mx-auto" style="max-width: 600px;"
                                     onclick="window.location.href='{{ route('posts.show', $commentPost) }}'">

                                    <!-- Header -->
                                    <div class="card-header bg-white">

                                        <!-- Profile of Post Owner -->
                                        <div class="row align-items-center">
                                            <div class="col text-start fw-bold text-primary">
                                                <a class= "btn btn-info"
                                                   href="{{ route("users.posts", $commentPost->user?->id) }}"
                                                >
                                                    &#x1F464;
                                                    {{ $commentPost->user->username ?? 'Unknown' }}
                                                </a>
                                            </div>

                                            <!-- Profile of Original Post Owner if Repost -->
                                            @if ($commentPost->echoed)
                                                <div class="col text-center text-muted small">
                                                    <a class= "btn btn-info"
                                                       href="{{ route("users.posts", $commentPost->echoed_post->user->id) }}"
                                                    >
                                                        &#x1F5E3;
                                                        {{ $commentPost->echoed_post->user->username ?? 'Unknown' }}
                                                    </a>
                                                </div>
                                            @endif

                                            <!-- DateTime of Post Creation -->
                                            <div class="col text-end w-bold text-info">
                                                {{ $commentPost->created_at->format('H:i d/m/Y') ?? 'Unknown' }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Media if Posted -->
                                    @if ($commentPost->media)
                                        <!-- Media -->
                                        <div  class="border-bottom">
                                            <img src="{{ $commentPost->media }}"
                                                 class="card-img-top"
                                                 alt="Post image">
                                        </div>
                                    @endif

                                    <!-- Body -->
                                    <div class="card-body border-bottom">

                                        <!-- Title -->
                                        <h5 class="card-title mb-2">
                                            {{ $commentPost->title }}
                                        </h5>

                                        <!-- Content if Posted-->
                                        @if ($commentPost->content)
                                            <p class="card-text">
                                                {{ $commentPost->content }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Footer -->
                                    <div class="card-footer bg-white border-bottom border-top-0 d-flex justify-content-between align-items-center">

                                        <!-- Claps (likes) on Post -->
                                        <div>
                                            &#x1F44F; {{ $commentPost->claps }}
                                        </div>

                                        <!-- Echoes (reposts) of Post -->
                                        <div>
                                            &#x1F5E3; {{ $commentPost->echoes }}
                                        </div>

                                        <!-- Comment count and dropdown button -->
                                        <div>
                                            &#x1F4AC; {{ $commentPost->comments->count() }} Comments
                                        </div>
                                    </div>

                                    <!-- Comments Dropdown -->
                                    <div class="d-flex justify-content-between my-2 mx-3">
                                        <div style="color: deepskyblue">
                                            <strong>
                                                {{ $commentMetricValue->user->username }}:
                                            </strong>
                                            {{ $commentMetricValue->content }}
                                        </div>
                                        <div>
                                            &#x1F44F; {{ $commentMetricValue->claps }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection
