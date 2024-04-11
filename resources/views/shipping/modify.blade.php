@extends('layouts.app')

@section('title', 'Modify')

@section('content_header_title', 'Shipping')
@section('content_header_subtitle', 'Edit')

@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
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

                    <form action="{{route('shippings.update', $shipping->id)}}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $shipping->name}}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="product-class">Service Type</label>
                                    <select name="shipping_service_type_id" id="shipping_service_type_id" class="form-control">
                                        @foreach (App\Models\ShippingServiceType::all() as $serviceTpye)
                                        <option value="{{ $serviceTpye->id }}" {{ $shipping->shipping_service_type_id == $serviceTpye->id ? 'selected' : '' }}>
                                            {{ $serviceTpye->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="service-route">Route</label>
                                    <select name="shipping_route_id" id="shipping_route_id" class="form-control">
                                        @foreach(App\Models\ShippingRoute::all() as $shippingRoute)
                                        <option value="{{ $shippingRoute->id }}" {{ $shippingRoute->shipping_route_id == $shippingRoute->id ? 'selected' : '' }}>
                                            {{ $shippingRoute->name }}
                                            @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="product-class">Route</label>
                                    <select name="shipping_route_id" id="shipping_route_id" class="form-control">
                                        @foreach (App\Models\ShippingRoute::all() as $shippingRoute)
                                        <option value="{{ $shippingRoute->id }}" {{ $shipping->shipping_route_id == $shippingRoute->id ? 'selected' : '' }}>
                                            {{ $shippingRoute->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" style="height:100px;">{{ $shipping->description }}</textarea>
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
                                @if ($shipping->image)
                                <img src="/shipping-img/{{ $shipping->image }}" id="selected-image" style="max-height: 100px" class="mt-5">
                                <p id="image-name" class="text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider"></p>
                                @else
                                <p>No image selected</p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="weight-cost">Weight Cost</label>
                                    <input class="form-control" type="number" name="weight_cost" min="0" step="1" value="{{ $shipping->weight_cost }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="size-cost">Size Cost</label>
                                    <input class="form-control" type="number" name="size_cost" min="0" step="1" value="{{$shipping->size_cost}}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="total-cost">Total Cost</label>
                                    <input class="form-control" type="number" name="total_cost" min="0" step="1" value="{{$shipping->total_cost}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="delivery-time">Average Delivery Time</label>
                            <div class="input-group">
                                <input type="text" id="estimated-delivery-time" name="estimated_delivery_time" class="form-control" value="{{$shipping->estimated_delivery_time}}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center md:gap-8 gap-4 pt-5 pb-5">
                            <a href="{{route('shippings.index')}}" class="w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-x1 font-medium text-white px-4 py-2"></a>
                            <button type="submit" class="btn btn-primary" style="width: auto;">Save Shipping</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
<style>
    .btn {
        width: 120px;
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