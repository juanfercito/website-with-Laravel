@extends('layouts.app')

@section('title', 'Modify')

@section('content_header_title', 'Users')
@section('content_header_subtitle', 'Edit')

@section('content')

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

        <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group row">
                <div class="col-md-3 mt-5 mb-5">
                    <label for="image" class="control-label">Upload Profile Image</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="user_image" name="user_image" onchange="previewImage(event)">
                            <label class="custom-file-label" for="user-image">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    @if ($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" id="selected-image" style="max-height: 100px" class="mt-5">
                    <p id="image-name" class="text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider"></p>
                    @else
                    <p>No image selected</p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="profile_name" id="profile_name" value="{{ $user->profile_name }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="dni">Dni</label>
                        <input type="text" name="dni" value="{{ $user->dni }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="telephone">Telephone</label>
                        <input type="text" name="telephone" value="{{ $user->telephone }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea type="text" name="address" value="{{ $user->address }}" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" value="{{ $user->city }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="province">Province</label>
                        <input type="text" name="province" value="{{ $user->province }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" name="confirm-password" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="">Roles</label>
                    <select name="roles[]" id="roles" class="form-control" multiple>
                        @foreach($roles as $id => $role)
                        <option value="{{ $id }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<style>
    .btn {
        border-radius: 32px;
    }

    .btn:hover {
        background: linear-gradient(to right, #0d4bf5, #040f74, #043e6e, #1093ff);
    }
</style>
@stop

@section('js')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('selected-image');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@stop