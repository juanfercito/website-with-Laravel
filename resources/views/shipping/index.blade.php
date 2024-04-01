@extends('adminlte::page')

@section('title', 'Shiping')

@section('content_header')
<h1>Shipping</h1>
@stop

@section('content')
<p>Welcome to this beautiful admin panel.</p>

<a class="btn btn-warning my-2" href="{{ route('shippings.create') }}">New</a>
<div style="overflow-x: auto;">
    <table class="table table-stripped mt-3">
        <thead style="background-color: #6777ef;">
            <tr>
                <th style="display: none;">ID</th>
                <th style="color: #fff; white-space: nowrap;">Name</th>
                <th style="color: #fff;">Service Type</th>
                <th style="color: #fff;">Route</th>
                <th style="color: #fff;">Logo</th>
                <th style="color: #fff;">Weight Cost</th>
                <th style="color: #fff;">Size Cost</th>
                <th style="color: #fff;">Average Delivery Time</th>
                <th style="color: #fff;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shippings as $shipping)
            <tr>
                <td style="display: none;">{{$shipping->id}}</td>
                <td>{{$shipping->name}}</td>
                <td>{{$shipping->shipping_service_type}}</td>
                <td>{{$shipping->shipping_routes}}</td>
                <td>
                    <img src="/shipping-service-img/{{$shipping->image}}" alt="{{$shipping->image}}" style="width: 50px; height: 30px;">
                </td>
                <td>{{$shipping->weight_cost}}</td>
                <td>{{$shipping->size_cost}}</td>
                <td>{{$shipping->estimated_delivery_time}}</td>
                <a class="btn btn-info" href="{{ route('shipping.edit', $shipping->id) }}">
                    <span class="d-none d-sm-inline-flex">Edit</span>
                    <i class="d-inline d-sm-none fas fa-edit"></i>
                </a>

                <form method="POST" action="{{ route('shipping.destroy', $shipping->id) }}" style="display: inline-flex">
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
    {!! $shippings->links() !!}
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
@stop