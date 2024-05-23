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
                                @if($latestProducts->isNotEmpty())
                                @foreach($latestProducts as $product)
                                <a href="{{ route('welcome.create', ['id' => $product->id]) }}" class="product_card" id="product_card">
                                    <div class="img">
                                        <img src="/product-img/{{$product->image}}" alt="{{ $product->title }}" class="product-image">
                                    </div>
                                    <h4>{{ $product->title }}</h4>
                                </a>
                                @endforeach
                                @else
                                <p>No se encontraron productos.</p>
                                @endif
                            </div>
                            <a class="watch-all" href="{{ route('welcome.showAllProducts', ['sort' => 'latest']) }}">
                                Watch All <i class="fa fa-arrow-right" style="margin-left:4px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center align-items-end fixed-bottom mb-3">
            <div class="col-md-3">
                <!-- Most Sold Products Content -->
                <div class="card">
                    <div class="card-content">
                        <h3 class="card-title">Lo más vendido</h3>
                        <div class="card-body">
                            <div id="product-container" class="product-row">
                                @if($bestSellingProducts->isNotEmpty())
                                @foreach($bestSellingProducts as $product)
                                <a href="{{ route('welcome.create', ['id' => $product->id]) }}" class="product_card">
                                    <div class="img">
                                        <img src="/product-img/{{$product->image}}" alt="{{ $product->title }}" class="product-image">
                                    </div>
                                    <h4>{{ $product->title }}</h4>
                                </a>
                                @endforeach
                                @else
                                <p>No se encontraron productos.</p>
                                @endif
                            </div>
                            <a class="watch-all" href="{{ route('welcome.showAllProducts', ['sort' => 'bestselling']) }}">
                                Watch All <i class="fa fa-arrow-right" style="margin-left:4px;"></i>
                            </a>
                        </div>
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
    .product-row {
        display: flex;
        flex-wrap: wrap;
        margin: -6px;
        max-height: 180px;
        overflow: hidden;
    }

    .product_card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: rgba(255, 255, 255, 0.4);
        border: 1px solid rgba(0, 0, 0, 0.4);
        border-radius: 16px;
        margin-bottom: 20px;
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

    /* Estilos para el enlace "Ver todos" */
    .watch-all {
        color: #fff;
        position: absolute;
        right: 24px;
        bottom: 4px;
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

        .product_card {
            width: 180px;
            height: 160px;
        }
    }

    @media (min-width: 551px) {
        .product-row {
            max-height: 220px;
        }
    }

    @media (min-width: 551px) and (max-width: 820px) {
        .product_card {
            width: 230px;
            height: 200px;
        }
    }

    @media (min-width:821px) and (max-width:950px) {
        .product_card {
            width: 230px;
            height: 200px;
        }
    }

    @media (min-width:951px) {
        .product_card {
            width: 270px;
            height: 230px;
        }

        .product-row {
            max-height: 250px;
        }

    }

    @media (min-width:1271px) {
        .product_card {
            width: 270px;
            height: 230px;
        }
    }
</style>
@endpush

@push('js')
<!-- Scripts JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function adjustProductVisibility() {
        const productCards = document.querySelectorAll('.product_card');
        const width = window.innerWidth;
        let maxVisible = 2; // Default to show at least 2 items

        if (width > 1576) {
            maxVisible = 6;
        } else if (width > 1271) {
            maxVisible = 5;
        } else if (width > 951) {
            maxVisible = 4;
        } else if (width > 821) {
            maxVisible = 3;
        } else if (width > 550) {
            maxVisible = 2;
        }

        productCards.forEach((card, index) => {
            if (index < maxVisible) {
                card.style.display = 'flex'; // Mostrar los productos
            } else {
                card.style.display = 'none'; // Ocultar los productos que exceden el límite
            }
        });
    }

    window.addEventListener('resize', adjustProductVisibility);
    window.addEventListener('load', adjustProductVisibility);
</script>

@endpush