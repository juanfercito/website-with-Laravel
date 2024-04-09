@extends('layouts.app')

@section('title', 'Roles')

@section('content_header_title', 'Roles')
@section('content_header_subtitle', 'View')

@section('content')
<p>Welcome to Role and Permissions admin panel.</p>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @can('insert-role')
                <a class="btn btn-warning" href="{{ route('roles.create') }}">New Role</a>
                @endcan
            </div>
        </div>
    </div>
</div>
<table class="table table-stripped mt-2">
    <thead style="background-color: #6777ef;">
        <th style="color: #fff;">Role</th>
        <th style="color: #fff">Actions</th>
    </thead>
    <tbody>
        @foreach ($roles as $role)
        <tr>
            <td>{{ $role->name }}</td>
            <td>
                @can('modify-role')
                <a class="btn btn-primary mx-2 fas fa-edit" href="{{ route('roles.edit', $role->id) }}"> Modify</a>
                @endcan

                @can('delete-role')
                <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display: inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger fas fa-trash-alt"> Delete</button>
                </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination justify-content-end">
    {!! $roles->links() !!}
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
@stop