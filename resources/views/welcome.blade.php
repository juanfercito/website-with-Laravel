@extends('layouts.main')

@section('title', 'Welcome to Online Shop')

@section('content')
<div class="title-beginning">
    <h2>All in a One Place</h2>
</div>

<div>
    <div class="background-carousel" style="background-image: url('assets/foreground-nature.jpg');">
    </div>

    <div class="container">
        <div class="row justify-content-center align-items-end fixed-bottom mb-3">
            <div class="col-md-3">
                <!-- Latest added Products Content -->
                <div class="card">
                    <div class="card-content">
                        <h3 class="card-title">Últimos añadidos</h3>
                        <div class="card-body">
                            <div id="product-container" class="product-row">
                                @php
                                $latestProducts = \App\Models\Product::latest()->get();
                                @endphp
                                @foreach($latestProducts as $product)
                                <div class="product-card">
                                    <div class="img">
                                        <img src="/product-img/{{$product->image}}" alt="{{ $product->title }}" class="product-image">
                                    </div>
                                    <h4>{{ $product->title }}</h4>
                                </div>
                                @endforeach
                            </div>
                            <a class="watch-all" href="/">Watch All <i class="fa fa-arrow-right" style="margin-left:4px;"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Most Sold Products Content -->
                <div class="card">
                    <div class="card-content">
                        <h3 class="card-title">Lo más vendido</h3>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <!-- Aquí va el contenido de cada producto -->
                                    <div class="product-card">
                                        <!-- Otros detalles del producto -->
                                    </div>
                                </div>
                            </div>
                            <a class="watch-all" href="/">Watch All <i class="fa fa-arrow-right" style="margin-left:4px;"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<!-- Estilos CSS -->
<style>
    /* Estilos para el contenedor del producto */
    .product-row {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        margin: -6px;
        /* Compensar el padding negativo */
    }

    .product-card {
        display: flex;
        position: relative;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        background-color: rgba(255, 255, 255, 0.4);
        border: 1px solid rgba(0, 0, 0, 0.4);
        border-radius: 16px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        margin-inline: 6px;

        h4 {
            font-size: 1.6rem;
            font-weight: bold;
            color: white;
        }
    }

    .product-card:hover,
    .product-card:hover .img {
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

    /* Estilos para el enlace "Ver todos" */
    .watch-all {
        color: #fff;
        position: absolute;
        right: 24px;
        bottom: 6px;
        font-size: 1.2rem;
        cursor: pointer;
        text-decoration: none;
    }

    .watch-all:hover {
        color: yellow;
    }

    /* Estilos para el icono de flecha */
    .watch-all i {
        margin-left: 4px;
        transition: transform 0.3s ease;
    }

    /* Estilos para el icono de flecha al pasar el mouse */
    .watch-all:hover i {
        transform: translateX(3px);
    }

    /* Estilos para el tamaño dinámico del producto */
    @media (max-width: 550px) {
        .product-card {
            width: 200px;
            height: 180px;
        }
    }

    @media (min-width: 551px) {
        .product-card {
            width: 230px;
            height: 200px;
        }
    }

    @media (min-width: 851px) {
        .product-card {
            width: 270px;
            height: 230px;
        }
    }

    @media (min-width: 1200px) {
        .card {
            top: 200px;
            transition: transform 0.3s ease;
        }
    }
</style>
@endpush

@push('js')
<!-- Scripts JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var screenWidth = window.innerWidth;
    $.ajax({
        url: '/get-products',
        type: 'GET',
        data: {
            screenWidth: screenWidth
        },
        success: function(response) {
            $('#product-container').html(response);
        },
        error: function(xhr) {
            console.error(xhr);
        }
    });
</script>
@endpush