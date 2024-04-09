@extends('layouts.app')

@section('title', 'Profile')

@section('content_header_title', 'Profile')
@section('content_header_subtitle', 'View')


@section('content')
@yield('content_body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card flex items-center justify-center">
                <div class="card-header">Preview</div>

                <div class="card-body">
                    <div class="text-center">
                        <img src="/storage/{{Auth::user()->image}}" alt="{{Auth::user()->image}}" style="max-width: 150px; max-height: 150px;">
                        <h2>{{ Auth::user()->profile_name }}</h2>
                        <p>{{ Auth::user()->name }}</p>
                        <p>{{ Auth::user()->email }}</p>
                        <p>
                            <span>DNI: </span>
                            {{ Auth::user()->dni }}
                        </p>
                        <p>
                            <span>Telephone: </span>
                            {{ Auth::user()->telephone }}
                        </p>

                    </div>
                    <a class="btn btn-info" href="{{ route('profile.edit', Auth::user()) }}">
                        <i class="d-inline fas fa-edit"></i>
                        <span class="d-none d-sm-inline-flex">Edit Profile</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')

<style>
    .card-body {
        display: grid;
        align-items: center;
        justify-content: center;
    }


    .btn:hover {
        background: linear-gradient(to right, #0d4bf5, #040f74, #043e6e, #1093ff);
    }
</style>
@stop