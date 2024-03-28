@extends('adminlte::page')

@section('title', 'Modify Role')

@section('content_header')
<h1>Edit Role</h1>
@stop

@section('content')
<p>Update the Features of Role.</p>

<div class="card">
    <div class="card-body">

        @if ($errors->any())
        <div class="alert alert-dark alert-dimissible fade show" role="alert">
            <strong>¡Try Again!</strong>

            @foreach ($errors->all() as $error)
            <span class="badge badge-danger">{{$error}}</span>
            @endforeach
            <button type="button" class="close" data-dimiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <form method="POST" action="{{ route('roles.update', $role->id) }}">
            @csrf
            @method('PATCH')
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="">Rol Name</label>
                    <input type="text" name="name" value="{{ $role->name }}" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="username">Role Permissions</label>
                    <br>
                    @foreach ($permission as $value)
                    <label>
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                        {{ $value->name }}
                    </label>
                    <br>
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@stop