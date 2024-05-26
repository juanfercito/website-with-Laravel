@extends('layouts.main')

@section('title', 'Online Shop | Latest Products')

@section ('content')

<div class="container">

    <a href="{{ url('/') }}" class="back"><i class="fa fa-arrow-left"></i></a>

    <div class="background-carousel" style="background-image: url('assets/e-commerce-img.jpg');">
    </div>

    <h1>
        @if ($sort === 'bestselling')
        <h3 class="view-title">Lo más vendido</h3>
        @else
        <h3 class="view-title">Últimos añadidos</h3>
        @endif
    </h1>

    <div class="card-view">
        <div class="card-content allProducts">
            <div class="card-body">
                <div class="product-row">
                    @foreach($products as $product)
                    <a href="{{ route('welcome.create', ['id' => $product->id]) }}" class="product_card">
                        <div class="img">
                            <img src="/product-img/{{$product->image}}" alt="{{ $product->title }}" class="product-image">
                        </div>
                        <h4>{{ $product->title }}</h4>
                    </a>
                    @endforeach
                </div>
                <div class="pagination-container">
                    {{ $products->appends(['sort' => $sort])->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
@stop

@push('css')
<style>
    .card-view {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 1;
        top: 0px;
    }

    .card-content .allProducts {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 90%;
    }

    .card-body {
        width: 100%;
        height: 27%;
        padding: 10px;
        margin-bottom: 6px;
        background-color: #f0f0f0;
        border: 1px solid rgba(0, 0, 0, 0.4);
        border-radius: 16px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        background-color: rgba(0, 0, 0, 0.4);
        position: relative;
        z-index: 1;
    }


    .view-title {
        width: 150px;
        padding: 8px;
        margin-top: 10px;
        margin-left: 7.5%;
        font-size: 1.5rem;
        color: #ddd;
        background: #212;
        border: 4px solid rgba(0, 0, 0, 0.4);
        border-radius: 10px 10px 0 0;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
    }

    .product-row {
        display: flex;
        flex-wrap: wrap;
        margin: -6px;
        height: max-content;
    }

    .product_card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: rgba(255, 255, 255, 0.4);
        border: 1px solid rgba(0, 0, 0, 0.4);
        border-radius: 16px;
        margin-top: 10px;
        transition: all 0.3s ease;
        margin-inline: 6px;
        text-decoration: none;

        h4 {
            font-size: 1.6rem;
            font-weight: bold;
            color: white;
        }
    }

    .product_card:hover,
    .product_card:hover .img {
        cursor: pointer;
        background-color: rgba(255, 255, 255, 0.2);
    }

    /* Estilos para el título del producto */
    .product-title {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }

    .img {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70%;
        height: 70%;
        margin-bottom: 10px;
        background-color: rgba(255, 255, 255, 0.5);
        border-radius: 16px;

        .product-image {
            max-width: 80%;
            max-height: 80%;
        }
    }

    /* Styles for responsive screen */
    @media (max-width: 550px) {

        .product_card {
            width: 150px;
            height: 130px;
        }
    }

    @media (min-width: 551px) and (max-width: 820px) {
        .product_card {
            width: 180px;
            height: 150px;
        }
    }

    @media (min-width:821px) and (max-width:950px) {
        .product_card {
            width: 180px;
            height: 150px;
        }
    }

    @media (min-width:951px) {
        .product_card {
            width: 220px;
            height: 180px;
        }

    }

    @media (min-width:1271px) {
        .product_card {
            width: 220px;
            height: 180px;
        }
    }

    /* Pagination links */
    .pagination-container {
        margin-top: 40px;
        text-align: center;
    }

    /* Estilos para los botones de paginación */
    .pagination-container .pagination {
        display: inline-block;
        padding: 0;
        margin: 0;
    }

    .pagination-container .pagination li {
        display: inline;
        margin-right: 5px;
        /* Espacio entre los botones de paginación */
    }

    .pagination-container .pagination li a {
        padding: 5px 10px;
        border: 1px solid #ccc;
        color: #333;
        text-decoration: none;
    }

    .pagination-container .pagination li span {
        padding: 5px 10px;
        border: 1px solid #ccc;
        color: #333;
        text-decoration: none;
    }

    .pagination-container .pagination li a,
    .pagination-container .pagination li span {
        font-size: 1.4rem;
    }

    .pagination-container .pagination .active a {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .pagination-container .pagination li a:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush