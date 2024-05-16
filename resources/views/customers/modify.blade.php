@extends('layouts.app')

@section('title', 'Customers')

@section('content_header_title', 'Customers')
@section('content_header_subtitle', 'Edit')

@section('content')
<p>Here you can view all the features about customers</p>

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

        <form method="POST" action="{{ route('customers.update', $customer->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" value="{{ $customer->name }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="profile_name">Username</label>
                        <input type="text" name="profile_name" value="{{ $customer->profile_name }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{ $customer->email }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="dni">Dni</label>
                        <input type="text" name="dni" value="{{ $customer->dni }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="telephone">Telephone</label>
                        <input type="text" name="telephone" value="{{ $customer->telephone }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" class="form-control">{{ $customer->address }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" value="{{ $customer->city }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="province">Province</label>
                        <input type="text" name="province" value="{{ $customer->province }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <a href="{{ route('customers.index') }}" class="btn btn-warning mb-3">Back to List</a>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <button type="submit" class="btn btn-primary">Update Customer</button>
                </div>
            </div>
        </form>

    </div>
</div>
@stop

@stop