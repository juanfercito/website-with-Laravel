@extends('layouts.app')

@section('title', 'Edit')

@section('content_header_title', 'Providers')
@section('content_header_subtitle', 'Edit')


@section('content')

<link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">

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

                    <form action="{{ route('providers.update', ['provider' => $provider->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $provider->name }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="provider-class">Provider Class</label>
                                    <select name="provider_class_id" id="provider_class_id" class="form-control">
                                        @foreach(App\Models\ProviderClass::all() as $providerClass)
                                        <option value="{{ $providerClass->id }}" {{ $provider->provider_class_id == $providerClass->id ? 'selected' : '' }}>
                                            {{ $providerClass->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="provider-category">Category</label>
                                    <select name="provider_category_id" id="provider_category_id" class="form-control">
                                        @foreach(App\Models\ProviderCategory::all() as $providerCategory)
                                        <option value="{{ $providerCategory->id }}" {{ $provider->provider_category_id == $providerCategory->id ? 'selected' : '' }}>
                                            {{ $providerCategory->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" style="height:100px;">{{ $provider->description }}</textarea>
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-3 mt-5 mb-5">
                                <label for="image" class="control-label">Upload Logo</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image" onchange="previewImage(event)">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <img src="{{ asset('storage/public/provider_img/' . $provider->image) }}" id="selected-image" style="max-height: 100px" class="mt-5">

                                <p id="image-name" class="text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider" style="display: none"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" name="location" class="form-control" value="{{ $provider->location }}">
                        </div>

                        <div class="form-group">
                            <label for="closing-order-date">Closing Order Date</label>
                            <div class="input-group">
                                <input type="text" id="closing-order-date" name="closing-order-date" class="form-control" value="{{ $provider->closing_order_date }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="application-date">Application Date</label>
                            <div class="input-group">
                                <input type="text" id="application-date" name="application-date" class="form-control" value="{{ $provider->application_date }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center md:gap-8 gap-4 pt-5 pb-5">
                            <a href="{{route('products.index')}}" class="w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-x1 font-medium text-white px-4 py-2"></a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Inicializar el campo de entrada de fecha y hora
    flatpickr("#closing-order-date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        altInput: true,
        altFormat: "F j, Y H:i",
        onChange: function(selectedDates, dateStr, instance) {
            // Actualizar el valor del campo de entrada al seleccionar una fecha en el calendario
            document.getElementById("closing-order-date").value = dateStr;
        }
    });
</script>

<script>
    // Inicializar el campo de entrada de fecha y hora
    flatpickr("#application-date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        altInput: true,
        altFormat: "F j, Y H:i",
        onChange: function(selectedDates, dateStr, instance) {
            // Actualizar el valor del campo de entrada al seleccionar una fecha en el calendario
            document.getElementById("application-date").value = dateStr;
        }
    });
</script>

{{-- This is for showing logo preview --}}
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