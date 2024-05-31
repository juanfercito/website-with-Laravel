@extends('layouts.main')

@section('title', 'Online Shop | Product')

@section('content')

<div class="container">

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif


    <a href="javascript:history.back()" class="back"><i class="fa fa-arrow-left"></i></a>

    <<div class="background-carousel" style='background-image: url("{{ asset('assets/e-commerce-img.jpg') }}");'>
</div>

<div class="card-view">
    <div class="card-content allProducts">

        <h3 class="view-title">{{ $product->title }}</h3>
        <div class="card-body">

            <div class="product-row">
                <div href="{{ route('welcome.create', ['id' => $product->id]) }}" class="product_card">
                    <div class="column-1">
                        <div class="img">
                            <img src="/product-img/{{$product->image}}" alt="{{ $product->title }}" class="product-image">
                        </div>
                        <h4>{{ $product->title }}</h4>
                    </div>

                    <div class="column-2">
                        <div class="description">
                            <label for="description">Product Description</label>
                            <textarea name="description" id="description" disabled>{{ $product->description }}</textarea>
                        </div>

                        <div class="column-2-row">
                            <div class="row-group">
                                <label for="stock">Stock</label>
                                <input type="number" class="stock" value="{{ $product->stock }}" disabled>
                            </div>
                            <div class="row-group">
                                <label for="sale-price">Sale Price</label>
                                <input type="number" name="sale_price" class="sale_price" value="{{ $incomeDetail ? $incomeDetail->sale_price : 'N/A' }}" disabled>
                            </div>
                        </div>



                        <form action="{{ route('cart.addToCart') }}" method="post">
                            @csrf
                            <div class="cant">
                                <label for="cant">Cant</label>
                                <input type="number" name="cant" min="1" value="1">
                            </div>

                            <div class="cart">
                                <label for="add-to-cart">Add to Cart</label>
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="title" value="{{ $product->title }}">
                                <input type="hidden" name="sale_price" value="{{ $product->sale_price }}">
                                <button type="submit" name="add-to-cart" class="add-to-cart fas fa-cart-plus"></button>
                            </div>
                        </form>
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
        max-width: 200px;
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
        height: auto;
    }

    .product_card {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        background-color: rgba(255, 255, 255, 0.4);
        border: 1px solid rgba(0, 0, 0, 0.4);
        border-radius: 16px;
        margin-top: 10px;
        transition: all 0.3s ease;
        margin-inline: 6px;
        text-decoration: none;
        width: 100%;

        h4 {
            font-size: 1.6rem;
            font-weight: bold;
            color: white;
            margin-bottom: 10px
        }
    }

    .product_card:hover,
    .product_card:hover .img {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .column-1 {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        width: 50%;
        height: 100%;
    }

    .column-2 {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        font-size: 2rem;
        width: 50%;
        height: 100%;

        label {
            font-size: 1.4rem;
            font-weight: bold;
        }
    }

    .column-2-row {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-around;
        width: 90%;

        .row-group {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-inline: 6px;

            input {
                color: #222;
                font-weight: bold;
                width: 50%;
                height: 30px;
                margin-left: 4px;
                padding: 4px;
                border: 1px solid #bbb;
                border-radius: 10px;
            }
        }
    }

    .description {
        width: 90%;
        height: auto;
        background: transparent;
        font-size: 2rem;
        margin-bottom: 10px;

        textarea {
            width: 100%;
            min-height: 200px;
            resize: none;
            border-radius: 10px;
            padding: 4px;
        }
    }

    .stock,
    .sale_price {
        width: 100%;
        margin-top: 20px;
        margin-bottom: 20px;
        font-size: 1.3rem;
    }

    .cant {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;

        input {
            width: 50%;
            height: 30px;
            margin-left: 4px;
            padding: 4px;
            font-size: 1.4rem;
            border: 1px solid #bbb;
            border-radius: 10px;
        }
    }

    .cart {
        margin-bottom: 10px;
        z-index: 1;
    }

    .cart .add-to-cart {
        font-size: 1.6rem;
        width: 60px;
        height: 30px;
        border: none;
        background: #4299E1;
        color: white;
        border-radius: 10px;
    }

    .cart .add-to-cart:hover {
        cursor: pointer;
        background: linear-gradient(to right, #4299E1, #1b2029, #4299E1);
        color: white;
        border-radius: 10px;
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
        width: 50%;
        max-height: 90%;
        margin: 10px;
        background-color: rgba(255, 255, 255, 0.5);
        border-radius: 16px;

        .product-image {
            max-width: 80%;
            max-height: 80%;
        }
    }

    @media (max-width: 700px) {

        .product-row {
            height: max-content;
        }

        .product_card {
            flex-direction: column;
        }

        .column-1 {
            width: 100%;
            justify-content: flex-start;
        }

        .column-2 {
            width: 90%;
        }

        .description {
            width: 100%;
        }

        .column-2-row {
            input {
                min-width: 60px;
            }
        }

        .stock,
        .sale_price {
            width: 100%;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .cant {
            margin-bottom: 20px;

            input {
                width: 50%;
                height: 30px;
                margin-left: 4px;
                padding: 4px;
                font-size: 1.4rem;
                border: 1px solid #bbb;
                border-radius: 10px;
            }
        }
    }

    @media (min-width: 701px) and (max-width: 1030px) {

        .product-row {
            max-height: max-content;
        }

        .column-1 {
            justify-content: flex-start;
            height: 90%;
        }

        .img {
            width: 100%;
            height: 100%;
        }
    }

    @media (min-width: 1031px) {
        .product-row {
            max-height: max-content;
        }

        .column-1 {
            justify-content: center;
            height: 90%;
        }

        .column-2 textarea,
        .column-2 label,
        .column-2 input {
            font-size: 1.6rem;
        }

        .img {
            width: 100%;
            height: 90%;
        }
    }
</style>
@endpush

@push('js')

@endpush