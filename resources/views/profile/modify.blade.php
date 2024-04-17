@extends('layouts.app')

@section('title', 'Profile')

@section('content_header_title', 'Profile')
@section('content_header_subtitle', 'Edit')

@section('content')

<form method="post" action="{{ route('profile.update', ['profile' => Auth::user()->id]) }}" class="mt-6 space-y-6" enctype="multipart/form-data">

    @csrf
    @method('PATCH')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ $user->name }}" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="profile_name">Profile Name</label>
                    <input type="text" name="profile_name" id="profile_name" value="{{ $user->profile_name }}" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="dni">Dni or Passport</label>
                    <input id="dni" type="text" name="dni" value="{{ $user->dni }}" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="telephone">Telephone</label>
                    <input id="telephone" type="text" name="telephone" value="{{ $user->telephone }}" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input id="address" type="text" name="address" value="{{ $user->address }}" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="city">City</label>
                    <input id="city" type="text" name="city" value="{{ $user->city }}" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="province">Province</label>
                    <input id="province" type="text" name="province" value="{{ $user->province }}" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3 mt-5 mb-5">
                <label for="image" class="control-label">Upload Image</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image" onchange="previewImage(event)">
                        <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                @if ($user->image)
                <img src="/storage/{{ $user->image }}" id="selected-image" style="max-height: 100px" class="mt-5">
                <p id="image-name" class="text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider"></p>
                @else
                <p>No image selected</p>
                @endif
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-info">Save Changes</button>
        </div>
    </div>
</form>
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
        const reader = new FileReader();
        reader.onload = function() {
            const img = document.getElementById('selected-image');
            img.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@stop