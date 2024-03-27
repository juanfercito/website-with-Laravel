@extends('adminlte::page')

@section('title', 'Create')

@section('content_header')
<h1>Create Role Panel</h1>
@stop

@section('content')
<p>Creating new role into this admin panel.</p>

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

        <form method="POST" action="{{ route('roles.store') }}">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="name"> Role Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="">Permissions For this Role</label>
                        <br>
                        @foreach($permission as $value)
                        <label>
                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name">
                            {{ $value->name }}
                        </label>
                        <br>
                        @endforeach
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
<style>
    .btn {
        width: 120px;
        border-radius: 12px;
    }

    .btn:hover {
        background: linear-gradient(to right, #0d4bf5, #040f74, #043e6e, #1093ff);
    }
</style>
@stop