@extends('layouts.app')

@section('title', 'Edit')

@section('content_header_title', 'Products')
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

                    <form action="{{route('products.update', $product->id)}}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $product->title }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="product-class">Product Class</label>
                                    <select name="product_class_id" id="product_class_id" class="form-control">
                                        @foreach (App\Models\ProductClass::all() as $productClass)
                                        <option value="{{ $productClass->id }}" {{ $product->product_class_id == $productClass->id ? 'selected' : '' }}>
                                            {{ $productClass->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="product-category">Category</label>
                                    <select type="text" name="product_category_id" class="form-control">
                                        @foreach (App\Models\ProductCategory::all() as $productCategory)
                                        <option value="{{ $productCategory->id }}" {{ $product->product_category_id == $productCategory->id ? 'selected' : '' }}>
                                            {{ $productCategory->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="product-type">Product Type</label>
                                    <select type="text" name="product_type_id" class="form-control">
                                        @foreach (App\Models\ProductType::all() as $productType)
                                        <option value="{{ $productType->id }}" {{ $product->product_type_id == $productType->id ? 'selected' : '' }}>
                                            {{ $productType->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-floating">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" style="height: 100px;">{{ $product->description }}</textarea>
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
                                @if ($product->image)
                                <img src="/product-img/{{ $product->image }}" id="selected-image" style="max-height: 100px" class="mt-5">
                                <p id="image-name" class="text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider"></p>
                                @else
                                <p>No image selected</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                            </div>
                        </div>

                        <br>
                        <button type="submit" class="btn btn-primary">Save Changes</button>

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
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
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