@extends('layouts.myapp')

<!-- LOGIC FOR ACTIVE PAGE AND BUTTONS -->

<!-- Change navbar style-->
@section('nav_dashboard', '#FFFFFF')
@section('nav_profile', '#FFFFFF')
@section('nav_settings', '#5de5fe')
@section('nav_all_stats', 'active')

@section('content')

    <!-- Create table to hold all User stats -->
    <div class="py-2 px-3">
        <table id="task_table" class="table table-striped">
            <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Username
                </th>
                <th>
                    No. Posts
                </th>
                <th>
                    No. Comments
                </th>
                <th>
                    Top Heard Post
                </th>
                <th>
                    Top Heard Comment
                </th>
                <th>
                    Top Clapped Post
                </th>
                <th>
                    Top Clapped Comment
                </th>
                <th>
                    Top Echoed Post
                </th>

            </tr>
            </thead>
            <tbody>
                <!-- Loop through all Users -->
                @foreach ($users as $user)
                    <tr>
                        <!-- ID -->
                        <td>
                            {{ $user->id }}
                        </td>
                        <!-- Username -->
                        <td>
                            {{ $user->username }}
                        </td>
                        <!-- No of Posts -->
                        <td>
                            {{ $user->posts_count }}
                        </td>
                        <!-- No of Comments -->
                        <td>
                            {{ $user->comments_count }}
                        </td>

                        <!-- Top Heard Post with link to Post -->
                        <td>
                            @if ($user->top_heard_post)
                                <a class="btn btn-success"
                                   href="{{ route('posts.show', $user->top_heard_post) }}"
                                >
                                    {{ $user->top_heard_post->heard }}
                                </a>
                            @else
                                –
                            @endif
                        </td>

                        <!-- Top Heard Comment with link to Comment -->
                        <td>
                            @if ($user->top_heard_comment)
                                <a class="btn btn-success"
                                   href="{{ route('posts.show', $user->top_heard_comment->post) }}"
                                >
                                    {{ $user->top_heard_comment->heard }}
                                </a>
                            @else
                                –
                            @endif
                        </td>

                        <!-- Top Clapped Post with link to Post -->
                        <td>
                            @if ($user->top_clapped_post)
                                <a class="btn btn-warning"
                                   href="{{ route('posts.show', $user->top_clapped_post) }}"
                                >
                                    {{ $user->top_clapped_post->claps }}
                                </a>
                            @else
                                –
                            @endif
                        </td>

                        <!-- Top Clapped Comment with link to Comment -->
                        <td>
                            @if ($user->top_clapped_comment)
                                <a class="btn btn-warning"
                                   href="{{ route('posts.show', $user->top_clapped_comment->post) }}"
                                >
                                    {{ $user->top_clapped_comment->claps }}
                                </a>
                            @else
                                –
                            @endif
                        </td>

                        <!-- Top Echoed Post with link to Post -->
                        <td>
                            @if ($user->top_echoed_post)
                                <a class="btn btn-primary"
                                   href="{{ route('posts.show', $user->top_echoed_post) }}"
                                >
                                    {{ $user->top_echoed_post->echoes }}
                                </a>
                            @else
                                –
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Run DataTables script -->
    <script>
        $(document).ready(function () {
            $('#task_table').DataTable({
                responsive: true,
                pagingType: 'simple_numbers'
            });
        });
    </script>

@endsection
