@extends('layouts.app')

@section('title', 'Roles')

@section('content_header_title', 'Roles')
@section('content_header_subtitle', 'View')

@section('content')
<p>Welcome to Role and Permissions admin panel.</p>

<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="border-radius: 16px;">
                <div class="card-body">
                    @can('insert-role')
                    <a class="btn btn-warning my-4" href="{{ route('roles.create') }}">New Role</a>
                    @endcan


                    <div style="overflow-x: auto;">
                        <table class="table table-stripped mt-3">
                            <thead style="background-color: #6777ef;">

                                <th style="color: #fff">Actions</th>
                                <th style="color: #fff;">Role</th>

                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>

                                    <td>
                                        @can('modify-role')
                                        <a class="btn btn-primary " href="{{ route('roles.edit', $role->id) }}">
                                            <i class="d-inline d-sm-none fas fa-pen"></i>
                                            <span class="d-none d-sm-inline-flex">Modify</span>
                                        </a>
                                        @endcan

                                        @can('delete-role')
                                        <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="d-inline d-sm-none fas fa-trash-alt"></i>
                                                <span class="d-none d-sm-inline-flex">Delete</span>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                    <td>{{ $role->name }}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

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