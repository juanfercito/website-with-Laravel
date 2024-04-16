@extends('layouts.app')

@section('title', 'Users')

@section('content_header_title', 'Users')
@section('content_header_subtitle', 'View')

@section('content')
<p>Here you can view all the features about customers</p>
<a class="btn btn-warning my-2" href="{{ route('users.create') }}">New User</a>

<div style="overflow-x: auto;">
    <table class="table table-stripped mt-3">
        <thead style="background-color: #6777ef;">
            <tr>

                <th style="color: #fff; display: flex; justify-content:center;">Actions</th>
                <th style="display: none;">ID</th>
                <th style="color: #fff; white-space: nowrap;">Name</th>
                <th style="color: #fff;">Username</th>
                <th style="color: #fff;">Email</th>
                <th style="color: #fff;">Dni</th>
                <th style="color: #fff;">Telephone</th>
                <th style="color: #fff;">Address</th>
                <th style="color: #fff;">city</th>
                <th style="color: #fff;">Province</th>
                <th style="color: #fff;">Role</th>

            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>

                <td>
                    <div class="btn-action">
                        <a class="btn btn-info btn-sm" href="{{ route('users.edit', $user->id) }}">
                            <i class="d-inline d-sm-none fas fa-pen"></i>
                            <span class="d-none d-sm-inline-flex">Modify</span>
                        </a>
                        <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <span class="d-none d-sm-inline">Delete</span>
                                <i class="d-inline d-sm-none fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>


                <td style="display: none;">{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->profile_name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->dni}}</td>
                <td>{{$user->telephone}}</td>
                <td>{{$user->address}}</td>
                <td>{{$user->city}}</td>
                <td>{{$user->province}}</td>
                <td>
                    @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $roleName)
                    <h5><span class="badge badge-dark">{{$roleName}}</span></h5>
                    @endforeach
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="pagination justify-content-end">
    {!! $users->links() !!}
</div>
@stop

@section('css')

{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>

<script>
    // Activating the horizontal scrolling with the mouse wheel
    var contenedor1 = document.getElementById('scrolling-1');

    contenedor1.addEventListener('wheel', function(event) {
        if (event.deltaY !== 0) {
            event.preventDefault();
            contenedor1.scrollLeft += event.deltaY;
        }
    }, {
        passive: true
    });
</script>
@stop