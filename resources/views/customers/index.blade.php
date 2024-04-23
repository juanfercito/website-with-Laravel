@extends('layouts.app')

@section('title', 'Customers')

@section('content_header_title', 'Customers')
@section('content_header_subtitle', 'View')

@section('content')
<p>Here you can view all the features about customers</p>

<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="border-radius: 16px;">
                <div class="card-body">
                    <div class="row">


                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <div class="input-group my-3">
                                <form action="{{ route('customers.index') }}" method="GET" class="input-group mb-6">

                                    <span class="input-group"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control" name="search" placeholder="Search for customers..." value="{{ request('search') }}">
                                    <button class="btn bg-secondary search-button" type="submit">
                                        <i class="text-white fas fa-search"></i> <!-- Icono de búsqueda -->
                                    </button>
                                    <button class="btn" type="reset" onclick="clearSearch();">
                                        <i class="text-white fa fa-sync"></i> <!-- Icono de búsqueda -->
                                    </button>

                                </form>
                            </div>
                        </div>

                    </div>

                    <div style="overflow-x: auto;">
                        <table class="table table-stripped mt-3" id="scrolling-1">
                            <thead style="background-color: #6777ef;">
                                <tr>

                                    <th style="color: #fff; display: flex; justify-content:center;">Actions</th>
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff; white-space: nowrap;">Name</th>
                                    <th style="color: #fff;">Email</th>
                                    <th style="color: #fff;">Dni</th>
                                    <th style="color: #fff;">Telephone</th>
                                    <th style="color: #fff;">Address</th>
                                    <th style="color: #fff;">city</th>
                                    <th style="color: #fff;">Province</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                <tr>

                                    <td>
                                        <div class="btn-action">
                                            <a class="btn btn-info btn-sm" href="{{ route('customers.edit', $customer->id) }}">
                                                <i class="d-inline d-sm-none fas fa-pen"></i>
                                                <span class="d-none d-sm-inline-flex">Modify</span>
                                            </a>
                                            <form method="POST" action="{{ route('customers.destroy', $user->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <span class="d-none d-sm-inline">Delete</span>
                                                    <i class="d-inline d-sm-none fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>


                                    <td style="display: none;">{{$customer->id}}</td>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>{{$customer->dni}}</td>
                                    <td>{{$customer->telephone}}</td>
                                    <td>{{$user->address}}</td>
                                    <td>{{$user->city}}</td>
                                    <td>{{$user->province}}</td>

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
    {!! $customers->links() !!}
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

{{-- link for refreshing screen --}}
<script>
    function clearSearch() {
        document.querySelector('.form-control[name="search"]').value = ''; // Establece el valor del campo de búsqueda en vacío
        document.querySelector('.input-group.mb-6').submit();
    }
</script>
@stop