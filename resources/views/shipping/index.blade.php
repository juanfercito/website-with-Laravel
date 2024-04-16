@extends('layouts.app')

@section('title', 'Shiping')

@section('content_header_title', 'Shipping Services')
@section('content_header_subtitle', 'View')


@section('content')
<p>Welcome to Shipment admin panel.</p>

<a class="btn btn-warning my-2" href="{{ route('shippings.create') }}">New Service</a>
<div style="overflow-x: auto;">
    <table class="table table-stripped mt-3">
        <thead style="background-color: #6777ef;">

            <th style="color: #fff;">Actions</th>
            <th style="display: none;">ID</th>
            <th style="color: #fff; white-space: nowrap;">Name</th>
            <th style="color: #fff;">Type</th>
            <th style="color: #fff;">Route</th>
            <th style="color: #fff;">Logo</th>
            <th style="color: #fff;">W - Cost</th>
            <th style="color: #fff;">S - Cost</th>
            <th style="color: #fff;">Total Cost</th>
            <th style="color: #fff;">Delivery Time</th>
        </thead>
        <tbody>
            @foreach($shippings as $shipping)
            <tr>

                <td>
                    <div class="btn-action">
                        @can('modify-shipping')
                        <a class="btn btn-info btn-sm" href="{{route('shippings.edit', $shipping->id)}}">
                            <i class="d-inline d-sm-none fas fa-pen"></i>
                            <span class="d-none d-sm-inline-flex">Modify</span>
                        </a>
                        @endcan

                        <form action="{{ route('shippings.destroy', $shipping->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            @can('delete-shipping')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this shipping?');">
                                <i class="d-inline d-sm-none fas fa-trash-alt"></i>
                                <span class="d-none d-sm-inline-flex">Delete</span>
                            </button>
                            @endcan
                        </form>
                    </div>
                </td>
                <td style="display: none;">{{$shipping->id}}</td>
                <td>{{$shipping->name}}</td>
                <td>{{$shipping->shippingServiceTypes->name}}</td>
                <td>{{$shipping->shippingRoutes->name}}</td>
                <td>
                    <img src="/shipping-img/{{$shipping->image}}" alt="{{$shipping->image}}" style="width: 50px; height: 30px;">
                </td>
                <td>{{$shipping->weight_cost}}</td>
                <td>{{$shipping->size_cost}}</td>
                <td>{{$shipping->total_cost}}</td>
                <td>{{$shipping->estimated_delivery_time}}</td>

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