@extends('layouts.myapp')

<!-- LOGIC FOR ACTIVE PAGE AND BUTTONS -->

<!-- Change navbar style-->
@section('nav_dashboard', '#FFFFFF')
@section('nav_profile', '#FFFFFF')
@section('nav_settings', '#5de5fe')
@section('nav_all_users', 'active')

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
                        <!-- First Name -->
                        <td>
                            {{ $user->first_name }}
                        </td>
                        <!-- Last Name -->
                        <td>
                            {{ $user->last_name }}
                        </td>
                        <!-- Email -->
                        <td>
                            {{ $user->email }}
                        </td>

                        <!-- Link to User details page -->
                        <td>
                            <a class="btn btn-secondary"
                               href="{{ route('users.details', $user) }}"
                            >
                                &#x1F5C4;
                            </a>
                        </td>

                        <!-- Link to User Posts page -->
                        <td>
                            <a class="btn btn-primary"
                               href="{{ route('users.posts', $user) }}"
                            >
                                &#x1F5E3;
                            </a>
                        </td>

                        <!-- Link to User Stats page -->
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
