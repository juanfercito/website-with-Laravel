@extends('adminlte::page')

@section('title', 'Providers')

@section('content_header')
<h1>Providers</h1>
@stop

@section('content')
<p>Providers admin panel.</p>

<a class="btn btn-warning my-2" href="{{ route('providers.create') }}">New Provider</a>

<div style="overflow-x: auto;">
    <table class="table table-stripped mt-3">
        <thead style="background-color: #6777ef;">
            <tr>
                <th style="display: none;">ID</th>
                <th style="color: #fff; white-space: nowrap;">Name</th>
                <th style="color: #fff;">Category</th>
                <th style="color: #fff;">Logo</th>
                <th style="color: #fff;">Location</th>
                <th style="color: #fff;">Closing Order</th>
                <th style="color: #fff;">Application Date</th>
                <th style="color: #fff;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($providers as $provider)
            <tr>
                <td style="display: none;">{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->category}}</td>
                <td>{{$user->logo}}</td>
                <td>{{$user->location}}</td>
                <td>{{$user->closing_order_date}}</td>
                <td>{{$user->application_date}}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('providers.edit', $provider->id) }}">
                        <span class="d-none d-sm-inline-flex">Edit</span>
                        <i class="d-inline d-sm-none fas fa-edit"></i>
                    </a>

                    <form method="POST" action="{{ route('providers.destroy', $provider->id) }}" style="display: inline-flex">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mx-2">
                            <span class="d-none d-sm-inline">Delete</span>
                            <i class="d-inline d-sm-none fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="pagination justify-content-end">
    {!! $providers->links() !!}
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
    // Activar el scroll horizontal con la rueda del ratón para el primer contenedor
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