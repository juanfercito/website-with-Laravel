@extends('layouts.app')

@section('title', 'Products')

@section('content_header_title', 'Products')
@section('content_header_subtitle', 'View')

@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="border-radius: 16px;">
                <div class="card-body">

                    <div class="row">
                        @can('insert-product')
                        <a class="btn btn-warning my-2 text-white" href="{{route('products.create')}}">New Product</a>
                        @endcan

                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <div class="input-group my-2">
                                <form action="{{ route('products.index') }}" method="GET" class="input-group mb-6">

                                    <span class="input-group"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control" name="search" placeholder="Search for..." value="{{ request('search') }}">
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
                        <table class="table table-stripped mt-3">
                            <thead style="background-color: #6777ef;">
                                <th style="color: #fff; display: flex; justify-content:center;">Actions</th>
                                <th style="display: none;">ID</th>
                                <th style="min-width: 80px; color:#fff;">Bars Code</th>
                                <th style="min-width:200px; color: #fff;">Title</th>
                                <th style="color: #fff;">Class</th>
                                <th style="color: #fff;">Category</th>
                                <th style="color: #fff;">Type</th>
                                <th style="color: #fff;">Image</th>
                                <th style="color: #fff;">Stock</th>
                                <th style="color: #fff;">Status</th>

                            </thead>

                            <tbody>
                                @foreach($products as $product)
                                <tr>

                                    <td>
                                        <div class="btn-action">
                                            @can('modify-product')
                                            <a class="btn btn-info btn-sm" href="{{ route('products.edit', $product->id) }}">
                                                <i class="d-inline d-sm-none fas fa-pen"></i>
                                                <span class="d-none d-sm-inline-flex">Modify</span>
                                            </a>
                                            @endcan

                                            <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                @can('delete-product')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="d-inline d-sm-none fas fa-trash-alt"></i>
                                                    <span class="d-none d-sm-inline-flex">Delete</span>
                                                </button>
                                                @endcan
                                            </form>
                                        </div>
                                    </td>

                                    <td>{{ $product->bars_code }}</td>
                                    <td>{{$product->title}}</td>
                                    <td>{{$product->productClass->name}}</td>
                                    <td>{{$product->productCategory->name}}</td>
                                    <td>{{$product->productType->name}}</td>
                                    <td>
                                        <img src="/product-img/{{$product->image}}" alt="{{$product->image}}" style="width: 50px; height: 30px;">
                                    </td>
                                    <td>{{$product->stock}}</td>
                                    <td>{{$product->status}}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    </-- center the table to right -- />
                    <div class="pagination justify-content-end">
                        {!! $products->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
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