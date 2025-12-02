@extends('layouts.myapp')

<!-- LOGIC FOR ACTIVE PAGE AND BUTTONS -->
@section('nav_settings', 'active')
@section('nav_all_users', 'active')

@section('content')

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
                    First Name
                </th>
                <th>
                    Last Name
                </th>
                <th>
                    Email
                </th>
                <th>
                    Details
                </th>
                <th>
                    Shouts
                </th>
                <th>
                    Statistics
                </th>

            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>
                        {{ $user->id }}
                    </td>
                    <td>
                        {{ $user->username }}
                    </td>
                    <td>
                        {{ $user->first_name }}
                    </td>
                    <td>
                        {{ $user->last_name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        <a class="btn btn-secondary"
                           href="{{ route('users.details', $user) }}"
                        >
                            &#x1F5C4;
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-primary"
                           href="{{ route('users.posts', $user) }}"
                        >
                            &#x1F5E3;
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-success"
                           href="{{ route('users.stats', $user) }}"
                        >
                            &#x1F4CA;
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            $('#task_table').DataTable({
                responsive: true,
                pagingType: 'simple_numbers'
            });
        });
    </script>

@endsection
